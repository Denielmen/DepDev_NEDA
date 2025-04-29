<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $fillable = [
        'title',
        'competency',
        'year',
        'budget',
        'hours',
        'provider',
        'dev_target',
        'performance_goal',
        'objective',
    ];

    protected $casts = [
        'year' => 'date',
    ];
}