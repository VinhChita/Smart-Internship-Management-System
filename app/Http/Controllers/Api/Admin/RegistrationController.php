<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'pending');

        return response()->json(
            User::where('status', $status)->where('role', '!=', 'admin')->latest()->paginate(20)
        );
    }

    public function approve(User $user)
    {
        $user->update(['status' => 'approved']);

        return response()->json($user);
    }

    public function reject(User $user)
    {
        $user->update(['status' => 'rejected']);

        return response()->json($user);
    }
}
