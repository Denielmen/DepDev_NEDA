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
        Schema::table('training_materials', function (Blueprint $table) {
            // Drop the existing foreign key constraint
            $table->dropForeign(['training_id']);
            
            // Add the new foreign key constraint with cascade delete
            $table->foreign('training_id')->references('id')->on('trainings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('training_materials', function (Blueprint $table) {
            // Drop the cascade foreign key constraint
            $table->dropForeign(['training_id']);
            
            // Add back the original foreign key constraint with set null
            $table->foreign('training_id')->references('id')->on('trainings')->onDelete('set null');
        });
    }
};
