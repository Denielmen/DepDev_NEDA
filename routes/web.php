<?php
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrainingProfileController;
use App\Http\Controllers\TrainingController;

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
    Route::get('training-plan', function () {
        $trainings = \App\Models\Training::where('type', 'Program')->get();
        return view('adminPanel.trainingPlan', compact('trainings'));
    })->name('training-plan');

    Route::get('training-plan/unprogrammed', function () {
        $trainings = \App\Models\Training::where('type', 'Unprogrammed')->get();
        return view('adminPanel.trainingPlanUnProg', compact('trainings'));
    })->name('training-plan.unprogrammed');

    Route::get('training-plan/create', function () {
        $users = \App\Models\User::all();
        return view('adminPanel.createTraining', compact('users'));
    })->name('training-plan.create');

    Route::get('training-plan/{id}', function ($id) {
        $training = \App\Models\Training::findOrFail($id);
        return view('adminPanel.trainingView', compact('training'));
    })->name('training.view');

    Route::get('training-plan/unprogrammed/{id}', function ($id) {
        $training = \App\Models\Training::findOrFail($id);
        return view('adminPanel.trainingViewUnprog', compact('training'));
    })->name('training.view.unprogrammed');

    

     // Participants routes
    Route::get('/participants', function () {
        $users = \App\Models\User::all();
        return view('adminPanel.listOfUser', compact('users'));
    })->name('participants');

    Route::get('/participants/{id}', function ($id) {
        $user = \App\Models\User::findOrFail($id);
        $programmedTrainings = \App\Models\Training::where('type', 'Program')->get();
        return view('adminPanel.userInfo', compact('user', 'programmedTrainings'));
    })->name('participants.info');

    Route::get('/participants/{id}/unprogrammed', function ($id) {
        $user = \App\Models\User::findOrFail($id);
        $unprogrammedTrainings = \App\Models\Training::where('type', 'Unprogrammed')->get();
        return view('adminPanel.userInfoUnprog', compact('user', 'unprogrammedTrainings'));
    })->name('participants.info.unprogrammed');

    // Reports routes
    Route::get('/reports', function () {
        return view('adminPanel.report');
    })->name('reports');
});
  