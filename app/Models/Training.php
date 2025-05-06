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
        'period_from',
        'period_to',
        'implementation_date',
        'period_from',
        'period_to',
        'implementation_date',
        'budget',
        'no_of_hours',
        'superior',
        'no_of_hours',
        'superior',
        'provider',
        'dev_target',
        'performance_goal',
        'objective',
        'type',
        'type',
        'status',
        'participant_pre_rating',
        'participant_post_rating',
        'supervisor_pre_rating',
        'supervisor_post_rating'
        'supervisor_post_rating'
    ];
    protected $casts = [
        'period_from' => 'date',
        'period_to' => 'date',
        'implementation_date' => 'date',
        'budget' => 'decimal:2',
        'participant_pre_rating' => 'integer',
        'participant_post_rating' => 'integer',
        'supervisor_pre_rating' => 'integer',
        'supervisor_post_rating' => 'integer'
        'period_from' => 'date',
        'period_to' => 'date',
        'implementation_date' => 'date',
        'budget' => 'decimal:2',
        'participant_pre_rating' => 'integer',
        'participant_post_rating' => 'integer',
        'supervisor_pre_rating' => 'integer',
        'supervisor_post_rating' => 'integer'
    ];

    /**
     * The participants that belong to the training.
     */
    public function participants()
    {
        return $this->belongsToMany(User::class, 'training_participants')
                    ->withTimestamps();
    }

    /**
     * The participants that belong to the training.
     */
    public function participants()
    {
        return $this->belongsToMany(User::class, 'training_participants')
            ->withPivot('year')
            ->withTimestamps();
    }
}