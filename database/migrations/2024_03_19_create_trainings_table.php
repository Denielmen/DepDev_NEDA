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
            $table->foreignId('competency_id')->constrained('competencies');
            $table->date('period_from')->nullable();
            $table->date('period_to')->nullable();
            $table->date('implementation_date');
            $table->decimal('budget', 10, 2)->nullable();
            $table->integer('no_of_hours')->nullable();
            $table->string('superior')->nullable();
            $table->string('provider')->nullable();
            $table->text('dev_target')->nullable();
            $table->text('performance_goal')->nullable();
            $table->text('objective')->nullable();
            $table->enum('type', ['Program', 'Unprogrammed'])->default('Program');
            $table->string('status')->default('Pending');
            $table->integer('participant_pre_rating')->nullable();
            $table->integer('participant_post_rating')->nullable();
            $table->integer('supervisor_pre_rating')->nullable();
            $table->integer('supervisor_post_rating')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('trainings');
    }
};