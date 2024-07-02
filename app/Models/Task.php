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
        'attachments',
    ];

    // Görevler bir kullanıcıya atanabilir
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Görevler bir projeye ait olabilir
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
?>
