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
                'implementation_date' => '2024-01-01',
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
                'implementation_date' => '2024-01-01',
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
            // Not yet implemented, no evaluations
            [
                'title' => 'Effective Communication Skills',
                'competency' => 'Communication',
                'implementation_date' => '2024-09-15',
                'no_of_hours' => 10,
                'provider' => 'CommTrain Institute',
                'status' => 'Pending',
                'type' => 'Program',
                'participant_pre_rating' => null,
                'participant_post_rating' => null,
                'supervisor_pre_rating' => null,
                'supervisor_post_rating' => null,
            ],
            [
                'title' => 'Time Management Essentials',
                'competency' => 'Time Management',
                'implementation_date' => '2024-10-05',
                'no_of_hours' => 6,
                'provider' => 'Productivity Hub',
                'status' => 'Pending',
                'type' => 'Program',
                'participant_pre_rating' => null,
                'participant_post_rating' => null,
                'supervisor_pre_rating' => null,
                'supervisor_post_rating' => null,
            ],
            // Implemented in Programmed
            [
                'title' => 'Strategic Planning Seminar',
                'competency' => 'Strategic Planning',
                'implementation_date' => '2024-04-20',
                'no_of_hours' => 14,
                'provider' => 'Strategy Experts',
                'status' => 'Pending',
                'type' => 'Program',
                'participant_pre_rating' => 3.4,
                'participant_post_rating' => 4.3,
                'supervisor_pre_rating' => 3.5,
                'supervisor_post_rating' => 4.2,
            ],
        ]);
    }
}