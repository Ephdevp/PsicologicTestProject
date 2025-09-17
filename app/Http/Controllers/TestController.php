<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\Question;

class TestController extends Controller
{
    /**
     * Procesa el cuestionario sumando los valores (score) enviados.
     */
    public function questionarieSubmit(Request $request)
    {
        var_dump($request->all());
        die();
        $test = Test::findOrFail($request->input('test_id'));
        // Filtrar solo inputs de preguntas: asumimos name="question{ID}"
        $totalScore = 0;
        $answers = [];
        foreach ($request->all() as $key => $value) {
            if (str_starts_with($key, 'question')) {
                // El valor esperado es un número (score)
                if (is_numeric($value)) {
                    $score = (int) $value;
                    $totalScore += $score;
                    $answers[$key] = $score;
                }
            }
        }

        // Podrías guardar score en pivot user_test si se requiere.
        // Por ahora simplemente retornamos una vista rápida o redirect con mensaje.
        return redirect()->route('dashboard.index')
            ->with('quiz_result', [
                'test' => $test->name,
                'score' => $totalScore,
                'answered' => count($answers),
            ]);
    }
}
