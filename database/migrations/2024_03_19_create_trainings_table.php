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
            $table->text('dev_target')->nullable();
            $table->text('performance_goal')->nullable();
            $table->text('objective')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('trainings');
    }
};