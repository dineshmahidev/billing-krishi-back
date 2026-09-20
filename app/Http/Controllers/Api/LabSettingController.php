<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LabSetting;
use Illuminate\Http\Request;

class LabSettingController extends Controller
{
    public function index()
    {
        return response()->json(LabSetting::current());
    }

    public function update(Request $request)
    {
        if (!$request->user()->isAdmin()) return response()->json(['message'=>'Forbidden'], 403);
        $lab = LabSetting::current();
        $data = $request->validate([
            'lab_name'=>'sometimes|required|string',
            'tagline'=>'sometimes|nullable|string',
            'address'=>'sometimes|nullable|string',
            'phone'=>'sometimes|nullable|string',
            'email'=>'sometimes|nullable|email',
            'logo'=>'sometimes|nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
            'seal'=>'sometimes|nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
            'signature'=>'sometimes|nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
        ]);
        foreach (['logo','seal','signature'] as $field) {
            if ($request->hasFile($field)) {
                $path = $request->file($field)->store('lab','public');
                $data[$field.'_path'] = 'storage/'.$path;
                unset($data[$field]);
            }
        }
        if ($request->has('logo_path')) $data['logo_path'] = $request->input('logo_path');
        $lab->update($data);
        return response()->json($lab);
    }
}
