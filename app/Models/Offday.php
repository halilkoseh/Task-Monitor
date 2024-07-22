<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offday extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reason',
        'document',
        'status',
        'offday_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

