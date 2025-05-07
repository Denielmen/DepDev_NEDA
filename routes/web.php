<?php
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrainingProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\ProfileController;

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

    Route::get('/training/{id}/export', [TrainingProfileController::class, 'export'])->name('training.export');
    
    Route::get('/training-effectiveness', function () {
        return view('userPanel.trainingEffectiveness');
    })->name('training.effectiveness');

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

        Route::post('training-plan/store', [TrainingProfileController::class, 'store'])->name('training-plan.store');

        Route::get('/training-plan', [TrainingProfileController::class, 'trainingPlan'])->name('training-plan');
        Route::get('/training-plan/edit', [TrainingProfileController::class, 'edit'])->name('training-plan.edit');
        Route::put('/training-plan/update', [TrainingProfileController::class, 'update'])->name('training-plan.update');
        Route::get('/training-plan/unprogrammed', function () {
            $trainings = \App\Models\Training::where('type', 'Unprogrammed')->get();
            return view('adminPanel.trainingPlanUnProg', compact('trainings'));
        })->name('training-plan.unprogrammed');

        // Add participant route
        Route::post('/training-plan/{training}/add-participant', [TrainingProfileController::class, 'addParticipant'])
            ->name('training-plan.add-participant');
        Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
        Route::post('/register', [RegisteredUserController::class, 'store']);
        // Delete training route
        Route::delete('/training-plan/{training}', [TrainingProfileController::class, 'destroy'])
            ->name('training-plan.destroy');

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

        // Add register route for admin
        Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
        Route::post('/register', [RegisteredUserController::class, 'store']);

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
            $trainings = \App\Models\Training::where('type', 'Program')
                ->orderBy('core_competency')
                ->get()
                ->groupBy('core_competency');
            return view('adminPanel.report', compact('trainings'));
        })->name('reports');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // User status toggle route
        Route::patch('/users/{user}/toggle-status', [App\Http\Controllers\Admin\AccountController::class, 'toggleStatus'])
            ->name('toggleUserStatus');
    });
});

require __DIR__.'/auth.php';