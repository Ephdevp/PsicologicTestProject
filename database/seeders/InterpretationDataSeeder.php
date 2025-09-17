<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TestData;
use App\Models\InterpretationData;

class InterpretationDataSeeder extends Seeder
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
                    $this->createInterpretations($test->id, $factor);
                }
            }
        }
    }

    private function createInterpretations(int $testId, string $factor): void
    {
        $interpretations = $this->getInterpretationsForFactor($factor);

        foreach ($interpretations as $interpretation) {
            InterpretationData::create([
                'test_id' => $testId,
                'factor' => $factor,
                'sten_min' => $interpretation['sten_min'],
                'sten_max' => $interpretation['sten_max'],
                'level_name' => $interpretation['level_name'],
                'interpretation' => $interpretation['interpretation'],
            ]);
        }
    }

    private function getInterpretationsForFactor(string $factor): array
    {
        $interpretations = [
            'extraversion' => [
                [
                    'sten_min' => 1, 'sten_max' => 3,
                    'level_name' => 'Introverted',
                    'interpretation' => 'You tend to be more reserved and prefer smaller groups or one-on-one interactions. You likely recharge by spending time alone and may prefer quieter environments.'
                ],
                [
                    'sten_min' => 4, 'sten_max' => 7,
                    'level_name' => 'Balanced',
                    'interpretation' => 'You show a balanced approach to social situations, being comfortable both in social settings and when alone. You can adapt your social energy based on the situation.'
                ],
                [
                    'sten_min' => 8, 'sten_max' => 10,
                    'level_name' => 'Extraverted',
                    'interpretation' => 'You are outgoing and energetic in social situations. You likely enjoy being around people, feel comfortable in groups, and tend to be talkative and assertive.'
                ],
            ],
            'neuroticism' => [
                [
                    'sten_min' => 1, 'sten_max' => 3,
                    'level_name' => 'Emotionally Stable',
                    'interpretation' => 'You tend to remain calm and composed under stress. You likely handle challenges well and maintain emotional equilibrium in difficult situations.'
                ],
                [
                    'sten_min' => 4, 'sten_max' => 7,
                    'level_name' => 'Moderate',
                    'interpretation' => 'You experience a normal range of emotions and stress responses. You may feel anxious or worried at times, but generally manage stress reasonably well.'
                ],
                [
                    'sten_min' => 8, 'sten_max' => 10,
                    'level_name' => 'Emotionally Reactive',
                    'interpretation' => 'You may experience emotions more intensely and be more sensitive to stress. You might find yourself worrying about things or feeling anxious more frequently than others.'
                ],
            ],
            'openness' => [
                [
                    'sten_min' => 1, 'sten_max' => 3,
                    'level_name' => 'Conventional',
                    'interpretation' => 'You tend to prefer familiar experiences and traditional approaches. You likely value stability and may be skeptical of new or unconventional ideas.'
                ],
                [
                    'sten_min' => 4, 'sten_max' => 7,
                    'level_name' => 'Moderate',
                    'interpretation' => 'You show a balanced approach to new experiences, being open to some novel ideas while maintaining appreciation for traditional methods.'
                ],
                [
                    'sten_min' => 8, 'sten_max' => 10,
                    'level_name' => 'Open to Experience',
                    'interpretation' => 'You are curious and open to new experiences, ideas, and creative approaches. You likely enjoy intellectual discussions and exploring new concepts.'
                ],
            ],
            'agreeableness' => [
                [
                    'sten_min' => 1, 'sten_max' => 3,
                    'level_name' => 'Competitive',
                    'interpretation' => 'You tend to be more competitive and direct in your approach. You may prioritize your own interests and be more willing to challenge others when necessary.'
                ],
                [
                    'sten_min' => 4, 'sten_max' => 7,
                    'level_name' => 'Balanced',
                    'interpretation' => 'You show a balanced approach between cooperation and competition, being able to work well with others while also standing up for your own interests when needed.'
                ],
                [
                    'sten_min' => 8, 'sten_max' => 10,
                    'level_name' => 'Cooperative',
                    'interpretation' => 'You are naturally cooperative and empathetic. You likely prioritize harmony in relationships and are considerate of others\' feelings and needs.'
                ],
            ],
            'conscientiousness' => [
                [
                    'sten_min' => 1, 'sten_max' => 3,
                    'level_name' => 'Flexible',
                    'interpretation' => 'You tend to be more spontaneous and flexible in your approach. You may prefer to adapt to situations as they arise rather than following strict plans.'
                ],
                [
                    'sten_min' => 4, 'sten_max' => 7,
                    'level_name' => 'Balanced',
                    'interpretation' => 'You show a balanced approach between organization and flexibility, being able to plan when necessary while remaining adaptable to changing circumstances.'
                ],
                [
                    'sten_min' => 8, 'sten_max' => 10,
                    'level_name' => 'Organized',
                    'interpretation' => 'You are highly organized and disciplined. You likely prefer structured environments, pay attention to details, and work systematically toward your goals.'
                ],
            ],
            'reasoning' => [
                [
                    'sten_min' => 1, 'sten_max' => 3,
                    'level_name' => 'Concrete',
                    'interpretation' => 'You tend to prefer concrete, practical thinking and may find abstract reasoning more challenging. You work best with clear, specific information.'
                ],
                [
                    'sten_min' => 4, 'sten_max' => 7,
                    'level_name' => 'Average',
                    'interpretation' => 'You show average reasoning abilities and can handle both concrete and abstract thinking reasonably well, depending on the situation.'
                ],
                [
                    'sten_min' => 8, 'sten_max' => 10,
                    'level_name' => 'Abstract',
                    'interpretation' => 'You excel at abstract reasoning and complex problem-solving. You can easily see patterns, connections, and work with theoretical concepts.'
                ],
            ],
            'memory' => [
                [
                    'sten_min' => 1, 'sten_max' => 3,
                    'level_name' => 'Average',
                    'interpretation' => 'Your memory performance is typical. You may benefit from using memory aids and organizational strategies for complex information.'
                ],
                [
                    'sten_min' => 4, 'sten_max' => 7,
                    'level_name' => 'Good',
                    'interpretation' => 'You have good memory abilities and can generally recall information effectively when needed.'
                ],
                [
                    'sten_min' => 8, 'sten_max' => 10,
                    'level_name' => 'Excellent',
                    'interpretation' => 'You have excellent memory capabilities and can easily recall detailed information across various contexts.'
                ],
            ],
            'attention' => [
                [
                    'sten_min' => 1, 'sten_max' => 3,
                    'level_name' => 'Distractible',
                    'interpretation' => 'You may find it challenging to maintain focus for extended periods and might be easily distracted by external stimuli.'
                ],
                [
                    'sten_min' => 4, 'sten_max' => 7,
                    'level_name' => 'Moderate',
                    'interpretation' => 'You have typical attention abilities and can generally focus on tasks when needed, though you may occasionally become distracted.'
                ],
                [
                    'sten_min' => 8, 'sten_max' => 10,
                    'level_name' => 'Focused',
                    'interpretation' => 'You have excellent attention and concentration abilities. You can maintain focus for extended periods and resist distractions effectively.'
                ],
            ],
        ];

        return $interpretations[$factor] ?? [];
    }
}
