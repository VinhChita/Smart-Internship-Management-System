<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $query = Program::with('company')->withCount('applications');

        // Interns only see open programs
        if ($user->isIntern()) {
            $query->where('status', 'open');
        } elseif ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(fn ($w) => $w->where('title', 'like', "%$q%")->orWhere('field', 'like', "%$q%"));
        }

        return response()->json($query->latest()->paginate(15));
    }

    public function show(Program $program)
    {
        return response()->json($program->load('company')->loadCount('applications'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['created_by'] = $request->user()->id;

        return response()->json(Program::create($data), 201);
    }

    public function update(Request $request, Program $program)
    {
        $this->authorizeOwner($request, $program);
        $program->update($this->validated($request));

        return response()->json($program);
    }

    public function destroy(Request $request, Program $program)
    {
        $this->authorizeOwner($request, $program);
        $program->delete();

        return response()->json(['message' => 'Deleted']);
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'company_id' => 'required|exists:companies,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'field' => 'nullable|string|max:100',
            'slots' => 'required|integer|min:1',
            'deadline' => 'required|date',
            'status' => 'required|in:draft,open,closed',
        ]);
    }

    private function authorizeOwner(Request $request, Program $program): void
    {
        $u = $request->user();
        if (! $u->isAdmin() && $program->created_by !== $u->id) {
            abort(403, 'Forbidden');
        }
    }
}
