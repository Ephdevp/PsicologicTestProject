<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionAnswersSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('seeders/data/answers_dump.sql');
        if (!file_exists($path)) {
            $this->command?->error("Missing file: {$path}. Place the selected INSERT from the SQL dump here.");
            return;
        }

        $sql = file_get_contents($path);
        if ($sql === false || trim($sql) === '') {
            $this->command?->error('answers_dump.sql is empty or unreadable.');
            return;
        }

        // Try to extract tuples in 6-field format: (id, option, question_id, test_id, 'text', score)
        $matches = [];
        $count6 = preg_match_all('/\(\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*,\s*\'([^\']*)\'\s*,\s*(NULL|\d+)\s*\)/u', $sql, $matches, PREG_SET_ORDER);

        // Or in normalized 3-field format: (question_id, 'text', score)
        $matches3 = [];
        $count3 = 0;
        if (!$count6) {
            $count3 = preg_match_all('/\(\s*(\d+)\s*,\s*\'([^\']*)\'\s*,\s*(NULL|\d+)\s*\)/u', $sql, $matches3, PREG_SET_ORDER);
        }

        if (!$count6 && !$count3) {
            $this->command?->error('No answer tuples found in answers_dump.sql');
            return;
        }

        $tuples = [];
        $inserted = 0;
        if ($count6) {
            foreach ($matches as $m) {
                // 6-field indices: 1=id, 2=option_idx, 3=question_id, 4=test_id, 5=answer_text, 6=score
                $questionId = (int)$m[3];
                $answerText = $m[5];
                $score = ($m[6] === 'NULL') ? null : (int)$m[6];

                $tuples[] = [$questionId, $answerText, $score];

                if (!Question::query()->where('id', $questionId)->exists()) {
                    $this->command?->warn("Skipping answer: question {$questionId} not found.");
                    continue;
                }
                Answer::query()->updateOrCreate([
                    'question_id' => $questionId,
                    'answer_text' => $answerText,
                ], [
                    'score' => $score,
                ]);
                $inserted++;
            }
        } else {
            foreach ($matches3 as $m) {
                // 3-field indices: 1=question_id, 2=answer_text, 3=score
                $questionId = (int)$m[1];
                $answerText = $m[2];
                $score = ($m[3] === 'NULL') ? null : (int)$m[3];

                $tuples[] = [$questionId, $answerText, $score];

                if (!Question::query()->where('id', $questionId)->exists()) {
                    $this->command?->warn("Skipping answer: question {$questionId} not found.");
                    continue;
                }
                Answer::query()->updateOrCreate([
                    'question_id' => $questionId,
                    'answer_text' => $answerText,
                ], [
                    'score' => $score,
                ]);
                $inserted++;
            }
        }

        // Rewrite file to normalized 3-field SQL for future runs
        if (!empty($tuples)) {
            $lines = [];
            foreach ($tuples as [$qid, $text, $sc]) {
                $scoreSql = ($sc === null) ? 'NULL' : (string)$sc;
                // escape single quotes in answer text
                $safeText = str_replace("'", "''", $text);
                $lines[] = "(" . $qid . ", '" . $safeText . "', " . $scoreSql . ")";
            }
            $normalized = "INSERT INTO `answers` (question_id, answer_text, score) VALUES\r\n" . implode(",\r\n", $lines) . ";\r\n";
            @file_put_contents($path, $normalized);
        }

        $this->command?->info("Seeded/updated {$inserted} answers from answers_dump.sql");
    }
}
