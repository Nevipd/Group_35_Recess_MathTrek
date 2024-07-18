<?php
/*
// use App\Http\Controllers\ProfileController;
// use App\Http\Controllers\SchoolController;
// use App\Http\Controllers\SchoolRepresentativeController;
// use App\Http\Controllers\QuestionController;
// use App\Http\Controllers\ChallengeController;
// use App\Http\Controllers\ReportController;
// use App\Http\Controllers\ParticipantController;
// use App\Http\Controllers\SchoolAuthController;
// use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard'); // pointing to the main dashboard view
// })->middleware(['auth', 'verified'])->name('dashboard');

// // School Representative Routes
// Route::get('/school/dashboard', function () {
//     return view('school.dashboard');
// })->middleware(['auth:school'])->name('school.dashboard');

// Route::get('/school/login', [SchoolAuthController::class, 'showLoginForm'])->name('school.login');
// Route::post('/school/login', [SchoolAuthController::class, 'login']);
// Route::get('/school/register', [SchoolAuthController::class, 'showRegistrationForm'])->name('school.register');
// Route::post('/school/register', [SchoolAuthController::class, 'register']);




// admin routes
// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// other routes
// Route::resource('schools', SchoolController::class);
// Route::resource('questions', QuestionController::class);
// Route::resource('profiles', ProfileController::class);
// Route::resource('challenges', ChallengeController::class);
// Route::resource('reports', ReportController::class);
// Route::resource('participants', ParticipantController::class);

// require __DIR__.'/auth.php';
*/
Route::get('/schools.index', function () {
    return view('schools.index');
})->name('schools.index');

Route::get('/participants.index', function () {
    return view('participants.index');
})->name('participants.index');

Route::get('/challenges.index', function () {
    return view('challenges.index');
})->name('challenges.index');
