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
     * Get formatted years in position (e.g., "5 years & 2 months")
     */
    public function getFormattedYearsInPosition()
    {
        if (!$this->position_start_date) {
            return '0 months';
        }

        $startDate = new \DateTime($this->position_start_date);
        $today = new \DateTime();
        $diff = $today->diff($startDate);

        $years = $diff->y;
        $months = $diff->m;

        if ($years > 0 && $months > 0) {
            return $years . ' year' . ($years > 1 ? 's' : '') . ' & ' . $months . ' month' . ($months > 1 ? 's' : '');
        } elseif ($years > 0) {
            return $years . ' year' . ($years > 1 ? 's' : '');
        } else {
            // If years is 0, show only months (even if months is 0)
            return $months . ' month' . ($months > 1 ? 's' : '');
        }
    }

    /**
     * Get formatted years in government (e.g., "5 years & 2 months")
     */
    public function getFormattedYearsInGovernment()
    {
        if (!$this->government_start_date) {
            return '0 months';
        }

        $startDate = new \DateTime($this->government_start_date);
        $today = new \DateTime();
        $diff = $today->diff($startDate);

        $years = $diff->y;
        $months = $diff->m;

        if ($years > 0 && $months > 0) {
            return $years . ' year' . ($years > 1 ? 's' : '') . ' & ' . $months . ' month' . ($months > 1 ? 's' : '');
        } elseif ($years > 0) {
            return $years . ' year' . ($years > 1 ? 's' : '');
        } else {
            // If years is 0, show only months (even if months is 0)
            return $months . ' month' . ($months > 1 ? 's' : '');
        }
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