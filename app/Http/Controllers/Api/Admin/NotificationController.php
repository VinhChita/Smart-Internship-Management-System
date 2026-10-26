<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppNotification;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // Broadcast to a role ("all", "intern", "supervisor")
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'nullable|string',
            'target' => 'required|in:all,intern,supervisor',
        ]);

        $users = User::where('status', 'approved')
            ->when($data['target'] !== 'all', fn ($q) => $q->where('role', $data['target']))
            ->pluck('id');

        $rows = $users->map(fn ($id) => [
            'user_id' => $id,
            'title' => $data['title'],
            'body' => $data['body'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ])->all();

        AppNotification::insert($rows);

        return response()->json(['message' => 'Sent', 'recipients' => count($rows)], 201);
    }
}
