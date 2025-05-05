<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

// dummy data for user
class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'user_id' => '20240001',
            'last_name' => 'Doe',
            'first_name' => 'John',
            'mid_init' => 'A',
            'position' => 'Administrative Assistant',
            'office' => 'Administrative Division',
            'years_in_position' => 2,
            'years_in_csc' => 5,
            'division' => 'Administrative Division',
            'salary_grade' => 8,
            'role' => 'Administrative',
            'superior' => 'Jane Smith',
            'password' => Hash::make('password123'),
        ]);
    }
} 