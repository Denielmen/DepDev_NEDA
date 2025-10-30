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
        // Fix any existing string values in date fields
        DB::table('users')->whereNotNull('government_start_date')->update([
            'government_start_date' => DB::raw('DATE(government_start_date)')
        ]);

        DB::table('users')->whereNotNull('position_start_date')->update([
            'position_start_date' => DB::raw('DATE(position_start_date)')
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No rollback needed for this data fix
    }
};
