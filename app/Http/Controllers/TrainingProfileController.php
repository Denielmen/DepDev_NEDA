<?php

namespace App\Http\Controllers;

use App\Models\Competency;
use App\Models\ParticipationType;
use App\Models\Training;
use App\Models\TrainingMaterial;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TrainingProfileController extends Controller
{
    public function program(Request $request)
    {
        $competencies = Competency::orderBy('name')->paginate(30); // <-- Add pagination here
        $userId = Auth::id();
        $search = $request->input('search');
        $sort = $request->input('sort');
        $order = $request->input('order', 'asc');

        $trainingsQuery = Training::where('type', 'Program')
            ->whereHas('participants', function ($q) use ($userId) {
                $q->where('users.id', $userId);
            })
            ->when($search, function ($q) use ($search) {
                $q->where(function ($q2) use ($search) {
                    $q2->where('title', 'like', "%$search%")
                        ->orWhere('core_competency', 'like', "%$search%");
                    if (preg_match('/^\\d{4}$/', $search)) {
                        $year = (int) $search;
                        $q2->orWhere(function ($q3) use ($year) {
                            $q3->whereNotNull('implementation_date_from')
                                ->whereNotNull('implementation_date_to')
                                ->whereYear('implementation_date_from', '<=', $year)
                                ->whereYear('implementation_date_to', '>=', $year);
                        })
                            ->orWhere(function ($q3) use ($year) {
                                $q3->whereNotNull('period_from')
                                    ->whereNotNull('period_to')
                                    ->where('period_from', '<=', $year)
                                    ->where('period_to', '>=', $year);
                            });
                    } else {
                        $q2->orWhere('implementation_date_from', 'like', "%$search%")
                            ->orWhere('implementation_date_to', 'like', "%$search%")
                            ->orWhere('period_from', 'like', "%$search%")
                            ->orWhere('period_to', 'like', "%$search%");
                    }
                });
            })
            ->with([
                'participants' => function ($query) use ($userId) {
                    $query->where('users.id', $userId);
                },
                'competency',
                'evaluations' => function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                },
            ]);

        // Sorting logic
        if ($sort === 'title') {
            $trainingsQuery->orderBy('title', $order);
        } elseif ($sort === 'created_at') {
            $trainingsQuery->orderBy('created_at', $order);
        } elseif ($sort === 'status') {
            // Implemented first = asc, Not Yet Implemented first = desc
            $trainingsQuery->orderByRaw("CASE WHEN status = 'Implemented' THEN 0 ELSE 1 END $order");
        } else {
            // Default: status, then title
            $trainingsQuery->orderByRaw("CASE WHEN status = 'Pending' THEN 0 ELSE 1 END")
                ->orderBy('status');
        }

        $trainings = $trainingsQuery->paginate(30);
        $participationTypes = ParticipationType::all()->keyBy('id');

        return view('userPanel.trainingProfileProgram', compact('trainings', 'competencies', 'participationTypes'));
    }

    public function unprogrammed(Request $request)
    {
        $userId = Auth::id();
        $search = $request->input('search');
        $sort = $request->input('sort');
        $order = $request->input('order', 'asc');

        $trainingsQuery = Training::where('type', 'Unprogrammed')
            ->where(function ($query) use ($userId) {
                $query->where('user_id', $userId)
                    ->orWhereHas('participants', function ($q) use ($userId) {
                        $q->where('users.id', $userId);
                    });
            })
            ->when($search, function ($q) use ($search) {
                $q->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%$search%")
                        ->orWhereHas('competency', function ($subQ) use ($search) {
                            $subQ->where('name', 'like', "%$search%");
                        });
                });
            })
            ->with(['participants' => function ($query) use ($userId) {
                $query->where('users.id', $userId);
            }]);

        // Sorting logic
        if ($sort === 'title') {
            $trainingsQuery->orderBy('title', $order);
        } elseif ($sort === 'created_at') {
            $trainingsQuery->orderBy('created_at', $order);
        } elseif ($sort === 'status') {
            $trainingsQuery->orderByRaw("CASE WHEN status = 'Implemented' THEN 0 ELSE 1 END $order");
        } else {
            $trainingsQuery->orderBy('created_at', 'desc');
        }

        $trainings = $trainingsQuery->paginate(30);
        $participationTypes = ParticipationType::all()->keyBy('id');

        return view('userPanel.trainingProfileUnProgram', compact('trainings', 'participationTypes'));
    }

    public function show(Training $training)
    {
        $userId = Auth::id();

        // Check if the user is a participant in this training
        if (! $training->participants()->where('users.id', $userId)->exists()) {
            abort(403, 'You are not authorized to view this training.');
        }

        // Force a fresh reload of the participants relationship
        $training->refresh();

        // Eager load the participants relationship with their pivot data
        $training->load(['participants' => function ($query) {
            $query->orderBy('last_name')->orderBy('first_name');
        }, 'competency']);

        // Get or create evaluation record for this training-user combination
        $evaluation = \App\Models\TrainingEvaluation::getOrCreate($training->id, $userId);

        // Get participation types for display
        $participationTypes = ParticipationType::all()->keyBy('id');

        return view('userPanel.trainingProfileShow', compact('training', 'participationTypes', 'evaluation'));
    }

    public function adminShow(Training $training)
    {
        // Force a fresh reload of the participants relationship
        $training->refresh();

        // Eager load the participants relationship with their pivot data
        $training->load(['participants' => function ($query) {
            $query->withPivot('participation_type_id', 'year')
                ->orderBy('last_name')->orderBy('first_name');
        }, 'competency']);

        // Get participation types for display
        $participationTypes = ParticipationType::all()->keyBy('id');

        return view('adminPanel.TrainingView', compact('training', 'participationTypes'));
    }

    public function showUnprogrammed($id)
    {
        $training = Training::where('type', 'Unprogrammed')->findOrFail($id);

        return view('userPanel.trainingProfileUnprogramShow', compact('training'));
    }

    public function editUnprogrammed($id)
    {
        $training = Training::where('type', 'Unprogrammed')->findOrFail($id);
        // Ensure only owner can edit
        if (Auth::id() !== $training->user_id) {
            abort(403, 'You are not authorized to edit this training.');
        }
        $competencies = Competency::orderBy('name')->get();
        $participationTypes = ParticipationType::all();

        return view('userPanel.trainingProfileUnprogramEdit', compact('training', 'competencies', 'participationTypes'));
    }

    public function updateUnprogrammed(Request $request, $id)
    {
        $training = Training::where('type', 'Unprogrammed')->findOrFail($id);
        if (Auth::id() !== $training->user_id) {
            abort(403, 'You are not authorized to update this training.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'competency_id' => 'required',
            'competency_input' => 'required_if:competency_id,others|nullable|string|max:255',
            'no_of_hours' => 'nullable|numeric',
            'provider' => 'nullable|string|max:255',
            'implementation_date_from' => 'nullable|date',
            'implementation_date_to' => 'nullable|date|after_or_equal:implementation_date_from',
            'participation_type_id' => 'nullable|exists:participation_types,id',
        ]);

        // Handle custom competency
        $competencyId = $validated['competency_id'];
        if ($competencyId === 'others') {
            $existingCompetency = Competency::where('name', $validated['competency_input'])->first();
            $competencyId = $existingCompetency?->id ?? Competency::create([
                'name' => $validated['competency_input'],
                'description' => 'Custom competency created by user',
            ])->id;
        }

        $training->update([
            'title' => $validated['title'],
            'competency_id' => $competencyId,
            'no_of_hours' => $validated['no_of_hours'] ?? $training->no_of_hours,
            'provider' => $validated['provider'] ?? $training->provider,
            'implementation_date_from' => $validated['implementation_date_from'] ?? $training->implementation_date_from,
            'implementation_date_to' => $validated['implementation_date_to'] ?? $training->implementation_date_to,
            'status' => 'Implemented',
        ]);

        // Update current user's participation type if provided
        if (! empty($validated['participation_type_id'])) {
            $training->participants()->updateExistingPivot(Auth::id(), [
                'participation_type_id' => $validated['participation_type_id'],
            ]);
        }

        // Save uploaded materials
        if ($request->hasFile('uploadMaterials')) {
            foreach ($request->file('uploadMaterials') as $file) {
                $filePath = $file->store('uploads', [
                    'disk' => 'public',
                    'visibility' => 'public',
                ]);
                \App\Models\TrainingMaterial::create([
                    'title' => $training->title,
                    'competency_id' => $training->competency_id,
                    'user_id' => Auth::id(),
                    'source' => Auth::user()->first_name.' '.Auth::user()->last_name,
                    'file_path' => $filePath,
                    'link' => null,
                    'type' => 'material',
                    'training_id' => $training->id,
                ]);
            }
        }

        // Save link material
        if ($request->filled('linkMaterials')) {
            // First, check if a link with the same URL already exists for this training
            $existingLink = \App\Models\TrainingMaterial::where('training_id', $training->id)
                ->where('type', 'link')
                ->where('link', $request->linkMaterials)
                ->first();
                
            if (!$existingLink) {
                \App\Models\TrainingMaterial::create([
                    'title' => $training->title . ' - Link',
                    'competency_id' => $training->competency_id,
                    'user_id' => Auth::id(),
                    'source' => Auth::user()->first_name.' '.Auth::user()->last_name,
                    'file_path' => null,
                    'link' => $request->linkMaterials,
                    'type' => 'link',
                    'training_id' => $training->id,
                ]);
            }
        }

        // Save uploaded certificates
        if ($request->hasFile('uploadCertificates')) {
            // First, ensure the certificates directory exists and is writable
            $certificatePath = storage_path('app/public/certificates');
            if (!file_exists($certificatePath)) {
                mkdir($certificatePath, 0755, true);
            }

            foreach ($request->file('uploadCertificates') as $file) {
                if ($file->isValid()) {
                    $originalName = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $filename = 'certificate_' . time() . '_' . uniqid() . '.' . $extension;
                    
                    // Store the file in the public disk under certificates directory
                    $storedPath = $file->storeAs('certificates', $filename, 'public');
                    
                    if ($storedPath) {
                        // Create a more descriptive title with original filename
                        $title = $training->title . ' Certificate - ' . $originalName;
                        
                        // Create the certificate record
                        \App\Models\TrainingMaterial::create([
                            'title' => $title,
                            'competency_id' => $training->competency_id,
                            'user_id' => Auth::id(),
                            'source' => Auth::user()->first_name.' '.Auth::user()->last_name,
                            'file_path' => $storedPath,
                            'link' => null,
                            'type' => 'certificate',
                            'training_id' => $training->id,
                        ]);
                    }
                } else {
                    // Log error if file upload fails
                    \Log::error('File upload failed', [
                        'file' => $file->getClientOriginalName(),
                        'error' => $file->getError(),
                        'message' => $file->getErrorMessage()
                    ]);
                }
            }
        }

        return redirect()->route('user.training.resources')
            ->with('success', 'Training updated successfully.');
    }

    public function edit(Training $training)
    {
        $training = Training::findOrFail($training->id);
        $competencies = Competency::orderBy('name')->get();
        $participationTypes = ParticipationType::all()->keyBy('id');
        $users = User::where('is_active', true)->orderBy('last_name')->paginate(30);

        $training->load(['participants' => function ($query) {
            $query->withPivot('participation_type_id', 'year');
        }]);

        return view('adminPanel.editTraining', compact('training', 'competencies', 'participationTypes', 'users'));
    }

    public function update(Request $request, Training $training)
    {

        try {
            // $training = Training::findOrFail($id);

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'competency_id' => 'required',
                'competency_input' => 'required_if:competency_id,others|nullable|string|max:255',
                'core_competency' => 'required|string|in:Foundational/Mandatory,Competency Enhancement,Leadership/Executive Development,Gender and Development (GAD)-Related,Others',
                'period_from' => 'required|integer|digits:4',
                'period_to' => 'required|integer|digits:4|gte:period_from',
                'implementation_date_from' => 'nullable|date',
                'implementation_date_to' => 'nullable|date',
                'no_of_hours' => 'nullable|numeric',
                'budget' => 'nullable|numeric',
                'provider' => 'nullable|string|max:255',
                'dev_target' => 'nullable|string',
                'performance_goal' => 'nullable|string',
                'objective' => 'nullable|string',
                'type' => 'required|in:Program,Unprogrammed',
                'participants' => 'nullable|array',
                'participants.*' => 'exists:users,id',
                'participation_types' => 'nullable|array',
                'participation_types.*' => 'exists:participation_types,id',
                'participant_years' => 'nullable|array',
                'participant_years.*' => 'integer|min:2000|max:2100',
                // adjust as needed
            ]);

            // Handle custom competency
            if ($validated['competency_id'] === 'others') {
                // Check if competency already exists
                $existingCompetency = Competency::where('name', $validated['competency_input'])->first();

                if ($existingCompetency) {
                    $competencyId = $existingCompetency->id;
                } else {
                    // Create new competency
                    $newCompetency = Competency::create([
                        'name' => $validated['competency_input'],
                        'description' => 'Custom competency created by user',
                    ]);
                    $competencyId = $newCompetency->id;
                }
                $validated['competency_id'] = $competencyId;
            }

            // Additional validation for participants and participation types
            if ($request->has('participants') && ! empty($request->participants)) {
                $participationTypes = $request->input('participation_types', []);
                $participantYears = $request->input('participant_years', []);

                foreach ($request->participants as $participantId) {
                    // Find matching user_year keys for this participant
                    $hasValidType = false;
                    $hasValidYear = false;

                    foreach ($participationTypes as $key => $typeId) {
                        if (strpos($key, $participantId.'_') === 0) {
                            if (ParticipationType::find($typeId)) {
                                $hasValidType = true;
                            }

                            $year = $participantYears[$key] ?? null;
                            if ($year !== null && $year >= 2000 && $year <= 2100) {
                                $hasValidYear = true;
                            }
                        }
                    }

                    if (! $hasValidType) {
                        return back()->withInput()->withErrors(['participants' => 'All participants must have a valid participation type.']);
                    }

                    if (! $hasValidYear) {
                        return back()->withInput()->withErrors(['participants' => 'All participants must have a valid year (between 2000 and 2100).']);
                    }
                }
            }

            // Update training details
            $training->update($validated);

            // Handle participants
            if ($request->has('participants')) {
                // First, detach all existing participants
                $training->participants()->detach();

                // Handle participants with user_year keys to support multiple entries for same user
                $participationTypes = $request->input('participation_types', []);
                $participantYears = $request->input('participant_years', []);

                // Process each unique user_year combination
                foreach ($participationTypes as $userYearKey => $participationTypeId) {
                    if ($participationTypeId && isset($participantYears[$userYearKey])) {
                        // Extract user ID and year from the key (format: userId_year)
                        $parts = explode('_', $userYearKey);
                        if (count($parts) === 2) {
                            $userId = $parts[0];
                            $year = $participantYears[$userYearKey];

                            // Attach the participant
                            $training->participants()->attach($userId, [
                                'participation_type_id' => $participationTypeId,
                                'year' => $year,
                            ]);
                        }
                    }
                }
            } else {
                // If no participants were selected, detach all
                $training->participants()->detach();
            }

            return redirect()->route('admin.training.view', $training->id)->with('success', 'Training updated successfully.');
        } catch (\Exception $e) {
            Log::error('Training update error: '.$e->getMessage());

            return back()->withInput()->withErrors(['error' => 'Failed to update training: '.$e->getMessage()]);
        }
    }

    public function trainingPlan(Request $request)
    {
        $query = Training::with(['participants', 'competency'])
            ->where('type', 'Program');

        // Apply search filter
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                  ->orWhereHas('competency', function($comp) use ($searchTerm) {
                      $comp->where('name', 'LIKE', "%{$searchTerm}%");
                  });
            });
        }

        $trainings = $query->orderBy('created_at', 'desc')
            ->paginate(30);// Show 30 trainings per page

        // Check if current user is read-only admin
        $isReadOnlyAdmin = \App\Helpers\AdminHelper::isReadOnlyAdmin();
        
        return view('adminPanel.trainingPlan', compact('trainings', 'isReadOnlyAdmin'));
        $trainings = Training::with('participants')
            ->where('type', 'Program')
            ->orderBy('created_at', 'desc')
            ->paginate(30); // Show 30 trainings per page

        return view('adminPanel.trainingPlan', compact('trainings'));
    }

    public function trainingPlanUnprogrammed(Request $request)
    {
        $query = Training::with(['participants', 'competency'])
            ->where('type', 'Unprogrammed');

        // Apply search filter
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                  ->orWhereHas('competency', function($comp) use ($searchTerm) {
                      $comp->where('name', 'LIKE', "%{$searchTerm}%");
                  });
            });
        }

        $trainings = $query->orderBy('created_at', 'desc')
            ->paginate(30); // Show 30 trainings per page

        // Check if current user is read-only admin
        $isReadOnlyAdmin = \App\Helpers\AdminHelper::isReadOnlyAdmin();
        
        return view('adminPanel.trainingPlanUnProg', compact('trainings', 'isReadOnlyAdmin'));

        return view('adminPanel.trainingPlanUnProg', compact('trainings'));
    }

    public function create()
    {
        $competencies = Competency::orderBy('name')->get();
        $users = User::where('is_active', true)->orderBy('last_name')->paginate(30);
        $participationTypes = ParticipationType::all()->keyBy('id');

        return view('adminPanel.createTraining', compact('competencies', 'users', 'participationTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'competency_id' => 'required',
            'competency_input' => 'required_if:competency_id,others|nullable|string|max:255',
            'core_competency' => 'required|string|in:Foundational/Mandatory,Competency Enhancement,Leadership/Executive Development,Gender and Development (GAD)-Related,Others',
            'core_competency_input' => 'required_if:core_competency,Others|nullable|string|max:255',
            'period_from' => 'required|integer|digits:4',
            'period_to' => 'required|integer|digits:4|gte:period_from',
            'implementation_date_from' => 'nullable|date',
            'implementation_date_to' => 'nullable|date',
            'no_of_hours' => 'nullable|numeric',
            'budget' => 'nullable|numeric',
            'provider' => 'nullable|string|max:255',
            'dev_target' => 'nullable|string',
            'performance_goal' => 'nullable|string',
            'objective' => 'nullable|string',
            'type' => 'required|in:Program,Unprogrammed',
            'participants' => 'required|array|min:1',
            'participants.*' => 'exists:users,id',
            'participation_types' => 'required|array',
            'participant_years' => 'required|array',
        ]);

        // Handle custom competency
        if ($validated['competency_id'] === 'others') {
            // Check if competency already exists
            $existingCompetency = Competency::where('name', $validated['competency_input'])->first();

            if ($existingCompetency) {
                $competencyId = $existingCompetency->id;
            } else {
                // Create new competency
                $newCompetency = Competency::create([
                    'name' => $validated['competency_input'],
                    'description' => 'Custom competency created by user',
                ]);
                $competencyId = $newCompetency->id;
            }
        } else {
            $competencyId = $validated['competency_id'];
        }

        foreach ($validated['participants'] as $participantId) {
            if (
                ! isset($validated['participation_types'][$participantId]) ||
                ! ParticipationType::find($validated['participation_types'][$participantId])
            ) {
                return back()->withInput()->withErrors(['participants' => 'All participants must have a valid participation type.']);
            }
        }

        DB::beginTransaction();
        try {
            $training = Training::create([
                'title' => $validated['title'],
                'competency_id' => $competencyId,
                'core_competency' => $validated['core_competency'] === 'Others' ? $validated['core_competency_input'] : $validated['core_competency'],
                'period_from' => $validated['period_from'],
                'period_to' => $validated['period_to'],
                'implementation_date_from' => null,
                'implementation_date_to' => $validated['implementation_date_to'] ?? null,
                'no_of_hours' => $validated['no_of_hours'] ?? null,
                'budget' => $validated['budget'] ?? null,
                'provider' => $validated['provider'] ?? null,
                'dev_target' => $validated['dev_target'] ?? null,
                'performance_goal' => $validated['performance_goal'] ?? null,
                'objective' => $validated['objective'] ?? null,
                'type' => $validated['type'],
                'status' => 'Not Yet Implemented',
            ]);

            foreach ($validated['participants'] as $participantId) {
                $training->participants()->attach($participantId, [
                    'year' => $validated['participant_years'][$participantId] ?? $validated['period_from'],
                    'participation_type_id' => $validated['participation_types'][$participantId],
                ]);
            }

            DB::commit();

            return redirect()->route('admin.training-plan')->with('success', 'Training created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()->withErrors(['error' => 'Failed to create training: '.$e->getMessage()]);
        }
    }

    public function getParticipants(Request $request)
    {
        $search = $request->get('search', '');
        $page = $request->get('page', 1);
        $all = $request->get('all', false);
        $trainingId = $request->get('training_id', null);

        $query = User::where('is_active', true)->orderBy('last_name');

        // Don't exclude users - allow same user to be added with different years
        // The duplicate prevention will be handled in the frontend

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('last_name', 'like', "%{$search}%")
                    ->orWhere('first_name', 'like', "%{$search}%")
                    ->orWhere('position', 'like', "%{$search}%")
                    ->orWhere('division', 'like', "%{$search}%");
            });
        }

        if ($all) {
            // Return all users without pagination for "Select All" functionality
            $users = $query->get();
            $participationTypes = ParticipationType::all();

            return response()->json([
                'users' => $users,
                'participation_types' => $participationTypes,
            ]);
        }

        $users = $query->paginate(30, ['*'], 'page', $page);
        $participationTypes = ParticipationType::all();

        return response()->json([
            'users' => $users->items(),
            'pagination' => [
                'current_page' => $users->currentPage(),
                'last_page' => $users->lastPage(),
                'per_page' => $users->perPage(),
                'total' => $users->total(),
                'from' => $users->firstItem(),
                'to' => $users->lastItem(),
            ],
            'participation_types' => $participationTypes,
        ]);
    }

    public function addParticipant(Training $training, Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'participation_type_id' => 'required|exists:participation_types,id',
            'year' => 'required|integer|digits:4',
        ]);

        // Check if user is already a participant for the given year
        if ($training->participants()->where('user_id', $request->user_id)->wherePivot('year', $request->year)->exists()) {
            return back()->with('error', 'User is already a participant in this training for the specified year.');
        }

        // Add the participant with participation type and year
        $training->participants()->attach($request->user_id, [
            'participation_type_id' => $request->participation_type_id,
            'year' => $request->year,
        ]);

        return back()->with('success', 'Participant added successfully.');
    }

    public function removeParticipant(Training $training, Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|exists:users,id',
            ]);

            DB::beginTransaction();

            $training->participants()->detach($request->user_id);

            DB::commit();

            return back()->with('success', 'Participant removed successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Remove participant error: '.$e->getMessage());

            return back()->withErrors(['error' => 'Failed to remove participant: '.$e->getMessage()]);
        }
    }

    public function destroy(Training $training)
    {
        // First detach all participants to avoid foreign key constraint issues
        $training->participants()->detach();

        // Then delete the training
        $training->delete();

        return redirect()->route('admin.training-plan')
            ->with('success', 'Training deleted successfully.');
    }

    public function rateParticipant(Request $request, $id)
    {
        Log::info('Rate Participant Request Received', $request->all());

        $request->validate([
            'type' => 'required|in:participant_pre,participant_post,supervisor_pre,supervisor_post',
            'rating' => 'required|integer|min:1|max:4',
            'user_id' => 'nullable|integer|exists:users,id',
        ]);

        $training = Training::findOrFail($id);
        $user = Auth::user();

        // Determine which user's evaluation we're updating
        $target_user_id = $request->user_id ?? $user->id;

        $isSupervisorAction = in_array($request->type, ['supervisor_pre', 'supervisor_post']);
        $isParticipantAction = in_array($request->type, ['participant_pre', 'participant_post']);

        // Check for supervisor actions: user must have admin role
        if ($isSupervisorAction && $user->role !== 'Admin') {
            return response()->json(['success' => false, 'message' => 'You are not authorized to perform supervisor ratings.'], 403);
        }

        // Check for participant actions: user must be a participant or admin
        if ($isParticipantAction && $user->role !== 'Admin' && ! $training->participants()->where('users.id', $user->id)->exists()) {
            return response()->json(['success' => false, 'message' => 'You are not authorized to rate this training.'], 403);
        }

        // Get or create evaluation record for this training-user combination
        $evaluation = \App\Models\TrainingEvaluation::getOrCreate($id, $target_user_id);

        if ($request->type === 'participant_pre') {
            $evaluation->participant_pre_rating = $request->rating;
            Log::info("Updating participant_pre_rating for training {$id}, user {$target_user_id} to {$request->rating}");
        } elseif ($request->type === 'participant_post') {
            $evaluation->participant_post_rating = $request->rating;
            Log::info("Updating participant_post_rating for training {$id}, user {$target_user_id} to {$request->rating}");
        } elseif ($request->type === 'supervisor_pre') {
            $evaluation->supervisor_pre_rating = $request->rating;
            Log::info("Updating supervisor_pre_rating for training {$id}, user {$target_user_id} to {$request->rating}");
        } elseif ($request->type === 'supervisor_post') {
            $evaluation->supervisor_post_rating = $request->rating;
            Log::info("Updating supervisor_post_rating for training {$id}, user {$target_user_id} to {$request->rating}");
        }

        try {
            $evaluation->save();
            Log::info("Evaluation for training {$id}, user {$target_user_id} saved successfully.");

            return response()->json([
                'success' => true,
                'message' => 'Evaluation stored successfully!',
                'pre_rating' => $evaluation->participant_pre_rating,
                'post_rating' => $evaluation->participant_post_rating,
                'supervisor_pre_rating' => $evaluation->supervisor_pre_rating,
                'supervisor_post_rating' => $evaluation->supervisor_post_rating,
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to save evaluation for training {$id}, user {$target_user_id}: ".$e->getMessage());

            return response()->json(['success' => false, 'message' => 'Failed to save evaluation.'], 500);
        }
    }

    public function resources(Request $request)
    {
        $userId = Auth::id();
        $tab = $request->input('tab', 'materials');
        
        // Base query for trainings with materials/links/certificates
        $query = Training::query();
        
        // Filter based on the active tab
        $query->whereHas('materials', function($q) use ($userId, $tab) {
            if ($tab === 'materials') {
                $q->where('type', 'material')->whereNotNull('file_path');
            } elseif ($tab === 'links') {
                $q->where('type', 'material')->whereNotNull('link');
            } else { // certificates
                $q->where('type', 'certificate')->where('user_id', $userId);
            }
        });

        // Apply search filter if present
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhereHas('materials', function($q) use ($search) {
                      $q->where('title', 'like', "%$search%")
                        ->orWhere('source', 'like', "%$search%");
                  });
            });
        }

        // Apply sorting
        $sort = $request->input('sort', 'created_at');
        $order = $request->input('order', 'desc');
        $query->orderBy($sort, $order);

        // Get paginated trainings
        $trainings = $query->paginate(10);

        // Load only the needed relationships based on the active tab
        $trainings->load(['materials' => function($q) use ($userId, $tab) {
            if ($tab === 'materials') {
                $q->where('type', 'material')->whereNotNull('file_path');
            } elseif ($tab === 'links') {
                $q->where('type', 'material')->whereNotNull('link');
            } else { // certificates
                $q->where('type', 'certificate')->where('user_id', $userId);
            }
        }]);

        // Prepare the data for the view with proper filtering
        $groupedTrainings = [];
        foreach ($trainings as $training) {
            $materials = $training->materials->filter(function($item) use ($tab) {
                return $tab === 'materials' && $item->type === 'material' && $item->file_path;
            });
            
            $links = $training->materials->filter(function($item) use ($tab) {
                return $tab === 'links' && $item->type === 'link' && $item->link;
            });
            
            $certificates = $training->materials->filter(function($item) use ($tab, $userId) {
                return $tab === 'certificates' && $item->type === 'certificate' && $item->user_id == $userId;
            });
            
            // Only add to results if there are items for the current tab
            if (($tab === 'materials' && $materials->isNotEmpty()) ||
                ($tab === 'links' && $links->isNotEmpty()) ||
                ($tab === 'certificates' && $certificates->isNotEmpty())) {
                $groupedTrainings[] = [
                    'training' => $training,
                    'materials' => $materials,
                    'links' => $links,
                    'certificates' => $certificates
                ];
            }
        }

        // Apply sorting
        $sort = $request->input('sort', 'created_at');
        $order = $request->input('order', 'desc');
        
        usort($groupedTrainings, function($a, $b) use ($sort, $order) {
            $valueA = $sort === 'title' ? $a['training']->title : $a['training']->created_at;
            $valueB = $sort === 'title' ? $b['training']->title : $b['training']->created_at;
            
            if ($order === 'asc') {
                return $valueA <=> $valueB;
            } else {
                return $valueB <=> $valueA;
            }
        });

        // Paginate the results
        $page = $request->input('page', 1);
        $perPage = 10;
        $currentPageItems = array_slice($groupedTrainings, ($page - 1) * $perPage, $perPage);
        $paginatedTrainings = new \Illuminate\Pagination\LengthAwarePaginator(
            $currentPageItems,
            count($groupedTrainings),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('userPanel.trainingResources', [
            'trainings' => $paginatedTrainings,
            'tab' => $request->input('tab', 'materials')
        ]);
    }

    public function evalParticipantForm($training_id)
    {
        $training = Training::findOrFail($training_id);
        $userId = Auth::id();

        // Check if the user is a participant in this training
        if (! $training->participants()->where('users.id', $userId)->exists()) {
            abort(403, 'You are not authorized to evaluate this training.');
        }

        // Get or create evaluation record for this training-user combination
        $evaluation = \App\Models\TrainingEvaluation::getOrCreate($training_id, $userId);

        return view('userPanel.evalParticipant', compact('training', 'evaluation'));
    }

    public function downloadMaterial(TrainingMaterial $material)
    {
        if (! $material->file_path) {
            return back()->with('error', 'No file available for download.');
        }

        $filePath = storage_path('app/public/'.$material->file_path);

        if (! file_exists($filePath)) {
            return back()->with('error', 'File not found.');
        }

        return response()->download($filePath);
    }

    public function postEvaluation(Request $request, $id)
    {
        $training = Training::with('participants')->findOrFail($id);
        $user_id = $request->query('user_id');

        // Get or create evaluation record for this training-user combination
        $evaluation = null;
        if ($user_id) {
            $evaluation = \App\Models\TrainingEvaluation::getOrCreate($id, $user_id);
        }

        return view('adminPanel.post_eval', compact('training', 'user_id', 'evaluation'));
    }

    public function postEvaluationWithUser(Request $request, $id, $user_id)
    {
        $training = Training::with('participants')->findOrFail($id);

        // Get or create evaluation record for this training-user combination
        $evaluation = \App\Models\TrainingEvaluation::getOrCreate($id, $user_id);

        return view('adminPanel.post_eval', compact('training', 'user_id', 'evaluation'));
    }

    public function submitParticipantEvaluation(Request $request, $id)
    {
        Log::info('Participant Evaluation Submission Request Received', $request->all());
        Log::debug('Incoming request data:', $request->all());

        try {
            $validatedData = $request->validate([
                'goals' => 'required|integer|min:1|max:4',
                'learning1' => 'required|string|in:1,2,3,4,NA',
                'learning2' => 'required|string|in:1,2,3,4,NA',
                'learning3' => 'required|string|in:1,2,3,4,NA',
                'learning4' => 'required|string|in:1,2,3,4,NA',
                'performance1' => 'required|string|in:1,2,3,4,NA',
                'performance2' => 'required|string|in:1,2,3,4,NA',
                'performance3' => 'required|string|in:1,2,3,4,NA',
                'changes' => 'required|string',
                'proficiency' => 'required|string|in:1,2,3,4',
                'comments' => 'nullable|string',
                'workPerformanceChanges' => 'required|string',
                'initiateParticipation' => 'required|in:Yes,No',
                'trainingSuggestions' => 'required|string',
                'training_id' => 'required|exists:trainings,id',
                'type' => 'required|in:participant_post',
            ]);
            Log::debug('Validation successful.', $validatedData);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed:', $e->errors());

            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $e->errors()], 422);
        }

        $training = Training::findOrFail($id);
        $userId = Auth::id();

        // Check if the user is a participant in this training
        if (! $training->participants()->where('users.id', $userId)->exists()) {
            return response()->json(['success' => false, 'message' => 'You are not authorized to evaluate this training.'], 403);
        }

        // Get or create evaluation record for this training-user combination
        $evaluation = \App\Models\TrainingEvaluation::getOrCreate($id, $userId);

        Log::debug('Training found:', ['id' => $training->id, 'title' => $training->title]);

        // Collect all numeric ratings for averaging
        $numericRatings = [];
        $detailedParticipantPostEvaluationData = [];

        $detailedParticipantPostEvaluationData['goals'] = $validatedData['goals'];
        for ($i = 1; $i <= 4; $i++) {
            $learningKey = 'learning'.$i;
            if (is_numeric($validatedData[$learningKey])) {
                $numericRatings[] = (int) $validatedData[$learningKey];
            }
            $detailedParticipantPostEvaluationData[$learningKey] = $validatedData[$learningKey];
        }
        // Save all performance fields
        for ($i = 1; $i <= 3; $i++) {
            $performanceKey = 'performance'.$i;
            if (is_numeric($validatedData[$performanceKey])) {
                $numericRatings[] = (int) $validatedData[$performanceKey];
            }
            $detailedParticipantPostEvaluationData[$performanceKey] = $validatedData[$performanceKey];
        }
        $detailedParticipantPostEvaluationData['changes'] = $validatedData['changes'];
        $detailedParticipantPostEvaluationData['proficiency'] = $validatedData['proficiency'];
        $detailedParticipantPostEvaluationData['comments'] = $validatedData['comments'] ?? '';
        $detailedParticipantPostEvaluationData['workPerformanceChanges'] = $validatedData['workPerformanceChanges'];
        $detailedParticipantPostEvaluationData['initiateParticipation'] = $validatedData['initiateParticipation'];
        $detailedParticipantPostEvaluationData['trainingSuggestions'] = $validatedData['trainingSuggestions'];

        $averageRating = null;
        if (count($numericRatings) > 0) {
            $averageRating = round(array_sum($numericRatings) / count($numericRatings), 2); // Round to 2 decimal places
        }
        Log::debug('Calculated average rating:', ['average' => $averageRating, 'numeric_ratings' => $numericRatings]);

        // Store the average rating and detailed data in the evaluation record
        $evaluation->participant_post_rating = $averageRating;
        $evaluation->participant_post_evaluation = $detailedParticipantPostEvaluationData;

        try {
            $evaluation->save();
            Log::info("Evaluation for training {$id}, user {$userId} participant post-evaluation saved successfully. Average rating: {$averageRating}");
            Log::debug('Evaluation saved successfully.', ['training_id' => $id, 'user_id' => $userId, 'participant_post_rating' => $evaluation->participant_post_rating, 'participant_post_evaluation' => $evaluation->participant_post_evaluation]);

            return response()->json([
                'success' => true,
                'message' => 'Participant post-evaluation submitted successfully!',
                'post_rating' => $evaluation->participant_post_rating,
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to save participant post-evaluation for training {$id}, user {$userId}: ".$e->getMessage(), ['exception' => $e]);

            return response()->json(['success' => false, 'message' => 'Failed to save participant post-evaluation.'], 500);
        }
    }

    public function viewEvaluationData($training_id, $type)
    {
        $training = Training::find($training_id);

        if (! $training) {
            // For API calls (e.g., pre-eval modal), return JSON. For page redirects, handle in view.
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Training not found.'], 404);
            } else {
                abort(404, 'Training not found.');
            }
        }

        // Get evaluation for the current user
        $userId = Auth::id();
        $evaluation = \App\Models\TrainingEvaluation::where('training_id', $training_id)
            ->where('user_id', $userId)
            ->first();

        $data = [
            'training' => $training,
            'evaluation' => $evaluation,
            'evaluation_type' => $type,
            'success' => false,
            'message' => 'No evaluation data found.',
        ];

        switch ($type) {
            case 'participant_pre':
                $data['rating'] = $evaluation ? $evaluation->participant_pre_rating : null;
                $data['success'] = ($data['rating'] !== null);

                return response()->json($data); // Always JSON for pre-eval modal
            case 'participant_post':
                $data['rating'] = $evaluation ? $evaluation->participant_post_rating : null;
                $data['detailed_evaluation'] = $evaluation ? $evaluation->participant_post_evaluation : null; // Retrieve all detailed data
                $data['success'] = ($data['rating'] !== null);

                // If data exists, or if it's a page load, render the view
                return view('userPanel.evalParticipantPostView', compact('training', 'data'));
            case 'supervisor_pre':
                $data['rating'] = $evaluation ? $evaluation->supervisor_pre_rating : null;
                $data['success'] = ($data['rating'] !== null);

                return response()->json($data); // Always JSON for pre-eval modal
            case 'supervisor_post':
                $data['rating'] = $evaluation ? $evaluation->supervisor_post_rating : null;
                $data['detailed_evaluation'] = $evaluation ? $evaluation->supervisor_post_evaluation : null;
                $data['success'] = ($data['rating'] !== null);

                return view('userPanel.evalSupervisorPostView', compact('training', 'data'));
            default:
                if (request()->expectsJson()) {
                    return response()->json(['success' => false, 'message' => 'Invalid evaluation type.'], 400);
                } else {
                    abort(400, 'Invalid evaluation type.');
                }
        }
    }

    public function submitPostEvaluation(Request $request, $id)
    {
        Log::info('Supervisor Post Evaluation Submission Request Received', $request->all());
        Log::debug('Incoming supervisor post-eval request data:', $request->all());

        try {
            $validatedData = $request->validate([
                'goals' => 'required|integer|min:1|max:4',
                'learning1' => 'required|string|in:1,2,3,4,5',
                'learning2' => 'required|string|in:1,2,3,4,5',
                'learning3' => 'required|string|in:1,2,3,4,5',
                'learning4' => 'required|string|in:1,2,3,4,5',
                'workPerformanceChanges' => 'required|string',
                'performance1' => 'required|string|in:1,2,3,4',
                'initiateParticipation' => 'required|in:Yes,No',
                'trainingSuggestions' => 'required|string',
                'type' => 'required|in:supervisor_post',
                'user_id' => 'nullable|integer|exists:users,id',
            ]);
            Log::debug('Supervisor post-eval validation successful.', $validatedData);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Supervisor post-eval validation failed:', $e->errors());

            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $e->errors()], 422);
        }

        $training = Training::findOrFail($id);
        $user = Auth::user();

        // Determine which user's evaluation we're updating
        $target_user_id = $validatedData['user_id'] ?? $user->id;

        Log::debug('Training found for supervisor post-eval:', ['id' => $training->id, 'title' => $training->title, 'target_user_id' => $target_user_id]);

        // Get or create evaluation record for this training-user combination
        $evaluation = \App\Models\TrainingEvaluation::getOrCreate($id, $target_user_id);

        $detailedSupervisorPostEvaluationData = [
            'goals' => $validatedData['goals'],
            'learning1' => $validatedData['learning1'],
            'learning2' => $validatedData['learning2'],
            'learning3' => $validatedData['learning3'],
            'learning4' => $validatedData['learning4'],
            'workPerformanceChanges' => $validatedData['workPerformanceChanges'],
            'performance1' => $validatedData['performance1'],
            'initiateParticipation' => $validatedData['initiateParticipation'],
            'trainingSuggestions' => $validatedData['trainingSuggestions'],
        ];

        // Calculate average rating for supervisor post (excluding NA/5 if needed)
        $numericRatings = [];
        foreach (['goals', 'learning1', 'learning2', 'learning3', 'learning4', 'performance1'] as $key) {
            if (is_numeric($validatedData[$key]) && $validatedData[$key] != 5) {
                $numericRatings[] = (int) $validatedData[$key];
            }
        }
        $averageRating = null;
        if (count($numericRatings) > 0) {
            $averageRating = round(array_sum($numericRatings) / count($numericRatings), 2);
        }
        $evaluation->supervisor_post_rating = $averageRating;
        $evaluation->supervisor_post_evaluation = $detailedSupervisorPostEvaluationData;

        try {
            $evaluation->save();
            Log::info("Evaluation for training {$id}, user {$target_user_id} supervisor post-evaluation saved successfully. Average rating: {$averageRating}");
            Log::debug('Evaluation saved successfully (supervisor post-eval).', ['training_id' => $id, 'user_id' => $target_user_id, 'supervisor_post_rating' => $evaluation->supervisor_post_rating, 'supervisor_post_evaluation' => $evaluation->supervisor_post_evaluation]);

            // Redirect back with a success message instead of returning JSON
            return redirect()->back()->with('success', 'Supervisor post-evaluation submitted successfully!');
        } catch (\Exception $e) {
            Log::error("Failed to save supervisor post-evaluation for training {$id}, user {$target_user_id}: ".$e->getMessage(), ['exception' => $e]);

            return redirect()->back()->with('error', 'Failed to save supervisor post-evaluation.');
        }
    }

    public function effectiveness(Request $request)
    {
        $userId = Auth::id();
        $search = $request->input('search');
        
        // Combine programmed and unprogrammed trainings
        $query = Training::where(function ($q) use ($userId) {
            $q->where('type', 'Program')
                ->whereHas('participants', function ($subQ) use ($userId) {
                    $subQ->where('users.id', $userId);
                })
                ->orWhere(function ($q2) use ($userId) {
                    $q2->where('type', 'Unprogrammed')
                        ->where(function ($q3) use ($userId) {
                            $q3->where('user_id', $userId)
                                ->orWhereHas('participants', function ($subQ) use ($userId) {
                                    $subQ->where('users.id', $userId);
                                });
                        });
                });
        })
        ->when($search, function ($q) use ($search) {
            $q->where('title', 'like', "%$search%")
                ->orWhereHas('competency', function ($subQ) use ($search) {
                    $subQ->where('name', 'like', "%$search%");
                });
        })
        ->with(['evaluations' => function ($query) use ($userId) {
            $query->where('user_id', $userId);
        }]);
        
        $trainings = $query->paginate(15);

        // Get all competencies used in user's trainings for charts
        $allUserTrainings = Training::where('type', 'Program')
            ->whereHas('participants', function ($q) use ($userId) {
                $q->where('users.id', $userId);
            })
            ->with(['evaluations' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }])
            ->get();

        $competencyIds = $allUserTrainings->pluck('competency_id')->unique()->filter();

        $competencyCharts = [];
        foreach ($competencyIds as $cid) {
            $compTrainings = $allUserTrainings->where('competency_id', $cid);

            // Group by year
            $yearly = [];
            foreach (
                $compTrainings->groupBy(function ($t) {
                    return $t->implementation_date_from
                        ? date('Y', strtotime($t->implementation_date_from))
                        : null;
                }) as $year => $yearTrainings
            ) {
                if ($year) {
                    $preAvg = round($yearTrainings->avg(function ($t) {
                        $evaluation = $t->evaluations->first();

                        return $evaluation ? ($evaluation->participant_pre_rating ?? $evaluation->supervisor_pre_rating) : null;
                    }), 2);
                    $postAvg = round($yearTrainings->avg(function ($t) {
                        $evaluation = $t->evaluations->first();

                        return $evaluation ? ($evaluation->participant_post_rating ?? $evaluation->supervisor_post_rating) : null;
                    }), 2);
                    $yearly[$year] = [
                        'pre' => $preAvg,
                        'post' => $postAvg,
                    ];
                }
            }
            $competencyCharts[$cid] = $yearly;
        }

        $competencyLabels = Competency::whereIn('id', $competencyIds)->pluck('name', 'id');

        return view('userPanel.trainingEffectiveness', compact('trainings', 'competencyCharts', 'competencyLabels'));
    }

    public function effectivenessUnprogrammed(Request $request)
    {
        $userId = Auth::id();
        $search = $request->input('search');
        $trainings = Training::where('type', 'Unprogrammed')
            ->where(function ($query) use ($userId) {
                $query->where('user_id', $userId)
                    ->orWhereHas('participants', function ($q) use ($userId) {
                        $q->where('users.id', $userId);
                    });
            })
            ->when($search, function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                    ->orWhereHas('competency', function ($subQ) use ($search) {
                        $subQ->where('name', 'like', "%$search%");
                    });
            })
            ->with(['evaluations' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }])
            ->paginate(10);

        // Get all competencies used in user's trainings for charts
        $allUserTrainings = Training::where('type', 'Unprogrammed')
            ->where(function ($query) use ($userId) {
                $query->where('user_id', $userId)
                    ->orWhereHas('participants', function ($q) use ($userId) {
                        $q->where('users.id', $userId);
                    });
            })
            ->with(['evaluations' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }])
            ->get();

        $competencyIds = $allUserTrainings->pluck('competency_id')->unique()->filter();

        $competencyCharts = [];
        foreach ($competencyIds as $cid) {
            $compTrainings = $allUserTrainings->where('competency_id', $cid);

            // Group by year
            $yearly = [];
            foreach (
                $compTrainings->groupBy(function ($t) {
                    return $t->implementation_date_from
                        ? date('Y', strtotime($t->implementation_date_from))
                        : null;
                }) as $year => $yearTrainings
            ) {
                if ($year) {
                    $preAvg = round($yearTrainings->avg(function ($t) {
                        $evaluation = $t->evaluations->first();

                        return $evaluation ? ($evaluation->participant_pre_rating ?? $evaluation->supervisor_pre_rating) : null;
                    }), 2);
                    $postAvg = round($yearTrainings->avg(function ($t) {
                        $evaluation = $t->evaluations->first();

                        return $evaluation ? ($evaluation->participant_post_rating ?? $evaluation->supervisor_post_rating) : null;
                    }), 2);
                    $yearly[$year] = [
                        'pre' => $preAvg,
                        'post' => $postAvg,
                    ];
                }
            }
            $competencyCharts[$cid] = $yearly;
        }

        $competencyLabels = Competency::whereIn('id', $competencyIds)->pluck('name', 'id');

        return view('userPanel.trainingEffectivenessUnprogrammed', compact('trainings', 'competencyCharts', 'competencyLabels'));
    }

    public function export($id)
    {
        $userId = Auth::id();

        // Use the same logic as the program() method to get programmed trainings
        $trainings = Training::where('type', 'Program')
            ->whereHas('participants', function ($q) use ($userId) {
                $q->where('users.id', $userId);
            })
            ->with([
                'participants' => function ($query) use ($userId) {
                    $query->where('users.id', $userId);
                },
                'competency',
                'evaluations' => function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                },
            ])
            ->orderBy('core_competency')
            ->orderBy('title')
            ->get();

        // Group trainings by core competency
        $groupedTrainings = $trainings->groupBy('core_competency');

        $pdf = Pdf::loadView('userPanel.training-export-pdf', compact('groupedTrainings'));

        return $pdf->download('my-programmed-trainings.pdf');
    }

    public function userProfileInfo()
    {
        $user = Auth::user();
        $programmedTrainings = Training::where('type', 'Program')
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
                },
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('userPanel.userInfo', compact('user', 'programmedTrainings'));
    }

    public function userProfileInfoUnprogrammed()
    {
        $user = Auth::user();
        $unprogrammedTrainings = Training::where('type', 'Unprogrammed')
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhereHas('participants', function ($q) use ($user) {
                        $q->where('users.id', $user->id);
                    });
            })
            ->with(['competency', 'participants'])
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('userPanel.userInfoUnprog', compact('user', 'unprogrammedTrainings'));
    }

    public function uploadUserProfilePicture(Request $request)
    {
        try {
            $request->validate([
                'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
            ]);

            $user = Auth::user();

            // Delete old profile picture if exists
            if ($user->profile_picture && file_exists(public_path('storage/'.$user->profile_picture))) {
                unlink(public_path('storage/'.$user->profile_picture));
            }

            // Store new profile picture
            $file = $request->file('profile_picture');
            $filename = 'profile_'.$user->id.'_'.time().'.'.$file->getClientOriginalExtension();
            $path = $file->storeAs('profile_pictures', $filename, 'public');

            // Update user record
            $user->profile_picture = $path;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Profile picture updated successfully!',
                'image_url' => asset('storage/'.$path),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error uploading profile picture: '.$e->getMessage(),
            ], 500);
        }
    }

    public function updateUserProfile(Request $request)
    {
        try {
            $request->validate([
                'salary_grade' => 'nullable|string|max:10',
                'division' => 'nullable|string|max:255',
                'position_start_date' => 'nullable|date',
                'government_start_date' => 'nullable|date',
                'position' => 'nullable|string|max:255',
                'superior' => 'nullable|string|max:255',
                'mid_init' => 'nullable|string|max:1',
            ]);

            $user = Auth::user();

            // Update only the fields that users are allowed to edit
            $user->salary_grade = $request->salary_grade;
            $user->division = $request->division;
            $user->position_start_date = $request->position_start_date;
            $user->government_start_date = $request->government_start_date;
            $user->position = $request->position;
            $user->superior = $request->superior;
            $user->mid_init = strtoupper(substr($request->mid_init, 0, 1)); // Ensure only first character is taken and uppercase

            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully!',
                'user' => [
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'mid_init' => $user->mid_init,
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating profile: '.$e->getMessage(),
            ], 500);
        }
    }
}
