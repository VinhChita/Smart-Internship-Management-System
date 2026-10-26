<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'phone' => 'nullable|string|max:30',
            'telegram' => 'nullable|string|max:100',
            'university' => 'nullable|string|max:255',
            'major' => 'nullable|string|max:255',
        ]);

        $request->user()->update($data);

        return response()->json($request->user()->fresh());
    }

    public function uploadCv(Request $request)
    {
        $request->validate(['cv' => 'required|file|mimes:pdf,doc,docx|max:5120']);

        $user = $request->user();
        if ($user->cv_path) {
            Storage::disk('public')->delete($user->cv_path);
        }

        $user->update(['cv_path' => $request->file('cv')->store('cvs', 'public')]);

        return response()->json([
            'message' => 'CV uploaded',
            'cv_url' => Storage::disk('public')->url($user->cv_path),
        ]);
    }
}
