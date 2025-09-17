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
        Schema::create('tests_data', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('time_limit')->default(45); // minutes
            $table->boolean('is_active')->default(true);
            $table->integer('required_test_id')->nullable(); // Test A required for Test B
            $table->json('factors')->nullable(); // Factor names for score calculation
            $table->timestamps();
            
            $table->foreign('required_test_id')->references('id')->on('tests_data')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tests_data');
    }
};
