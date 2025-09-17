<?php

namespace App\Http\Controllers;

use App\Models\TestData;
use App\Models\TestSession;
use App\Models\UserAnswerRecord;
use App\Models\StenAge;
use App\Models\InterpretationData;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TestSessionController extends Controller
{
    /**
     * Start a new test session
     */
    public function start(TestData $test): RedirectResponse
    {
        $user = auth()->user();

        // Check if user can access this test
        if (!$test->canBeAccessedByUser($user)) {
            return redirect()->route('dashboard')
                ->with('error', 'You need to complete the required test first.');
        }

        // Check if user has already completed this test
        if ($test->isCompletedByUser($user)) {
            return redirect()->route('test.result', $test)
                ->with('info', 'You have already completed this test.');
        }

        // Close any existing in-progress session for this test
        $user->testSessions()
            ->where('test_id', $test->id)
            ->where('status', 'in_progress')
            ->update(['status' => 'abandoned']);

        // Create new session
        $session = TestSession::create([
            'user_id' => $user->id,
            'test_id' => $test->id,
            'session_token' => Str::uuid(),
            'status' => 'in_progress',
            'started_at' => now(),
            'expires_at' => now()->addMinutes($test->time_limit),
        ]);

        return redirect()->route('test-session.take', $session->session_token);
    }

    /**
     * Display the test-taking interface
     */
    public function take(string $sessionToken): View
    {
        $session = TestSession::where('session_token', $sessionToken)
            ->with(['test.questions.answers', 'userAnswerRecords'])
            ->firstOrFail();

        // Check if session belongs to current user
        if ($session->user_id !== auth()->id()) {
            abort(403);
        }

        // Check if session is expired
        if ($session->isExpired()) {
            $session->markAsExpired();
            return redirect()->route('dashboard')
                ->with('error', 'Your test session has expired. Please start a new session.');
        }

        // Check if session is completed
        if ($session->status === 'completed') {
            return redirect()->route('test.result', $session->test);
        }

        $questions = $session->test->questions()->with('answers')->orderBy('question_order')->get();
        $answeredQuestions = $session->userAnswerRecords->pluck('question_id')->toArray();

        return view('tests.take', compact('session', 'questions', 'answeredQuestions'));
    }

    /**
     * Save an answer to a question
     */
    public function saveAnswer(Request $request, string $sessionToken): RedirectResponse
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'answer_id' => 'required|exists:answers,id',
        ]);

        $session = TestSession::where('session_token', $sessionToken)->firstOrFail();

        // Check if session belongs to current user
        if ($session->user_id !== auth()->id()) {
            abort(403);
        }

        // Check if session is expired
        if ($session->isExpired()) {
            $session->markAsExpired();
            return redirect()->route('dashboard')
                ->with('error', 'Your test session has expired.');
        }

        // Save or update the answer
        UserAnswerRecord::updateOrCreate(
            [
                'test_session_id' => $session->id,
                'question_id' => $request->question_id,
            ],
            [
                'answer_id' => $request->answer_id,
                'answered_at' => now(),
            ]
        );

        // Check if test is complete
        if ($session->isComplete()) {
            $this->completeTest($session);
            return redirect()->route('test.result', $session->test)
                ->with('success', 'Test completed successfully!');
        }

        return redirect()->route('test-session.take', $sessionToken);
    }

    /**
     * Complete the test and calculate scores
     */
    private function completeTest(TestSession $session): void
    {
        $scores = $this->calculateScores($session);
        $session->markAsCompleted($scores);
    }

    /**
     * Calculate STEN scores for the test session
     */
    private function calculateScores(TestSession $session): array
    {
        $test = $session->test;
        $factors = $test->factors ?? [];
        $scores = [];

        foreach ($factors as $factor) {
            // Get all questions for this factor
            $factorQuestions = $test->questions()
                ->where('factor', $factor)
                ->pluck('id');

            // Calculate raw score for this factor
            $rawScore = $session->userAnswerRecords()
                ->whereIn('question_id', $factorQuestions)
                ->join('answers', 'user_answer_records.answer_id', '=', 'answers.id')
                ->sum('answers.score_value');

            // Convert to STEN score
            $stenScore = StenAge::findStenScore($test->id, $factor, $rawScore);

            $scores[$factor] = [
                'raw_score' => $rawScore,
                'sten_score' => $stenScore,
            ];
        }

        return $scores;
    }

    /**
     * Show test results
     */
    public function result(TestData $test): View
    {
        $user = auth()->user();
        
        $session = $user->testSessions()
            ->where('test_id', $test->id)
            ->where('status', 'completed')
            ->latest()
            ->firstOrFail();

        $interpretations = [];
        if ($session->calculated_scores) {
            foreach ($session->calculated_scores as $factor => $scoreData) {
                if (isset($scoreData['sten_score'])) {
                    $interpretation = InterpretationData::findInterpretation(
                        $test->id, 
                        $factor, 
                        $scoreData['sten_score']
                    );
                    
                    $interpretations[$factor] = [
                        'sten_score' => $scoreData['sten_score'],
                        'interpretation' => $interpretation,
                    ];
                }
            }
        }

        return view('tests.result', compact('test', 'session', 'interpretations'));
    }
}
