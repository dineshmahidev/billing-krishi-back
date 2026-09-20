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
        $data = $request->validate(['name'=>'required|unique:report_types,name','title'=>'required','active'=>'boolean']);
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
        $data = $request->validate(['name'=>'sometimes|required|unique:report_types,name,'.$id,'title'=>'sometimes|required','active'=>'boolean']);
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
