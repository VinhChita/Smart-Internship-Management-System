<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AppNotification;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Report::with('intern');

        if ($user->isIntern()) {
            $query->where('intern_id', $user->id);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        return response()->json($query->latest()->paginate(15));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:weekly,final',
            'week_number' => 'nullable|integer|min:1|max:52',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('reports', 'public');
        }
        unset($data['file']);

        $data['intern_id'] = $request->user()->id;

        return response()->json(Report::create($data), 201);
    }

    public function review(Request $request, Report $report)
    {
        $data = $request->validate(['supervisor_feedback' => 'required|string']);

        $report->update($data + ['status' => 'reviewed']);

        AppNotification::create([
            'user_id' => $report->intern_id,
            'title' => 'Report reviewed',
            'body' => 'Your report "'.$report->title.'" has new feedback.',
        ]);

        return response()->json($report);
    }
}
