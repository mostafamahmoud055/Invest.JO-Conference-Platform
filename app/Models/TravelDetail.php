<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TravelDetail extends Model
{
    protected $table = 'travel_details';

    protected $fillable = [
        'user_id',
        'arrival_date',
        'arrival_time',
        'departure_date',
        'departure_time',
        'nationality',
        'country',
        'passport_image',
    ];
}
