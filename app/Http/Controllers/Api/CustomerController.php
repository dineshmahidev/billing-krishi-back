<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $q = Customer::query();
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
        $list = Customer::where('name','like',"%$q%")
            ->orWhere('company_name','like',"%$q%")
            ->where('is_active', true)
            ->limit(10)->get(['id','name','company_name','phone','email','address','gstin']);
        return response()->json($list);
    }
}
