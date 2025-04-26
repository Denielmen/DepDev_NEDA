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

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisteredUserController;

// Public routes (accessible without login)

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::get('/', function () {
    return view('welcome');
});

// Protected routes (require login)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['verified'])->name('dashboard');
     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Add route for training profile
});

require __DIR__.'/auth.php';
