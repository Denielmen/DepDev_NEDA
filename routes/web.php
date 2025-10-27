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
//remove lines 48-50 before deployment

//GET /register: shows the registration form.
//POST /register: processes the registration.
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::get('/', function () {
    if (!(Auth::check())) {
        return redirect()->route('login');
    } else {
        $role = Auth::user()->role;
        $redirectUrl = $role === 'Admin' ? route('admin.home') : route('user.home');
        return response("<script>alert('User is already logged in.');window.location.href='{$redirectUrl}';</script>");
    }
});

//Handles the login request.
Route::post('/login', [LoginController::class, 'login']);

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/welcome', function () {
        return view('welcome');
    });
});

// USER PANEL ROUTES (all with user. prefix)
Route::middleware(['auth'])->prefix('user')->group(function () {
    Route::get('/', function () {
        if (!Auth::check() || !Auth::user()->is_active || Auth::user()->role !== 'User') { //Check if the user is disabled or not active
            abort(403, 'Unauthorized');
        }
        return view('userPanel.welcomeUser');
    })->name('user.home');

    Route::get('/training-profile', function () {
        return redirect()->route('user.training.profile.program');
    })->name('user.training.profile');

    Route::get('/training-profile/program', [TrainingProfileController::class, 'program'])
        ->name('user.training.profile.program');

    Route::get('/training-profile/unprogrammed', [TrainingProfileController::class, 'unprogrammed'])
        ->name('user.training.profile.unprogrammed');

    Route::get('/training-profile/program/{training}', [TrainingProfileController::class, 'show'])
        ->name('user.training.profile.show');

    Route::get('/training-profile/unprogrammed/{id}', [TrainingProfileController::class, 'showUnprogrammed'])
        ->name('user.training.profile.unprogram.show');

    Route::get('/training-profile/unprogrammed/{id}/edit', [TrainingProfileController::class, 'editUnprogrammed'])
        ->name('user.training.profile.unprogram.edit');

    Route::put('/training-profile/unprogrammed/{id}', [TrainingProfileController::class, 'updateUnprogrammed'])
        ->name('user.training.profile.unprogram.update');

    Route::get('/training/{id}/effectiveness/participant/{type}', [TrainingProfileController::class, 'effectivenessParticipant'])
        ->name('user.training.effectiveness.participant');

    Route::get('/tracking', [TrainingTrackingController::class, 'index'])
        ->name('user.tracking');

    Route::post('/tracking', [TrainingTrackingController::class, 'store'])
        ->name('user.tracking.store');


    Route::get('user/training-effectiveness', [TrainingProfileController::class, 'effectiveness'])->name('user.training.effectiveness');
    Route::get('user/training-effectiveness-unprogrammed', [TrainingProfileController::class, 'effectivenessUnprogrammed'])->name('user.training.effectiveness.unprogrammed');
    Route::get('/training-resources', [TrainingProfileController::class, 'resources'])
        ->name('user.training.resources');

    Route::get('/evalParticipant/{training_id}', [TrainingProfileController::class, 'evalParticipantForm'])
        ->name('user.evalParticipant');

    Route::get('/evalSupervisor', function () {
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

    // User profile info routes
    Route::get('/profile/info', [TrainingProfileController::class, 'userProfileInfo'])
        ->name('user.profile.info');
    Route::get('/profile/info/unprogrammed', [TrainingProfileController::class, 'userProfileInfoUnprogrammed'])
        ->name('user.profile.info.unprogrammed');
    Route::post('/profile/upload-picture', [TrainingProfileController::class, 'uploadUserProfilePicture'])
        ->name('user.profile.upload-picture');
    Route::put('/profile/update', [TrainingProfileController::class, 'updateUserProfile'])
        ->name('user.profile.update');
});

// ADMIN PANEL ROUTES (with read-only middleware for Admin_ accounts)
Route::middleware(['auth', 'readonly.admin'])->prefix('admin')->group(function () {
    Route::get('/', [App\Http\Controllers\AdminController::class, 'welcomeAdmin'])->name('admin.home');

    // });

    // Route::middleware(['auth'])->prefix('user')->group(function () {
    //     Route::get('/', function () {
    //         if (!Auth::user() || Auth::user()->role !== 'User') {
    //             abort(403, 'Unauthorized');
    //         }
    //         return view('userPanel.welcomeUser');
    //     })->name('user.home');

    // Training Plan routes

    Route::get('training-plan/unprogrammed', [TrainingProfileController::class, 'trainingPlanUnprogrammed'])->name('admin.training-plan.unprogrammed');

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
    Route::get('/training-plan/{training}', [TrainingProfileController::class, 'adminShow'])
        ->name('admin.training-plan.show');

    Route::get('training-plan/{id}', function ($id) {
        $training = \App\Models\Training::with(['participants' => function ($query) {
            $query->withPivot('participation_type_id', 'year');
        }])->findOrFail($id);
        $participationTypes = \App\Models\ParticipationType::all()->keyBy('id');
        return view('adminPanel.TrainingView', compact('training', 'participationTypes'));
    })->name('admin.training.view');

    Route::get('training-plan/unprogrammed/{id}', function ($id) {
        $training = \App\Models\Training::with(['participants' => function ($query) {
            $query->withPivot('participation_type_id', 'year');
        }])->findOrFail($id);
        $participationTypes = \App\Models\ParticipationType::all()->keyBy('id');
        return view('adminPanel.TrainingViewUnprog', compact('training', 'participationTypes'));
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
            ->with([
                'participants' => function ($query) use ($user) {
                    $query->where('training_participants.user_id', $user->id)->withPivot('participation_type_id');
                },
                'competency',
                'evaluations' => function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                }
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(5); // Show 10 trainings per page
        
        // Check if current user is read-only admin
        $isReadOnlyAdmin = \App\Helpers\AdminHelper::isReadOnlyAdmin();
        
        return view('adminPanel.userInfo', compact('user', 'programmedTrainings', 'isReadOnlyAdmin'));
    })->name('admin.participants.info');

    Route::get('/participants/{id}/unprogrammed', function ($id) {
        $user = \App\Models\User::findOrFail($id);
        $unprogrammedTrainings = \App\Models\Training::where('type', 'Unprogrammed')
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhereHas('participants', function ($q) use ($user) {
                        $q->where('users.id', $user->id);
                    });
            })
            ->with(['competency', 'participants'])
            ->orderBy('created_at', 'desc')
            ->paginate(5); // Show 10 trainings per page
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
    Route::delete('/users/{user}/delete', [App\Http\Controllers\Admin\AccountController::class, 'deleteUser'])
        ->name('admin.deleteUser');
    Route::post('/employee/{id}/upload-picture', [App\Http\Controllers\Admin\AccountController::class, 'uploadProfilePicture'])
        ->name('admin.employee.upload-picture');
    Route::get('/training-details/{training_id}/user/{user_id}', [App\Http\Controllers\AdminController::class, 'viewUserInfo'])->name('admin.viewUserInfo');
    Route::get('/training-details/unprogrammed/{training_id}/user/{user_id}', [App\Http\Controllers\AdminController::class, 'viewUserInfoUnprog'])->name('admin.viewUserInfoUnprog');
    Route::post('/fix-certificates', [App\Http\Controllers\AdminController::class, 'fixAllCertificates'])->name('admin.fixCertificates');
    Route::get('/get-participants', [TrainingProfileController::class, 'getParticipants'])->name('admin.getParticipants');
    Route::get('/training/{id}/post-evaluation', [TrainingProfileController::class, 'postEvaluation'])
        ->name('admin.training.post-evaluation');
    Route::get('/training/{id}/post-evaluation/user/{user_id}', [TrainingProfileController::class, 'postEvaluationWithUser'])
        ->name('admin.training.post-evaluation.user');
    Route::post('/training/{id}/rate', [TrainingProfileController::class, 'rateParticipant'])
        ->name('admin.training.rate');
    Route::post('/training/{id}/post-evaluation/submit', [TrainingProfileController::class, 'submitPostEvaluation'])->name('admin.training.post-evaluation.submit');
    Route::post('/training-plan/{training}/add-participant', [TrainingProfileController::class, 'addParticipant'])
        ->name('admin.training-plan.add-participant');

    // Employee profile edit routes
    Route::get('/employee/{id}/edit', [App\Http\Controllers\Admin\EmployeeController::class, 'edit'])->name('admin.employee.edit');
    Route::put('/employee/{id}', [App\Http\Controllers\Admin\EmployeeController::class, 'update'])->name('admin.employee.update');
});

// Admin reports and exports
Route::get('/admin/reports', [AdminController::class, 'reports'])->name('admin.reports');
Route::middleware(['auth'])->group(function () {
    Route::get('/reports/export/pdf', [AdminController::class, 'exportPdf'])->name('admin.reports.export.pdf');
    Route::get('/reports/export/excel', [AdminController::class, 'exportExcel'])->name('admin.reports.export.excel');
});

require __DIR__ . '/auth.php';
