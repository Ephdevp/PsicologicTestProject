<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class TestQuestionsSeeder extends Seeder
{
    public function run(): void
    {
        $sqlPath = database_path('seeders/data/questions_dump.sql');
        if (! File::exists($sqlPath)) {
            $this->command?->error("SQL data file not found: {$sqlPath}");
            return;
        }

        $sql = File::get($sqlPath);
        DB::unprepared($sql);

        $this->command?->info("SQL data from questions_dump.sql has been executed successfully.");
    }
}
