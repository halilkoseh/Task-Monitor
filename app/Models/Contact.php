<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['name', 'email', 'message', 'user_id'];  // Add 'user_id' here

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
