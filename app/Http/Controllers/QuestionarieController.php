<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Test;

class QuestionarieController extends Controller
{
    public function index($testId)
    {
        $questions = Question::where('test_id', $testId)->get();
        $countQuestions = count($questions);
        $test = Test::find($testId);
        $testId = $testId;
        $testName = $test->name ?? 'Questionnaire';
        $testDuration = $test->max_duration ?? 45;
        return view('questionnaire', compact('questions', 'testName', 'testDuration', 'testId', 'countQuestions'));
    }
}
