<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Switch `link` from VARCHAR(255) to TEXT to allow long URLs
        DB::statement('ALTER TABLE training_materials MODIFY link TEXT NULL');
    }

    public function down()
    {
        // Revert back to VARCHAR(255) if needed
        DB::statement('ALTER TABLE training_materials MODIFY link VARCHAR(255) NULL');
    }
};
