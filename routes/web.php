<?php

use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Web\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/home', fn () => view('home'))->name('home');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');

    Route::get('/registrations', [AdminController::class, 'registrations'])->name('registrations');
    Route::post('/registrations/{user}/approve', [AdminController::class, 'approve'])->name('registrations.approve');
    Route::post('/registrations/{user}/reject', [AdminController::class, 'reject'])->name('registrations.reject');

    Route::get('/companies', [AdminController::class, 'companies'])->name('companies');
    Route::post('/companies', [AdminController::class, 'storeCompany'])->name('companies.store');
    Route::delete('/companies/{company}', [AdminController::class, 'destroyCompany'])->name('companies.destroy');

    Route::get('/programs', [AdminController::class, 'programs'])->name('programs');
    Route::post('/programs', [AdminController::class, 'storeProgram'])->name('programs.store');
    Route::delete('/programs/{program}', [AdminController::class, 'destroyProgram'])->name('programs.destroy');

    Route::get('/notifications', [AdminController::class, 'notifications'])->name('notifications');
    Route::post('/notifications', [AdminController::class, 'sendNotification'])->name('notifications.send');
});
