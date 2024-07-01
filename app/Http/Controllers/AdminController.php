<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Project;

class AdminController extends Controller
{
    public function index()
    {

        $users = User::all();
        $userTasks = User::with('tasks')->get();
        $tasks = Task::all(); // Tüm görevleri al

        return view('admin.index', [
            'users' => $users,
            'userTasks' => $userTasks,
            'tasks' => $tasks // Tüm görevleri görünüme gönder
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
            'gorev' => 'required',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->gorev = $request->gorev;
        $user->save();

        return redirect()->back()->with('success', 'Kullanıcı başarıyla eklendi!');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username,' . $id,

            'gorev' => 'required',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->username = $request->username;
        $user->gorev = $request->gorev;
        $user->save();

        return redirect()->back()->with('success', 'Kullanıcı başarıyla güncellendi!');
    }

    public function storeTask(Request $request)
    {
        // Ek materyalleri yükleme işlemi
        $attachmentPath = null;
        if ($request->hasFile('attachments')) {
            $attachmentPath = $request->file('attachments')->store('attachments', 'public');
        }

        // Atanan her kullanıcı için ayrı bir görev kaydı oluşturma
        foreach ($request->input('assignedTo') as $userId) {
            Task::create([
                'title' => $request->taskTitle,
                'description' => $request->taskDescription,
                'user_id' => $userId,  // Tek kullanıcı ID'si atanıyor
                'project' => $request->project,
                'start_date' => $request->startDate,
                'due_date' => $request->dueDate,
                'attachments' => $attachmentPath
            ]);
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
    // Projeyi id'ye göre bul, ve ilişkili kullanıcıları ve görevlerini al
    $project = Project::with(['tasks' => function ($query) use ($id) {
                          $query->where('project', $id)->with('assignedUser');
                      }, 'users'])
                      ->where('id', $id)
                      ->firstOrFail();

    // Eğer bulunan proje yoksa 404 hatası göster
    if (!$project) {
        abort(404);
    }

    // Kullanıcıların görevlerini al
    $userTasks = User::with('tasks')->get();

    return view('projects.show', [
        'project' => $project,
        'userTasks' => $userTasks,
    ]);
}

















}
