<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TestData;
use App\Models\StenAge;

class StenAgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tests = TestData::all();

        foreach ($tests as $test) {
            if ($test->factors) {
                foreach ($test->factors as $factor) {
                    $this->createStenRanges($test->id, $factor);
                }
            }
        }
    }

    private function createStenRanges(int $testId, string $factor): void
    {
        // Standard STEN conversion table (simplified example)
        // In real implementation, this would be based on standardization data
        $stenRanges = [
            ['raw_min' => 5, 'raw_max' => 6, 'sten' => 1],   // Very Low
            ['raw_min' => 7, 'raw_max' => 8, 'sten' => 2],   // Low
            ['raw_min' => 9, 'raw_max' => 10, 'sten' => 3],  // Below Average
            ['raw_min' => 11, 'raw_max' => 12, 'sten' => 4], // Below Average
            ['raw_min' => 13, 'raw_max' => 14, 'sten' => 5], // Average
            ['raw_min' => 15, 'raw_max' => 16, 'sten' => 6], // Average
            ['raw_min' => 17, 'raw_max' => 18, 'sten' => 7], // Above Average
            ['raw_min' => 19, 'raw_max' => 20, 'sten' => 8], // Above Average
            ['raw_min' => 21, 'raw_max' => 22, 'sten' => 9], // High
            ['raw_min' => 23, 'raw_max' => 25, 'sten' => 10], // Very High
        ];

        foreach ($stenRanges as $range) {
            StenAge::create([
                'test_id' => $testId,
                'factor' => $factor,
                'age_min' => null, // No age restrictions for this example
                'age_max' => null,
                'gender' => null, // No gender restrictions for this example
                'raw_score_min' => $range['raw_min'],
                'raw_score_max' => $range['raw_max'],
                'sten_score' => $range['sten'],
            ]);
        }
    }
}
