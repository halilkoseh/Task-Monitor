<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use App\Mail\TaskStatusUpdated;
use Illuminate\Support\Facades\Mail;

class TaskController extends Controller
{
    public function index()
    {

        $users = User::all();
        $userTasks = User::with('tasks')->get();
        $tasks = Task::all();
       

        return view('tasks.index', [
            'users' => $users,
            'userTasks' => $userTasks,
            'tasks' => $tasks
        ]);
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

    public function updateStatus($id, Request $request)
    {
        $task = Task::findOrFail($id);
        $task->status = $request->status;
        $task->save();

        $assignedUser = $task->assignedUser;
        if ($assignedUser && $assignedUser->email) {
            Mail::to($assignedUser->email)->send(new TaskStatusUpdated($task));
        }

        $admins = User::where('is_admin', 1)->get();
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new TaskStatusUpdated($task));
        }

        return response()->json(['success' => true, 'message' => 'Task status updated successfully'], 200);
    }

    public function getUsersByProject($projectId)
    {
        $users = Project::findOrFail($projectId)->users;
        return response()->json($users);
    }
}
