<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('competency');
            $table->date('implementation_date');
            $table->integer('No. of Hours')->nullable();
            $table->string('provider')->nullable();
            $table->enum('status', ['Implemented', 'Pending', 'Cancelled'])->default('Pending');
            $table->enum('type', ['Program', 'Unprogrammed']);
            $table->decimal('participant_pre_rating', 3, 2)->nullable();
            $table->decimal('participant_post_rating', 3, 2)->nullable();
            $table->decimal('supervisor_pre_rating', 3, 2)->nullable();
            $table->decimal('supervisor_post_rating', 3, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('trainings');
    }
}; 