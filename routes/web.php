<?php
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrainingProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TrainingTrackingController;
use App\Http\Controllers\TrainingMaterialController;
use Illuminate\Support\Facades\Auth;



Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::get('/', function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }
    // If already logged in, show an error message
    abort(403, 'User is already logged in.');
});
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');
    
    Route::post('/login', [LoginController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    Route::get('/welcome', function () {
        return view('welcome');
    });
});
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/', function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }
    // If already logged in, show an error message
    abort(403, 'User is already logged in.');
});

// USER PANEL ROUTES (all with user. prefix)
Route::middleware(['auth'])->prefix('user')->group(function () {
    Route::get('/', function () {
        if (!auth()->user() || auth()->user()->role !== 'User') {
            abort(403, 'Unauthorized');
        }
        return view('userPanel.welcomeUser');
    })->name('user.home');

    Route::get('/training-profile', function() {
    return redirect()->route('user.training.profile.program');
})->name('user.training.profile');

    Route::get('/training-profile/program', [TrainingProfileController::class, 'program'])
        ->name('user.training.profile.program');

    Route::get('/training-profile/unprogrammed', [TrainingProfileController::class, 'unprogrammed'])
        ->name('user.training.profile.unprogrammed');

    Route::get('/training-profile/program/{id}', [TrainingProfileController::class, 'show'])
        ->name('user.training.profile.show');

    Route::get('/training-profile/unprogrammed/{id}', [TrainingProfileController::class, 'showUnprogrammed'])
        ->name('user.training.profile.unprogram.show');

    Route::get('/training/{id}/effectiveness/participant/{type}', [TrainingProfileController::class, 'effectivenessParticipant'])
        ->name('user.training.effectiveness.participant');

    Route::get('/tracking', [TrainingTrackingController::class, 'index'])
        ->name('user.tracking');

    Route::post('/tracking', [TrainingTrackingController::class, 'store'])
        ->name('user.tracking.store');


Route::get('user/training-effectiveness', [TrainingController::class, 'showTrainingEffectiveness'])->name('user.training.effectiveness');
    Route::get('/training-resources', [TrainingProfileController::class, 'resources'])
        ->name('user.training.resources');

    Route::get('/evalParticipant/{training_id}', [TrainingProfileController::class, 'evalParticipantForm'])
        ->name('user.evalParticipant');

    Route::get('/evalSupervisor', function() {
        return view('userPanel.evalSupervisor');
    })->name('user.evalSupervisor');

    Route::get('/training/{id}/export', [TrainingProfileController::class, 'export'])
        ->name('user.training.export');

    Route::post('/training/{id}/rate', [TrainingProfileController::class, 'rateParticipant'])
        ->name('user.training.rate.participant');

    Route::get('/training-materials/{trainingMaterial}/download', [TrainingMaterialController::class, 'download'])
        ->name('user.training_materials.download');

    // Route for submitting the detailed participant evaluation form
    Route::post('/training/{id}/submit-participant-evaluation', [TrainingProfileController::class, 'submitParticipantEvaluation'])
        ->name('user.training.submit.participant.evaluation');

    // Route for viewing evaluations
    Route::get('/evaluation/view/{training_id}/{type}', [TrainingProfileController::class, 'viewEvaluationData'])
        ->name('user.evaluation.view');
});

// ADMIN PANEL ROUTES (unchanged, but make sure admin checks are in place)
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
    Route::get('/training-plan/{training}/edit', [TrainingProfileController::class, 'edit'])
        ->name('admin.training-plan.edit');
    Route::put('/training-plan/{training}', [TrainingProfileController::class, 'update'])
        ->name('admin.training-plan.update');
    Route::delete('/training-plan/{training}/participant/{user}', [TrainingProfileController::class, 'removeParticipant'])
        ->name('admin.training-plan.remove-participant');
    Route::delete('/training-plan/{training}', [TrainingProfileController::class, 'destroy'])
        ->name('admin.training-plan.destroy');

    Route::get('/training-plan/{training}', [TrainingProfileController::class, 'show'])
        ->name('admin.training-plan.show');

    Route::get('training-plan/{id}', function ($id) {
        $training = \App\Models\Training::findOrFail($id);
        return view('adminPanel.trainingView', compact('training'));
    })->name('admin.training.view');

    Route::get('training-plan/unprogrammed/{id}', function ($id) {
        $training = \App\Models\Training::with(['participants' => function($query) {
            $query->withPivot('participation_type_id', 'year');
        }])->findOrFail($id);
        $participationTypes = \App\Models\ParticipationType::all()->keyBy('id');
        return view('adminPanel.trainingViewUnprog', compact('training', 'participationTypes'));
    })->name('admin.training.view.unprogrammed');

    // Participants routes
    Route::get('/participants', [App\Http\Controllers\AdminController::class, 'participants'])->name('admin.participants');

    // Register routes for admin
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('admin.register');
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/participants/{id}', function ($id) {
        $user = \App\Models\User::findOrFail($id);
        $programmedTrainings = \App\Models\Training::where('type', 'Program')
            ->whereHas('participants', function ($query) use ($user) {
                $query->where('training_participants.user_id', $user->id);
            })
            ->with(['participants' => function ($query) use ($user) {
                $query->where('training_participants.user_id', $user->id)->withPivot('participation_type_id');
            }])
            ->get();
        return view('adminPanel.userInfo', compact('user', 'programmedTrainings'));
    })->name('admin.participants.info');

    Route::get('/participants/{id}/unprogrammed', function ($id) {
        $user = \App\Models\User::findOrFail($id);
        $unprogrammedTrainings = \App\Models\Training::where('type', 'Unprogrammed')
            ->where(function($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->orWhereHas('participants', function($q) use ($user) {
                          $q->where('users.id', $user->id);
                      });
            })
            ->with(['competency', 'participants'])
            ->get();
        return view('adminPanel.userInfoUnprog', compact('user', 'unprogrammedTrainings'));
    })->name('admin.participants.info.unprogrammed');

    //Search routes
    Route::get('/search', [SearchController::class, 'index'])->name('admin.search.index');
    Route::get('/search/export/{format}', [SearchController::class, 'export'])->name('search.export');
    Route::get('/search/results', [SearchController::class, 'results'])->name('admin.search.results');

    // Profile and user management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('admin.profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('admin.profile.destroy');
    Route::patch('/users/{user}/toggle-status', [App\Http\Controllers\Admin\AccountController::class, 'toggleStatus'])
        ->name('admin.toggleUserStatus');
    Route::get('viewUserInfo/{id}', [App\Http\Controllers\AdminController::class, 'viewUserInfo'])->name('admin.viewUserInfo');
    Route::get('viewUserInfoUnprog/{id}', [App\Http\Controllers\AdminController::class, 'viewUserInfoUnprog'])->name('admin.viewUserInfoUnprog');
    Route::get('/training/{id}/post-evaluation', [TrainingProfileController::class, 'postEvaluation'])
        ->name('admin.training.post-evaluation');
    Route::post('/training/{id}/rate', [TrainingProfileController::class, 'rateParticipant'])
        ->name('admin.training.rate');
    Route::post('/training/{id}/post-evaluation/submit', [TrainingProfileController::class, 'submitPostEvaluation'])->name('admin.training.post-evaluation.submit');
    Route::post('/training-plan/{training}/add-participant', [TrainingProfileController::class, 'addParticipant'])
        ->name('admin.training-plan.add-participant');
});

// Admin reports and exports
Route::get('/admin/reports', [AdminController::class, 'reports'])->name('admin.reports');
Route::middleware(['auth'])->group(function () {
    Route::get('/reports/export/pdf', [AdminController::class, 'exportPdf'])->name('admin.reports.export.pdf');
    Route::get('/reports/export/excel', [AdminController::class, 'exportExcel'])->name('admin.reports.export.excel');
});

require __DIR__.'/auth.php';



