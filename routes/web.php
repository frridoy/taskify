<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\HomeContoller;
use App\Http\Controllers\HRController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskTransferController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [HomeController::class, 'home'])->name('frontend.home');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth', 'isSuperAdmin'])->group(function () {

    Route::get('super-admin/dashboard', [SuperAdminController::class, 'dashboard'])->name('superAdmin.dashboard');

    Route::get('user/create', [UserController::class, 'create'])->name('users.create');
    Route::post('user/store', [UserController::class, 'store'])->name('users.store');
    Route::get('user/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::put('user/update/{id}', [UserController::class, 'update'])->name('users.update');
});

Route::middleware(['auth', 'isEmployee'])->group(function () {

    Route::get('employee/dashboard', [EmployeeController::class, 'dashboard'])->name('employee.dashboard');
    Route::get('all_tasks', [EmployeeController::class, 'index'])->name('my.tasks');
    Route::get('pending/tasks', [EmployeeController::class, 'pending_tasks'])->name('pending_tasks');
    Route::get('processing/tasks', [EmployeeController::class, 'processing_tasks'])->name('processing_tasks');
    Route::patch('tasks/{task}/receive', [EmployeeController::class, 'receive'])->name('task.receive');
    Route::patch('tasks/{task}/complete', [EmployeeController::class, 'complete'])->name('task.complete');
    Route::get('completed/task', [EmployeeController::class, 'completed_tasks'])->name('completed_tasks');
    Route::get('graph', [EmployeeController::class, 'graph'])->name('monthly.graph');
});

Route::middleware(['auth', 'isHR'])->group(function () {

    Route::get('hr/dashboard', [HRController::class, 'dashboard'])->name('hr.dashboard');

    Route::get('team/build', [TeamController::class, 'team_build'])->name('team.build');
    Route::post('team/store', [TeamController::class, 'store'])->name('team.store');
    Route::get('team/index', [TeamController::class, 'team_index'])->name('team.index');
    Route::get('team/view/{team_number}', [TeamController::class, 'team_view'])->name('team.view');

    Route::get('office_info/setup', [SettingController::class, 'office_info_setup'])->name('office_info_setup.form');
    Route::post('office_info_setup/store', [SettingController::class, 'store'])->name('office_info_setup.store');
    Route::get('office_info_setup/index', [SettingController::class, 'index'])->name('office_info_setup.index');
    Route::get('office_info_setup/edit/{id}', [SettingController::class, 'edit'])->name('office_info_setup.edit');
    Route::put('office_info_setup/update', [SettingController::class, 'update'])->name('office_info_setup.update');
});


Route::middleware(['auth'])->group(function () {

Route::get('attendance/index', [AttendanceController::class, 'index'])->name('attendance.list');
Route::get('attendance', [AttendanceController::class, 'attendance'])->name('attendance.provide');
Route::post('attendance/store', [AttendanceController::class, 'store'])->name('attendance.store');

Route::get('tasks/{task}/details', [TaskController::class, 'show'])->name('tasks.show');
Route::post('tasks/{id}/transfer', [TaskTransferController::class, 'store'])->name('tasks.transfer.store');

Route::get('task-assign', [TaskController::class, 'assign'])->name('tasks.assign');
Route::post('task-assign-store', [TaskController::class, 'store'])->name('tasks.store');

});

Route::middleware(['auth', 'isAdmin_isManager'])->group(function () {

    Route::get('task-assign-index', [TaskController::class, 'index'])->name('tasks.index');

    Route::get('user-index', [UserController::class, 'index'])->name('users.index');

});


require __DIR__ . '/auth.php';
