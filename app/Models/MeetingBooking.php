<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeetingBooking extends Model
{
    protected $fillable = [
        'hall_id',
        'requester_user_id',
        'meeting_type',
        'topic',
        'status',
        'date',
        'time',
        
    ];

    public function hall()
    {
        return $this->belongsTo(Hall::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'requester_user_id');
    }
}
