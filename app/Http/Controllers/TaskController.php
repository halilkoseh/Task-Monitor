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
    // Find the task by ID
    $task = Task::findOrFail($id);

    // Update the task status
    $task->status = $request->status;

    // Save the changes
    $task->save();

    // Get the assigned user
    $assignedUser = $task->assignedUser;

    // Send email to assigned user
    if ($assignedUser && $assignedUser->username) {
        Mail::to($assignedUser->username)->send(new TaskStatusUpdated($task));
    }

    // Get admin users
    $admins = User::where('is_admin', 1)->get();

    // Send email to admins
    foreach ($admins as $admin) {
        Mail::to($admin->username)->send(new TaskStatusUpdated($task));
    }

    // Return a success response
    return response()->json(['success' => true, 'message' => 'Görev durumu güncellendi'], 200);
}



}

