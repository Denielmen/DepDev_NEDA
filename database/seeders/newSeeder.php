<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Training;
use App\Models\TrainingMaterial;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class newSeeder extends Seeder
{
    public function run()
    {
        // USERS
        $divisions = ['HR', 'IT', 'Finance', 'Admin', 'Planning'];
        $positions = ['Manager', 'Staff', 'Officer', 'Assistant', 'Director'];
        $users = [];
        for ($i = 1; $i <= 10; $i++) {
            $users[] = User::create([
                'first_name' => "User{$i}",
                'last_name' => "Lastname{$i}",
                'mid_init' => chr(65 + $i),
                'division' => $divisions[array_rand($divisions)],
                'position' => $positions[array_rand($positions)],
                'is_active' => true,
                'years_in_position' => rand(1, 10),
                'years_in_csc' => rand(1, 20),
                'salary_grade' => rand(10, 25),
                'role' => 'User',
                'superior' => $i > 1 ? $users[array_rand($users)]->first_name . ' ' . $users[array_rand($users)]->last_name : null,
                'password' => Hash::make('password'),
            ]);
        }

        // TRAININGS
        $competencyIds = [1, 2, 3, 4, 5]; // adjust if you have a competencies table
        $trainings = [];
        for ($i = 1; $i <= 50; $i++) {
            $isProgram = $i <= 25;
            $isImplemented = $i % 2 === 0 || !$isProgram; // half implemented, all unprogrammed implemented
            $type = $isProgram ? 'Program' : 'Unprogrammed';
            $user = $users[array_rand($users)];
            $coreCompetencyId = rand(1, 5); // Adjust range as needed

            if ($isProgram) {
                $period_from = Carbon::now()->subYears(rand(1, 5))->year;
                $period_to = $isImplemented
                    ? Carbon::now()->subMonths(rand(1, 12))->year
                    : Carbon::now()->addYears(1)->year;
                $training = Training::create([
                    'title' => "Program Training {$i}",
                    'type' => $type,
                    'period_from' => $period_from,
                    'period_to' => $period_to,
                    'competency_id' => $coreCompetencyId,
                    'core_competency_id' => $coreCompetencyId,
                    'user_id' => $user->id,
                    'budget' => rand(10000, 50000),
                    'status' => $isImplemented ? 'Implemented' : 'Not Yet Implemented',
                ]);
            } else {
                $implementation_date_from = Carbon::now()->subMonths(rand(1, 24))->year;
                $training = Training::create([
                    'title' => "Unprogrammed Training {$i}",
                    'type' => $type,
                    'implementation_date_from' => $implementation_date_from,
                    'competency_id' => $coreCompetencyId,
                    'core_competency_id' => $coreCompetencyId,
                    'user_id' => $user->id,
                    'budget' => rand(10000, 50000),
                    'status' => 'Implemented', // Always implemented for unprogrammed
                ]);
            }
            $trainings[] = $training;
        }

        // TRAINING MATERIALS
        foreach ($trainings as $training) {
            for ($j = 1; $j <= 2; $j++) {
                $isMaterial = rand(0, 1);
                TrainingMaterial::create([
                    'training_id' => $training->id,
                    'title' => $isMaterial ? "Material for {$training->title}" : "Link for {$training->title}",
                    'file_path' => $isMaterial ? "materials/{$training->id}_{$j}.pdf" : null,
                    'link' => !$isMaterial ? "https://example.com/{$training->id}_{$j}" : null,
                    'type' => $isMaterial ? 'material' : 'link',
                    'competency_id' => $training->competency_id,
                    'user_id' => $users[array_rand($users)]->id,
                    'source' => $isMaterial ? 'Uploaded' : 'External', // <-- Add this line or set as needed
                ]);
            }
        }
    }
}
