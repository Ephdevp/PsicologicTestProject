<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $tests = $user->tests()->wherePivot('user_id', $user->id)->get();
        $testA = $user->tests()->where('name', 'Test A')->first();
        $testACompleted = false;
        if($testA)
        {
            $testACompleted = $testA->pivot->status == 'completed' ?? false;
        }


        return view('dashboard', compact('user', 'tests', 'testACompleted'));
    }
}
