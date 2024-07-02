<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Project;
use App\Models\UserProject; // UserProject modelini import et

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
                'user_id' => $userId,
                'project_id' => $request->project, // Proje ID'sini task'a ekle
                'start_date' => $request->startDate,
                'due_date' => $request->dueDate,
                'attachments' => $attachmentPath
            ]);

            // UserProject tablosuna ekleme yap
            UserProject::create([
                'user_id' => $userId,
                'project_id' => $request->project,
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
            $query->where('project_id', $id)->with('assignedUser');
        }, 'users'])
            ->where('id', $id)
            ->firstOrFail();

        // Eğer bulunan proje yoksa 404 hatası göster
        if (!$project) {
            abort(404);
        }

        // Sadece bu projeye ait kullanıcıları getir
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


}
