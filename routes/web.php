<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Default dashboard - redirects based on role
Route::get('/dashboard', function () {
    $user = auth()->user();
    
    if ($user->role === 'admin') {
        return redirect()->route('dashboard.admin');
    } elseif ($user->role === 'designer') {
        return redirect()->route('dashboard.designer');
    } else {
        return redirect()->route('dashboard.client');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// Role-based dashboards
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard/client', [DashboardController::class, 'client'])
        ->middleware('role:client')
        ->name('dashboard.client');
    
    Route::get('/dashboard/designer', [DashboardController::class, 'designer'])
        ->middleware('role:designer')
        ->name('dashboard.designer');
    
    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])
        ->middleware('role:admin')
        ->name('dashboard.admin');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

