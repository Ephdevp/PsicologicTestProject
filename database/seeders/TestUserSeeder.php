<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('test_user')->insert([
            'user_id' => 1,
            'test_id' => 1,
        ]);

        // DB::table('test_user')->insert([
        //     'user_id' => 1,
        //     'test_id' => 2,
        // ]);

        DB::table('test_user')->insert([
            'user_id' => 2,
            'test_id' => 1,
        ]);

        DB::table('test_user')->insert([
            'user_id' => 2,
            'test_id' => 2,
        ]);
    }
}
