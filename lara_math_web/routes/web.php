<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\SchoolRepresentativeController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\SchoolAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard'); // pointing to the main dashboard view
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/questions/import', [QuestionController::class, 'importForm'])->name('questions.importForm');
    Route::post('/questions/import', [QuestionController::class, 'import'])->name('questions.import');

    Route::resource('schools', SchoolController::class);
    Route::resource('questions', QuestionController::class);
    Route::resource('challenges', ChallengeController::class);
    Route::resource('reports', ReportController::class);
    Route::resource('participants', ParticipantController::class);
    
});

require __DIR__.'/auth.php';
