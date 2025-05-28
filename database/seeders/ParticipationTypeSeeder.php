<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParticipationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('participation_types')->insert([
            [
                'name' => 'Participant',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Resource Speaker',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
