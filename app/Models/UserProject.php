<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProject extends Model
{
    use HasFactory;

    protected $table = 'project_user';

    protected $fillable = [
        'user_id',
        'project_id',
    ];

}