<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ReportType;
use Illuminate\Http\Request;

class ReportTypeController extends Controller
{
    public function index(Request $request)
    {
        $query = ReportType::query();
        if ($request->has('active')) $query->where('active', $request->boolean('active'));
        return response()->json($query->orderBy('name')->get());
    }

    public function store(Request $request)
    {
        if (!$request->user()->isAdmin()) return response()->json(['message'=>'Forbidden'], 403);
        $data = $request->validate([
            'name'=>'required|unique:report_types,name',
            'title'=>'required',
            'quantity_label'=>'nullable|string|max:50',
            'active'=>'boolean',
            'show_specification'=>'boolean',
            'custom_columns'=>'nullable|array',
            'custom_columns.*'=>'string|max:50'
        ]);
        if (empty($data['quantity_label'])) {
            $data['quantity_label'] = 'Quantity';
        }
        $type = ReportType::create($data);
        return response()->json($type, 201);
    }

    public function show($id)
    {
        return response()->json(ReportType::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        if (!$request->user()->isAdmin()) return response()->json(['message'=>'Forbidden'], 403);
        $type = ReportType::findOrFail($id);
        $data = $request->validate([
            'name'=>'sometimes|required|unique:report_types,name,'.$id,
            'title'=>'sometimes|required',
            'quantity_label'=>'nullable|string|max:50',
            'active'=>'boolean',
            'show_specification'=>'boolean',
            'custom_columns'=>'nullable|array',
            'custom_columns.*'=>'string|max:50'
        ]);
        if (array_key_exists('quantity_label', $data) && empty($data['quantity_label'])) {
            $data['quantity_label'] = 'Quantity';
        }
        $type->update($data);
        return response()->json($type);
    }

    public function destroy(Request $request, $id)
    {
        if (!$request->user()->isAdmin()) return response()->json(['message'=>'Forbidden'], 403);
        $type = ReportType::findOrFail($id);
        if ($type->reports()->exists()) return response()->json(['message'=>'Cannot delete: has reports'], 422);
        $type->delete();
        return response()->json(['message'=>'Deleted']);
    }
}
