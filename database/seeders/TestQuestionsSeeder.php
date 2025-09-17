<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\Test;
use Illuminate\Database\Seeder;

class TestQuestionsSeeder extends Seeder
{
    public function run(): void
    {
        $tests = Test::all();
        if ($tests->isEmpty()) {
            $this->command?->warn('No tests found. Run TestSeeder first.');
            return;
        }

        $groups = ['communicative','emotional','intellectual','willpower'];
        $factors = ['A','B','C','E'];

        foreach ($tests as $test) {
            // Skip if test already has >= 10 questions
            if ($test->questions()->count() >= 10) {
                continue;
            }

            $questions = [];
            for ($i = 1; $i <= 10; $i++) {
                $questions[] = [
                    'test_id' => $test->id,
                    'group' => $groups[($i - 1) % count($groups)],
                    'factor' => $factors[($i - 1) % count($factors)],
                    'question_text' => 'Sample question '.$i.' for test: '.$test->name,
                ];
            }

            foreach ($questions as $q) {
                Question::query()->firstOrCreate([
                    'test_id' => $q['test_id'],
                    'question_text' => $q['question_text'],
                ], $q);
            }
        }
    }
}
