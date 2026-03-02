<?php

namespace App\Models;

use App\Models\MeetingBooking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hall extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'capacity'];

    public function meetings()
    {
        return $this->hasMany(MeetingBooking::class);
    }
}
