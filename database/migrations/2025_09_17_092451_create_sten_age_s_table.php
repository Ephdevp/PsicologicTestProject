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
            $table->increments('id');
            $table->text('group_sex_age')->nullable();
            $table->enum('sex', ['male', 'female']);
            $table->unsignedTinyInteger('age_from');
            $table->unsignedTinyInteger('age_to');
            $table->unsignedTinyInteger('sten_value');
            $table->unsignedTinyInteger('A_from')->nullable();
            $table->unsignedTinyInteger('A_to')->nullable();
            $table->unsignedTinyInteger('B_from')->nullable();
            $table->unsignedTinyInteger('B_to')->nullable();
            $table->unsignedTinyInteger('C_from')->nullable();
            $table->unsignedTinyInteger('C_to')->nullable();
            $table->unsignedTinyInteger('E_from')->nullable();
            $table->unsignedTinyInteger('E_to')->nullable();
            $table->unsignedTinyInteger('F_from')->nullable();
            $table->unsignedTinyInteger('F_to')->nullable();
            $table->unsignedTinyInteger('G_from')->nullable();
            $table->unsignedTinyInteger('G_to')->nullable();
            $table->unsignedTinyInteger('H_from')->nullable();
            $table->unsignedTinyInteger('H_to')->nullable();
            $table->unsignedTinyInteger('I_from')->nullable();
            $table->unsignedTinyInteger('I_to')->nullable();
            $table->unsignedTinyInteger('L_from')->nullable();
            $table->unsignedTinyInteger('L_to')->nullable();
            $table->unsignedTinyInteger('M_from')->nullable();
            $table->unsignedTinyInteger('M_to')->nullable();
            $table->unsignedTinyInteger('N_from')->nullable();
            $table->unsignedTinyInteger('N_to')->nullable();
            $table->unsignedTinyInteger('O_from')->nullable();
            $table->unsignedTinyInteger('O_to')->nullable();
            $table->unsignedTinyInteger('Q1_from')->nullable();
            $table->unsignedTinyInteger('Q1_to')->nullable();
            $table->unsignedTinyInteger('Q2_from')->nullable();
            $table->unsignedTinyInteger('Q2_to')->nullable();
            $table->unsignedTinyInteger('Q3_from')->nullable();
            $table->unsignedTinyInteger('Q3_to')->nullable();
            $table->unsignedTinyInteger('Q4_from')->nullable();
            $table->unsignedTinyInteger('Q4_to')->nullable();
            $table->timestamps();

            $table->index(['sex', 'age_from', 'age_to', 'sten_value'], 'idx_sten_age_demo');
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
