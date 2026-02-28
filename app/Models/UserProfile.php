<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $table = 'user_profiles';

    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'family_name',
        'user_id',
        'phone',
        'job_title',
        'website',
        'bio',
        'linked_in_profile',
        'national_id',
    ];
}
