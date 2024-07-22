<?php

use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\OffdayController;

// Authentication Routes
Route::get('/', function () {
    return view('auth.login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    Route::post('/admin/users', [AdminController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::get('/admin/users/show', [UserController::class, 'show'])->name('admin.users.show');
    Route::get('/admin/users/assaign', [UserController::class, 'assaign'])->name('admin.users.assaign');
    Route::get('/admin/users/index', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/{id}/edit', [AdminController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{id}', [AdminController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [AdminController::class, 'destroy'])->name('admin.users.destroy');
    Route::post('/admin/tasks', [AdminController::class, 'storeTask'])->name('admin.tasks.store');
    Route::get('/admin/work-sessions', [AdminController::class, 'showWorkSessions'])->name('admin.workSessions');
    Route::get('/admin/work-sessions/{id}/edit', [AdminController::class, 'editWorkSession'])->name('admin.editWorkSession');
    Route::post('/admin/work-sessions/{id}', [AdminController::class, 'updateWorkSession'])->name('admin.updateWorkSession');
    Route::delete('/admin/work-sessions/{id}', [AdminController::class, 'destroyWorkSession'])->name('admin.destroyWorkSession');
    Route::get('/admin/filter-work-sessions', [AdminController::class, 'filterWorkSessions'])->name('admin.filterWorkSessions');
    Route::get('/admin/offdays', [OffdayController::class, 'index'])->name('admin.offdays.index');
    Route::post('/admin/offdays/{id}/approve', [OffdayController::class, 'approve'])->name('admin.offdays.approve');
    Route::post('/admin/offdays/{id}/reject', [OffdayController::class, 'reject'])->name('admin.offdays.reject');
    Route::get('/admin/offdays/{id}/edit', [OffdayController::class, 'edit'])->name('admin.offdays.edit');
    Route::put('/admin/offdays/{id}', [OffdayController::class, 'update'])->name('admin.offdays.update');
    Route::delete('/admin/offdays/{id}', [OffdayController::class, 'destroy'])->name('admin.offdays.destroy');

    Route::get('/admin/reports/index', [ReportController::class, 'index'])->name('admin.reports.index');

});

// Authenticated User Routes
Route::middleware('auth')->group(function () {
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks');
    Route::get('/user', [UserController::class, 'showUserTasks'])->name('user');
    Route::get('/profile', [UserController::class, 'showProfile'])->name('profile');
    Route::post('/profile/update-password', [UserController::class, 'updatePassword'])->name('profile.updatePassword');
    Route::post('/tasks/{id}/update-status', [TaskController::class, 'updateStatus'])->name('tasks.update-status');
    Route::get('/userProfile', [UserController::class, 'showProfile'])->name('userProfile');
    Route::post('/user/start-work-session', [UserController::class, 'startWorkSession'])->name('user.startWorkSession');
    Route::post('/user/start-break', [UserController::class, 'startBreak'])->name('user.startBreak');
    Route::post('/user/end-break', [UserController::class, 'endBreak'])->name('user.endBreak');
    Route::post('/user/end-work-session', [UserController::class, 'endWorkSession'])->name('user.endWorkSession');
    Route::get('/user/work-sessions', [UserController::class, 'showWorkSessions'])->name('user.workSessions');

    Route::get('/offday/index', [OffdayController::class, 'indexUser'])->name('offday.index');
    Route::get('/offday/create', [OffdayController::class, 'createUser'])->name('offday.create');
    Route::post('/offday', [OffdayController::class, 'storeUser'])->name('offday.store');
    Route::get('/offdays/{id}', [OffdayController::class, 'show'])->name('offdays.show');
    Route::put('/offdays/{id}', [OffdayController::class, 'update'])->name('offdays.update');
});

// General Routes
Route::resource('projects', ProjectController::class);
Route::get('projects/create', [ProjectController::class, 'create'])->name('projects.create');
Route::get('/users/{id}/tasks', [UserController::class, 'showTasks'])->name('admin.index');
Route::get('/tasks/index', [TaskController::class, 'index'])->name('tasks.index');
Route::get('/tasks/chart-data', [AdminController::class, 'getChartData'])->name('tasks.chart-data');
Route::post('/tasks/{id}/update-status', [AdminController::class, 'updateTaskStatus'])->name('tasks.update-status');

Route::get('/tasks/{id}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
Route::patch('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');
Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');
Route::get('/navbar-tasks', [TaskController::class, 'index1'])->name('navbar.tasks');
Route::get('/admin/users/search1', [UserController::class, 'search1'])->name('admin.users.search1');



Route::get('/tasks/status-counts', [TaskController::class, 'getStatusCounts']);
Route::get('/tasks', [TaskController::class, 'index']);





Route::get('/mission', [TaskController::class, 'index1'])->name('mission.index');
Route::get('/mission/{id}/edit', [TaskController::class, 'edit'])->name('mission.edit');
Route::patch('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');
Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');
Route::get('/navbar-tasks', [TaskController::class, 'index1'])->name('navbar.tasks');




// web.php
Route::get('/offday/monthly-data', [OffdayController::class, 'getMonthlyOffdayData']);
