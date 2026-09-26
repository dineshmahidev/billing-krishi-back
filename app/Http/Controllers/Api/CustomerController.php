<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\Report;
use App\Models\ReportResult;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $q = Customer::query()->with('group:id,name');
        if ($search = $request->search) {
            $q->where(function($qq) use ($search){
                $qq->where('name','like',"%$search%")
                  ->orWhere('company_name','like',"%$search%")
                  ->orWhere('phone','like',"%$search%")
                  ->orWhere('email','like',"%$search%");
            });
        }
        if ($request->has('is_active')) $q->where('is_active', $request->boolean('is_active'));
        $q->orderBy('name');
        $perPage = $request->input('per_page', 15);
        if ($request->has('all')) return response()->json($q->get());
        return response()->json($q->paginate($perPage));
    }

    public function show($id) { return response()->json(Customer::findOrFail($id)); }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:customers,name',
            'company_name' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:1000',
            'gstin' => 'nullable|string|max:30',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
        ]);
        $customer = Customer::create($data);
        return response()->json($customer, 201);
    }

    public function update(Request $request, $id)
    {
        $c = Customer::findOrFail($id);
        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255|unique:customers,name,'.$c->id,
            'company_name' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:1000',
            'gstin' => 'nullable|string|max:30',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
        ]);
        $c->update($data);
        return response()->json($c);
    }

    public function destroy($id)
    {
        $c = Customer::findOrFail($id);
        $c->delete();
        return response()->json(['message'=>'Deleted']);
    }

    // For autocomplete - lightweight
    public function search(Request $request)
    {
        $q = $request->q ?? $request->search ?? '';
        $list = Customer::where('is_active', true)
            ->where(function ($qq) use ($q) {
                $qq->where('name', 'like', "%$q%")
                  ->orWhere('company_name', 'like', "%$q%");
            })
            ->limit(10)->get(['id','name','company_name','phone','email','address','gstin']);
        return response()->json($list);
    }

    // ---------- Company groups ----------
    public function groups()
    {
        $groups = CustomerGroup::withCount('customers')
            ->with('customers:id,name,company_name,phone,group_id')
            ->orderBy('name')->get();
        return response()->json($groups);
    }

    public function storeGroup(Request $request)
    {
        if (!$request->user()->isAdmin()) return response()->json(['message'=>'Forbidden'], 403);
        $data = $request->validate(['name'=>'required|string|max:100|unique:customer_groups,name']);
        return response()->json(CustomerGroup::create($data), 201);
    }

    public function updateGroup(Request $request, $id)
    {
        if (!$request->user()->isAdmin()) return response()->json(['message'=>'Forbidden'], 403);
        $g = CustomerGroup::findOrFail($id);
        $data = $request->validate(['name'=>'required|string|max:100|unique:customer_groups,name,'.$g->id]);
        $g->update($data);
        return response()->json($g);
    }

    public function destroyGroup($id)
    {
        $g = CustomerGroup::findOrFail($id);
        Customer::where('group_id', $g->id)->update(['group_id'=>null]);
        $g->delete();
        return response()->json(['message'=>'Group deleted']);
    }

    // Replace the group's members with the selected companies
    public function assignGroup(Request $request, $id)
    {
        if (!$request->user()->isAdmin()) return response()->json(['message'=>'Forbidden'], 403);
        $g = CustomerGroup::findOrFail($id);
        $data = $request->validate([
            'customer_ids'=>'nullable|array',
            'customer_ids.*'=>'integer|exists:customers,id',
        ]);
        $ids = $data['customer_ids'] ?? [];
        DB::transaction(function () use ($g, $ids) {
            Customer::where('group_id', $g->id)->whereNotIn('id', $ids)->update(['group_id'=>null]);
            if ($ids) Customer::whereIn('id', $ids)->update(['group_id'=>$g->id]);
        });
        return response()->json($g->fresh('customers:id,name,company_name,phone,group_id'));
    }

    // Party-wise weekly summary: parameter x times tested x rate
    public function summary(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);
        $from = $request->input('from') ?: now()->startOfWeek()->toDateString();
        $to = $request->input('to') ?: now()->endOfWeek()->toDateString();

        $names = array_values(array_unique(array_filter(
            [$customer->name, $customer->company_name, $customer->contact_person],
            fn($v) => $v !== null && trim($v) !== ''
        )));

        $reportIds = Report::where(function ($q) use ($customer, $names) {
                $q->where('customer_id', $customer->id)
                  ->orWhereIn('party_name', $names)
                  ->orWhereIn('customer_name', $names);
            })
            ->whereRaw('COALESCE(sample_date, DATE(created_at)) >= ?', [$from])
            ->whereRaw('COALESCE(sample_date, DATE(created_at)) <= ?', [$to])
            ->pluck('id');

        $raw = DB::table('invoice_items')
            ->join('invoices', 'invoices.id', '=', 'invoice_items.invoice_id')
            ->whereIn('invoices.report_id', $reportIds)
            ->groupBy('invoice_items.parameter_id', 'invoice_items.name', 'invoice_items.unit', 'invoice_items.hsn_code')
            ->orderBy('invoice_items.name')
            ->selectRaw('invoice_items.parameter_id, invoice_items.name, invoice_items.unit, invoice_items.hsn_code,
                         SUM(invoice_items.qty) as qty,
                         COUNT(DISTINCT invoices.id) as times,
                         SUM(invoice_items.amount) as amount,
                         ROUND(SUM(invoice_items.amount) / NULLIF(SUM(invoice_items.qty), 0), 2) as rate')
            ->get();

        $rows = $raw->map(function ($r) {
            return [
                'parameter_id' => $r->parameter_id,
                'name' => $r->name,
                'unit' => $r->unit,
                'hsn_code' => $r->hsn_code,
                'rate' => round(floatval($r->rate), 2),
                'times' => (int)$r->times,
                'qty' => (int)$r->qty,
                'amount' => round(floatval($r->amount), 2),
            ];
        });

        $invoices = Invoice::whereIn('report_id', $reportIds)
            ->with('report:id,report_no,sample_date')
            ->orderByDesc('created_at')
            ->get(['id','invoice_no','report_id','status','subtotal','gst_amount','total_amount','created_at']);

        return response()->json([
            'customer' => $customer,
            'range' => ['from'=>$from, 'to'=>$to],
            'report_count' => count($reportIds),
            'test_count' => (int)$rows->sum('times'),
            'rows' => $rows,
            'total' => round($rows->sum('amount'), 2),
            'invoices' => $invoices,
        ]);
    }
}
