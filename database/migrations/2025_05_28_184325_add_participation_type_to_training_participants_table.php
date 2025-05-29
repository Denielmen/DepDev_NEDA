<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('training_participants', function (Blueprint $table) {
            // Add the foreign key column
            $table->foreignId('participation_type_id')
                  ->nullable() // Make it nullable if you have existing data or allow no type initially
                  ->constrained('participation_types') // Constrain to the participation_types table
                  ->onDelete('set null') // Set to null if the referenced participation type is deleted
                  ->after('user_id'); // Place it after the user_id column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('training_participants', function (Blueprint $table) {
            // Drop the foreign key constraint and the column
            $table->dropForeign(['participation_type_id']);
            $table->dropColumn('participation_type_id');
        });
    }
};
