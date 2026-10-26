<?php

use App\Http\Controllers\Api\Admin;
use App\Http\Controllers\Api\ApplicationController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EvaluationController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ProgramController;
use App\Http\Controllers\Api\ReportController;
use Illuminate\Support\Facades\Route;

// ---------- Public ----------
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// ---------- Authenticated (all roles) ----------
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::put('/profile', [ProfileController::class, 'update']);
    Route::post('/profile/cv', [ProfileController::class, 'uploadCv']);

    Route::get('/programs', [ProgramController::class, 'index']);
    Route::get('/programs/{program}', [ProgramController::class, 'show']);

    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::patch('/notifications/{notification}/read', [NotificationController::class, 'markRead']);

    Route::get('/messages/{user}', [MessageController::class, 'conversation']);
    Route::post('/messages', [MessageController::class, 'store']);

    Route::get('/applications', [ApplicationController::class, 'index']);
    Route::get('/attendance', [AttendanceController::class, 'index']);
    Route::get('/reports', [ReportController::class, 'index']);
    Route::get('/evaluations', [EvaluationController::class, 'index']);

    // ---------- Intern ----------
    Route::middleware('role:intern')->group(function () {
        Route::post('/applications', [ApplicationController::class, 'store']);
        Route::post('/reports', [ReportController::class, 'store']);
    });

    // ---------- Supervisor + Admin ----------
    Route::middleware('role:supervisor,admin')->group(function () {
        Route::post('/programs', [ProgramController::class, 'store']);
        Route::put('/programs/{program}', [ProgramController::class, 'update']);
        Route::delete('/programs/{program}', [ProgramController::class, 'destroy']);

        Route::patch('/applications/{application}/review', [ApplicationController::class, 'review']);
        Route::post('/attendance', [AttendanceController::class, 'store']);
        Route::patch('/reports/{report}/review', [ReportController::class, 'review']);
        Route::post('/evaluations', [EvaluationController::class, 'store']);
    });

    // ---------- Admin ----------
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', [Admin\DashboardController::class, 'stats']);
        Route::apiResource('users', Admin\UserController::class)->except('show');
        Route::apiResource('companies', Admin\CompanyController::class)->except('show');
        Route::get('/registrations', [Admin\RegistrationController::class, 'index']);
        Route::patch('/registrations/{user}/approve', [Admin\RegistrationController::class, 'approve']);
        Route::patch('/registrations/{user}/reject', [Admin\RegistrationController::class, 'reject']);
        Route::post('/notifications', [Admin\NotificationController::class, 'store']);
    });
});
