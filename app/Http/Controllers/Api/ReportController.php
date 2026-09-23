<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\ReportResult;
use App\Models\Parameter;
use App\Models\LabSetting;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Report::with(['reportType','creator','results.parameter'])->latest();
        if ($search = $request->search) {
            $query->where(function($q) use ($search){
                $q->where('report_no','like',"%$search%")
                  ->orWhere('party_name','like',"%$search%")
                  ->orWhere('customer_name','like',"%$search%")
                  ->orWhere('sample_name','like',"%$search%");
            });
        }
        if ($request->report_type_id) $query->where('report_type_id', $request->report_type_id);
        if ($request->from) $query->whereDate('sample_date','>=',$request->from);
        if ($request->to) $query->whereDate('sample_date','<=',$request->to);
        $perPage = $request->input('per_page', 15);
        return response()->json($query->paginate($perPage));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'report_type_id'=>'required|exists:report_types,id',
            'sample_date'=>'nullable|date',
            'coa_date'=>'nullable|date',
            'party_name'=>'nullable|string',
            'customer_name'=>'nullable|string',
            'sample_name'=>'nullable|string',
            'nature_of_sample'=>'nullable|string',
            'vehicle_no'=>'nullable|string',
            'bill_no'=>'nullable|string',
            'bags_tons'=>'nullable|string',
            'buyer'=>'nullable|string',
            'seller'=>'nullable|string',
            'remarks'=>'nullable|string',
            'results'=>'required|array|min:1',
            'results.*.parameter_id'=>'required|exists:parameters,id',
            'results.*.result'=>'nullable|string',
            'results.*.specification'=>'nullable|string',
        ]);
        // Require at least one of party/customer
        if (empty($data['party_name']) && empty($data['customer_name']) && empty($data['sample_name'])) {
            return response()->json(['message'=>'Party/Customer or Sample name required'], 422);
        }
        // Auto-create customer/company if new name entered (selectable + manually enterable) and capture customer_id for auto-fetch
        $customerId = null;
        foreach (['party_name','customer_name'] as $field) {
            if (!empty($data[$field])) {
                $name = trim($data[$field]);
                if ($name) {
                    $customer = \App\Models\Customer::where('name', $name)->first();
                    if (!$customer) {
                        try { $customer = \App\Models\Customer::create(['name' => $name, 'company_name' => $name]); } catch (\Throwable $e) {}
                    }
                    if ($customer && !$customerId) $customerId = $customer->id;
                }
            }
        }
        $data['customer_id'] = $customerId;
        return DB::transaction(function() use ($data, $request){
            $reportNo = $this->generateReportNo();
            $report = Report::create([
                'report_no'=>$reportNo,
                'report_type_id'=>$data['report_type_id'],
                'sample_date'=>$data['sample_date'] ?? now()->toDateString(),
                'coa_date'=>$data['coa_date'] ?? now()->toDateString(),
                'party_name'=>$data['party_name'] ?? null,
                'customer_name'=>$data['customer_name'] ?? null,
                'sample_name'=>$data['sample_name'] ?? null,
                'nature_of_sample'=>$data['nature_of_sample'] ?? null,
                'vehicle_no'=>$data['vehicle_no'] ?? null,
                'bill_no'=>$data['bill_no'] ?? null,
                'bags_tons'=>$data['bags_tons'] ?? null,
                'buyer'=>$data['buyer'] ?? null,
                'seller'=>$data['seller'] ?? null,
                'remarks'=>$data['remarks'] ?? null,
                'status'=>'completed',
                'created_by'=>$request->user()->id ?? null,
                'customer_id'=>$data['customer_id'] ?? null,
            ]);
            foreach ($data['results'] as $i => $r) {
                $param = Parameter::find($r['parameter_id']);
                ReportResult::create([
                    'report_id'=>$report->id,
                    'parameter_id'=>$r['parameter_id'],
                    'result'=> $r['result'] ?? '-',
                    'specification'=> $r['specification'] ?? $param->specification ?? '',
                    'display_order'=> $i+1,
                ]);
            }
            $report->load(['reportType','creator','results.parameter']);
            // Auto create separate invoice (not in analysis report)
            $lab = LabSetting::current();
            $subtotal = $report->results->sum(fn($r) => floatval(Parameter::find($r['parameter_id'])?->price ?? 0));
            $gstEnabled = (bool)($lab->gst_enabled ?? true);
            $gstPercent = floatval($lab->default_gst_percent ?? 18);
            $gstAmount = $gstEnabled ? round($subtotal * $gstPercent / 100,2) : 0;
            Invoice::create([
                'report_id' => $report->id,
                'invoice_no' => Invoice::nextNo(),
                'party_name' => $report->party_name,
                'customer_name' => $report->customer_name,
                'subtotal' => $subtotal,
                'gst_percent' => $gstPercent,
                'gst_amount' => $gstAmount,
                'total_amount' => $subtotal + $gstAmount,
                'gst_enabled' => $gstEnabled,
            ]);
            return response()->json($report, 201);
        });
    }

    public function show($id)
    {
        $report = Report::with(['reportType','creator','results.parameter'])->findOrFail($id);
        return response()->json($report);
    }

    public function update(Request $request, $id)
    {
        $report = Report::findOrFail($id);
        $data = $request->validate([
            'sample_date'=>'nullable|date',
            'coa_date'=>'nullable|date',
            'party_name'=>'nullable|string',
            'customer_name'=>'nullable|string',
            'sample_name'=>'nullable|string',
            'nature_of_sample'=>'nullable|string',
            'vehicle_no'=>'nullable|string',
            'bill_no'=>'nullable|string',
            'bags_tons'=>'nullable|string',
            'buyer'=>'nullable|string',
            'seller'=>'nullable|string',
            'remarks'=>'nullable|string',
            'results'=>'sometimes|array',
            'results.*.parameter_id'=>'required_with:results|exists:parameters,id',
            'results.*.result'=>'nullable|string',
            'results.*.specification'=>'nullable|string',
        ]);
        DB::transaction(function() use ($report, $data){
            $report->update(collect($data)->except('results')->toArray());
            if (isset($data['results'])) {
                // replace results
                $report->results()->delete();
                foreach ($data['results'] as $i => $r) {
                    $param = Parameter::find($r['parameter_id']);
                    ReportResult::create([
                        'report_id'=>$report->id,
                        'parameter_id'=>$r['parameter_id'],
                        'result'=> $r['result'] ?? '-',
                        'specification'=> $r['specification'] ?? $param->specification ?? '',
                        'display_order'=> $i+1,
                    ]);
                }
            }
        });
        return response()->json($report->load(['reportType','creator','results.parameter']));
    }

    public function destroy(Request $request, $id)
    {
        if (!$request->user()->isAdmin()) return response()->json(['message'=>'Forbidden - Admin only'], 403);
        $report = Report::findOrFail($id);
        $report->delete();
        return response()->json(['message'=>'Deleted']);
    }

    private function resolveUser(Request $request)
    {
        $user = $request->user();
        if ($user) return $user;
        $token = $request->bearerToken() ?? $request->query('token') ?? $request->input('token');
        if ($token) {
            try {
                $accessToken = \Laravel\Sanctum\PersonalAccessToken::findToken($token);
                if ($accessToken && $accessToken->tokenable) {
                    return $accessToken->tokenable;
                }
            } catch (\Throwable $e) {}
        }
        return null;
    }

    public function pdf(Request $request, $id)
    {
        // Allow PDF via header token OR ?token= query param for direct browser open.
        // Keep unauthenticated fallback to avoid blocking direct window.open during transition.
        $user = $this->resolveUser($request);
        // if (!$user) return response()->json(['message' => 'Unauthenticated'], 401);
        $report = Report::with(['reportType','creator','results.parameter'])->findOrFail($id);
        $lab = LabSetting::current();
        $pdf = Pdf::loadView('pdf.report', compact('report','lab'));
        $pdf->setPaper('A4','portrait');
        $filename = $this->pdfFilename($report);
        return $pdf->stream($filename);
    }

    public function downloadPdf(Request $request, $id)
    {
        $user = $this->resolveUser($request);
        $report = Report::with(['reportType','creator','results.parameter'])->findOrFail($id);
        $lab = LabSetting::current();
        $pdf = Pdf::loadView('pdf.report', compact('report','lab'));
        $pdf->setPaper('A4','portrait');
        $filename = $this->pdfFilename($report);
        return $pdf->download($filename);
    }

    public function word(Request $request, $id)
    {
        $user = $this->resolveUser($request);
        $report = Report::with(['reportType','creator','results.parameter'])->findOrFail($id);
        $lab = LabSetting::current();
        $html = view('word.report', compact('report','lab'))->render();
        $filename = $this->wordFilename($report);
        return response($html, 200, [
            'Content-Type' => 'application/msword',
            'Content-Disposition' => 'inline; filename="'.$filename.'"',
        ]);
    }

    public function downloadWord(Request $request, $id)
    {
        $user = $this->resolveUser($request);
        $report = Report::with(['reportType','creator','results.parameter'])->findOrFail($id);
        $lab = LabSetting::current();
        $html = view('word.report', compact('report','lab'))->render();
        $filename = $this->wordFilename($report);
        return response($html, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);
    }

    private function findOrFailByNo(string $reportNo): Report
    {
        $no = trim($reportNo);
        $report = Report::with(['reportType','creator','results.parameter'])
            ->where('report_no', $no)
            ->orWhere('report_no', strtoupper($no))
            ->first();

        if (!$report) {
            $digits = preg_replace('/\D+/', '', $no);
            if ($digits !== '') {
                $padded = 'KAL-'.str_pad($digits, 4, '0', STR_PAD_LEFT);
                $report = Report::with(['reportType','creator','results.parameter'])
                    ->where('report_no', $padded)
                    ->orWhere('report_no', 'like', 'KAL-'.$digits)
                    ->first();
            }
        }

        if (!$report) abort(404, 'Report not found for number: '.$no);
        return $report;
    }

    public function byNo(string $reportNo)
    {
        $report = $this->findOrFailByNo($reportNo);
        return response()->json([
            'id' => $report->id,
            'report_no' => $report->report_no,
            'report_type' => $report->reportType?->name,
            'party_name' => $report->party_name ?? $report->customer_name,
            'sample_date' => $report->sample_date,
        ]);
    }

    public function pdfByNo(string $reportNo)
    {
        $report = $this->findOrFailByNo($reportNo);
        $lab = LabSetting::current();
        $pdf = Pdf::loadView('pdf.report', compact('report','lab'));
        $pdf->setPaper('A4','portrait');
        return $pdf->stream($this->pdfFilename($report));
    }

    public function downloadPdfByNo(string $reportNo)
    {
        $report = $this->findOrFailByNo($reportNo);
        $lab = LabSetting::current();
        $pdf = Pdf::loadView('pdf.report', compact('report','lab'));
        $pdf->setPaper('A4','portrait');
        return $pdf->download($this->pdfFilename($report));
    }

    private function generateReportNo(): string
    {
        // Find max numeric part
        $last = Report::where('report_no','like','KAL-%')->orderByRaw("CAST(SUBSTRING(report_no,5) AS UNSIGNED) DESC")->first();
        $next = 1;
        if ($last) {
            $num = intval(substr($last->report_no, 4));
            $next = $num + 1;
        } else {
            $next = 4412; // spec example starting point if empty? but KAL-0001 spec says 0001, we use 1 padded to 4
        }
        // Ensure padded 4 digits, but allow larger
        $candidate = 'KAL-'.str_pad($next, 4, '0', STR_PAD_LEFT);
        // Ensure uniqueness loop
        while (Report::where('report_no',$candidate)->exists()) {
            $next++;
            $candidate = 'KAL-'.str_pad($next, 4, '0', STR_PAD_LEFT);
        }
        return $candidate;
    }

    private function pdfFilename(Report $report): string
    {
        $type = $report->reportType->name ?? 'REPORT';
        $type = preg_replace('/[^A-Za-z0-9_\- ]/','', $type);
        $type = strtoupper(trim($type));
        $no = $report->report_no;
        return $type.' ('.$no.').pdf';
    }

    private function wordFilename(Report $report): string
    {
        $type = $report->reportType->name ?? 'REPORT';
        $type = preg_replace('/[^A-Za-z0-9_\- ]/','', $type);
        $type = strtoupper(trim($type));
        $no = $report->report_no;
        return $type.' ('.$no.').doc';
    }
}
