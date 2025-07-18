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
            $table->foreignId('training_id')->nullable()->constrained('trainings')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('training_materials', function (Blueprint $table) {
            $table->dropForeign(['training_id']);
            $table->dropColumn('training_id');
        });
    }
}; 