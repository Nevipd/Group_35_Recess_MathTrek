<?php

use App\Http\Controllers\ProfileController;
/**adding generated controllers */
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/** adding routes for the new controllers */
Route::resource('schools', SchoolController::class);
Route::resource('questions', QuestionController::class);
Route::resource('challenges', ChallengeController::class);
Route::resource('reports', ReportController::class);

require __DIR__.'/auth.php';
