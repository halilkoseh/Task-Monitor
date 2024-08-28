<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Project;
use App\Mail\TaskAssigned;
use Illuminate\Support\Facades\Mail;
use App\Models\WorkSession;
use App\Models\WorkBreak;
use App\Models\UserProject;
use Illuminate\Support\Facades\Storage;






class AdminController extends Controller
{
    public function index()
    {
        // Get all users
        $users = User::all();

        // Get tasks for each user
        $userTasks = User::with('tasks')->get();

        // Get all tasks
        $tasks = Task::all();

        // Get the logged-in user
        $loggedInUser = auth()->user();

        // Pass data to the view
        return view('tasks.index', [
            'users' => $users,
            'userTasks' => $userTasks,
            'tasks' => $tasks,
            'loggedInUser' => $loggedInUser,  // Pass the logged-in user to the view
        ]);
    }


    public function getChartData()
    {
        $tasks = Task::with('project')->get();
        $chartData = $tasks->map(function ($task) {
            return [
                'projectName' => $task->projectName,
                'progress' => $task->status === 'Tamamlandı' ? 100 :
                    ($task->status === 'Test Ediliyor' ? 80 :
                        ($task->status === 'Devam Ediyor' ? 60 :
                            ($task->status === 'Başladı' ? 40 : 20)))
            ];
        });

        return response()->json($chartData);
    }

    public function updateTaskStatus($id, Request $request)
    {
        $task = Task::findOrFail($id);
        $task->status = $request->status;
        $task->save();

        return response()->json(['success' => true, 'message' => 'Task status updated successfully']);
    }



    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
            'email' => 'required|email',
            'gorev' => 'required',
            'phoneNumber' => 'required',
            'linkedinAddress' => 'required',
            'portfolioLink' => 'required',
            'profilePic' => 'required',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->email = $request->email;
        $user->gorev = $request->gorev;
        $user->phoneNumber = $request->phoneNumber;
        $user->linkedinAddress = $request->linkedinAddress;
        $user->portfolioLink = $request->portfolioLink;


        if ($request->hasFile('profilePic')) {

            $file = $request->file('profilePic');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path() . '/images';
            $file->move($destinationPath, $fileName);

            $user->profilePic = $fileName;
        }





        $user->save();

        return redirect()->back()->with('success', 'Kullanıcı başarıyla eklendi!');
    }













    public function edit($id)
    {
        $user = User::findOrFail($id);
        $profilePic = $user->profilePic;

        return view('admin.users.edit', compact('user'));

    }





    public function update(Request $request, $id)
    {

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->gorev = $request->gorev;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->email = $request->email;
        $user->phoneNumber = $request->phoneNumber;
        $user->linkedinAddress = $request->linkedinAddress;
        $user->portfolioLink = $request->portfolioLink;
        $user->profilePic = $request->profilePic;


        if ($request->hasFile('profilePic')) {

            $file = $request->file('profilePic');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path() . '/images';
            $file->move($destinationPath, $fileName);

            $user->profilePic = $fileName;
        }



        $user->save();

        return redirect()->route('admin.users.show', $user->id)->with('success', 'Kullanıcı başarıyla güncellendi!');
    }






    public function storeTask(Request $request)
    {
        $attachmentPath = null;
        $request->validate([
            'taskTitle' => 'required',
            'taskDescription' => 'required',
            'assignedTo' => 'required',
            'startDate' => 'required',
            'dueDate' => 'required',
            'attachments' => 'nullable|file|mimes:zip',
            'project' => 'required',
        ]);

        if ($request->hasFile('attachments')) {
            $file = $request->file('attachments');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('attachments');
            $file->move($destinationPath, $fileName);

            $attachmentPath = 'attachments/' . $fileName;
        }

        foreach ($request->input('assignedTo') as $userId) {
            $task = Task::create([
                'title' => $request->taskTitle,
                'description' => $request->taskDescription,
                'user_id' => $userId,
                'project_id' => $request->project,
                'start_date' => $request->startDate,
                'due_date' => $request->dueDate,
                'attachments' => $attachmentPath,
            ]);

            UserProject::create([
                'user_id' => $userId,
                'project_id' => $request->project,
            ]);

            $user = User::find($userId);
            if ($user && $user->email) {
                Mail::to($user->email)->send(new TaskAssigned($task, $user));
            } else {
                return redirect()->back()->with('error', 'Kullanıcı e-posta adresi bulunamadı!');
            }
        }

        return redirect()->back()->with('success', 'Görevler başarıyla atandı!');
    }













    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Kullanıcı başarıyla silindi.');
    }





    public function index1($id)
    {
        $project = Project::with([
            'tasks' => function ($query) use ($id) {
                $query->where('project_id', $id)->with('assignedUser');
            },
            'users'
        ])
            ->where('id', $id)
            ->firstOrFail();

        if (!$project) {
            abort(404);
        }
        $users = $project->users;

        return view('projects.show', [
            'project' => $project,
            'users' => $users,
        ]);
    }

    public function destroyProject(Project $project)
    {
        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'Proje başarıyla silindi.');
    }


    public function getProjectUsers(Project $projectId)
    {
        // Belirli bir project_id'ye sahip user_id'leri project_user tablosunda bul ve döndür
        $userIds = UserProject::where('project_id', $projectId->id)->pluck('user_id');

        $users = User::whereIn('id', $userIds)->get();
        return response()->json($users);
    }



    public function showWorkSessions()
    {
        $users = User::all();
        $workSessions = WorkSession::with(['user', 'breaks'])->get();

        return view('admin.work_sessions', compact('users', 'workSessions'));

    }

    public function editWorkSession($id)
    {
        $workSession = WorkSession::with('breaks')->findOrFail($id);
        return view('admin.edit_work_session', compact('workSession'));
    }


    public function updateWorkSession(Request $request, $id)
    {
        $request->validate([
            'start_time' => 'required|date',
            'end_time' => 'required|date',
            'status' => 'required|string',
            'breaks.*.start_time' => 'required|date',
            'breaks.*.end_time' => 'required|date'
        ]);

        $workSession = WorkSession::findOrFail($id);
        $workSession->update([
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => $request->status,
        ]);

        foreach ($request->breaks as $breakId => $breakData) {
            $break = WorkBreak::findOrFail($breakId);
            $break->update([
                'start_time' => $breakData['start_time'],
                'end_time' => $breakData['end_time'],
            ]);
        }

        return redirect()->route('admin.workSessions')->with('success', 'Work session updated.');
    }

    public function filterWorkSessions(Request $request)
    {
        $users = User::all();
        $userId = $request->input('user_id');

        if (!$userId) {
            return redirect()->route('admin.workSessions');
        }

        $workSessions = WorkSession::where('user_id', $userId)->with(['user', 'breaks'])->get();

        return view('admin.work_sessions', compact('workSessions', 'users'));
    }

    public function destroyWorkSession($id)
    {
        $workSession = WorkSession::findOrFail($id);
        $workSession->delete();

        return redirect()->route('admin.workSessions')->with('success', 'Çalışma oturumu başarıyla silindi.');
    }




    public function showWorkSessions1()
    {
        $user = auth()->user();
        $workSessions = WorkSession::with(['user', 'breaks'])
            ->where('user_id', $user->id)
            ->get();

        return view('user.tasks', compact('user', 'workSessions'));
    }




}
