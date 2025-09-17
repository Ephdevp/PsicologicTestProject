<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TestData;
use App\Models\TestSession;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard
     */
    public function index(): View
    {
        $totalUsers = User::count();
        $totalTests = TestData::count();
        $completedSessions = TestSession::where('status', 'completed')->count();
        $inProgressSessions = TestSession::where('status', 'in_progress')
            ->where('expires_at', '>', now())
            ->count();

        $recentSessions = TestSession::with(['user', 'test'])
            ->latest()
            ->limit(10)
            ->get();

        $testStats = TestData::withCount(['testSessions as completed_count' => function ($query) {
            $query->where('status', 'completed');
        }])
        ->withCount(['testSessions as total_count'])
        ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalTests', 
            'completedSessions',
            'inProgressSessions',
            'recentSessions',
            'testStats'
        ));
    }

    /**
     * Show users list
     */
    public function users(): View
    {
        $users = User::withCount(['testSessions as completed_tests' => function ($query) {
            $query->where('status', 'completed');
        }])
        ->withCount(['testSessions as total_sessions'])
        ->paginate(20);

        return view('admin.users', compact('users'));
    }

    /**
     * Show test results
     */
    public function results(): View
    {
        $sessions = TestSession::with(['user', 'test'])
            ->where('status', 'completed')
            ->latest()
            ->paginate(20);

        return view('admin.results', compact('sessions'));
    }

    /**
     * Show specific test session details
     */
    public function sessionDetails(TestSession $session): View
    {
        $session->load(['user', 'test', 'userAnswerRecords.question', 'userAnswerRecords.answer']);

        return view('admin.session-details', compact('session'));
    }
}
