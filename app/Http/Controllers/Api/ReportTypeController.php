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
            'default_remarks'=>'nullable|string',
            'default_notes'=>'nullable|string',
            'visible_fields'=>'nullable|array',
            'visible_fields.*'=>'string|max:50',
            'active'=>'boolean',
            'show_specification'=>'boolean',
            'custom_columns'=>'nullable|array',
            'custom_columns.*'=>'string|max:50',
            'table_columns'=>'nullable|array',
        ]);
        if (empty($data['quantity_label'])) {
            $data['quantity_label'] = 'Quantity';
        }
        // Keep custom_columns in sync with table_columns if passed
        if (!empty($data['table_columns'])) {
            $customs = [];
            foreach ($data['table_columns'] as $tc) {
                if (($tc['type'] ?? '') === 'custom' || (!in_array($tc['key'] ?? '', ['s_no','parameter','specification','result']))) {
                    if (!empty($tc['label'])) $customs[] = $tc['label'];
                }
            }
            if (!isset($data['custom_columns']) || empty($data['custom_columns'])) {
                $data['custom_columns'] = $customs;
            }
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
            'default_remarks'=>'nullable|string',
            'default_notes'=>'nullable|string',
            'visible_fields'=>'nullable|array',
            'visible_fields.*'=>'string|max:50',
            'active'=>'boolean',
            'show_specification'=>'boolean',
            'custom_columns'=>'nullable|array',
            'custom_columns.*'=>'string|max:50',
            'table_columns'=>'nullable|array',
        ]);
        if (array_key_exists('quantity_label', $data) && empty($data['quantity_label'])) {
            $data['quantity_label'] = 'Quantity';
        }
        if (!empty($data['table_columns'])) {
            $customs = [];
            foreach ($data['table_columns'] as $tc) {
                if (($tc['type'] ?? '') === 'custom' || (!in_array($tc['key'] ?? '', ['s_no','parameter','specification','result']))) {
                    if (!empty($tc['label'])) $customs[] = $tc['label'];
                }
            }
            $data['custom_columns'] = $customs;
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
