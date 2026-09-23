<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Parameter;
use App\Models\ReportType;
use Illuminate\Http\Request;

class ParameterController extends Controller
{
    public function index(Request $request)
    {
        $q = Parameter::with('reportType');
        if ($request->report_type_id) $q->where('report_type_id', $request->report_type_id);
        if ($request->has('active')) $q->where('active', $request->boolean('active'));
        return response()->json($q->orderBy('display_order')->get());
    }

    public function byType($typeId)
    {
        $type = ReportType::findOrFail($typeId);
        return response()->json($type->activeParameters()->get());
    }

    public function store(Request $request)
    {
        if (!$request->user()->isAdmin()) return response()->json(['message'=>'Forbidden'], 403);
        $data = $request->validate([
            'report_type_id'=>'required|exists:report_types,id',
            'name'=>'required',
            'unit'=>'nullable|string',
            'specification'=>'nullable|string',
            'price'=>'nullable|numeric|min:0|max:999999',
            'hsn_code'=>'nullable|string|max:20',
            'display_order'=>'nullable|integer',
            'active'=>'boolean'
        ]);
        $data['display_order'] = $data['display_order'] ?? (Parameter::where('report_type_id',$data['report_type_id'])->max('display_order')+1);
        $param = Parameter::create($data);
        return response()->json($param, 201);
    }

    public function update(Request $request, $id)
    {
        if (!$request->user()->isAdmin()) return response()->json(['message'=>'Forbidden'], 403);
        $param = Parameter::findOrFail($id);
        $data = $request->validate([
            'name'=>'sometimes|required',
            'unit'=>'nullable|string',
            'specification'=>'nullable|string',
            'price'=>'sometimes|nullable|numeric|min:0|max:999999',
            'hsn_code'=>'sometimes|nullable|string|max:20',
            'display_order'=>'nullable|integer',
            'active'=>'boolean'
        ]);
        $param->update($data);
        return response()->json($param);
    }

    public function destroy(Request $request, $id)
    {
        if (!$request->user()->isAdmin()) return response()->json(['message'=>'Forbidden'], 403);
        $param = Parameter::findOrFail($id);
        if ($param->id && \App\Models\ReportResult::where('parameter_id',$param->id)->exists()) {
            $param->update(['active'=>false]);
            return response()->json(['message'=>'Deactivated (used in reports)','parameter'=>$param]);
        }
        $param->delete();
        return response()->json(['message'=>'Deleted']);
    }
}
