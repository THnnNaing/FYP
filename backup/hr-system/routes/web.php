<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HRController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard redirect based on role
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        switch ($user->user_type) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'hr':
                return redirect()->route('hr.dashboard');
            default:
                return redirect()->route('employee.dashboard');
        }
    })->name('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::resource('departments', DepartmentController::class);
    Route::resource('designations', DesignationController::class);
});

// HR Routes - FIXED TYPOS HERE
Route::middleware(['auth', 'role:hr'])->group(function () {
    Route::get('/hr/dashboard', [HRController::class, 'dashboard'])->name('hr.dashboard');
});

// Employee Routes (shared between admin, hr, and employee roles)
Route::middleware(['auth'])->group(function () {
    Route::resource('employees', EmployeeController::class);
});

// Role-specific routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Admin-specific employee routes (if any)
});

Route::middleware(['auth', 'role:hr'])->group(function () {
    // HR-specific employee routes (if any)
});

Route::middleware(['auth', 'role:employee'])->group(function () {
    Route::get('/employee/dashboard', [EmployeeController::class, 'dashboard'])->name('employee.dashboard');
});

require __DIR__ . '/auth.php';
