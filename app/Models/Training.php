<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

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
        'status',
        'type',
        'participant_pre_rating',
        'participant_post_rating',
        'supervisor_pre_rating',
        'supervisor_post_rating',
        'hours'
    ];

    protected $casts = [
        'year' => 'date',
        'supervisor_post_rating',
    ];
}
}