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
        $user = Auth::user();
        $age = $user->people->first()->age ?? null;
        $gender = $user->people->first()->gender ?? null;

        // Extract answer inputs safely: keys like Answere_{questionId}
        $answerInputs = collect($request->all())
            ->filter(fn($v, $k) => str_starts_with($k, 'Answere_'));
        if ($answerInputs->isEmpty()) {
            return back()->withErrors(['answers' => __('You must answer the questionnaire.')]);
        }//llegan todas las respuestas

        // Resolve testId using any provided answer → its question's test_id
        $firstAnswerId = (int) $answerInputs->first();
        $firstAnswer = Answer::find($firstAnswerId);//se extrae con exito la primera respuesta

        if (!$firstAnswer || !$firstAnswer->question) {
            return back()->withErrors(['answers' => __('Invalid questionnaire submission.')]);
        }

        $test_id = (int) $firstAnswer->question->test_id;
        

        // Validate that all questions of this test are answered
        $questionIds = Question::where('test_id', $test_id)->pluck('id');//se tienen todos los ids de las questions del test en $test_id
        
        $providedQuestionIds = $answerInputs->keys()
            ->map(fn($k) => (int) str_replace('Answere_', '', $k));

        $missing = $questionIds->diff($providedQuestionIds);
        if ($missing->isNotEmpty()) {
            return back()->withErrors(['answers' => __('Please answer all questions before submitting.')]);
        }

        // Collect answer IDs as integers and map factor associations
        $answerIds = $answerInputs->values()->map(fn($v) => (int) $v)->all();//llegan todos los ids de las respuestas
        $results = [];
        $factorList = [];
        $questionIdList = [];
        
        foreach($answerIds as $id)
        {
            $answer = Answer::with('question:id,factor_id,test_id')->find($id);
            if(!$answer || !$answer->question || $answer->question->factor_id == null) continue;
            $factorList[] = $answer->question->factor_id;
            $questionIdList[] = $answer->question->id;
        }//factors y questions estan completos
            
        foreach($factorList as $factor)
        {
            $value = 0;
            foreach($answerIds as $answerId)
            {
                $answer = Answer::find($answerId);
                if($answer->question->factor_id == null)
                {
                    continue;
                }

                if($answer->question->factor_id == $factor)
                {
                    $value += $answer->score;
                }
            }

            $factor = Factor::where('id', $factor)->first()->name;
            if($factor == 'L' || $factor == 'O' || $factor == 'Q4')
            {
                $result = DB::select("SELECT 5-lookup_sten(?, ?, ?, ?) AS sten", [
                    $gender,
                    $age,
                    $factor,
                    $value
                ]);
            }else{
                $result = DB::select("SELECT lookup_sten(?, ?, ?, ?)-5 AS sten", [
                    $gender,
                    $age,
                    $factor,
                    $value
                ]);
            }
            $results[$factor] = $result[0]->sten ?? null;

        }
        // Mark the test as completed for the user

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
