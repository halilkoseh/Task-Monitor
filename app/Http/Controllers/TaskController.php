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



public function destroyTasks(Task $task)
{
    $task->delete();

    return redirect()->route('projects.index')->with('success', 'Başarıyla silindi.');
}





public function index()
{
    $tasks = Task::all();
    return view('tasks.index', compact('tasks'));
    
}

public function edit($id)
{
    $task = Task::findOrFail($id);
    return view('tasks.edit', compact('task'));
}

public function update(Request $request, $id)
{
    $task = Task::findOrFail($id);
    $task->update($request->all());

    return redirect()->route('tasks.index')->with('success', 'Task updated successfully');
}

public function destroy($id)
{
    $task = Task::findOrFail($id);
    $task->delete();

    return redirect()->route('tasks.index')->with('success', 'Task deleted successfully');
}
    




public function index1()
{
    $tasks = Task::all();
    return view('components.navbar', compact('tasks'));
    
}







}

