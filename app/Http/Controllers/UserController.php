<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Task;
use App\Models\Project;
use App\Models\WorkSession;
use Carbon\Carbon;
use App\Models\Offday;
use App\Models\Contact;




class UserController extends Controller
{
    public function create()
    {
        return view('admin.users.create');
    }

    public function show()
    {
        $users = User::all();
        return view('admin.users.show', compact('users'));
    }

    public function assaign()
    {
        $users = User::all();
        $projects = Project::all();
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
        $users = User::with('tasks')->findOrFail($id);
        return view('tasks.index', compact('users'));


    }

    public function showProfile()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }


    public function showProfile1()
    {
        $user = Auth::user();
        return view('userProfile', compact('user'));
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



    public function showUserTasks()
    {
        $user = Auth::user();

        $userTasks = $user->tasks;

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

    public function startWorkSession()
    {
        $user = Auth::user();

        $activeSession = $user->workSessions()
            ->where(function ($query) {
                $query->where('status', 'working')
                    ->orWhere('status', 'on_break');
            })
            ->first();

        if ($activeSession) {
            return response()->json(['message' => 'You already have an active work session.'], 400);
        }

        $workSession = $user->workSessions()->create([
            'start_time' => now(),
            'status' => 'working'
        ]);

        return redirect()->route('user.workSessions')->with('message', 'Work session started');
    }




    public function startBreak()
    {
        $user = Auth::user();

        // Aktif bir çalışma oturumunu en son başlayan oturumlardan alıyoruz.
        $workSession = $user->workSessions()
            ->where('status', 'working')
            ->latest('start_time')
            ->first();

        if ($workSession) {
            // Yeni bir mola oturumu başlatıyoruz.
            $workSession->breaks()->create([
                'start_time' => now(),
            ]);

            // Çalışma oturumunun durumunu 'on_break' olarak güncelliyoruz.
            $workSession->status = 'on_break';
            $workSession->save();

            return redirect()->route('user.workSessions')->with('message', 'Break started');
        }

        return response()->json(['message' => 'You are not currently working or there is no active work session.'], 400);
    }



    public function endBreak()
    {
        $user = Auth::user();

        // En son mola durumundaki çalışma oturumunu buluyoruz.
        $workSession = $user->workSessions()
            ->where('status', 'on_break')
            ->latest('start_time')
            ->first();

        // Mola oturumlarının arasında bitmemiş olan en sonuncusunu buluyoruz.
        $currentBreak = $workSession
            ? $workSession->breaks()->whereNull('end_time')->latest('start_time')->first()
            : null;

        if ($workSession && $currentBreak) {
            // Molanın bitiş zamanını güncelliyoruz.
            $currentBreak->update(['end_time' => now()]);

            // Çalışma oturumunun durumunu tekrar 'working' olarak ayarlıyoruz.
            $workSession->status = 'working';
            $workSession->save();

            return redirect()->back()->with('message', 'Break ended');
        }

        return response()->json(['message' => 'No active break found.'], 400);
    }

    public function endWorkSession()
    {
        $user = Auth::user();

        $workSession = $user->workSessions()
            ->whereIn('status', ['working', 'on_break'])
            ->latest('start_time')
            ->first();

        if ($workSession) {
            if ($workSession->status === 'on_break') {
                $currentBreak = $workSession->breaks()->whereNull('end_time')->latest('start_time')->first();
                if ($currentBreak) {
                    $currentBreak->update(['end_time' => now()]);
                }
            }

            // Sadece end_time'i güncelliyoruz.
            $workSession->update([
                'end_time' => now(),
                'status' => 'ended',
            ]);

            return redirect()->route('user.workSessions')->with('message', 'Work session ended');
        }

        return response()->json(['message' => 'No active work session found.'], 400);
    }




    public function showWorkSessions()
    {
        $user = Auth::user();
        $workSessions = $user->workSessions()->with('breaks')->get();

        $totalWorkDuration = 0;

        foreach ($workSessions as $session) {
            $startTime = Carbon::parse($session->start_time);
            $endTime = Carbon::parse($session->end_time ?? now());

            $workDuration = 0;
            $currentStartTime = $startTime;

            foreach ($session->breaks as $break) {
                if ($break->start_time) {
                    $breakStartTime = Carbon::parse($break->start_time);
                    $breakEndTime = $break->end_time ? Carbon::parse($break->end_time) : $endTime;

                    $workDuration += $breakStartTime->diffInSeconds($currentStartTime);
                    $currentStartTime = $breakEndTime;
                }
            }

            $workDuration += $endTime->diffInSeconds($currentStartTime);
            $totalWorkDuration += $workDuration;
        }

        $hours = floor($totalWorkDuration / 3600);
        $minutes = floor(($totalWorkDuration % 3600) / 60);
        $seconds = $totalWorkDuration % 60;

        $formattedTotalWorkDuration = '';
        if ($hours > 0) {
            $formattedTotalWorkDuration .= "$hours hours ";
        }
        if ($minutes > 0) {
            $formattedTotalWorkDuration .= "$minutes minutes ";
        }
        if ($seconds > 0 || empty($formattedTotalWorkDuration)) {
            $formattedTotalWorkDuration .= "$seconds seconds";
        }

        return view('user.workSessions', compact('workSessions', 'formattedTotalWorkDuration'));
    }

    // app/Http/Controllers/UserController.php

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $imagePath;
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Kullanıcı başarıyla eklendi.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:8',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $imagePath;
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Kullanıcı başarıyla güncellendi.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Kullanıcı başarıyla silindi.');
    }



    public function search1(Request $request)
    {
        $query = User::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'LIKE', "%{$search}%");
        }

        $users = $query->get();

        return view('admin.users.show', compact('users'));
    }


    // UserController.php
    public function search(Request $request)
    {
        $query = $request->input('query');

        $users = User::where('name', 'like', '%' . $query . '%')->get();
        $tasks = Task::where('title', 'like', '%' . $query . '%')->get();
        $projects = Project::where('name', 'like', '%' . $query . '%')->get();

        $results = [];

        foreach ($users as $user) {
            $results[] = ['type' => 'user', 'id' => $user->id, 'name' => $user->name];
        }

        foreach ($tasks as $task) {
            $results[] = ['type' => 'task', 'id' => $task->id, 'name' => $task->title];

        }

        foreach ($projects as $project) {
            $results[] = ['type' => 'project', 'id' => $project->id, 'name' => $project->name];
        }

        return response()->json($results);
    }











    public function show1($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }



    public function show2()
    {
        $users = User::all();
        return view('user.teammates', compact('users'));
    }

    public function show3()
    {
        $users = User::all();
        $tasks = Task::all();
        $assignedTasks = Task::where('user_id', Auth::id())->get();
        $userTasks = Task::where('user_id', Auth::id())->get();

        return view('user.contact', compact('users', 'tasks', 'assignedTasks', 'userTasks'));
    }




    public function storeContact(Request $request)
    {
        Contact::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'message' => $request->input('message'),
            'user_id' => Auth::id(), // Store the logged-in user's ID
        ]);

        return redirect()->back()->with('success', 'Mesajınız başarıyla gönderildi!');
    }









    

    public function search9(Request $request)
    {
        $query = User::query();

        // Check if the search input is present
        if ($request->has('search') && !empty($request->input('search'))) {
            $search = $request->input('search');

            // Search for users by name
            $query->where('name', 'LIKE', "%{$search}%");
        }

        $users = $query->get();

        // Fetch contacts only related to the users found in the search
        $contacts = Contact::whereIn('user_id', $users->pluck('id'))->get();

        return view('admin.support', compact('users', 'contacts'));
    }








}

