<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Invoice;
use App\Models\LabSetting;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    private function resolveUser(Request $request) {
        $user = $request->user();
        if ($user) return $user;
        $token = $request->bearerToken() ?? $request->query('token');
        if ($token) {
            try { $at = \Laravel\Sanctum\PersonalAccessToken::findToken($token); if ($at && $at->tokenable) return $at->tokenable; } catch (\Throwable $e) {}
        }
        return null;
    }

    public function index(Request $request) {
        $q = Invoice::with(['report.reportType'])->latest();
        if ($search = $request->search) {
            $q->where(function($qq) use ($search){
                $qq->where('invoice_no','like',"%$search%")
                  ->orWhere('party_name','like',"%$search%")
                  ->orWhere('customer_name','like',"%$search%");
            });
        }
        if ($request->company) $q->where(function($qq) use ($request){ $qq->where('party_name','like',"%{$request->company}%")->orWhere('customer_name','like',"%{$request->company}%"); });
        if ($request->status) $q->where('status', $request->status);
        if ($request->report_type_id) $q->whereHas('report', fn($qq)=> $qq->where('report_type_id', $request->report_type_id));
        if ($request->from) $q->whereDate('created_at','>=',$request->from);
        if ($request->to) $q->whereDate('created_at','<=',$request->to);

        $stats = [
            'total_invoices' => (clone $q)->count(),
            'total_revenue' => round((clone $q)->sum('total_amount'),2),
            'paid_revenue' => round((clone $q)->where('status','paid')->sum('total_amount'),2),
            'unpaid_revenue' => round((clone $q)->where('status','unpaid')->sum('total_amount'),2),
            'paid_count' => (clone $q)->where('status','paid')->count(),
            'unpaid_count' => (clone $q)->where('status','unpaid')->count(),
        ];

        $perPage = $request->input('per_page', 15);
        $paginated = $q->paginate($perPage);
        return response()->json(array_merge($paginated->toArray(), ['stats'=>$stats]));
    }

    public function show($reportId) {
        $report = Report::with(['reportType','results.parameter'])->findOrFail($reportId);
        $invoice = Invoice::where('report_id', $report->id)->first();
        if (!$invoice) return response()->json(['message'=>'Invoice not found - generate report first'], 404);
        return response()->json($invoice);
    }

    public function toggleStatus(Request $request, $reportId) {
        $data = $request->validate(['status'=>'required|in:paid,unpaid,partial']);
        $invoice = Invoice::where('report_id',$reportId)->firstOrFail();
        $invoice->status = $data['status'];
        $invoice->save();
        return response()->json($invoice);
    }

    public function toggleGst(Request $request, $reportId) {
        if (!$request->user()->isAdmin()) return response()->json(['message'=>'Admin only'],403);
        $data = $request->validate(['gst_enabled'=>'required|boolean', 'gst_percent'=>'sometimes|numeric|min:0|max:100']);
        $invoice = Invoice::where('report_id',$reportId)->firstOrFail();
        $invoice->gst_enabled = $data['gst_enabled'];
        if (isset($data['gst_percent'])) $invoice->gst_percent = $data['gst_percent'];
        $invoice->gst_amount = $invoice->gst_enabled ? round($invoice->subtotal * $invoice->gst_percent / 100,2) : 0;
        $invoice->total_amount = $invoice->subtotal + $invoice->gst_amount;
        $invoice->save();
        return response()->json($invoice);
    }

    public function pdf(Request $request, $reportId) {
        $this->resolveUser($request);
        $report = Report::with(['reportType','results.parameter'])->findOrFail($reportId);
        $invoice = Invoice::where('report_id',$report->id)->first();
        if (!$invoice) { $invoice = $this->ensureInvoice($report); }
        $lab = LabSetting::current();
        $pdf = Pdf::loadView('pdf.invoice', compact('report','invoice','lab'));
        $pdf->setPaper('A4','portrait');
        return $pdf->stream($invoice->invoice_no.'.pdf');
    }

    public function downloadPdf(Request $request, $reportId) {
        $this->resolveUser($request);
        $report = Report::with(['reportType','results.parameter'])->findOrFail($reportId);
        $invoice = Invoice::where('report_id',$report->id)->first();
        if (!$invoice) $invoice = $this->ensureInvoice($report);
        $lab = LabSetting::current();
        $pdf = Pdf::loadView('pdf.invoice', compact('report','invoice','lab'));
        $pdf->setPaper('A4','portrait');
        return $pdf->download($invoice->invoice_no.'.pdf');
    }

    public function word(Request $request, $reportId)
    {
        $this->resolveUser($request);
        $report = Report::with(['reportType','results.parameter'])->findOrFail($reportId);
        $invoice = Invoice::where('report_id',$report->id)->first();
        if (!$invoice) $invoice = $this->ensureInvoice($report);
        $lab = LabSetting::current();
        $html = view('word.invoice', compact('report','invoice','lab'))->render();
        return response($html, 200, [
            'Content-Type' => 'application/msword',
            'Content-Disposition' => 'inline; filename="'.$invoice->invoice_no.'.doc"',
        ]);
    }

    public function downloadWord(Request $request, $reportId)
    {
        $this->resolveUser($request);
        $report = Report::with(['reportType','results.parameter'])->findOrFail($reportId);
        $invoice = Invoice::where('report_id',$report->id)->first();
        if (!$invoice) $invoice = $this->ensureInvoice($report);
        $lab = LabSetting::current();
        $html = view('word.invoice', compact('report','invoice','lab'))->render();
        return response($html, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'Content-Disposition' => 'attachment; filename="'.$invoice->invoice_no.'.doc"',
        ]);
    }

    private function ensureInvoice(Report $report): Invoice {
        $existing = Invoice::where('report_id',$report->id)->first();
        if ($existing) return $existing;
        $lab = LabSetting::current();
        $subtotal = $report->results->sum(fn($r) => floatval($r->parameter->price ?? 0));
        $gstEnabled = (bool)($lab->gst_enabled ?? true);
        $gstPercent = floatval($lab->default_gst_percent ?? 18);
        $gstAmount = $gstEnabled ? round($subtotal * $gstPercent / 100,2) : 0;
        return Invoice::create([
            'report_id' => $report->id,
            'invoice_no' => Invoice::nextNo(),
            'party_name' => $report->party_name,
            'customer_name' => $report->customer_name,
            'subtotal' => $subtotal,
            'gst_percent' => $gstPercent,
            'gst_amount' => $gstAmount,
            'total_amount' => $subtotal + $gstAmount,
            'gst_enabled' => $gstEnabled,
            'status' => 'unpaid',
        ]);
    }
}
