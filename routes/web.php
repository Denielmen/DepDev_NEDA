<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrainingProfileController;

// User Panel Routes
Route::get('/', function () {
    return view('userPanel.welcomeUser');
});

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


// Admin Panel Routes
Route::get('/admin', function () {
    return view('adminPanel.welcomeAdmin'); 
})->name('admin.dashboard');

Route::get('/admin/training-planUnProg', function () {
    return view('adminPanel.trainingPlanUnProg');
})->name('admin.training-planUnProg');
  