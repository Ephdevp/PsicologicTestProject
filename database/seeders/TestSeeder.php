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
                'name' => 'Sample Anxiety Test',
                'description' => 'Measures general anxiety indicators for baseline assessment.',
                'max_duration' => 10,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cognitive Speed Check',
                'description' => 'Quick evaluation of processing speed and attention.',
                'max_duration' => 7,
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
