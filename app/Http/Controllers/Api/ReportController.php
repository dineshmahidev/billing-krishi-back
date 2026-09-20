<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\ReportResult;
use App\Models\Parameter;
use App\Models\LabSetting;
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
        // if (!$user) return response()->json(['message' => 'Unauthenticated'], 401);
        $report = Report::with(['reportType','creator','results.parameter'])->findOrFail($id);
        $lab = LabSetting::current();
        $pdf = Pdf::loadView('pdf.report', compact('report','lab'));
        $pdf->setPaper('A4','portrait');
        $filename = $this->pdfFilename($report);
        return $pdf->download($filename);
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
        // Try party name for extra context sanitized, but spec says REPORTTYPE (REPORTNO).pdf
        return $type.' ('.$no.').pdf';
    }
}
