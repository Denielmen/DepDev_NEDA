<?php
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrainingProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController; // akon gi add    
use App\Http\Controllers\TrainingTrackingController;
use App\Http\Controllers\TrainingMaterialController;

Route::get('/search', [SearchController::class, 'index'])->name('search.index');
Route::get('/search/export/{format}', [SearchController::class, 'export'])->name('search.export');
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::get('/search/results', [SearchController::class, 'results'])->name('search.results');

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

// Protected Routes (Require Login) to be delete later
Route::middleware(['auth'])->prefix('user')->group(function () {
    Route::get('/', function () {
        if (!auth()->user() || auth()->user()->role !== 'User') {
            abort(403, 'Unauthorized');
        }
        return view('userPanel.welcomeUser');
    })->name('home');

    Route::get('/training-profile/program', [TrainingProfileController::class, 'program'])
        ->name('training.profile.program');

    Route::get('/training-profile/unprogrammed', [TrainingProfileController::class, 'unprogrammed'])
        ->name('training.profile.unprogrammed');

    Route::get('/training-profile/program/{id}', [TrainingProfileController::class, 'show'])
        ->name('training.profile.show');

    Route::get('/training/{id}/effectiveness/participant/{type}', [TrainingProfileController::class, 'effectivenessParticipant'])
        ->name('training.effectiveness.participant');

    Route::get('/tracking', [TrainingTrackingController::class, 'index'])->name('tracking');

    Route::get('/training-effectivenesss', function() {
        return view('userPanel.trainingEffectivenesss');
    })->name('training.effectivenesss');

    Route::get('/training-resources', [TrainingProfileController::class, 'resources'])->name('training.resources');

    Route::get('/evalParticipant', [\App\Http\Controllers\TrainingProfileController::class, 'evalParticipantForm'])->name('evalParticipant');

    Route::get('/evalSupervisor', function() {
        return view('userPanel.evalSupervisor');
    })->name('evalSupervisor');

    Route::get('/training/{id}/export', [TrainingProfileController::class, 'export'])->name('training.export');
    
    Route::get('/training-effectiveness', function () {
        return view('userPanel.trainingEffectiveness');
    })->name('training.effectiveness');

    Route::post('/training/{id}/rate', [TrainingProfileController::class, 'rateParticipant'])
        ->name('training.rate.participant');

    Route::get('/training-resources', [TrainingProfileController::class, 'resources'])
        ->name('training.resources');
        Route::get('/training-materials/{trainingMaterial}/download', [TrainingMaterialController::class, 'download'])->name('training_materials.download');
    });

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/', function () {
        if (!auth()->user() || auth()->user()->role !== 'Admin') {
            abort(403, 'Unauthorized');
        }
        return view('adminPanel.welcomeAdmin');
    })->name('admin.home');

    // Training Plan routes
    Route::get('training-plan', function () {
        $trainings = \App\Models\Training::where('type', 'Program')->get();
        return view('adminPanel.trainingPlan', compact('trainings'));
    })->name('admin.training-plan');

    Route::get('training-plan/unprogrammed', function () {
        $trainings = \App\Models\Training::where('type', 'Unprogrammed')->get();
        return view('adminPanel.trainingPlanUnProg', compact('trainings'));
    })->name('admin.training-plan.unprogrammed');

    Route::get('training-plan/create', [TrainingProfileController::class, 'create'])->name('admin.training-plan.create');

    Route::post('training-plan/store', [TrainingProfileController::class, 'store'])->name('admin.training-plan.store');

    Route::get('/training-plan', [TrainingProfileController::class, 'trainingPlan'])->name('admin.training-plan');
    Route::get('/training-plan/edit', [TrainingProfileController::class, 'edit'])->name('admin.training-plan.edit');
    Route::put('/training-plan/update', [TrainingProfileController::class, 'update'])->name('admin.training-plan.update');
    Route::get('/training-plan/unprogrammed', function () {
        $trainings = \App\Models\Training::where('type', 'Unprogrammed')->get();
        return view('adminPanel.trainingPlanUnProg', compact('trainings'));
    })->name('admin.training-plan.unprogrammed');

    // Add participant route
    Route::post('/training-plan/{training}/add-participant', [TrainingProfileController::class, 'addParticipant'])
        ->name('admin.training-plan.add-participant');
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
    // Delete training route
    Route::delete('/training-plan/{training}', [TrainingProfileController::class, 'destroy'])
        ->name('admin.training-plan.destroy');

    Route::get('training-plan/{id}', function ($id) {
        $training = \App\Models\Training::findOrFail($id);
        return view('adminPanel.trainingView', compact('training'));
    })->name('admin.training.view');

    Route::get('training-plan/unprogrammed/{id}', function ($id) {
        $training = \App\Models\Training::findOrFail($id);
        return view('adminPanel.trainingViewUnprog', compact('training'));
    })->name('admin.training.view.unprogrammed');

    // Participants routes
    Route::get('/participants', [App\Http\Controllers\AdminController::class, 'participants'])->name('admin.participants');

    // Register routes for admin
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('admin.register');
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/participants/{id}', function ($id) {
        $user = \App\Models\User::findOrFail($id);
        // Fetch programmed trainings where the user is a participant
        $programmedTrainings = \App\Models\Training::where('type', 'Program')
            ->whereHas('participants', function ($query) use ($user) {
                $query->where('training_participants.user_id', $user->id);
            })
            // Eager load the participant relationship specifically for this user
            ->with(['participants' => function ($query) use ($user) {
                $query->where('training_participants.user_id', $user->id)->withPivot('participation_type_id');
            }])
            ->get();
        return view('adminPanel.userInfo', compact('user', 'programmedTrainings'));
    })->name('admin.participants.info');

    Route::get('/participants/{id}/unprogrammed', function ($id) {
        $user = \App\Models\User::findOrFail($id);
        $unprogrammedTrainings = \App\Models\Training::where('type', 'Unprogrammed')->get();
        return view('adminPanel.userInfoUnprog', compact('user', 'unprogrammedTrainings'));
    })->name('admin.participants.info.unprogrammed');

    // Reports routes
    // Route::get('/reports', function () {
    //     return view('adminPanel.report');
    // })->name('reports');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('admin.profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('admin.profile.destroy');

    // User status toggle route
    Route::patch('/users/{user}/toggle-status', [App\Http\Controllers\Admin\AccountController::class, 'toggleStatus'])
        ->name('admin.toggleUserStatus');

    // View user info routes
    Route::get('viewUserInfo/{id}', [App\Http\Controllers\AdminController::class, 'viewUserInfo'])->name('admin.viewUserInfo');
    Route::get('viewUserInfoUnprog/{id}', [App\Http\Controllers\AdminController::class, 'viewUserInfoUnprog'])->name('admin.viewUserInfoUnprog');

    // Post-evaluation route
    Route::get('/training/{id}/post-evaluation', [TrainingProfileController::class, 'postEvaluation'])
        ->name('admin.training.post-evaluation');

    // Route to handle saving participant evaluation rating (moved inside admin group)
    Route::post('/training/{id}/rate', [TrainingProfileController::class, 'rateParticipant'])
        ->name('admin.training.rate'); // Renamed to admin.training.rate
});

Route::get('/admin/reports', [AdminController::class, 'reports'])->name('admin.reports');

Route::post('/tracking', [TrainingTrackingController::class, 'store'])->name('tracking.store');

// After (for testing):
    Route::middleware(['auth'])->group(function () {
        // Training Reports Export Routes
        Route::get('/reports/export/pdf', [AdminController::class, 'exportPdf'])->name('admin.reports.export.pdf');
        Route::get('/reports/export/excel', [AdminController::class, 'exportExcel'])->name('admin.reports.export.excel');
    });

require __DIR__.'/auth.php';