<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\Test;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class TestQuestionsSeeder extends Seeder
{
    public function run(): void
    {
        $sqlPath = database_path('seeders/data/interpretation_data_trimmed.sql');
        if (! File::exists($sqlPath)) {
            $this->command?->error("SQL data file not found: {$sqlPath}");
            return;
        }

        $sql = File::get($sqlPath);
        // Extract only the INSERT INTO `questions` ... VALUES (...) block
        if (! preg_match('/INSERT\s+INTO\s+`questions`[^V]*VALUES\s*(.*?);/si', $sql, $m)) {
            $this->command?->error('No INSERT INTO `questions` VALUES block found in SQL file.');
            return;
        }

        $valuesBlock = trim($m[1]);
        // Split into tuples while respecting parentheses nesting and quotes
        $tuples = $this->splitSqlTuples($valuesBlock);

        $factorMap = [
            'A' => 1,
            'B' => 2,
            'C' => 3,
            'E' => 4,
            'F' => 5,
            'G' => 6,
            'H' => 7,
            'I' => 8,
            'L' => 9,
            'M' => 10,
            'N' => 11,
            'O' => 12,
            'Q1' => 13,
            'Q2' => 14,
            'Q3' => 15,
            'Q4' => 16,
        ];

        $created = 0; $skipped = 0; $errors = 0;
        foreach ($tuples as $tuple) {
            $fields = $this->splitFields($tuple);
            // Expecting 4 fields: test_id, group, factor_id (code), question_text
            if (count($fields) !== 4) {
                $errors++; continue;
            }

            $testId = $this->parseValue($fields[0]);
            $group = $this->parseValue($fields[1]);
            $factorCode = $this->parseValue($fields[2]);
            $questionText = $this->parseValue($fields[3]);

            $factorId = null;
            if (is_string($factorCode) && $factorCode !== '') {
                $factorId = $factorMap[$factorCode] ?? null;
            }

            if (! $testId) {
                $skipped++; continue;
            }

            $payload = [
                'test_id' => $testId,
                'group' => $group,
                'factor_id' => $factorId,
                'question_text' => $questionText,
            ];

            Question::query()->firstOrCreate([
                'test_id' => $testId,
                'question_text' => $questionText,
            ], $payload) ? $created++ : $skipped++;
        }

        $this->command?->info("Questions seeded. created={$created}, skipped={$skipped}, parseErrors={$errors}");
    }

    /**
     * Split a VALUES block like (..),(..),(..)
     * into individual tuple strings without surrounding whitespace.
     */
    protected function splitSqlTuples(string $valuesBlock): array
    {
        $tuples = [];
        $depth = 0; $start = 0; $inQuote = false; $q = '';
        $len = strlen($valuesBlock);
        for ($i = 0; $i < $len; $i++) {
            $ch = $valuesBlock[$i];
            if ($inQuote) {
                if ($ch === $q) {
                    // handle escaped quotes within string: '' -> '
                    if ($i + 1 < $len && $valuesBlock[$i + 1] === $q) {
                        $i++; // skip escaped quote
                    } else {
                        $inQuote = false; $q = '';
                    }
                }
                continue;
            }
            if ($ch === '\'' || $ch === '"') { $inQuote = true; $q = $ch; continue; }
            if ($ch === '(') { if ($depth === 0) { $start = $i; } $depth++; }
            elseif ($ch === ')') { $depth--; if ($depth === 0) { $tuples[] = substr($valuesBlock, $start, $i - $start + 1); } }
        }
        return $tuples;
    }

    /**
     * Split fields within a tuple like (a,'b',NULL,'c') respecting quotes.
     */
    protected function splitFields(string $tuple): array
    {
        // Trim surrounding parentheses
        $s = trim($tuple);
        if (str_starts_with($s, '(') && str_ends_with($s, ')')) {
            $s = substr($s, 1, -1);
        }
        $fields = [];
        $buf = '';
        $inQuote = false; $q = '';
        $len = strlen($s);
        for ($i = 0; $i < $len; $i++) {
            $ch = $s[$i];
            if ($inQuote) {
                if ($ch === $q) {
                    if ($i + 1 < $len && $s[$i + 1] === $q) {
                        // escaped quote within string (SQL style '')
                        $buf .= $q; $i++;
                    } else {
                        $inQuote = false; $q = '';
                    }
                } else {
                    $buf .= $ch;
                }
                continue;
            }
            if ($ch === '\'' || $ch === '"') { $inQuote = true; $q = $ch; continue; }
            if ($ch === ',') { $fields[] = trim($buf); $buf = ''; continue; }
            $buf .= $ch;
        }
        if ($buf !== '') { $fields[] = trim($buf); }
        return $fields;
    }

    /**
     * Parse a single SQL literal into PHP value.
     */
    protected function parseValue(string $raw)
    {
        $raw = trim($raw);
        if ($raw === 'NULL') return null;
        // numeric?
        if (preg_match('/^-?\d+(?:\.\d+)?$/', $raw)) {
            return (int) $raw;
        }
        // quoted string
        if ((str_starts_with($raw, "'") && str_ends_with($raw, "'")) ||
            (str_starts_with($raw, '"') && str_ends_with($raw, '"'))) {
            $quote = $raw[0];
            $val = substr($raw, 1, -1);
            // Unescape doubled quotes
            $val = str_replace($quote.$quote, $quote, $val);
            return $val;
        }
        return trim($raw, "'\"");
    }
}
