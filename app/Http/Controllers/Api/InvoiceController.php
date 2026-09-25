<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Invoice;
use App\Models\LabSetting;
use App\Models\CustomerGroup;
use App\Models\Customer;
use App\Models\ReportType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Support\PdfFont;
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
        $invoice = Invoice::with('items')->where('report_id', $report->id)->first();
        if (!$invoice) return response()->json(['message'=>'Invoice not found - generate report first'], 404);
        if ($invoice->items->isEmpty()) { $invoice->syncItems($report); $invoice->recalcTotals(); $invoice->refresh()->load('items'); }
        return response()->json($invoice);
    }

    // Admin: edit invoice line rates & quantities (parameter rows stay static / follow report)
    public function updateItems(Request $request, $reportId) {
        if (!$request->user()->isAdmin()) return response()->json(['message'=>'Admin only'],403);
        $report = Report::with(['results.parameter'])->findOrFail($reportId);
        $invoice = Invoice::where('report_id',$report->id)->first() ?? $this->ensureInvoice($report);
        $data = $request->validate([
            'items'=>'required|array|min:1',
            'items.*.parameter_id'=>'required|integer|exists:parameters,id',
            'items.*.rate'=>'required|numeric|min:0|max:9999999',
            'items.*.qty'=>'required|integer|min:1|max:99999',
        ]);
        $invoice->syncItems($report);
        foreach ($data['items'] as $in) {
            $item = $invoice->items()->where('parameter_id', $in['parameter_id'])->first();
            if (!$item) continue;
            $item->rate = round(floatval($in['rate']), 2);
            $item->qty = (int)$in['qty'];
            $item->amount = round($item->rate * $item->qty, 2);
            $item->save();
        }
        $invoice->recalcTotals();
        return response()->json($invoice->fresh('items'));
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
        $invoice = $this->invoiceFor($report);
        $lab = LabSetting::current();
        $pdf = Pdf::loadView('pdf.invoice', compact('report','invoice','lab'));
        PdfFont::apply($pdf);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream($invoice->invoice_no.'.pdf');
    }

    public function downloadPdf(Request $request, $reportId) {
        $this->resolveUser($request);
        $report = Report::with(['reportType','results.parameter'])->findOrFail($reportId);
        $invoice = $this->invoiceFor($report);
        $lab = LabSetting::current();
        $pdf = Pdf::loadView('pdf.invoice', compact('report','invoice','lab'));
        PdfFont::apply($pdf);
        $pdf->setPaper('A4','portrait');
        return $pdf->download($invoice->invoice_no.'.pdf');
    }

    public function word(Request $request, $reportId)
    {
        $this->resolveUser($request);
        $report = Report::with(['reportType','results.parameter'])->findOrFail($reportId);
        $invoice = $this->invoiceFor($report);
        $lab = LabSetting::current();
        $html = view('word.invoice', compact('report','invoice','lab'))->render();
        return response($html, 200, [
            'Content-Type' => 'application/msword; charset=UTF-8',
            'Content-Disposition' => 'inline; filename="'.$invoice->invoice_no.'.doc"',
        ]);
    }

    public function downloadWord(Request $request, $reportId)
    {
        $this->resolveUser($request);
        $report = Report::with(['reportType','results.parameter'])->findOrFail($reportId);
        $invoice = $this->invoiceFor($report);
        $lab = LabSetting::current();
        $html = view('word.invoice', compact('report','invoice','lab'))->render();
        return response($html, 200, [
            'Content-Type' => 'application/msword; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="'.$invoice->invoice_no.'.doc"',
        ]);
    }

    // Invoice with line items (created/synced on first access)
    // ---------- Group / Bulk settlement ----------

    // Resolve member ids + match names for a group or a single customer
    private function scopeOf(Request $request): array {
        $data = $request->validate([
            'group_id'=>'sometimes|nullable|integer|exists:customer_groups,id',
            'customer_id'=>'sometimes|nullable|integer|exists:customers,id',
            'from'=>'nullable|date',
            'to'=>'nullable|date',
        ]);
        if (empty($data['group_id']) && empty($data['customer_id'])) {
            abort(response()->json(['message'=>'group_id or customer_id required'], 422));
        }
        $members = !empty($data['group_id'])
            ? Customer::where('group_id', $data['group_id'])->get()
            : Customer::whereIn('id', [$data['customer_id']])->get();
        $names = $members->flatMap(fn($c)=>[$c->name, $c->company_name, $c->contact_person])
            ->filter(fn($v)=> $v !== null && trim($v) !== '')
            ->unique()->values()->all();
        $from = ($data['from'] ?? null) ?: now()->startOfWeek()->toDateString();
        $to = ($data['to'] ?? null) ?: now()->endOfWeek()->toDateString();
        return [$members, $names, $from, $to, $data];
    }

    private function invoicesQuery($members, array $names) {
        $ids = $members->pluck('id');
        return Invoice::where(function ($qq) use ($ids, $names) {
            $qq->whereHas('report', fn($r) => $r->whereIn('customer_id', $ids))
               ->orWhereIn('party_name', $names)
               ->orWhereIn('customer_name', $names);
        });
    }

    private function reportsQuery($members, array $names, string $from, string $to) {
        $ids = $members->pluck('id');
        return Report::where(function ($q) use ($ids, $names) {
                $q->whereIn('customer_id', $ids)
                  ->orWhereIn('party_name', $names)
                  ->orWhereIn('customer_name', $names);
            })
            ->whereRaw('COALESCE(sample_date, DATE(created_at)) >= ?', [$from])
            ->whereRaw('COALESCE(sample_date, DATE(created_at)) <= ?', [$to]);
    }

    // Tab 2: Group Summary â€” party-wise invoice totals for the selected duration
    public function groupSummary(Request $request) {
        if (!$request->user()->isAdmin()) return response()->json(['message'=>'Admin only'], 403);
        return response()->json($this->buildGroupSummary($request));
    }

    // Group Summary PDF download
    public function groupSummaryPdf(Request $request) {
        if (!$request->user()->isAdmin()) return response()->json(['message'=>'Admin only'], 403);
        $data = $this->buildGroupSummary($request);
        $pdf = Pdf::loadView('pdf.group-summary', ['data'=>$data, 'lab'=>LabSetting::current()]);
        PdfFont::apply($pdf);
        $pdf->setPaper('A4', 'portrait');
        $who = $data['scope']==='group' ? ($data['group']->name ?? 'group') : ($data['customer']->name ?? 'party');
        $file = 'group-summary-'.preg_replace('/[^A-Za-z0-9]+/', '-', $who).'-'.$data['range']['from'].'-to-'.$data['range']['to'].'.pdf';
        return $pdf->download($file);
    }

    private function buildGroupSummary(Request $request): array {
        [$members, $names, $from, $to] = $this->scopeOf($request);

        $invoices = $this->invoicesQuery($members, $names)
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->with('report:id,customer_id,party_name,customer_name')
            ->get(['id','invoice_no','report_id','party_name','customer_name','status','subtotal','gst_amount','total_amount','created_at']);

        $byMember = $members->mapWithKeys(fn($c) => [$c->id => [
            'customer_id'=>$c->id, 'party'=>$c->company_name ?: $c->name,
            'invoices'=>0, 'paid'=>0, 'unpaid'=>0, 'partial'=>0, 'amount'=>0.0, 'paid_amount'=>0.0,
        ]])->all();

        $unmatched = ['customer_id'=>null, 'party'=>'Other (unmatched)', 'invoices'=>0, 'paid'=>0, 'unpaid'=>0, 'partial'=>0, 'amount'=>0.0, 'paid_amount'=>0.0];
        $hasUnmatched = false;

        foreach ($invoices as $inv) {
            $target = null;
            $key = null;
            $cid = $inv->report?->customer_id;
            if ($cid && isset($byMember[$cid])) { $key = $cid; $target = $byMember[$cid]; }
            if (!$target) {
                $invName = trim((string)($inv->party_name ?: $inv->customer_name));
                foreach ($members as $c) {
                    foreach ([$c->name, $c->company_name, $c->contact_person] as $nm) {
                        if ($nm && strcasecmp(trim($nm), $invName) === 0) { $key = $c->id; $target = $byMember[$c->id]; break 3; }
                    }
                }
            }
            if (!$target) { $key = '__unmatched'; $target = $unmatched; }
            $target['invoices']++;
            $target[$inv->status] = ($target[$inv->status] ?? 0) + 1;
            $target['amount'] = round($target['amount'] + floatval($inv->total_amount), 2);
            if ($inv->status === 'paid') $target['paid_amount'] = round($target['paid_amount'] + floatval($inv->total_amount), 2);
            if ($key === '__unmatched') $unmatched = $target; else $byMember[$key] = $target;
        }

        $rows = array_values($byMember);
        if ($unmatched['invoices'] > 0) $rows[] = $unmatched;

        return [
            'group' => !empty($request->group_id) ? CustomerGroup::find($request->group_id) : null,
            'customer' => !empty($request->customer_id) ? Customer::find($request->customer_id) : null,
            'scope' => !empty($request->group_id) ? 'group' : 'party',
            'range' => ['from'=>$from, 'to'=>$to],
            'rows' => $rows,
            'totals' => [
                'invoices' => (int)collect($rows)->sum('invoices'),
                'amount' => round(collect($rows)->sum('amount'), 2),
                'paid_amount' => round(collect($rows)->sum('paid_amount'), 2),
            ],
        ];
    }

    // Tab 3: Bulk Settlement â€” type-wise parameter breakdown, static rate + editable qty
    public function bulkSettlement(Request $request) {
        if (!$request->user()->isAdmin()) return response()->json(['message'=>'Admin only'], 403);
        return response()->json($this->buildSettlement($request));
    }

    // Type-wise settlement bill PDF (each report type = one bill section)
    public function settlementPdf(Request $request) {
        if (!$request->user()->isAdmin()) return response()->json(['message'=>'Admin only'], 403);
        $data = $this->buildSettlement($request);

        // Apply edited rate / qty overrides from the screen
        $map = [];
        foreach ((array)$request->input('overrides', []) as $o) {
            if (!isset($o['type_id'], $o['parameter_id'])) continue;
            $map[$o['type_id'].':'.$o['parameter_id']] = [
                'rate' => round(floatval($o['rate'] ?? 0), 2),
                'qty' => max(0, (int)($o['qty'] ?? 0)),
            ];
        }
        $grand = 0.0;
        foreach ($data['types'] as &$ty) {
            foreach ($ty['rows'] as &$row) {
                $k = $ty['report_type_id'].':'.$row['parameter_id'];
                if (isset($map[$k])) {
                    $row['rate'] = $map[$k]['rate'];
                    $row['qty'] = $map[$k]['qty'];
                }
                $row['amount'] = round($row['rate'] * $row['qty'], 2);
            }
            unset($row);
            $ty['subtotal'] = round(collect($ty['rows'])->sum('amount'), 2);
            $grand += $ty['subtotal'];
        }
        unset($ty);
        $data['grand_total'] = round($grand, 2);
        $data['edited'] = count($map) > 0;

        $pdf = Pdf::loadView('pdf.settlement', ['data'=>$data, 'lab'=>LabSetting::current()]);
        PdfFont::apply($pdf);
        $pdf->setPaper('A4', 'portrait');
        $who = $data['scope']==='group' ? ($data['group']['name'] ?? 'group') : ($data['customer']['name'] ?? 'party');
        $file = 'settlement-'.preg_replace('/[^A-Za-z0-9]+/', '-', $who).'-'.$data['range']['from'].'-to-'.$data['range']['to'].'.pdf';
        return $pdf->download($file);
    }

    private function buildSettlement(Request $request): array {
        [$members, $names, $from, $to] = $this->scopeOf($request);

        $reportIds = $this->reportsQuery($members, $names, $from, $to)->pluck('id');
        $typeNames = ReportType::pluck('name', 'id');
        $reportsPerType = Report::whereIn('id', $reportIds)->groupBy('report_type_id')
            ->selectRaw('report_type_id, COUNT(*) as c')->pluck('c', 'report_type_id');

        $raw = DB::table('report_results')
            ->join('parameters', 'parameters.id', '=', 'report_results.parameter_id')
            ->join('reports', 'reports.id', '=', 'report_results.report_id')
            ->whereIn('report_results.report_id', $reportIds)
            ->where(function ($q) { $q->whereNull('report_results.enabled')->orWhere('report_results.enabled', 1); })
            ->groupBy('reports.report_type_id', 'parameters.id', 'parameters.name', 'parameters.unit', 'parameters.price')
            ->orderBy('parameters.name')
            ->selectRaw('reports.report_type_id, parameters.id as parameter_id, parameters.name, parameters.unit,
                         parameters.price as rate, COUNT(*) as times')
            ->get();

        $grouped = [];
        foreach ($raw as $r) {
            $tid = $r->report_type_id ?: 0;
            $grouped[$tid] = $grouped[$tid] ?? ['report_type_id'=>$tid, 'name'=>$typeNames[$tid] ?? 'Unknown', 'reports'=>(int)($reportsPerType[$tid] ?? 0), 'rows'=>[]];
            $rate = round(floatval($r->rate), 2);
            $times = (int)$r->times;
            $grouped[$tid]['rows'][] = [
                'parameter_id' => $r->parameter_id,
                'name' => $r->name,
                'unit' => $r->unit,
                'rate' => $rate,          // default static price â€” editable on screen
                'times' => $times,
                'qty' => $times,          // editable, defaults to times tested
                'amount' => round($rate * $times, 2),
            ];
        }
        foreach ($grouped as &$g) $g['subtotal'] = round(collect($g['rows'])->sum('amount'), 2);
        unset($g);
        ksort($grouped);

        $gid = $request->input('group_id');
        $cid = $request->input('customer_id');
        return [
            'scope' => $gid ? 'group' : 'party',
            'group' => $gid ? CustomerGroup::find($gid) : null,
            'customer' => $cid ? Customer::find($cid) : null,
            'range' => ['from'=>$from, 'to'=>$to],
            'report_count' => count($reportIds),
            'types' => array_values($grouped),
            'grand_total' => round(collect($grouped)->sum('subtotal'), 2),
        ];
    }

    private function invoiceFor(Report $report): Invoice {
        $invoice = $this->ensureInvoice($report);
        if ($invoice->items()->count() === 0) { $invoice->syncItems($report); $invoice->recalcTotals(); }
        $invoice->load('items');
        return $invoice;
    }

    private function ensureInvoice(Report $report): Invoice {
        $existing = Invoice::where('report_id',$report->id)->first();
        if ($existing) { if ($existing->items()->count() === 0) { $existing->syncItems($report); $existing->recalcTotals(); } return $existing; }
        $lab = LabSetting::current();
        $subtotal = $report->results->filter(fn($r) => $r->enabled !== false)->sum(fn($r) => floatval($r->parameter->price ?? 0));
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
            'status' => 'unpaid',
        ]);
        $invoice->syncItems($report);
        $invoice->recalcTotals();
        return $invoice;
    }
}
