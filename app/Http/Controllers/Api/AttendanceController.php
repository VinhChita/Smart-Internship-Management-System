<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Attendance::with('intern');

        if ($user->isIntern()) {
            $query->where('intern_id', $user->id);
        } elseif ($user->isSupervisor()) {
            $query->where('supervisor_id', $user->id);
        }

        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        return response()->json($query->latest('date')->paginate(30));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'intern_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'status' => 'required|in:present,absent,late,excused',
            'note' => 'nullable|string|max:255',
        ]);

        $record = Attendance::updateOrCreate(
            ['intern_id' => $data['intern_id'], 'date' => $data['date']],
            ['supervisor_id' => $request->user()->id, 'status' => $data['status'], 'note' => $data['note'] ?? null]
        );

        return response()->json($record, 201);
    }
}
