<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingEvaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'training_id',
        'user_id',
        'participant_pre_rating',
        'participant_post_rating',
        'participant_post_evaluation',
        'supervisor_pre_rating',
        'supervisor_post_rating',
        'supervisor_post_evaluation',
    ];

    protected $casts = [
        'participant_pre_rating' => 'integer',
        'participant_post_rating' => 'integer',
        'supervisor_pre_rating' => 'integer',
        'supervisor_post_rating' => 'integer',
        'participant_post_evaluation' => 'array',
        'supervisor_post_evaluation' => 'array',
    ];

    /**
     * Get the training that owns the evaluation.
     */
    public function training()
    {
        return $this->belongsTo(Training::class);
    }

    /**
     * Get the user that owns the evaluation.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get or create an evaluation record for a specific training and user.
     */
    public static function getOrCreate($training_id, $user_id)
    {
        return static::firstOrCreate([
            'training_id' => $training_id,
            'user_id' => $user_id,
        ]);
    }
}
