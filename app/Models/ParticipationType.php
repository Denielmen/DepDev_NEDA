<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParticipationType extends Model
{
    protected $fillable = ['name', 'description'];

    public function trainingParticipants()
    {
        return $this->hasMany(TrainingParticipant::class);
    }
} 