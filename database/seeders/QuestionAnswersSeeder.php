<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionAnswersSeeder extends Seeder
{
    public function run(): void
    {
        $questions = Question::all();
        if ($questions->isEmpty()) {
            $this->command?->warn('No questions found. Run TestQuestionsSeeder first.');
            return;
        }

        foreach ($questions as $question) {
            $existing = $question->answers()->count();
            if ($existing >= 3) {
                continue;
            }

            $base = [
                ['answer_text' => 'Option A', 'score' => 1],
                ['answer_text' => 'Option B', 'score' => 2],
                ['answer_text' => 'Option C', 'score' => 3],
            ];

            foreach ($base as $row) {
                Answer::query()->firstOrCreate([
                    'question_id' => $question->id,
                    'answer_text' => $row['answer_text'],
                ], [
                    'score' => $row['score'],
                ]);
            }
        }
    }
}
