<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:intern,supervisor',
            'phone' => 'nullable|string|max:30',
            'university' => 'nullable|string|max:255',
            'major' => 'nullable|string|max:255',
        ]);

        $data['status'] = 'pending'; // Admin must approve
        $user = User::create($data);

        return response()->json([
            'message' => 'Registration submitted. Please wait for admin approval.',
            'user' => $user,
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (! Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid email or password'], 422);
        }

        $user = Auth::user();

        if ($user->status !== 'approved') {
            Auth::logout();
            return response()->json(['message' => 'Account is '.$user->status], 403);
        }

        $token = $user->createToken('mobile')->plainTextToken;

        return response()->json(['token' => $token, 'user' => $user]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }

    public function me(Request $request)
    {
        return response()->json($request->user()->load('company'));
    }
}
