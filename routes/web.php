<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrainingProfileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisteredUserController;


    // Route to view user accounts
    Route::get('/admin/accounts', [App\Http\Controllers\Admin\AccountController::class, 'index'])
        ->name('admin.accounts');

// Public Routes (Accessible Without Login)
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::get('/welcome', function () {
    return view('welcome');
});

// Protected Routes (Require Login)
Route::middleware(['auth'])->group(function () {   // User Panel Routes
    Route::get('/', function () {
        return view('userPanel.welcomeUser');
    })->name('home');

    Route::get('/training-profile/program', [TrainingProfileController::class, 'program'])
        ->name('training.profile.program');

    Route::get('/training-profile/unprogrammed', [TrainingProfileController::class, 'unprogrammed'])
        ->name('training.profile.unprogrammed');

    Route::get('/tracking', function () {
        return view('userPanel.tracking');
    })->name('tracking');

    Route::get('/training-effectiveness', function () {
        return view('userPanel.trainingEffectiveness');
    })->name('training.effectiveness');

    // Admin Panel Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', function () {
            return view('adminPanel.welcomeAdmin');
        })->name('home');

        Route::get('/training-plan', function () {
            return view('adminPanel.trainingPlan');
        })->name('training-plan');

        Route::get('/training-planUnProg', function () {
            return view('adminPanel.trainingPlanUnProg');
        })->name('training-planUnProg');
    });

    // Dashboard and Profile Routes
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['verified'])->name('dashboard');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';