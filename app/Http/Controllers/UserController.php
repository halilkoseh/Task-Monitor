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


    // yeni eklenenler mesai
 // Start a new work session
 // Start a new work session

 public function startWorkSession()
{
    $user = Auth::user();

    // Kullanıcı zaten aktif bir mesai başlatmış mı kontrol et
    $activeSession = $user->workSessions()->where('status', 'working')->orWhere('status', 'on_break')->first();

    if ($activeSession) {
        return response()->json(['message' => 'Halen aktif bir mesainiz var.'], 400);
    }

    // Yeni mesai başlat


    $workSession = $user->workSessions()->create([
        'start_time' => now()->format("Y-m-d H:i:s") ,



        'status' => 'working'
    ]);

    return response()->json(['message' => 'Mesai başlatıldı', 'workSession' => $workSession]);
}
 


public function startBreak()
{
    $user = Auth::user();
    $workSession = $user->workSessions()->where('status', 'working')->latest()->first();


    if ($workSession) {
        $workSession->breaks()->create([
            'start_time' => now()->format("Y-m-d H:i:s"),
        ]);

        $workSession->status = 'on_break';
        $workSession->save();

        return response()->json(['message' => 'Mola başlatıldı', 'workSession' => $workSession]);
    }

    return response()->json(['message' => 'Şu anda molada değilsiniz veya aktif bir mesai yok.'], 400);
}

 // End the current break and resume work
 public function endBreak()
 {
     $user = Auth::user();
     $workSession = $user->workSessions()->where('status', 'on_break')->latest()->first();
     $currentBreak = $workSession->breaks()->whereNull('end_time')->latest()->first();
 
    

     if ($workSession && $currentBreak) {
         // $currentBreak->update(['end_time' => now()->format("Y-m-d H:i:s") ,
          //  'start_time'=>$currentBreak->start_time ]);

        $currentBreak->end_time=now()->format("Y-m-d H:i:s");
        

         $workSession->update(['status' => 'working']);
 
         // dd(now()->format("Y-m-d H:i:s"), $currentBreak->end_time,$currentBreak->start_time);




         return redirect()->back();


     }
 
     return response()->json(['message' => 'Aktif bir mola bulunamadı.'], 400);


 }
 

 public function endWorkSession()
 {
     $user = Auth::user();
     $workSession = $user->workSessions()->where('status', 'working')->orWhere('status', 'on_break')->latest()->first();
 
     if ($workSession) {
         if ($workSession->status === 'on_break') {
             // Mola bitirme
             $this->endBreak();
         }
 
         $workSession->update([
             'end_time' => now()->format("Y-m-d H:i:s"),
             'status' => 'ended',
         ]);
 
         return response()->json(['message' => 'Mesai sona erdi', 'workSession' => $workSession]);
     }
 
     return response()->json(['message' => 'Aktif bir mesai bulunamadı.'], 400);
 }
 

 // Show all work sessions with breaks
 public function showWorkSessions()
{
    $user = Auth::user();
    $workSessions = $user->workSessions()->with('breaks')->get();

    $totalWorkDuration = 0;

    foreach ($workSessions as $session) {
        $startTime = Carbon::parse($session->start_time);
        $endTime = Carbon::parse($session->end_time ?? Carbon::now());

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
        $formattedTotalWorkDuration .= "$hours saat ";
    }
    if ($minutes > 0) {
        $formattedTotalWorkDuration .= "$minutes dakika ";
    }
    if ($seconds > 0 || empty($formattedTotalWorkDuration)) {
        $formattedTotalWorkDuration .= "$seconds saniye";
    }

    return view('user.workSessions', compact('workSessions', 'formattedTotalWorkDuration'));
}





 }