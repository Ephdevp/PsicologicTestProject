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
        Schema::table('user_test', function (Blueprint $table) {
            $table->timestamp('completed_at')->nullable()->comment('Timestamp when the user completed the test');
            $table->enum('status', ['not_started', 'completed'])->default('not_started')->comment('Status of the test for the user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_test', function (Blueprint $table) {
            $table->dropColumn(['score', 'completed_at', 'status']);
        });
    }
};
