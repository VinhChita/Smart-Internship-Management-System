<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AppNotification;
use App\Models\Evaluation;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Evaluation::with(['intern', 'supervisor', 'program']);

        if ($user->isIntern()) {
            $query->where('intern_id', $user->id);
        } elseif ($user->isSupervisor()) {
            $query->where('supervisor_id', $user->id);
        }

        return response()->json($query->latest()->paginate(15));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'intern_id' => 'required|exists:users,id',
            'program_id' => 'nullable|exists:internship_programs,id',
            'score' => 'required|integer|min:0|max:100',
            'feedback' => 'nullable|string',
        ]);

        $data['supervisor_id'] = $request->user()->id;
        $evaluation = Evaluation::create($data);

        AppNotification::create([
            'user_id' => $data['intern_id'],
            'title' => 'New evaluation',
            'body' => 'You received a new evaluation score: '.$data['score'].'/100.',
        ]);

        return response()->json($evaluation, 201);
    }
}
