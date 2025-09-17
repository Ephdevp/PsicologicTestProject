<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TestData;
use App\Models\Question;
use App\Models\Answer;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tests = TestData::all();

        foreach ($tests as $test) {
            if ($test->name === 'Personality Assessment A') {
                $this->createPersonalityAQuestions($test);
            } elseif ($test->name === 'Advanced Personality Assessment B') {
                $this->createPersonalityBQuestions($test);
            } elseif ($test->name === 'Cognitive Assessment') {
                $this->createCognitiveQuestions($test);
            }
        }
    }

    private function createPersonalityAQuestions(TestData $test): void
    {
        $questions = [
            // Extraversion questions
            [
                'text' => 'I am the life of the party.',
                'factor' => 'extraversion',
                'answers' => [
                    ['text' => 'Strongly Disagree', 'score' => 1],
                    ['text' => 'Disagree', 'score' => 2],
                    ['text' => 'Neutral', 'score' => 3],
                    ['text' => 'Agree', 'score' => 4],
                    ['text' => 'Strongly Agree', 'score' => 5],
                ]
            ],
            [
                'text' => 'I feel comfortable around people.',
                'factor' => 'extraversion',
                'answers' => [
                    ['text' => 'Strongly Disagree', 'score' => 1],
                    ['text' => 'Disagree', 'score' => 2],
                    ['text' => 'Neutral', 'score' => 3],
                    ['text' => 'Agree', 'score' => 4],
                    ['text' => 'Strongly Agree', 'score' => 5],
                ]
            ],
            [
                'text' => 'I start conversations.',
                'factor' => 'extraversion',
                'answers' => [
                    ['text' => 'Strongly Disagree', 'score' => 1],
                    ['text' => 'Disagree', 'score' => 2],
                    ['text' => 'Neutral', 'score' => 3],
                    ['text' => 'Agree', 'score' => 4],
                    ['text' => 'Strongly Agree', 'score' => 5],
                ]
            ],
            // Neuroticism questions
            [
                'text' => 'I worry about things.',
                'factor' => 'neuroticism',
                'answers' => [
                    ['text' => 'Strongly Disagree', 'score' => 1],
                    ['text' => 'Disagree', 'score' => 2],
                    ['text' => 'Neutral', 'score' => 3],
                    ['text' => 'Agree', 'score' => 4],
                    ['text' => 'Strongly Agree', 'score' => 5],
                ]
            ],
            [
                'text' => 'I get stressed out easily.',
                'factor' => 'neuroticism',
                'answers' => [
                    ['text' => 'Strongly Disagree', 'score' => 1],
                    ['text' => 'Disagree', 'score' => 2],
                    ['text' => 'Neutral', 'score' => 3],
                    ['text' => 'Agree', 'score' => 4],
                    ['text' => 'Strongly Agree', 'score' => 5],
                ]
            ],
            // Openness questions
            [
                'text' => 'I have a vivid imagination.',
                'factor' => 'openness',
                'answers' => [
                    ['text' => 'Strongly Disagree', 'score' => 1],
                    ['text' => 'Disagree', 'score' => 2],
                    ['text' => 'Neutral', 'score' => 3],
                    ['text' => 'Agree', 'score' => 4],
                    ['text' => 'Strongly Agree', 'score' => 5],
                ]
            ],
            [
                'text' => 'I have excellent ideas.',
                'factor' => 'openness',
                'answers' => [
                    ['text' => 'Strongly Disagree', 'score' => 1],
                    ['text' => 'Disagree', 'score' => 2],
                    ['text' => 'Neutral', 'score' => 3],
                    ['text' => 'Agree', 'score' => 4],
                    ['text' => 'Strongly Agree', 'score' => 5],
                ]
            ],
        ];

        $this->createQuestionsWithAnswers($test, $questions);
    }

    private function createPersonalityBQuestions(TestData $test): void
    {
        $questions = [
            // Agreeableness questions
            [
                'text' => 'I sympathize with others\' feelings.',
                'factor' => 'agreeableness',
                'answers' => [
                    ['text' => 'Strongly Disagree', 'score' => 1],
                    ['text' => 'Disagree', 'score' => 2],
                    ['text' => 'Neutral', 'score' => 3],
                    ['text' => 'Agree', 'score' => 4],
                    ['text' => 'Strongly Agree', 'score' => 5],
                ]
            ],
            [
                'text' => 'I have a soft heart.',
                'factor' => 'agreeableness',
                'answers' => [
                    ['text' => 'Strongly Disagree', 'score' => 1],
                    ['text' => 'Disagree', 'score' => 2],
                    ['text' => 'Neutral', 'score' => 3],
                    ['text' => 'Agree', 'score' => 4],
                    ['text' => 'Strongly Agree', 'score' => 5],
                ]
            ],
            // Conscientiousness questions
            [
                'text' => 'I am always prepared.',
                'factor' => 'conscientiousness',
                'answers' => [
                    ['text' => 'Strongly Disagree', 'score' => 1],
                    ['text' => 'Disagree', 'score' => 2],
                    ['text' => 'Neutral', 'score' => 3],
                    ['text' => 'Agree', 'score' => 4],
                    ['text' => 'Strongly Agree', 'score' => 5],
                ]
            ],
            [
                'text' => 'I pay attention to details.',
                'factor' => 'conscientiousness',
                'answers' => [
                    ['text' => 'Strongly Disagree', 'score' => 1],
                    ['text' => 'Disagree', 'score' => 2],
                    ['text' => 'Neutral', 'score' => 3],
                    ['text' => 'Agree', 'score' => 4],
                    ['text' => 'Strongly Agree', 'score' => 5],
                ]
            ],
        ];

        $this->createQuestionsWithAnswers($test, $questions);
    }

    private function createCognitiveQuestions(TestData $test): void
    {
        $questions = [
            // Reasoning questions
            [
                'text' => 'I can solve complex problems easily.',
                'factor' => 'reasoning',
                'answers' => [
                    ['text' => 'Strongly Disagree', 'score' => 1],
                    ['text' => 'Disagree', 'score' => 2],
                    ['text' => 'Neutral', 'score' => 3],
                    ['text' => 'Agree', 'score' => 4],
                    ['text' => 'Strongly Agree', 'score' => 5],
                ]
            ],
            // Memory questions
            [
                'text' => 'I have an excellent memory.',
                'factor' => 'memory',
                'answers' => [
                    ['text' => 'Strongly Disagree', 'score' => 1],
                    ['text' => 'Disagree', 'score' => 2],
                    ['text' => 'Neutral', 'score' => 3],
                    ['text' => 'Agree', 'score' => 4],
                    ['text' => 'Strongly Agree', 'score' => 5],
                ]
            ],
            // Attention questions
            [
                'text' => 'I can focus on tasks for long periods.',
                'factor' => 'attention',
                'answers' => [
                    ['text' => 'Strongly Disagree', 'score' => 1],
                    ['text' => 'Disagree', 'score' => 2],
                    ['text' => 'Neutral', 'score' => 3],
                    ['text' => 'Agree', 'score' => 4],
                    ['text' => 'Strongly Agree', 'score' => 5],
                ]
            ],
        ];

        $this->createQuestionsWithAnswers($test, $questions);
    }

    private function createQuestionsWithAnswers(TestData $test, array $questions): void
    {
        foreach ($questions as $index => $questionData) {
            $question = Question::create([
                'test_id' => $test->id,
                'question_text' => $questionData['text'],
                'question_order' => $index + 1,
                'factor' => $questionData['factor'],
            ]);

            foreach ($questionData['answers'] as $answerIndex => $answerData) {
                Answer::create([
                    'question_id' => $question->id,
                    'answer_text' => $answerData['text'],
                    'score_value' => $answerData['score'],
                    'answer_order' => $answerIndex + 1,
                ]);
            }
        }
    }
}
