<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'password',
        'gorev', // yeni sütun
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Kullanıcıya atanmış görevler
    public function tasks()
    {
        return $this->hasMany(Task::class, 'user_id');

    }

//user modal 
    public function workSessions()
{
    return $this->hasMany(WorkSession::class);
}


public function projects()
{
    return $this->belongsToMany(Project::class, 'project_user', 'user_id', 'project_id');
}







}
