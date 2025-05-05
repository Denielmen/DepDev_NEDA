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
            'provider' => 'NEDA Training Institute',
            'year'=> '2023',
        ]);

        Training::create([
            'title' => 'Project Management Fundamentals',
            'competency' => 'Project Management',
            'provider' => 'PMI Philippines',
            'year'=> '2023',
        ]);
    }
} 