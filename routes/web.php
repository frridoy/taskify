<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeContoller;
use App\Http\Controllers\HRController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskTransferController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



// Route::get('/', function () {
//     return redirect()->route('login');
// });

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//only super admin can access

Route::middleware(['auth', 'isSuperAdmin'])->group(function () {
    Route::get('super-admin/dashboard', [SuperAdminController::class, 'dashboard'])->name('superAdmin.dashboard');
});


//only HR can access
Route::middleware(['auth', 'isHR'])->group(function () {

    Route::get('hr/dashboard', [HRController::class, 'dashboard'])->name('hr.dashboard');
});


//only employee can access

Route::middleware(['auth', 'isEmployee'])->group(function () {

    Route::get('employee/dashboard', [EmployeeController::class, 'dashboard'])->name('employee.dashboard');
    //all tasks list
    Route::get('my-task', [EmployeeController::class, 'index'])->name('my.tasks');
    //pending tasks list
    Route::get('pending-task', [EmployeeController::class, 'pending_tasks'])->name('pending_tasks');
    //processing tasks list
    Route::get('processing-task', [EmployeeController::class, 'processing_tasks'])->name('processing_tasks');
    //receive task
    Route::patch('/tasks/{task}/receive', [EmployeeController::class, 'receive'])->name('task.receive');
    //complete task
    Route::patch('/tasks/{task}/complete', [EmployeeController::class, 'complete'])->name('task.complete');
    //completed tasks list
    Route::get('completed-task', [EmployeeController::class, 'completed_tasks'])->name('completed_tasks');
    //missed task

    Route::get('graph', [EmployeeController::class, 'graph'])->name('monthly.graph');


});



//only super admin and HR can access

Route::middleware(['auth', 'isHR'])->group(function () {

    //tasks

    Route::get('task-assign-index', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('task-assign', [TaskController::class, 'assign'])->name('tasks.assign');
    Route::post('task-assign-store', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{task}/details', [TaskController::class, 'show'])->name('tasks.show');


    //users

    Route::get('user-create', [UserController::class, 'create'])->name('users.create');
    Route::post('user-store', [UserController::class, 'store'])->name('users.store');
    Route::get('user-index', [UserController::class, 'index'])->name('users.index');
    Route::get('user-edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::put('user-update/{id}', [UserController::class, 'update'])->name('users.update');

    //transfer
    Route::get('/tasks/transfer/{id}', [TaskTransferController::class, 'transfer'])->name('tasks.transfer.create');
    Route::post('/tasks/{id}/transfer', [TaskTransferController::class, 'store'])->name('tasks.transfer.store');

    //build team
    Route::get('/team', [TeamController::class, 'team_build'])->name('team.build');
    Route::post('/team/store', [TeamController::class, 'store'])->name('team.store');

});

require __DIR__ . '/auth.php';
