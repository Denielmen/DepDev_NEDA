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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->unique()->nullable();
            $table->string('last_name', 50);
            $table->string('first_name', 50);
            $table->string('mid_init', 10)->nullable();
            $table->string('position', 100);
            $table->string('office', 100);
            $table->integer('years_in_position');
            $table->integer('years_in_csc');
            $table->string('division', 100);
            $table->integer('salary_grade');
            $table->string('role', 50);
            $table->string('superior', 100)->nullable();
            $table->string('password', 255);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};