<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Training;

class TrainingSeeder extends Seeder
{
    public function run()
    {
        Training::insert([
            [
                'title' => 'Project Management Basics',
                'competency' => 'Project Management',
                'implementation_date' => '2024-06-01',
                'no_of_hours' => 16,
                'provider' => 'PMI Philippines',
                'status' => 'Not Yet Implemented',
                'type' => 'Program',
                'participant_pre_rating' => 3.0,
                'participant_post_rating' => 4.0,
                'supervisor_pre_rating' => 3.2,
                'supervisor_post_rating' => 4.1,
            ],
            [
                'title' => 'Advanced Excel Training',
                'competency' => 'Data Analysis',
                'implementation_date' => '2024-07-15',
                'no_of_hours' => 8,
                'provider' => 'Excel Experts Inc.',
                'status' => 'Not Yet Implemented',
                'type' => 'Program',
                'participant_pre_rating' => 2.5,
                'participant_post_rating' => 3.8,
                'supervisor_pre_rating' => 2.7,
                'supervisor_post_rating' => 3.9,
            ],
            [
                'title' => 'Leadership Workshop',
                'competency' => 'Leadership',
                'implementation_date' => '2024-08-10',
                'no_of_hours' => 12,
                'provider' => 'Leadership Academy',
                'status' => 'Implemented',
                'type' => 'Unprogrammed',
                'participant_pre_rating' => 3.1,
                'participant_post_rating' => 4.2,
                'supervisor_pre_rating' => 3.0,
                'supervisor_post_rating' => 4.0,
            ],
        ]);
    }
}