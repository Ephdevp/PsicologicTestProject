<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PersonController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/questionnaire', function () {
    return view('questionnaire');
})->name('questionnaire');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/person', [PersonController::class, 'store'])->name('person.store');
    Route::put('/person/{person}', [PersonController::class, 'update'])->name('person.update');
});

require __DIR__.'/auth.php';
