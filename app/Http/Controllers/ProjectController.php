<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get projects where the user is associated or is an admin
        if ($user->role == 'admin') {
            $projects = Project::all();
        } else {
            $projects = $user->projects;
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
        // Sadece projede yer alan kullanıcı projeyi görebilir
        if (Auth::user()->role != 'admin' && !$project->users->contains(Auth::user()->id)) {
            abort(403, 'Bu projeye erişim izniniz yok.');
        }
        return view('projects.index', compact('project'));
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

    
}
