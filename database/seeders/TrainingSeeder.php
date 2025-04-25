<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Training;

class TrainingSeeder extends Seeder
{
    public function run(): void
    {
        Training::create([
            'title' => 'Business Writing',
            'competency' => 'Business Writing',
            'implementation_date' => '2023-11-23',
            'provider' => 'NEDA Training Institute',
            'status' => 'Implemented',
            'type' => 'Program',
            'participant_pre_rating' => 3.50,
            'participant_post_rating' => 4.25,
            'supervisor_pre_rating' => 3.75,
            'supervisor_post_rating' => 4.50
        ]);

        Training::create([
            'title' => 'Project Management Fundamentals',
            'competency' => 'Project Management',
            'implementation_date' => '2023-12-15',
            'provider' => 'PMI Philippines',
            'status' => 'Implemented',
            'type' => 'Unprogrammed',
            'participant_pre_rating' => 3.00,
            'participant_post_rating' => 4.00,
            'supervisor_pre_rating' => 3.25,
            'supervisor_post_rating' => 4.25
        ]);
    }
} 