<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\OffdayController;


Route::get('/', function () {
    return view('auth.login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    Route::post('/admin/users', [AdminController::class, 'store'])->name('admin.users.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks');
    Route::get('/user', [UserController::class, 'showUserTasks'])->name('user');


});





Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');

Route::get('/admin/users/show', [UserController::class, 'show'])->name('admin.users.show');

Route::get('/admin/users/assaign', [UserController::class, 'assaign'])->name('admin.users.assaign');


Route::get('/admin/users/index', [UserController::class, 'index'])->name('admin.users.index');


Route::get('/admin/users/{id}/edit', [AdminController::class, 'edit'])->name('admin.users.edit');
Route::put('/admin/users/{id}', [AdminController::class, 'update'])->name('admin.users.update');

Route::post('/admin/tasks', [AdminController::class, 'storeTask'])->name('admin.tasks.store');


Route::get('/users/{id}/tasks', [UserController::class, 'showTasks'])->name('admin.index');















Route::get('/user/task', [UserController::class, 'showUserTasks'])->name('user.tasks');


Route::post('/tasks/{id}/update-status', [TaskController::class, 'updateStatus'])->name('tasks.update-status');


Route::get('/userProfile', [UserController::class, 'showProfile'])->name('userProfile');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserController::class, 'showProfile'])->name('profile');
    Route::post('/profile/update-password', [UserController::class, 'updatePassword'])->name('profile.updatePassword');
});





Route::delete('admin/users/{user}', [AdminController::class, 'destroy'])->name('admin.users.destroy');



Route::resource('projects', ProjectController::class);




Route::get('projects/create', [ProjectController::class, 'index'])->name('projects.index');

Route::get('projects/create', [ProjectController::class, 'create'])->name('projects.create');



Route::get('/admin/users/assaign', [UserController::class, 'assaign'])->name('admin.users.assaign');






Route::get('projects/show/{id}', [AdminController::class, 'index1'])->name('projects.show');



Route::post('/user/start-work-session', [UserController::class, 'startWorkSession'])->name('user.startWorkSession');
Route::post('/user/start-break', [UserController::class, 'startBreak'])->name('user.startBreak');
Route::post('/user/end-break', [UserController::class, 'endBreak'])->name('user.endBreak');
Route::post('/user/end-work-session', [UserController::class, 'endWorkSession'])->name('user.endWorkSession');
Route::get('/user/work-sessions', [UserController::class, 'showWorkSessions'])->name('user.workSessions');

Route::get('/admin/work-sessions', [AdminController::class, 'showWorkSessions'])->name('admin.workSessions');
Route::get('/admin/work-sessions/{id}/edit', [AdminController::class, 'editWorkSession'])->name('admin.editWorkSession');
Route::post('/admin/work-sessions/{id}', [AdminController::class, 'updateWorkSession'])->name('admin.updateWorkSession');
Route::get('/admin/filter-work-sessions', [AdminController::class, 'filterWorkSessions'])->name('admin.filterWorkSessions');

Route::get('/user/work-sessions', [UserController::class, 'showWorkSessions'])->name('user.workSessions');


Route::get('/user/work-sessions', [UserController::class, 'showWorkSessions'])->name('user.workSessions');
Route::get('/user/work-sessions', [UserController::class, 'showWorkSessions'])->name('user.workSessions');


Route::get('/user/offdays', [OffdayController::class, 'index1'])->name('offday.index');
Route::get('/offdays/create', [OffdayController::class, 'create'])->name('offday.create');
Route::post('/offdays', [OffdayController::class, 'store'])->name('offday.store');
Route::get('/offdays/{id}', [OffdayController::class, 'show'])->name('offday.show');





Route::get('/admin/offdays', [OffdayController::class, 'Index'])->name('offdays.index');
Route::post('/admin/offdays/{id}/approve', [OffdayController::class, 'approve'])->name('offdays.approve');
Route::post('/admin/offdays/{id}/reject', [OffdayController::class, 'reject'])->name('offdays.reject');







Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::get('/tasks/{id}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
Route::patch('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');
Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');
Route::get('/navbar-tasks', [TaskController::class, 'index1'])->name('navbar.tasks');

