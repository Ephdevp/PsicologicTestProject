<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserLevelSeeder extends Seeder
{
    public function run(): void
    {
        $levels = [
            ['level_name' => 'super_admin'],
            ['level_name' => 'admin'],
            ['level_name' => 'user'],
        ];

        // Upsert to avoid duplicates if seeder runs multiple times
        DB::table('user_levels')->upsert($levels, ['level_name'], ['level_name']);
    }
}
