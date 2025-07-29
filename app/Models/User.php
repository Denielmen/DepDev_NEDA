<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\ResetPasswordNotification;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'user_id',
        'email',
        'last_name',
        'first_name',
        'mid_init',
        'position',
        'position_start_date',
        'years_in_position',
        'years_in_csc',
        'government_start_date',
        'division',
        'salary_grade',
        'role',
        'superior',
        'password',
        'is_active',
        'is_superior_eligible',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected static function boot()
    {
        parent::boot();

        // Remove or comment out this section to prevent auto-generation
        // static::creating(function ($user) {
        //     // Get the next ID
        //     $nextId = static::max('id') + 1;
        //     // Generate user_id in the format DepDev_ + id
        //     $user->user_id = 'DepDev_' . $nextId;
        // });   
        // Akon gi comment nalang no use naman ini siya noh?
    }

    /**
     * The trainings that belong to the user.
     */
    public function trainings()
    {
        return $this->belongsToMany(Training::class, 'training_participants')
                    ->withPivot('participation_type_id', 'year')
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
            'is_superior_eligible' => 'boolean',
            'position_start_date' => 'date',
            'government_start_date' => 'date',
        ];
    }

    /**
     * Get all users who can be superiors (those with higher positions or admin role)
     */
    public static function getSuperiors()
    {
        return static::where('is_active', true)
            ->where('is_superior_eligible', true)
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

    /**
     * Send the password reset notification.
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}