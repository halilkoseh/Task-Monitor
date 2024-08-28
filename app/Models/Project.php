<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'description'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'project_user');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'project_id', 'id');     }


        public static function getUserProjects($userId)
    {
        return self::whereHas('users', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get();
    }



    



}
