<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'user_id',
        'last_name',
        'first_name',
        'mid_init',
        'position',
        'office',
        'years_in_position',
        'years_in_csc',
        'division',
        'salary_grade',
        'role',
        'superior',
        'password',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            // Get the next ID
            $nextId = static::max('id') + 1;
            // Generate user_id in the format DepDev_ + id
            $user->user_id = 'DepDev_' . $nextId;
        });
    }

    /**
     * The trainings that belong to the user.
     */
    public function trainings()
    {
        return $this->belongsToMany(Training::class, 'training_participants')
                    ->withTimestamps();
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }
}