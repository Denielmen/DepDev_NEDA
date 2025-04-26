<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
