<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TestSessionController;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [TestController::class, 'index'])->name('dashboard');
    
    // Test routes
    Route::get('/tests/{test}', [TestController::class, 'show'])->name('test.show');
    Route::post('/tests/{test}/start', [TestSessionController::class, 'start'])->name('test.start');
    Route::get('/tests/{test}/result', [TestSessionController::class, 'result'])->name('test.result');
    
    // Test session routes
    Route::get('/session/{sessionToken}', [TestSessionController::class, 'take'])->name('test-session.take');
    Route::post('/session/{sessionToken}/answer', [TestSessionController::class, 'saveAnswer'])->name('test-session.answer');
});

// Admin routes
Route::middleware(['auth', 'role:admin,super_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/results', [AdminController::class, 'results'])->name('results');
    Route::get('/sessions/{session}', [AdminController::class, 'sessionDetails'])->name('session.details');
});

// Legacy route for existing view
Route::get('/questionnaire', function () {
    return view('questionnaire');
})->name('questionnaire');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
