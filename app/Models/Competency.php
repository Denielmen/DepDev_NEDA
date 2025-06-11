<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competency extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    public function trainings()
    {
        return $this->hasMany(Training::class);
    }

    public function trainingMaterials()
    {
        return $this->hasMany(TrainingMaterial::class);
    }
} 