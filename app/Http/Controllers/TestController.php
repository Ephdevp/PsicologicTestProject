<?php

namespace App\Http\Controllers;

use App\Models\TestData;
use App\Models\TestSession;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TestController extends Controller
{
    /**
     * Display a listing of available tests
     */
    public function index(): View
    {
        $user = auth()->user();
        $tests = TestData::where('is_active', true)
            ->with(['requiredTest'])
            ->get();

        // Add accessibility and completion status for each test
        $testsWithStatus = $tests->map(function ($test) use ($user) {
            return [
                'test' => $test,
                'can_access' => $test->canBeAccessedByUser($user),
                'is_completed' => $test->isCompletedByUser($user),
                'progress' => $this->getTestProgress($user, $test),
            ];
        });

        return view('dashboard', compact('testsWithStatus'));
    }

    /**
     * Show the form for starting a specific test
     */
    public function show(TestData $test): View
    {
        $user = auth()->user();

        // Check if user can access this test
        if (!$test->canBeAccessedByUser($user)) {
            abort(403, 'You need to complete the required test first.');
        }

        // Check if user has already completed this test
        if ($test->isCompletedByUser($user)) {
            return redirect()->route('test.result', $test)
                ->with('info', 'You have already completed this test.');
        }

        // Check for active session
        $activeSession = $user->testSessions()
            ->where('test_id', $test->id)
            ->where('status', 'in_progress')
            ->first();

        if ($activeSession && $activeSession->isExpired()) {
            $activeSession->markAsExpired();
            $activeSession = null;
        }

        return view('tests.show', compact('test', 'activeSession'));
    }

    /**
     * Get test progress for a user
     */
    private function getTestProgress($user, $test): array
    {
        $session = $user->testSessions()
            ->where('test_id', $test->id)
            ->latest()
            ->first();

        if (!$session || $session->status === 'completed') {
            $totalQuestions = $test->questions()->count();
            $answeredQuestions = 0;
        } else {
            $totalQuestions = $test->questions()->count();
            $answeredQuestions = $session->userAnswerRecords()->count();
        }

        return [
            'answered' => $answeredQuestions,
            'total' => $totalQuestions,
            'percentage' => $totalQuestions > 0 ? round(($answeredQuestions / $totalQuestions) * 100) : 0,
        ];
    }
}
