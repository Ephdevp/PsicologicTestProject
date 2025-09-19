<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        $database = config('database.connections.mysql.database');

        // Cambiar colación del schema
        DB::statement("ALTER DATABASE `{$database}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

        // Obtener tablas del schema
        $tables = collect(DB::select("SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = ?", [$database]))
            ->pluck('TABLE_NAME')
            ->toArray();

        foreach ($tables as $table) {
            // Convertir cada tabla
            DB::statement("ALTER TABLE `{$table}` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        }
    }

    public function down(): void
    {
        // No se revierte automáticamente (sería costoso y normalmente innecesario)
    }
};
