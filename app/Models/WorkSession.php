<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'start_time',
        'end_time',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function breaks()
    {
        return $this->hasMany(WorkBreak::class);
    }

    public function getTranslatedStatusAttribute()
    {
        $translations = [
            'working' => 'Çalışıyor',
            'ended' => 'Bitti',
            'on-break' => 'Mola'
        ];

        return $translations[$this->status] ?? $this->status;
    }

    public function workSession()
    {
        return $this->belongsTo(WorkSession::class);
    }

    public function getStartBadgeAttribute()
    {
        return '<span class="badge badge-start">' . Carbon::parse($this->start_time)->format('d/m/Y H:i') . '</span>';
    }

    public function getEndBadgeAttribute()
    {
        return '<span class="badge badge-end">' . Carbon::parse($this->end_time)->format('d/m/Y H:i') . '</span>';
    }

}