<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('training_materials', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('source');
            $table->string('file_path')->nullable();
            $table->string('link')->nullable();
            $table->string('type')->default('material');
            $table->foreignId('competency_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('training_materials');
    }
}; 