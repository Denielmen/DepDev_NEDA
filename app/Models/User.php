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

    /**
     * Get all users who can be superiors (those with higher positions or admin role)
     */
    public static function getSuperiors()
    {
        return static::where('is_active', true)
            ->where(function($query) {
                $query->where('role', 'Admin')
                    ->orWhere('position', 'like', '%Director%')
                    ->orWhere('position', 'like', '%Manager%')
                    ->orWhere('position', 'like', '%Head%')
                    ->orWhere('position', 'like', '%Chief%');
            })
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();
    }

    /**
     * Get the user's full name
     */
    public function getFullNameAttribute()
    {
        return $this->last_name . ', ' . $this->first_name . ($this->mid_init ? ' ' . $this->mid_init : '');
    }
}