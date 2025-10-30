<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TthRecord extends Model
{
    protected $fillable = ['training_id', 'date_from', 'date_to'];

    public function training()
    {
        return $this->belongsTo(Training::class);
    }
} 