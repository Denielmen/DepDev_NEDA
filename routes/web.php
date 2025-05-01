<?php
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrainingProfileController;

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

// Login Routes (if not using Laravel Breeze or Jetstream)
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

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

    // Training Plan routes
    Route::get('/training-plan', function () {
        return view('adminPanel.trainingPlan');
    })->name('training-plan');

    Route::get('/training-plan/unprogrammed', function () {
        return view('adminPanel.trainingPlanUnProg');
    })->name('training-plan.unprogrammed');

    Route::get('/training-plan/create', function () {
        return view('adminPanel.createTraining');
    })->name('training-plan.create');

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
  