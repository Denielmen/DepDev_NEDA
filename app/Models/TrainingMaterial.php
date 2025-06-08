<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder; // Import the Builder class

class TrainingMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'competency_id', 'user_id', 'source', 'file_path', 'link', 'type',
    ];

    /**
     * Scope a query to search training materials by title, description, or file name.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string|null  $search
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch(Builder $query, ?string $search = null): Builder
    {
        if ($search) {
            $query->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
        }

        return $query;
    }// app/Models/Training.php
    
    public function trainingMaterials()
    {
        return $this->hasMany(TrainingMaterial::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function competency()
    {
        return $this->belongsTo(Competency::class, 'competency_id');
    }

    public function training()
    {
        return $this->belongsTo(Training::class,'training_id');
    }
}
