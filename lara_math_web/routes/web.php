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
use App\Models\ActivityLog;

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

    // report handling routes
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::post('/reports/send-to-all', [ReportController::class, 'sendReportToAll'])->name('reports.sendToAll');
    Route::get('/reports/manual-email', [ReportController::class, 'showManualEmailForm'])->name('reports.manualEmailForm');
    Route::post('/reports/send-to-email', [ReportController::class, 'sendReportToEmail'])->name('reports.sendReportToEmail');
    
    // school handling routes
    Route::post('/schools/{school}/send-email', [SchoolController::class, 'sendEmail'])->name('schools.send-email');

    // general controller routes
    Route::resource('schools', SchoolController::class);
    Route::resource('questions', QuestionController::class);
    Route::resource('challenges', ChallengeController::class);
    Route::resource('reports', ReportController::class);
    Route::resource('participants', ParticipantController::class);
    
});

//test email route
// Route::get('/send-test-email', function () {
//     $details = [
//         'title' => 'Test Email from Laravel',
//         'body' => 'This is a test email sent from a Laravel application.'
//     ];

//     \Mail::to('recipient@example.com')->send(new \App\Mail\TestEmail($details));

//     return 'Email sent';
// });

require __DIR__.'/auth.php';
