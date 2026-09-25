<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate(['email'=>'required|email','password'=>'required']);
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message'=>'Invalid email or password'], 422);
        }
        if ($user->status !== 'active') {
            return response()->json(['message'=>'Account is disabled'], 403);
        }
        $token = $user->createToken('api')->plainTextToken;
        return response()->json(['token'=>$token,'user'=>$user]);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message'=>'Logged out']);
    }

    public function updateProfile(Request $request)
    {
        $request->validate(['name'=>'required|string|max:255']);
        $user = $request->user();
        $user->name = $request->name;
        $user->save();
        return response()->json(['message'=>'Profile updated','user'=>$user]);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password'=>'required',
            'password'=>'required|min:6|confirmed',
        ]);
        $user = $request->user();
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['message'=>'Current password is incorrect'], 422);
        }
        $user->password = $request->password;
        $user->save();
        return response()->json(['message'=>'Password changed successfully']);
    }
}
