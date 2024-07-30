<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;


class ReportController extends Controller
{


    public function index()
    {

        $users = User::all();
        $userTasks = User::with('tasks')->get();
        $tasks = Task::all();
       

        return view('report.index', [
            'users' => $users,
            'userTasks' => $userTasks,
            'tasks' => $tasks
        ]);
    }

    public function showReports()
    {
        $tasks = Task::all(); 
        return view('reports', compact('tasks'));
    }











}
