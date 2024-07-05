<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Mail\TaskStatusUpdated;
use Illuminate\Support\Facades\Mail;



class TaskController extends Controller
{
    
public function updateStatus($id, Request $request)
{
    $task = Task::findOrFail($id);

    $task->status = $request->status;

    $task->save();

    $assignedUser = $task->assignedUser;

    if ($assignedUser && $assignedUser->username) {
        Mail::to($assignedUser->username)->send(new TaskStatusUpdated($task));
    }

    $admins = User::where('is_admin', 1)->get();

    foreach ($admins as $admin) {
        Mail::to($admin->username)->send(new TaskStatusUpdated($task));
    }

    return response()->json(['success' => true, 'message' => 'Görev durumu güncellendi'], 200);
}



}

