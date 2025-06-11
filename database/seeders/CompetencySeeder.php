<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Competency;

class CompetencySeeder extends Seeder
{
    public function run()
    {
        $competencies = [
            [
                'name' => 'Project Management',
                'description' => 'Skills and knowledge required to effectively manage projects'
            ],
            [
                'name' => 'Data Analysis',
                'description' => 'Ability to analyze and interpret data for decision making'
            ],
            [
                'name' => 'Leadership',
                'description' => 'Skills to lead and manage teams effectively'
            ],
            [
                'name' => 'Communication',
                'description' => 'Effective verbal and written communication skills'
            ],
            [
                'name' => 'Technical Skills',
                'description' => 'Specific technical knowledge and abilities'
            ],
            [
                'name' => 'Strategic Planning',
                'description' => 'Ability to develop and implement strategic plans'
            ],
            [
                'name' => 'Problem Solving',
                'description' => 'Analytical and critical thinking skills'
            ],
            [
                'name' => 'Team Management',
                'description' => 'Skills to manage and coordinate team activities'
            ]
        ];

        foreach ($competencies as $competency) {
            Competency::create($competency);
        }
    }
} 