<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TestData;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Test A - First test, no prerequisites
        $testA = TestData::create([
            'name' => 'Personality Assessment A',
            'description' => 'A comprehensive personality assessment measuring key psychological factors.',
            'time_limit' => 45,
            'is_active' => true,
            'required_test_id' => null,
            'factors' => ['extraversion', 'neuroticism', 'openness'],
        ]);

        // Test B - Requires Test A to be completed
        TestData::create([
            'name' => 'Advanced Personality Assessment B',
            'description' => 'An advanced personality assessment that builds upon the results of Assessment A.',
            'time_limit' => 45,
            'is_active' => true,
            'required_test_id' => $testA->id,
            'factors' => ['agreeableness', 'conscientiousness'],
        ]);

        // Test C - Independent test
        TestData::create([
            'name' => 'Cognitive Assessment',
            'description' => 'An assessment focused on cognitive abilities and thinking patterns.',
            'time_limit' => 30,
            'is_active' => true,
            'required_test_id' => null,
            'factors' => ['reasoning', 'memory', 'attention'],
        ]);
    }
}
