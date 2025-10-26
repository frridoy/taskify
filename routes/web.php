<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeePolicyController;
use App\Http\Controllers\EmployeeSalaryController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\HomeContoller;
use App\Http\Controllers\HRController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskNotificationController;
use App\Http\Controllers\TaskTransferController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('frontend.master');
// });

Route::get('/', [HomeController::class, 'index'])->name('frontend.home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'isSuperAdmin'])->group(function () {

    Route::get('super-admin/dashboard', [SuperAdminController::class, 'dashboard'])->name('superAdmin.dashboard');
    Route::get('organization-info', [SettingController::class, 'officeSetUp'])->name('office_info_setup.form');
    Route::post('organization-info-store', [SettingController::class, 'store'])->name('office_info_setup.store');
    Route::get('organization-info-edit/{id}', [SettingController::class, 'edit'])->name('office_info_setup.edit');
    Route::put('organization-info-update/{id}', [SettingController::class, 'update'])->name('office_info_setup.update');
    Route::post('password-reset/{id}', [PasswordResetController::class, 'passwordReset'])->name('password_reset');
    Route::get('search-engine', [ReportController::class, 'searchEngine'])->name('search.engine');
    Route::get('search-engine/result', [ReportController::class, 'searchEngineResult'])->name('search.engine.result');
});

Route::middleware(['auth', 'isEmployee'])->group(function () {

    Route::get('employee/dashboard', [EmployeeController::class, 'dashboard'])->name('employee.dashboard');
    Route::get('all-tasks', [EmployeeController::class, 'index'])->name('my.tasks');
    Route::get('pending-tasks', [EmployeeController::class, 'pendingTasks'])->name('pending_tasks');
    Route::get('processing-tasks', [EmployeeController::class, 'processingTasks'])->name('processing_tasks');
    Route::patch('tasks/{task}/receive', [EmployeeController::class, 'receive'])->name('task.receive');
    Route::patch('tasks/{task}/complete', [EmployeeController::class, 'complete'])->name('task.complete');
    Route::get('completed-task', [EmployeeController::class, 'completedTasks'])->name('completed_tasks');
    Route::get('task-notification', [TaskNotificationController::class, 'taskNotification'])->name('task.notification');
    Route::get('tasks/{task}/details/{notification_id}', [TaskNotificationController::class, 'show'])->name('tasks.show.delete');
});

Route::middleware(['auth', 'isHR'])->group(function () {
    Route::get('hr/dashboard', [HRController::class, 'dashboard'])->name('hr.dashboard');
    Route::get('notice', [NoticeController::class, 'notice'])->name('notice.create');

    Route::resource('hr/degrees', \App\Http\Controllers\HR\DegreeController::class)->names([
        'index' => 'hr.degrees.index',
        'create' => 'hr.degrees.create',
        'store' => 'hr.degrees.store',
        'edit' => 'hr.degrees.edit',
        'update' => 'hr.degrees.update',
        'destroy' => 'hr.degrees.destroy'
    ])->except(['show']);

    Route::resource('hr/job-posts', \App\Http\Controllers\HR\JobPostController::class)->names([
        'index' => 'hr.job_posts.index',
        'create' => 'hr.job_posts.create',
        'store' => 'hr.job_posts.store',
        'show' => 'hr.job_posts.show',
        'edit' => 'hr.job_posts.edit',
        'update' => 'hr.job_posts.update',
        'destroy' => 'hr.job_posts.destroy'
    ]);
});

Route::middleware(['auth'])->group(function () {

    Route::get('attendance-index', [AttendanceController::class, 'index'])->name('attendance.list');
    Route::get('attendance', [AttendanceController::class, 'attendance'])->name('attendance.provide');
    Route::post('attendance-store', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::get('attendance-check-out/{id}', [AttendanceController::class, 'checkOut'])->name('check_out');
    Route::post('attendance-check-out/{id}', [AttendanceController::class, 'checkOutUpdate'])->name('check_out_update');
    Route::get('attendance-export-csv', [AttendanceController::class, 'exportCsv'])->name('attendance.export.csv');
    Route::get('tasks/{task}/details', [TaskController::class, 'show'])->name('tasks.show');
    Route::post('tasks/{id}/transfer', [TaskTransferController::class, 'store'])->name('tasks.transfer.store');
    Route::get('task-assign', [TaskController::class, 'assign'])->name('tasks.assign');
    Route::post('task-assign-store', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('leave-request', [LeaveRequestController::class, 'leaveRequest'])->name('leave_request');
    Route::post('leave-request-store', [LeaveRequestController::class, 'store'])->name('leave_request_store');
    Route::get('leave-request-index', [LeaveRequestController::class, 'index'])->name('leave_request_index');
    Route::put('leave-request/{id}/action', [LeaveRequestController::class, 'action'])->name('leave_request_action');
    Route::get('organization-info-index', [SettingController::class, 'index'])->name('office_info_setup.index');
    Route::get('notice-index', [NoticeController::class, 'index'])->name('notice.index');
    Route::get('notice-view/{id}', [NoticeController::class, 'view'])->name('notice.view');
    Route::get('reward', [RewardController::class, 'index'])->name('reward.index');
    Route::get('employee-salaries-records', [EmployeeSalaryController::class, 'records'])->name('employee_salaries.records');
    Route::get('/employee-salary-details/{id}', [EmployeeSalaryController::class, 'perEmployeeDetails'])->name('employee_salary.details');
    Route::get('employee-policy-index', [EmployeePolicyController::class, 'index'])->name('employee_policy.index');
});

Route::middleware(['auth', 'isAdmin_isManager'])->group(function () {

    Route::get('task-assign-index', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('tasks-export-csv', [TaskController::class, 'exportCsv'])->name('tasks.export.csv');
    Route::get('user-index', [UserController::class, 'index'])->name('users.index');
    Route::get('user-create', [UserController::class, 'create'])->name('users.create');
    Route::post('user-store', [UserController::class, 'store'])->name('users.store');
    Route::get('user-edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::put('user-update/{id}', [UserController::class, 'update'])->name('users.update');
    Route::get('user-view/{id}', [UserController::class, 'view'])->name('users.view');
    Route::get('team-index', [TeamController::class, 'index'])->name('team.index');
    Route::get('team-build', [TeamController::class, 'teamBuild'])->name('team.build');
    Route::post('team-store', [TeamController::class, 'store'])->name('team.store');
    Route::get('team-view/{team_number}', [TeamController::class, 'view'])->name('team.view');
    Route::get('/team/{team_number}/edit',  [TeamController::class, 'edit'])->name('team.edit');
    Route::put('/team/{team_number}/update', [TeamController::class, 'update'])->name('team.update');
    Route::post('notice', [NoticeController::class, 'store'])->name('notice.store');
    Route::get('notice-edit/{id}', [NoticeController::class, 'edit'])->name('notice.edit');
    Route::put('notice-update/{id}', [NoticeController::class, 'update'])->name('notice.update');
    Route::get('employee-policy', [EmployeePolicyController::class, 'employeePolicy'])->name('employee_policy');
    Route::post('employee-policy-store', [EmployeePolicyController::class, 'store'])->name('employee_policy.store');
    Route::get('employee-policy-edit/{id}', [EmployeePolicyController::class, 'edit'])->name('employee_policy.edit');
    Route::put('employee-policy-update/{id}', [EmployeePolicyController::class, 'update'])->name('employee_policy.update');
    Route::resource('employee-salaries', EmployeeSalaryController::class);
    Route::get('/employee-salaries/{month?}/{year?}', [EmployeeSalaryController::class, 'index']);
});

require __DIR__ . '/auth.php';
