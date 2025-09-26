<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HRController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\LeaveTypeController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BonusTypeController;
use App\Http\Controllers\DeductionTypeController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\TrainingProgramController;
use App\Http\Controllers\TrainingAssignmentController;
use Illuminate\Support\Facades\Auth;

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

    // Profile Routes (for Admin and HR)
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::resource('employees', EmployeeController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('designations', DesignationController::class);
    Route::resource('leave_types', LeaveTypeController::class);
    Route::resource('bonus_types', BonusTypeController::class);
    Route::resource('deduction_types', DeductionTypeController::class);
    Route::resource('payrolls', PayrollController::class)->only(['index', 'show']);
    Route::resource('training_programs', TrainingProgramController::class);
});

// HR Routes (prefixed with /hr)
Route::middleware(['auth', 'role:hr'])->prefix('hr')->name('hr.')->group(function () {
    Route::get('/dashboard', [HRController::class, 'dashboard'])->name('dashboard');
    Route::resource('employees', EmployeeController::class)
        ->only(['index', 'create', 'store', 'show', 'edit', 'update'])
        ->parameters(['employees' => 'employee']);
    Route::resource('leaves', LeaveController::class)
        ->only(['index', 'create', 'store', 'show'])
        ->parameters(['leaves' => 'leave']);
    Route::post('/leaves/{leave}/approve', [LeaveController::class, 'approve'])->name('leaves.approve');
    Route::post('/leaves/{leave}/decline', [LeaveController::class, 'decline'])->name('leaves.decline');
    Route::resource('payrolls', PayrollController::class)
        ->only(['index', 'create', 'store', 'show'])
        ->parameters(['payrolls' => 'payroll']);
    Route::post('/payrolls/{payroll}/approve', [PayrollController::class, 'approve'])->name('payrolls.approve');
    Route::resource('training_assignments', TrainingAssignmentController::class)
        ->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'])
        ->parameters(['training_assignments' => 'training_assignment']);
    Route::post('/training_assignments/{training_assignment}/update-status', [TrainingAssignmentController::class, 'updateStatus'])
        ->name('training_assignments.update_status');
});

// Employee Routes (prefixed with /employee)
Route::middleware(['auth', 'role:employee'])->prefix('employee')->name('employee.')->group(function () {
    Route::get('/dashboard', [EmployeeController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [EmployeeController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [EmployeeController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [EmployeeController::class, 'update'])->name('profile.update');
    Route::resource('leaves', LeaveController::class)
        ->only(['index', 'create', 'store', 'show'])
        ->parameters(['leaves' => 'leave']);
    Route::resource('payrolls', PayrollController::class)
        ->only(['index', 'show'])
        ->parameters(['payrolls' => 'payroll']);
    Route::post('/payrolls/request', [PayrollController::class, 'requestPayroll'])->name('payrolls.request');
    Route::resource('training_assignments', TrainingAssignmentController::class)
        ->only(['index', 'show'])
        ->parameters(['training_assignments' => 'training_assignment']);
});

require __DIR__ . '/auth.php';