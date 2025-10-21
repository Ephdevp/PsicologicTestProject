<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QuestionarieController;
use App\Http\Controllers\TestController;
use App\Models\Question;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return redirect()->route('login');
});

// Language switcher
Route::get('/lang/{locale}', function (Request $request, string $locale) {
    if (in_array($locale, ['en','ru'])) {
        $request->session()->put('locale', $locale);
    }
    return back();
})->name('lang.switch');

Route::middleware(['auth', 'verified'])->controller(QuestionarieController::class)->group(function () {
    Route::get('/questionnaire/{testId}', 'index')->name('questionnaire.index');
});
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard.index');

Route::middleware(['auth', 'verified'])->controller(TestController::class)->group(function () {
    Route::post('/questionnaire/submit', 'questionarieSubmit')->name('test.questionarieSubmit');
    Route::get('/results/{test?}', 'showResults')->name('results.show');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/person', [PersonController::class, 'store'])->name('person.store');
    Route::put('/person/{person}', [PersonController::class, 'update'])->name('person.update');
});

require __DIR__.'/auth.php';

