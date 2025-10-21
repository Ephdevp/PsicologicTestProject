<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Factor;
use App\Models\InterpretationData;
use App\Models\Person;
use App\Models\Question;
use App\Models\Test;
use App\Models\UserResults;
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
        
        //Validacion de que el usuario no esta evaluado en este test
        if(UserResults::where('user_id', $user->id)->where('test_id', $test_id)->exists())
        {
            return redirect()->route('dashboard.index')->with('error', 'You have already completed this test.');
        }

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
        // var_dump($results);
        // die();
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
            $result = $this->lookupSten($age, $gender, $factor, $value);
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

        $userResult = new UserResults();
        $userResult->create([
            'user_id' => $user->id,
            'test_id' => $test_id,
            'factorA_sten' => $results['A'] ?? null,
            'factorB_sten' => $results['B'] ?? null,
            'factorC_sten' => $results['C'] ?? null,
            'factorE_sten' => $results['E'] ?? null,
            'factorF_sten' => $results['F'] ?? null,
            'factorG_sten' => $results['G'] ?? null,
            'factorH_sten' => $results['H'] ?? null,
            'factorI_sten' => $results['I'] ?? null,
            'factorL_sten' => $results['L'] ?? null,
            'factorM_sten' => $results['M'] ?? null,
            'factorN_sten' => $results['N'] ?? null,
            'factorO_sten' => $results['O'] ?? null,
            'factorQ1_sten' => $results['Q1'] ?? null,
            'factorQ2_sten' => $results['Q2'] ?? null,
            'factorQ3_sten' => $results['Q3'] ?? null,
            'factorQ4_sten' => $results['Q4'] ?? null,

        ]);

        return redirect()->route('results.show')->with('test_id', $test_id);

    }

    public function showResults($test = null)
    {
        $user = Auth::user();
        $person = Person::where('user_id', $user->id)->first();
        $test_id = $test ?? session('test_id');
        $interpretations = [];

        $test = Test::find($test_id);
        $interpretationData = InterpretationData::all();

        $pivotTest = null;
        //extraer la relacion de muchos a muchos
        foreach($test->users as $testUser)
        {
            if($testUser->id == $user->id)
            {
                $pivotTest = $testUser;
                break;
            }
        }
        $userResults = UserResults::where('user_id', $user->id)->where('test_id', $test_id)->first();
        if($test->category == 'basic')
        {
            foreach($interpretationData as $data)
            {
                switch($data->factor)
                {
                    case 'C':
                        if($userResults->factorC_sten >= $data->sten_from && $userResults->factorC_sten <= $data->sten_to && $data->plan == 'basic') {
                            $interpretations['C'] = [
                                'title' => $data->title,
                                'psychology_text' => $data->psychology_text,
                                'health_text' => $data->health_text,
                            ];
                        }
                    break;
                    case 'L':
                        if($userResults->factorL_sten >= $data->sten_from && $userResults->factorL_sten <= $data->sten_to && $data->plan == 'basic') {
                            $interpretations['L'] = [
                                'title' => $data->title,
                                'psychology_text' => $data->psychology_text,
                                'health_text' => $data->health_text,
                            ];
                        }
                    break;
                    case 'O':
                        if($userResults->factorO_sten >= $data->sten_from && $userResults->factorO_sten <= $data->sten_to && $data->plan == 'basic') {
                            $interpretations['O'] = [
                                'title' => $data->title,
                                'psychology_text' => $data->psychology_text,
                                'health_text' => $data->health_text,
                            ];
                        }
                    break;
                    case 'Q4':
                        if($userResults->factorQ4_sten >= $data->sten_from && $userResults->factorQ4_sten <= $data->sten_to && $data->plan == 'basic') {
                            $interpretations['Q4'] = [
                                'title' => $data->title,
                                'psychology_text' => $data->psychology_text,
                                'health_text' => $data->health_text,
                            ];
                        }
                    break;
                }
            }
            $EZ = $userResults->factorC_sten + $userResults->factorL_sten + $userResults->factorO_sten + $userResults->factorQ4_sten;
            return view('results.basic', compact('user', 'person', 'test_id', 'userResults', 'test', 'pivotTest', 'interpretations', 'EZ'));
        }
        //Futura implementacion para test premium
        // foreach($interpretationData as $data)
        //     {
        //         switch($data->factor)
        //         {
        //             case 'C':
        //                 if($userResults->factorC_sten >= $data->sten_from && $userResults->factorC_sten <= $data->sten_to && $data->plan == 'premium') {
        //                     $interpretations['C'] = [
        //                         'title' => $data->title,
        //                         'psychology_text' => $data->psychology_text,
        //                         'health_text' => $data->health_text,
        //                     ];
        //                 }
        //             break;
        //             case 'L':
        //                 if($userResults->factorL_sten >= $data->sten_from && $userResults->factorL_sten <= $data->sten_to && $data->plan == 'premium') {
        //                     $interpretations['L'] = [
        //                         'title' => $data->title,
        //                         'psychology_text' => $data->psychology_text,
        //                         'health_text' => $data->health_text,
        //                     ];
        //                 }
        //             break;
        //             case 'O':
        //                 if($userResults->factorO_sten >= $data->sten_from && $userResults->factorO_sten <= $data->sten_to && $data->plan == 'premium') {
        //                     $interpretations['O'] = [
        //                         'title' => $data->title,
        //                         'psychology_text' => $data->psychology_text,
        //                         'health_text' => $data->health_text,
        //                     ];
        //                 }
        //             break;
        //             case 'Q4':
        //                 if($userResults->factorQ4_sten >= $data->sten_from && $userResults->factorQ4_sten <= $data->sten_to && $data->plan == 'premium') {
        //                     $interpretations['Q4'] = [
        //                         'title' => $data->title,
        //                         'psychology_text' => $data->psychology_text,
        //                         'health_text' => $data->health_text,
        //                     ];
        //                 }
        //             break;
        //         }
        //     }
        //     return view('results.basic', compact('user', 'person', 'test_id', 'userResults', 'test', 'pivotTest'));
    }

    //metodo para calcular el valor del sten
    public function lookupSten($age, $gender, $factor, $value)
    {
        $gender = $gender;
        $age = $age;
        $factor = $factor;
        $value = $value;

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

        return $result;
    }
}
