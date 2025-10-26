<?php

namespace Database\Seeders;

use App\Models\Test;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    public function run(): void
    {
            Test::create([
                'name' => 'Test A',
                'description' => null,
                'max_duration' => 45,
                'status' => 'active',
                'category' => 'basic',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Test::create([
                'name' => 'Test B',
                'description' => null,
                'max_duration' => 45,
                'status' => 'active',
                'category' => 'basic',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Test::create([
                'name' => 'Test A',
                'description' => null,
                'max_duration' => 45,
                'status' => 'active',
                'category' => 'premium',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Test::create([
                'name' => 'Test B',
                'description' => null,
                'max_duration' => 45,
                'status' => 'active',
                'category' => 'premium',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    }
}
