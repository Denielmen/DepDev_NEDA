<?php
use App\Http\Controllers\Auth\RegisteredUserController;
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

Route::get('/tracking', function() {
    return view('userPanel.tracking');
})->name('tracking');

Route::get('/training-effectiveness', function() {
    return view('userPanel.trainingEffectiveness');
})->name('training.effectiveness');

// Admin Panel Routes
Route::prefix('admin')->name('admin.')->group(function () {
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

    // Reports routes
    Route::get('/reports', function () {
        return view('adminPanel.report');
    })->name('reports');
});
  