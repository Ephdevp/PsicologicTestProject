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
        Schema::create('user_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('test_id');
            $table->string('factorA_sten', 3);
            $table->string('factorB_sten', 3);
            $table->string('factorC_sten', 3);
            $table->string('factorE_sten', 3);
            $table->string('factorF_sten', 3);
            $table->string('factorG_sten', 3);
            $table->string('factorH_sten', 3);
            $table->string('factorI_sten', 3);
            $table->string('factorL_sten', 3);
            $table->string('factorM_sten', 3);
            $table->string('factorN_sten', 3);
            $table->string('factorO_sten', 3);
            $table->string('factorQ1_sten', 3);
            $table->string('factorQ2_sten', 3);
            $table->string('factorQ3_sten', 3);
            $table->string('factorQ4_sten', 3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_results');
    }
};
