<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkBreak extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_time',
        'end_time'
    ];

    public function workSession()
    {
        return $this->belongsTo(WorkSession::class);
    }
}
