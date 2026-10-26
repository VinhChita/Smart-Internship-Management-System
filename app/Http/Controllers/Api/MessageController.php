<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    // Conversation with one user
    public function conversation(Request $request, User $user)
    {
        $me = $request->user()->id;

        $messages = Message::where(fn ($q) => $q->where('sender_id', $me)->where('receiver_id', $user->id))
            ->orWhere(fn ($q) => $q->where('sender_id', $user->id)->where('receiver_id', $me))
            ->orderBy('created_at')
            ->get();

        return response()->json($messages);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'body' => 'required|string|max:2000',
        ]);

        if ((int) $data['receiver_id'] === $request->user()->id) {
            return response()->json(['message' => 'Cannot message yourself'], 422);
        }

        $data['sender_id'] = $request->user()->id;

        return response()->json(Message::create($data), 201);
    }
}
