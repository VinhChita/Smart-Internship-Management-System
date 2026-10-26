<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AppNotification;
use App\Models\Application;
use App\Models\Program;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Application::with(['program.company', 'intern']);

        if ($user->isIntern()) {
            $query->where('intern_id', $user->id);
        } elseif ($user->isSupervisor()) {
            $query->whereHas('program', fn ($q) => $q->where('created_by', $user->id));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return response()->json($query->latest()->paginate(15));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'program_id' => 'required|exists:internship_programs,id',
            'cover_letter' => 'nullable|string',
        ]);

        $program = Program::findOrFail($data['program_id']);

        if ($program->status !== 'open' || $program->deadline->isPast()) {
            return response()->json(['message' => 'Program is closed'], 422);
        }

        if (Application::where('program_id', $program->id)->where('intern_id', $request->user()->id)->exists()) {
            return response()->json(['message' => 'Already applied'], 422);
        }

        $application = Application::create([
            'program_id' => $program->id,
            'intern_id' => $request->user()->id,
            'cover_letter' => $data['cover_letter'] ?? null,
        ]);

        return response()->json($application, 201);
    }

    public function review(Request $request, Application $application)
    {
        $data = $request->validate(['status' => 'required|in:approved,rejected']);

        $user = $request->user();
        if ($user->isSupervisor() && $application->program->created_by !== $user->id) {
            abort(403, 'Forbidden');
        }

        $application->update(['status' => $data['status'], 'reviewed_by' => $user->id]);

        AppNotification::create([
            'user_id' => $application->intern_id,
            'title' => 'Application '.$data['status'],
            'body' => 'Your application for "'.$application->program->title.'" was '.$data['status'].'.',
        ]);

        return response()->json($application);
    }
}
