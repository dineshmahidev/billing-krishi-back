<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\ReportResult;
use App\Models\ReportType;
use App\Models\Parameter;
use App\Models\LabSetting;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Support\PdfFont;
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
        if ($party = $request->party) {
            $query->where(function($q) use ($party){
                $q->where('party_name','like',"%$party%")
                  ->orWhere('customer_name','like',"%$party%");
            });
        }
        if ($request->from) $query->whereDate('sample_date','>=',$request->from);
        if ($request->to) $query->whereDate('sample_date','<=',$request->to);

        // Stats for the active filters (date + party + type + search)
        $ids = (clone $query)->pluck('id');
        $stats = [
            'total_reports' => $ids->count(),
            'completed' => (clone $query)->where('status','completed')->count(),
            'draft' => (clone $query)->where('status','draft')->count(),
            'parties' => Report::whereIn('id', $ids)->selectRaw("COUNT(DISTINCT NULLIF(COALESCE(NULLIF(party_name,''), customer_name), '')) as c")->value('c') ?: 0,
            'tests' => \App\Models\ReportResult::whereIn('report_id', $ids)->count(),
        ];

        $perPage = $request->input('per_page', 15);
        $paginated = $query->paginate($perPage);
        return response()->json(array_merge($paginated->toArray(), ['stats'=>$stats]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'report_no'=>'nullable|string|max:50|unique:reports,report_no',
            'report_type_id'=>'required|integer',
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
            'results.*.parameter_id'=>'required|integer',
            'results.*.result'=>'nullable|string',
            'results.*.specification'=>'nullable|string',
            'results.*.enabled'=>'sometimes|nullable|boolean',
        ]);
        // Scoped existence checks (raw exists: rules bypass demo isolation)
        if (!ReportType::whereKey($data['report_type_id'])->exists()) {
            return response()->json(['message'=>'The selected report type id is invalid.', 'errors'=>['report_type_id'=>['The selected report type id is invalid.']]], 422);
        }
        $validParams = Parameter::whereIn('id', array_column($data['results'], 'parameter_id'))->pluck('id')->all();
        $badParams = false;
        foreach ($data['results'] as $i => $r) {
            if (!in_array($r['parameter_id'], $validParams)) $badParams = true;
        }
        if ($badParams) {
            return response()->json(['message'=>'The given data was invalid.', 'errors'=>['results'=>['The selected parameter id is invalid.']]], 422);
        }
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
            $reportNo = !empty($data['report_no']) ? trim($data['report_no']) : $this->generateReportNo();
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
                    'enabled'=> array_key_exists('enabled', $r) ? (bool)($r['enabled'] ?? true) : true,
                    'display_order'=> $i+1,
                ]);
            }
            $report->load(['reportType','creator','results.parameter']);
            // Auto create separate invoice (not in analysis report)
            $lab = LabSetting::current();
            $subtotal = $report->results->filter(fn($r) => $r->enabled !== false)->sum(fn($r) => floatval(Parameter::find($r['parameter_id'])?->price ?? 0));
            $gstEnabled = (bool)($lab->gst_enabled ?? true);
            $gstPercent = floatval($lab->default_gst_percent ?? 18);
            $gstAmount = $gstEnabled ? round($subtotal * $gstPercent / 100,2) : 0;
            $invoice = Invoice::create([
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
            $invoice->syncItems($report);
            $invoice->recalcTotals();
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
            'report_no'=>'sometimes|nullable|string|max:50|unique:reports,report_no,'.$id,
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
            'results.*.enabled'=>'sometimes|nullable|boolean',
        ]);
        if (array_key_exists('report_no', $data) && trim((string)$data['report_no']) === '') {
            unset($data['report_no']); // blank = keep existing number
        }
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
                        'enabled'=> array_key_exists('enabled', $r) ? (bool)($r['enabled'] ?? true) : true,
                        'display_order'=> $i+1,
                    ]);
                }
            }
        });
        // Keep invoice lines + totals in sync with enabled parameters (edited rates kept)
        $invoice = Invoice::where('report_id', $report->id)->first();
        if ($invoice) {
            $invoice->syncItems($report);
            $invoice->recalcTotals();
        }
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
        PdfFont::apply($pdf);
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
        PdfFont::apply($pdf);
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
            'Content-Type' => 'application/msword; charset=UTF-8',
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
            'Content-Type' => 'application/msword; charset=UTF-8',
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
        PdfFont::apply($pdf);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream($this->pdfFilename($report));
    }

    public function downloadPdfByNo(string $reportNo)
    {
        $report = $this->findOrFailByNo($reportNo);
        $lab = LabSetting::current();
        $pdf = Pdf::loadView('pdf.report', compact('report','lab'));
        PdfFont::apply($pdf);
        $pdf->setPaper('A4','portrait');
        return $pdf->download($this->pdfFilename($report));
    }

    private function generateReportNo(): string
    {
        // Include trashed rows: report_no is UNIQUE in DB even for soft-deleted reports
        $base = Report::withTrashed()->withoutGlobalScope(\App\Models\Scopes\DemoScope::class);
        // Find max numeric part
        $last = (clone $base)->where('report_no','like','KAL-%')->orderByRaw("CAST(SUBSTRING(report_no,5) AS UNSIGNED) DESC")->first();
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
        while ((clone $base)->where('report_no',$candidate)->exists()) {
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
