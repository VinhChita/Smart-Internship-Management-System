<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Company;
use App\Models\Program;
use App\Models\Report;
use App\Models\User;

class DashboardController extends Controller
{
    public function stats()
    {
        return response()->json([
            'interns' => User::where('role', 'intern')->where('status', 'approved')->count(),
            'supervisors' => User::where('role', 'supervisor')->where('status', 'approved')->count(),
            'companies' => Company::count(),
            'active_programs' => Program::where('status', 'open')->count(),
            'pending_registrations' => User::where('status', 'pending')->count(),
            'pending_applications' => Application::where('status', 'pending')->count(),
            'reports_submitted' => Report::where('status', 'submitted')->count(),
        ]);
    }
}
