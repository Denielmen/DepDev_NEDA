<?php
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrainingProfileController;
use App\Http\Controllers\SearchController;

Route::get('/search', [SearchController::class, 'index'])->name('search.index');
Route::get('/search/results', [SearchController::class, 'results'])->name('search.results');
Route::get('/search/export/{format}', [SearchController::class, 'export'])->name('search.export');
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

// Login Routes (if not using Laravel Breeze or Jetstream)
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [LoginController::class, 'login']); // For POST requests
// User Panel Routes
Route::get('/', function () {
    return view('userPanel.welcomeUser');
})->name('home');

Route::get('/training-profile', function() {
    return redirect()->route('training.profile.program');
})->name('training.profile');

Route::get('/training-profile/program', [TrainingProfileController::class, 'program'])
    ->name('training.profile.program');

Route::get('/training-profile/unprogrammed', [TrainingProfileController::class, 'unprogrammed'])
    ->name('training.profile.unprogrammed');

Route::get('/training-profile/program/{id}', [TrainingProfileController::class, 'show'])
    ->name('training.profile.show');

Route::get('/tracking', function() {
    return view('userPanel.tracking');
})->name('tracking');

Route::get('/training-effectivenesss', function() {
    return view('userPanel.trainingEffectivenesss');
})->name('training.effectivenesss');

Route::get('/evalParticipant', function() { 
    return view('userPanel.evalParticipant');
})->name('evalParticipant');

Route::get('/evalSupervisor', function() {
    return view('userPanel.evalSupervisor');
})->name('evalSupervisor');


// Admin Panel Routes
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    // Admin Home
    Route::get('/', function () {
        return view('adminPanel.welcomeAdmin');
    })->name('home');

   

    Route::get('/training-plan/create', function () {
        return view('adminPanel.createTraining');
    })->name('training-plan.create');

    // Training Plan routes
    Route::get('/training-plan', [TrainingProfileController::class, 'trainingPlan'])->name('training-plan');
    Route::get('/training-plan/edit', [TrainingProfileController::class, 'edit'])->name('training-plan.edit');
    Route::put('/training-plan/update', [TrainingProfileController::class, 'update'])->name('training-plan.update');
    Route::get('/training-plan/unprogrammed', function () {
        return view('adminPanel.trainingPlanUnProg');
    })->name('training-plan.unprogrammed');

    // Participants routes
    Route::get('/participants', function () {
        return view('adminPanel.listOfUser');
    })->name('participants');

    Route::get('/participants/{id}', function ($id) {
        return view('adminPanel.userInfo');
    })->name('participants.info');

    Route::get('/participants/{id}/unprogrammed', function ($id) {
        return view('adminPanel.userInfoUnprog');
    })->name('participants.info.unprogrammed');

    // Reports routes
    Route::get('/reports', function () {
        return view('adminPanel.report');
    })->name('reports');
});