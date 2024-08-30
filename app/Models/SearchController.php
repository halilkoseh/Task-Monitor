<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        $user = User::where('name', 'like', '%' . $query . '%')->first();
        if ($user) {
            Log::info('User found: ', ['id' => $user->id]);
            return response()->json(['success' => true, 'type' => 'user', 'id' => $user->id]);
        }

        $task = Task::where('title', 'like', '%' . $query . '%')->first();
        if ($task) {
            Log::info('Task found: ', ['id' => $task->id]);
            return response()->json(['success' => true, 'type' => 'task', 'id' => $task->id]);
        }

        $project = Project::where('name', 'like', '%' . $query . '%')->first();
        if ($project) {
            Log::info('Project found: ', ['id' => $project->id]);
            return response()->json(['success' => true, 'type' => 'project', 'id' => $project->id]);
        }

        Log::info('No results found for query: ', ['query' => $query]);
        return response()->json(['success' => false]);
    }
}
