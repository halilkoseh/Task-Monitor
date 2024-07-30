<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'project_id',
        'start_date',
        'due_date',
        'status',
        'attachments',
    ];

            // Task.php (Model)
        public function attachments()
        {
            return $this->hasMany(Attachment::class);
        }


    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function edit($id)
{
    $task = Task::findOrFail($id); // Assuming you have a Task model
    return view('tasks.edit', compact('task'));
}


    public function project()
    {
        return $this->belongsTo(Project::class);
    }

 

}

// app/Models/Task.php


