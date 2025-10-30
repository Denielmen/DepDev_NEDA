<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Add foreign keys to trainings table
        Schema::table('trainings', function (Blueprint $table) {
            // Add index on competency_id
            $table->index('competency_id');
            
            // Add index on type for faster filtering
            $table->index('type');
            
            // Add index on status for faster filtering
            $table->index('status');
        });

        // Only proceed if the training_materials table exists
        if (Schema::hasTable('training_materials')) {
            // Add any missing indexes
            Schema::table('training_materials', function (Blueprint $table) {
                if (!Schema::hasColumn('training_materials', 'competency_id')) {
                    $table->foreignId('competency_id')->nullable()->constrained()->onDelete('set null');
                }
            });
        }

        // Add indexes to training participants table (checking both possible names)
        if (Schema::hasTable('training_participants')) {
            Schema::table('training_participants', function (Blueprint $table) {
                // Add index on training_id and user_id
                $table->index(['training_id', 'user_id']);
                
                // Add index on year for faster filtering
                $table->index('year');
            });
        } elseif (Schema::hasTable('training_participant')) {
            Schema::table('training_participant', function (Blueprint $table) {
                // Add index on training_id and user_id
                $table->index(['training_id', 'user_id']);
            });
        }
    }

    public function down()
    {
        // Remove indexes from trainings table
        Schema::table('trainings', function (Blueprint $table) {
            // Check if indexes exist before dropping
            if (Schema::hasIndex('trainings', 'trainings_competency_id_index')) {
                $table->dropIndex(['competency_id']);
            }
            if (Schema::hasIndex('trainings', 'trainings_type_index')) {
                $table->dropIndex(['type']);
            }
            if (Schema::hasIndex('trainings', 'trainings_status_index')) {
                $table->dropIndex(['status']);
            }
        });

        if (Schema::hasTable('training_materials')) {
            Schema::table('training_materials', function (Blueprint $table) {
                if (Schema::hasColumn('training_materials', 'competency_id')) {
                    if (Schema::hasIndex('training_materials', 'training_materials_competency_id_foreign')) {
                        $table->dropForeign(['competency_id']);
                    }
                    $table->dropColumn('competency_id');
                }
            });
        }

        // Remove indexes from training participants table (checking both possible names)
        if (Schema::hasTable('training_participants')) {
            Schema::table('training_participants', function (Blueprint $table) {
                if (Schema::hasIndex('training_participants', 'training_participants_training_id_user_id_index')) {
                    $table->dropIndex(['training_id', 'user_id']);
                }
                if (Schema::hasIndex('training_participants', 'training_participants_year_index')) {
                    $table->dropIndex(['year']);
                }
            });
        } elseif (Schema::hasTable('training_participant')) {
            Schema::table('training_participant', function (Blueprint $table) {
                if (Schema::hasIndex('training_participant', 'training_participant_training_id_foreign')) {
                    $table->dropForeign(['training_id']);
                }
                if (Schema::hasIndex('training_participant', 'training_participant_user_id_foreign')) {
                    $table->dropForeign(['user_id']);
                }
                if (Schema::hasIndex('training_participant', 'training_participant_participation_type_id_foreign')) {
                    $table->dropForeign(['participation_type_id']);
                }
                if (Schema::hasIndex('training_participant', 'training_participant_training_id_user_id_index')) {
                    $table->dropIndex(['training_id', 'user_id']);
                }
            });
        }
    }
}; 