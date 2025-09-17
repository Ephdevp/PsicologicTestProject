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
        Schema::create('interpretation_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_id')->constrained('tests_data')->onDelete('cascade');
            $table->string('factor'); // Factor name
            $table->integer('sten_min'); // Minimum STEN score for this interpretation
            $table->integer('sten_max'); // Maximum STEN score for this interpretation
            $table->string('level_name'); // e.g., "Low", "Average", "High"
            $table->text('interpretation'); // Interpretation text
            $table->timestamps();
            
            $table->index(['test_id', 'factor', 'sten_min', 'sten_max']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interpretation_data');
    }
};
