<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TestController extends Controller
{
    public function questionarieSubmit(Request $request)
    {
        $requestCount = count($request->all());

        $user = Auth::user();
        $age = $user->person->age ?? null;
        $gender = $user->person->gender ?? null;
        // Prueba de la función lookup_sten: usar un factor y raw ficticio si hay edad y sexo.
        $testLookup = null;
        if ($age && $gender) {
            // Escoge un factor de ejemplo; podría venir de la request en el futuro.
            $factor = 'A';
            $raw = 10; // valor de prueba
            try {
                $row = DB::select('SELECT lookup_sten(?, ?, ?, ?) AS sten', [$gender, $age, $factor, $raw]);
                $testLookup = $row[0]->sten ?? null;
            } catch (\Throwable $e) {
                Log::error('Error calling lookup_sten: '.$e->getMessage());
            }
        }

        // Devolver respuesta temporal con datos de debug
        return response()->json([
            'request_count' => $requestCount,
            'age' => $age,
            'gender' => $gender,
            'lookup_test_factor' => $factor ?? null,
            'lookup_test_raw' => $raw ?? null,
            'lookup_sten_result' => $testLookup,
        ]);
    }
}
