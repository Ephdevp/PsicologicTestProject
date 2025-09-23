<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Factor;
use App\Models\Question;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function questionarieSubmit(Request $request)
    {
        $requestCount = count($request->all());

        $user = Auth::user();
        $age = $user->people->first()->age ?? null;
        $gender = $user->people->first()->gender ?? null;

        $answereIdList = [];
        $questionIdList = [];
        $results = [];
        $factorList = [];
        // Collect all answers from the request
        foreach($request->all() as $value)
        {
            $answereIdList[] = $value;
        }

        //get all answers ids from request
        $answerIds = [];
        for ($i = 1; $i < $requestCount; $i++) {
            $answerIds[] = $answereIdList[$i];
        }
        
        //get all question ids from answers
        foreach($answerIds as $id)
        {

            $answer = Answer::where('id', $id)->first();
            if($answer->question->factor_id == null) continue;
            $factorList[] = $answer->question->factor_id;
            $questionIdList[] = $answer->question->id;
        }

        foreach($factorList as $factor)
        {
            $value = 0;
            foreach($answerIds as $answerId)
            {
                $answer = Answer::where('id', $answerId)->first();
                if($answer->question->factor_id == $factor)
                {
                    $value += $answer->score;
                }
            }
            $factor = Factor::where('id', $factor)->first()->name;
            $result = DB::select("SELECT lookup_sten(?, ?, ?, ?)-5 AS sten", [
                        $gender,
                        $age,
                        $factor,
                        $value
                    ]);
            $results[$factor] = $result[0]->sten ?? null;

        }
        // Mark the test as completed for the user
        $test_id = $answer->question->test_id;

        DB::table('test_user')
            ->where('user_id', $user->id)
            ->where('test_id', $test_id)
            ->where('status', 'not_started')
            ->update([
                'status' => 'completed',
                'completed_at' => Carbon::now(),
            ]);

            if($answerIds)
            {
                foreach($answerIds as $answerId)
                {
                    DB::table('answer_user')->insert([
                        'user_id' => $user->id,
                        'answer_id' => $answerId,
                    ]);
                }
            }

        return redirect()->route('dashboard.index')->with('results', $results);

    }
}
