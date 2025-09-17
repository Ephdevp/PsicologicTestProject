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
            $table->string('factor', 3)->nullable();
            $table->string('group', 25)->nullable();
            $table->string('plan', 25)->nullable();
            $table->integer('sten_from')->nullable();
            $table->integer('sten_to')->nullable();
            $table->string('title', 60)->nullable();
            $table->text('psychology_text')->nullable();
            $table->text('health_text')->nullable();
            $table->timestamps();
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
