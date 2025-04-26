<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrainingProfileController;

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

Route::get('/admin/training-planUnProg', function () {
    return view('adminPanel.trainingPlanUnProg');
})->name('admin.training-planUnProg');
  