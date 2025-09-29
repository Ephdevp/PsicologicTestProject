<?php

namespace Database\Seeders;

use App\Models\Test;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'name' => 'Test A',
                'description' => null,
                'max_duration' => 45,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Test B',
                'description' => null,
                'max_duration' => 45,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($data as $row) {
            Test::query()->firstOrCreate(
                ['name' => $row['name']],
                $row
            );
        }
    }
}
