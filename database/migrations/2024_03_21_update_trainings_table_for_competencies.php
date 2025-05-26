<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('trainings', function (Blueprint $table) {
            // First, add the new column
            $table->foreignId('competency_id')->nullable()->after('title')->constrained('competencies');
        });

        // Then, migrate existing competency data
        DB::statement('UPDATE trainings t JOIN competencies c ON t.competency = c.name SET t.competency_id = c.id');

        Schema::table('trainings', function (Blueprint $table) {
            // Finally, drop the old column
            $table->dropColumn('competency');
        });
    }

    public function down()
    {
        Schema::table('trainings', function (Blueprint $table) {
            // Add back the old column
            $table->string('competency')->after('title');
        });

        // Migrate data back
        DB::statement('UPDATE trainings t JOIN competencies c ON t.competency_id = c.id SET t.competency = c.name');

        Schema::table('trainings', function (Blueprint $table) {
            // Drop the foreign key and column
            $table->dropForeign(['competency_id']);
            $table->dropColumn('competency_id');
        });
    }
}; 