<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\AppNotification;
use App\Models\Application;
use App\Models\Company;
use App\Models\Program;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'interns' => User::where('role', 'intern')->where('status', 'approved')->count(),
            'supervisors' => User::where('role', 'supervisor')->where('status', 'approved')->count(),
            'companies' => Company::count(),
            'programs' => Program::where('status', 'open')->count(),
            'pending' => User::where('status', 'pending')->count(),
            'applications' => Application::where('status', 'pending')->count(),
            'reports' => Report::where('status', 'submitted')->count(),
        ];

        $recentUsers = User::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers'));
    }

    // ----- Users -----
    public function users(Request $request)
    {
        $users = User::query()
            ->when($request->filled('role'), fn ($q) => $q->where('role', $request->role))
            ->when($request->filled('q'), function ($q) use ($request) {
                $s = $request->q;
                $q->where(fn ($w) => $w->where('name', 'like', "%$s%")->orWhere('email', 'like', "%$s%"));
            })
            ->latest()->paginate(10)->withQueryString();

        return view('admin.users', compact('users'));
    }

    public function storeUser(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,supervisor,intern',
        ]);
        $data['status'] = 'approved';

        User::create($data);

        return back()->with('success', 'បានបង្កើតអ្នកប្រើប្រាស់');
    }

    public function destroyUser(Request $request, User $user)
    {
        if ($user->id === $request->user()->id) {
            return back()->withErrors(['user' => 'មិនអាចលុបគណនីខ្លួនឯងបានទេ']);
        }

        $user->delete();

        return back()->with('success', 'បានលុបអ្នកប្រើប្រាស់');
    }

    // ----- Registrations -----
    public function registrations()
    {
        $users = User::where('status', 'pending')->where('role', '!=', 'admin')->latest()->paginate(10);

        return view('admin.registrations', compact('users'));
    }

    public function approve(User $user)
    {
        $user->update(['status' => 'approved']);

        return back()->with('success', 'បានអនុម័ត '.$user->name);
    }

    public function reject(User $user)
    {
        $user->update(['status' => 'rejected']);

        return back()->with('success', 'បានបដិសេធ '.$user->name);
    }

    // ----- Companies -----
    public function companies()
    {
        $companies = Company::withCount('programs')->latest()->paginate(10);

        return view('admin.companies', compact('companies'));
    }

    public function storeCompany(Request $request)
    {
        Company::create($request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string|max:30',
        ]));

        return back()->with('success', 'បានបន្ថែមក្រុមហ៊ុន');
    }

    public function destroyCompany(Company $company)
    {
        $company->delete();

        return back()->with('success', 'បានលុបក្រុមហ៊ុន');
    }

    // ----- Programs -----
    public function programs()
    {
        $programs = Program::with('company')->withCount('applications')->latest()->paginate(10);
        $companies = Company::orderBy('name')->get();

        return view('admin.programs', compact('programs', 'companies'));
    }

    public function storeProgram(Request $request)
    {
        $data = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'field' => 'nullable|string|max:100',
            'slots' => 'required|integer|min:1',
            'deadline' => 'required|date',
            'status' => 'required|in:draft,open,closed',
        ]);
        $data['created_by'] = $request->user()->id;

        Program::create($data);

        return back()->with('success', 'បានបង្កើតកម្មវិធីកម្មសិក្សា');
    }

    public function destroyProgram(Program $program)
    {
        $program->delete();

        return back()->with('success', 'បានលុបកម្មវិធី');
    }

    // ----- Notifications -----
    public function notifications()
    {
        return view('admin.notifications');
    }

    public function sendNotification(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'nullable|string',
            'target' => 'required|in:all,intern,supervisor',
        ]);

        $ids = User::where('status', 'approved')
            ->when($data['target'] !== 'all', fn ($q) => $q->where('role', $data['target']))
            ->pluck('id');

        AppNotification::insert($ids->map(fn ($id) => [
            'user_id' => $id,
            'title' => $data['title'],
            'body' => $data['body'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ])->all());

        return back()->with('success', 'បានផ្ញើទៅ '.$ids->count().' នាក់');
    }
}
