<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeePolicyController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\HomeContoller;
use App\Http\Controllers\HRController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskNotificationController;
use App\Http\Controllers\TaskTransferController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view ('frontend.master');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth', 'isSuperAdmin'])->group(function () {

    Route::get('super-admin/dashboard', [SuperAdminController::class, 'dashboard'])->name('superAdmin.dashboard');

    Route::get('organization-info', [SettingController::class, 'office_info_setup'])->name('office_info_setup.form');
    Route::post('organization-info-store', [SettingController::class, 'store'])->name('office_info_setup.store');
    Route::get('organization-info-edit/{id}', [SettingController::class, 'edit'])->name('office_info_setup.edit');
    Route::put('organization-info-update/{id}', [SettingController::class, 'update'])->name('office_info_setup.update');
});

Route::middleware(['auth', 'isEmployee'])->group(function () {

    Route::get('employee/dashboard', [EmployeeController::class, 'dashboard'])->name('employee.dashboard');

    Route::get('all-tasks', [EmployeeController::class, 'index'])->name('my.tasks');
    Route::get('pending-tasks', [EmployeeController::class, 'pending_tasks'])->name('pending_tasks');
    Route::get('processing-tasks', [EmployeeController::class, 'processing_tasks'])->name('processing_tasks');
    Route::patch('tasks/{task}/receive', [EmployeeController::class, 'receive'])->name('task.receive');
    Route::patch('tasks/{task}/complete', [EmployeeController::class, 'complete'])->name('task.complete');
    Route::get('completed-task', [EmployeeController::class, 'completed_tasks'])->name('completed_tasks');
    Route::get('graph', [EmployeeController::class, 'graph'])->name('monthly.graph');

    Route::get('task-notification', [TaskNotificationController::class, 'task_notification'])->name('task.notification');
    Route::get('tasks/{task}/details/{notification_id}', [TaskNotificationController::class, 'show'])->name('tasks.show.delete');

});

Route::middleware(['auth', 'isHR'])->group(function () {

    Route::get('hr/dashboard', [HRController::class, 'dashboard'])->name('hr.dashboard');
    Route::get('notice', [NoticeController::class, 'notice'])->name('notice.create');

});


Route::middleware(['auth'])->group(function () {

    Route::get('attendance-index', [AttendanceController::class, 'index'])->name('attendance.list');
    Route::get('attendance', [AttendanceController::class, 'attendance'])->name('attendance.provide');
    Route::post('attendance-store', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::get('attendance-check-out/{id}', [AttendanceController::class, 'check_out'])->name('check_out');
    Route::post('attendance-check-out/{id}', [AttendanceController::class, 'check_out_update'])->name('check_out_update');

    Route::get('tasks/{task}/details', [TaskController::class, 'show'])->name('tasks.show');
    Route::post('tasks/{id}/transfer', [TaskTransferController::class, 'store'])->name('tasks.transfer.store');

    Route::get('task-assign', [TaskController::class, 'assign'])->name('tasks.assign');
    Route::post('task-assign-store', [TaskController::class, 'store'])->name('tasks.store');

    Route::get('leave-request', [LeaveRequestController::class, 'leave_request'])->name('leave_request');
    Route::post('leave-request-store', [LeaveRequestController::class, 'store'])->name('leave_request_store');
    Route::get('leave-request-index', [LeaveRequestController::class, 'leave_request_index'])->name('leave_request_index');
    Route::put('leave-request/{id}/action', [LeaveRequestController::class, 'action'])->name('leave_request_action');

    Route::get('organization-info-index', [SettingController::class, 'index'])->name('office_info_setup.index');

    Route::get('notice-index', [NoticeController::class, 'index'])->name('notice.index');
    Route::get('notice-view/{id}', [NoticeController::class, 'view'])->name('notice.view');
});


Route::middleware(['auth', 'isAdmin_isManager'])->group(function () {

    Route::get('task-assign-index', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/export/csv', [TaskController::class, 'exportCsv'])->name('tasks.export.csv');

    Route::get('user-index', [UserController::class, 'index'])->name('users.index');
    Route::get('user-create', [UserController::class, 'create'])->name('users.create');
    Route::post('user-store', [UserController::class, 'store'])->name('users.store');
    Route::get('user-edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::put('user-update/{id}', [UserController::class, 'update'])->name('users.update');

    Route::get('team-index', [TeamController::class, 'team_index'])->name('team.index');
    Route::get('team-build', [TeamController::class, 'team_build'])->name('team.build');
    Route::post('team-store', [TeamController::class, 'store'])->name('team.store');
    Route::get('team-view/{team_number}', [TeamController::class, 'team_view'])->name('team.view');

    Route::post('notice', [NoticeController::class, 'store'])->name('notice.store');
    Route::get('notice-edit/{id}', [NoticeController::class, 'edit'])->name('notice.edit');
    Route::put('notice-update/{id}', [NoticeController::class, 'update'])->name('notice.update');
    Route::get('employee-policy', [EmployeePolicyController::class, 'employee_policy'])->name('employee_policy');
    Route::post('employee-policy-store', [EmployeePolicyController::class, 'store'])->name('employee_policy.store');
    Route::get('employee-policy-edit/{id}', [EmployeePolicyController::class, 'edit'])->name('employee_policy.edit');
    Route::put('employee-policy-update/{id}', [EmployeePolicyController::class, 'update'])->name('employee_policy.update');
    Route::get('employee-policy-index', [EmployeePolicyController::class, 'index'])->name('employee_policy.index');

    Route::get('reward', [RewardController::class, 'index'])->name('reward.index');

});


require __DIR__ . '/auth.php';
