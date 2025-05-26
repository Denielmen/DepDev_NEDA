<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'competency_id',
        'period_from',
        'period_to',
        'implementation_date',
        'budget',
        'no_of_hours',
        'superior',
        'provider',
        'dev_target',
        'performance_goal',
        'objective',
        'type',
        'status',
        'participant_pre_rating',
        'participant_post_rating',
        'supervisor_pre_rating',
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
    ];

    public function competency()
    {
        return $this->belongsTo(Competency::class)->withDefault();
    }

    /**
     * The participants that belong to the training.
     */
    public function participants()
    {
        return $this->belongsToMany(User::class, 'training_participant')
                    ->withPivot('participation_type_id')
                    ->withTimestamps();
    }

    /**
     * Get the participation type for a specific participant.
     */
    public function getParticipantType($userId)
    {
        $participant = $this->participants()
            ->where('users.id', $userId)
            ->first();
        
        if ($participant) {
            return ParticipationType::find($participant->pivot->participation_type_id);
        }
        
        return null;
    }

    /**
     * The participation types that belong to the training.
     */
    public function participationTypes()
    {
        return $this->belongsToMany(ParticipationType::class, 'training_participant')
                    ->withPivot('user_id')
                    ->withTimestamps();
    }
}