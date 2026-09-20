<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->user()->isAdmin()) return response()->json(['message'=>'Forbidden'], 403);
        return response()->json(User::orderBy('created_at','desc')->get());
    }

    public function store(Request $request)
    {
        if (!$request->user()->isAdmin()) return response()->json(['message'=>'Forbidden'], 403);
        $data = $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:6|confirmed',
            'role'=>'sometimes|in:admin,staff',
            'status'=>'sometimes|in:active,inactive',
            'permissions'=>'nullable|array',
            'permissions.*'=>'string',
        ]);
        $data['password'] = Hash::make($data['password']);
        $data['role'] = $data['role'] ?? 'staff';
        $data['status'] = $data['status'] ?? 'active';
        $user = User::create($data);
        return response()->json($user, 201);
    }

    public function show(Request $request, $id)
    {
        if (!$request->user()->isAdmin()) return response()->json(['message'=>'Forbidden'], 403);
        return response()->json(User::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        if (!$request->user()->isAdmin()) return response()->json(['message'=>'Forbidden'], 403);
        $user = User::findOrFail($id);
        $data = $request->validate([
            'name'=>'sometimes|required|string',
            'email'=>'sometimes|required|email|unique:users,email,'.$id,
            'password'=>'sometimes|nullable|min:6|confirmed',
            'role'=>'sometimes|in:admin,staff',
            'status'=>'sometimes|in:active,inactive',
            'permissions'=>'nullable|array',
        ]);
        if (!empty($data['password'])) $data['password'] = Hash::make($data['password']);
        else unset($data['password']);
        $user->update($data);
        return response()->json($user);
    }

    public function updateStatus(Request $request, $id)
    {
        if (!$request->user()->isAdmin()) return response()->json(['message'=>'Forbidden'], 403);
        $user = User::findOrFail($id);
        $data = $request->validate(['status'=>'required|in:active,inactive']);
        $user->update($data);
        return response()->json($user);
    }

    public function destroy(Request $request, $id)
    {
        if (!$request->user()->isAdmin()) return response()->json(['message'=>'Forbidden'], 403);
        $user = User::findOrFail($id);
        if ($user->id === auth()->id()) return response()->json(['message'=>'Cannot delete yourself'], 422);
        $user->delete();
        return response()->json(['message'=>'Deleted']);
    }
}
