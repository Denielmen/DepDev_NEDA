<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $fillable = [
        'title',
        'competency',
        'implementation_date',
        'provider',
        'status',
        'type',
        'participant_pre_rating',
        'participant_post_rating',
        'supervisor_pre_rating',
        'supervisor_post_rating'
    ];

    protected $casts = [
        'implementation_date' => 'date'
    ];
} 