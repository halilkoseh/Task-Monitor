<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Task;
use App\Models\Project;


class UserController extends Controller
{
    public function create()
    {
        // Kullanıcı oluşturma formunu gösterme
        return view('admin.users.create');
    }

    public function show()
    {
        // Tüm kullanıcıları gösterme
        $users = User::all();
        return view('admin.users.show', compact('users'));
    }

    public function assaign()
    {
        $users = User::all();
        $projects = Project::all(); // Tüm projeleri al
        $tasks = Task::all();

        return view('admin.users.assaign', compact('users', 'projects', 'tasks'));

        


    }


    public function index()
    {

        $users = User::all();
        return view('admin.users.show', compact('users'));

    }

    public function showTasks($id)
    {
        $user = User::with('tasks')->findOrFail($id);
        return view('admin.index', compact('user'));
    }

    public function showProfile()
    {
        // Kullanıcı profilini gösterme
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (Hash::check($request->current_password, $user->password)) {
            $user->password = Hash::make($request->new_password);
            $user->save();

            return back()->with('success', 'Password updated successfully.');
        } else {
            return back()->withErrors(['current_password' => 'Current password does not match.']);
        }
    }






    // yeni eklenenler


    public function showUserTasks()
    {
        // Şu anki kullanıcıyı al
        $user = Auth::user();

        // Kullanıcının görevlerini al
        $userTasks = $user->tasks;

        // Verileri görünüme gönder
        return view('user.tasks', [
            'userTasks' => $userTasks,
        ]);
    }


    public function updateTaskStatus($id, Request $request)
    {
        $task = Task::findOrFail($id);

        if ($task->user_id !== Auth::id()) {
            return response()->json(['error' => 'Yetkiniz olmayan bir görevi güncelleyemezsiniz.'], 403);
        }

        $task->status = $request->status;
        $task->save();


        return response()->json(['success' => true, 'message' => 'Görev durumu güncellendi.']);
    }





}
