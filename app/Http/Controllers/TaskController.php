<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use App\Mail\TaskStatusUpdated;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Models\Offday;

class TaskController extends Controller
{
    public function index()
    {
        $users = User::all();
        $userTasks = User::with('tasks')->get();
        $tasks = Task::all();

        return view('tasks.index', compact('users', 'userTasks', 'tasks'));
    }



    public function getStatusCounts()
    {
        $statusCounts = Task::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->all();

        return response()->json($statusCounts);
    }

    public function edit($id)
    {
        $task = Task::findOrFail($id);
        $users = User::all();
        $projects = Project::all();

        return view('tasks.edit', compact('task', 'users', 'projects'));
    }


    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);



        $task->update($request->all());

        return redirect()->route('mission.index')->with('success', 'Task updated successfully');

    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('mission.index')->with('success', 'Task deleted successfully');
    }



    public function index1()
    {
        $users = User::all();
        $userTasks = User::with('tasks')->get();
        $tasks = Task::all();

        return view('mission.index', compact('users', 'userTasks', 'tasks'));
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




    public function monthlyLeaveCounts()
    {
        $leaveCounts = Offday::selectRaw('MONTH(offday_date) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return response()->json($leaveCounts);
    }







    public function show($id)
    {
        // Find the task by ID
        $task = Task::findOrFail($id);

        // Return the view with the task data
        return view('tasks.show', compact('task'));
    }





    public function filter(Request $request)
    {
        $query = Task::query();
        $users = User::all();

        if ($request->filled('owner_id')) {
            $query->where('user_id', $request->owner_id);
        }

        if ($request->filled('start_date')) {
            $startDate = \Carbon\Carbon::parse($request->start_date)->format('Y-m-d');
            $query->where('start_date', '>=', $startDate);
        }

        if ($request->filled('end_date')) {
            $endDate = \Carbon\Carbon::parse($request->end_date)->format('Y-m-d');
            $query->where('due_date', '<=', $endDate);
        }

        $tasks = $query->get();
        $taskCount = $tasks->count();  // Count the number of tasks

        return view('mission.index', compact('tasks', 'users', 'taskCount'));
    }






}
