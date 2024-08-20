<?php

use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PayrollController;
use App\Http\Controllers\Admin\AllowanceController;
use App\Http\Controllers\Admin\DeductionsController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\DashboardController;

Route::controller(AuthController::class)->group(function () {
    Route::get('login', 'login')->name('login');
    Route::post('login', 'loginAuth');
    Route::any('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('forgot-password', 'forgotPassword')->name('password.email');
    Route::post('forgot-password', 'sendResetLink')->name('password.request');
    Route::get('reset-password/{token}', 'resetPassword')->name('password.reset');
    Route::post('reset-password', 'updatePassword')->name('password.update');
});

Route::middleware(['auth'])->group(function () {

    Route::prefix('admin')->name('admin.')->group(function() {
        Route::resource('employees', EmployeeController::class);
    });
    Route::get('/', [DashboardController::class, 'index'])->name('home');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('allowances', AllowanceController::class)->except(['show']);
    Route::resource('deductions', DeductionsController::class)->except(['show']);
    Route::resource('payslips', PayrollController::class);
    Route::post('employee-salary-setting/{encryptedId}', [EmployeeController::class, 'salarySetting'])->name('employee.salary-setting');
    Route::get('attendance', [AttendanceController::class, 'index'])->name('attendances.index');
    Route::get('attendance-details/{attendance}', [AttendanceController::class, 'attendanceDetails'])->name('attendance.details');
    Route::resource('tasks', TaskController::class);
    Route::get('/my-tasks', [TaskController::class, 'myTasks'])->name('tasks.my_tasks');

    });