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
        Schema::create('sten_age_s', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_id')->constrained('tests_data')->onDelete('cascade');
            $table->string('factor'); // Factor name
            $table->integer('age_min')->nullable(); // Minimum age for this range
            $table->integer('age_max')->nullable(); // Maximum age for this range
            $table->string('gender')->nullable(); // M, F, or null for all
            $table->integer('raw_score_min'); // Minimum raw score
            $table->integer('raw_score_max'); // Maximum raw score
            $table->integer('sten_score'); // STEN score (1-10)
            $table->timestamps();
            
            $table->index(['test_id', 'factor', 'sten_score']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sten_age_s');
    }
};
