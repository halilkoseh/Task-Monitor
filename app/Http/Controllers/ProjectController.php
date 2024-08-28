<?php
namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\UserProject;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        $user = Auth::user();

        // Get projects where the user is associated or is an admin
        if ($user && $user->role == 'admin') {
            $projects = Project::all();
        } else {
            $projects = $user ? $user->projects : collect();
        }
        return view('projects.index', compact('projects'));




    }

    public function create()
    {
        $users = User::all();
        return view('projects.create', compact('users'));

    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'description' => 'nullable',
            'users' => 'required|array',
            'users.*' => 'exists:users,id',
        ]);



        // Proje oluştur
        $project = Project::create([
            'name' => $request->name,
            'type' => $request->type,
            'description' => $request->description,

        ]);


        $project->users()->attach($request->input('users'));

        return redirect()->route('projects.index')->with('success', 'Proje başarıyla oluşturuldu.');
    }

    public function show(Project $project)
    {
        $user = Auth::user();


        if ($user && $user->role != 'admin' && !$project->users->contains($user->id)) {
            abort(403, 'Bu projeye erişim izniniz yok.');
        }
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'description' => 'nullable'
        ]);

        $project->update($request->all());

        return redirect()->route('projects.index')->with('success', 'Proje başarıyla güncellendi.');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Proje başarıyla silindi.');
    }




    public function index1()
    {
        // Giriş yapan kullanıcının ID'sini al
        $userId = auth()->id();

        // Kullanıcının erişim yetkisi olduğu projelerin ID'lerini al
        $projectIds = UserProject::where('user_id', $userId)
            ->pluck('project_id');

        // Projeleri getir (eğer erişim yetkisi olan projeler varsa)
        $projects = Project::whereIn('id', $projectIds)->get();

        // Projeleri view'e gönder
        return view('projects.indexUser', compact('projects'));






    }







    public function show1(Project $project)
    {
        $user = Auth::user();


        if (
            $user &&
            $user->role == 'admin' &&
            !$project->users->contains($user->id)
        ) {
            abort(403, 'Bu projeye erişim izniniz yok.');
        }


        return view('projects.showUser', compact('project'));
    }


}

