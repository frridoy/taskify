<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HRController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', [SuperAdminController::class, 'home'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth', 'isSuperAdmin'])->group(function () {
    Route::get('super-admin/dashboard', [SuperAdminController::class, 'dashboard'])->name('superAdmin.dashboard');
    Route::get('user-create', [UserController::class, 'create'])->name('users.create');
    Route::post('user-store', [UserController::class, 'store'])->name('users.store');
    Route::get('user-index', [UserController::class, 'index'])->name('users.index');
});

Route::middleware(['auth', 'isHR'])->group(function () {
    Route::get('hr/dashboard', [HRController::class, 'dashboard'])->name('hr.dashboard');
});

Route::middleware(['auth', 'isEmployee'])->group(function () {
    Route::get('employee/dashboard', [EmployeeController::class, 'dashboard'])->name('employee.dashboard');
});
require __DIR__.'/auth.php';
