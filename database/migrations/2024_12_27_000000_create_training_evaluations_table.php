<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('training_evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_id')->constrained('trainings')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Participant evaluations
            $table->integer('participant_pre_rating')->nullable();
            $table->integer('participant_post_rating')->nullable();
            $table->json('participant_post_evaluation')->nullable();
            
            // Supervisor evaluations
            $table->integer('supervisor_pre_rating')->nullable();
            $table->integer('supervisor_post_rating')->nullable();
            $table->json('supervisor_post_evaluation')->nullable();
            
            $table->timestamps();
            
            // Ensure one evaluation record per training-user combination
            $table->unique(['training_id', 'user_id']);
        });

        // Migrate existing evaluation data from trainings table
        $this->migrateExistingEvaluations();
    }

    /**
     * Migrate existing evaluation data from trainings table.
     */
    private function migrateExistingEvaluations(): void
    {
        $trainings = DB::table('trainings')
            ->where(function ($query) {
                $query->whereNotNull('participant_pre_rating')
                    ->orWhereNotNull('participant_post_rating')
                    ->orWhereNotNull('supervisor_pre_rating')
                    ->orWhereNotNull('supervisor_post_rating')
                    ->orWhereNotNull('participant_post_evaluation')
                    ->orWhereNotNull('supervisor_post_evaluation');
            })
            ->get();

        foreach ($trainings as $training) {
            // Get all participants for this training
            $participants = DB::table('training_participants')
                ->where('training_id', $training->id)
                ->get();

            foreach ($participants as $participant) {
                // Create evaluation record for each participant
                DB::table('training_evaluations')->updateOrInsert(
                    [
                        'training_id' => $training->id,
                        'user_id' => $participant->user_id,
                    ],
                    [
                        'participant_pre_rating' => $training->participant_pre_rating,
                        'participant_post_rating' => $training->participant_post_rating,
                        'participant_post_evaluation' => $training->participant_post_evaluation,
                        'supervisor_pre_rating' => $training->supervisor_pre_rating,
                        'supervisor_post_rating' => $training->supervisor_post_rating,
                        'supervisor_post_evaluation' => $training->supervisor_post_evaluation,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_evaluations');
    }
};
