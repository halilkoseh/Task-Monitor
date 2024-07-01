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
        'project',
        'start_date',
        'due_date',
        'attachments',

    ];

    // Görevler bir kullanıcıya atanabilir
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function projectName()
    {
        return $this->belongsTo(Project::class, 'project', 'id'); // specify the foreign key and local key
    }




    public function tasks()
    {
        return $this->hasMany(Task::class, 'user_id');

    }





}
