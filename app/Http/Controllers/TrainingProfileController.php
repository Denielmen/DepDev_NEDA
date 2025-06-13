<?php

namespace App\Http\Controllers;

use App\Models\Training;
use App\Models\User;
use App\Models\TrainingMaterial;
use App\Models\Competency;
use App\Models\ParticipationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TrainingProfileController extends Controller
{
    public function program()
    {
        $competencies = Competency::orderBy('name')->get();
        $userId = Auth::id();
        $trainings = Training::where('type', 'Program')
            ->orderByRaw("CASE WHEN status = 'Pending' THEN 0 ELSE 1 END")
            ->orderBy('status')
            // Eager load the specific participant for the current user, without trying to load participationType on User model
            ->with(['participants' => function($query) use ($userId) {
                $query->where('users.id', $userId);
            }])
            ->paginate(10);

        // Load all participation types once for efficient lookup in the view
       $participationTypes = ParticipationType::all()->keyBy('id');

        return view('userPanel.trainingProfileProgram', compact('trainings', 'competencies', 'participationTypes'));
    }

    public function unprogrammed()
    {
        $userId = Auth::id();
        $trainings = Training::where('type', 'Unprogrammed')
            ->where(function($query) use ($userId) {
                $query->where('user_id', $userId) // Creator of the training
                    ->orWhereHas('participants', function($q) use ($userId) {
                        $q->where('users.id', $userId); // User is a participant
                    });
            })
            // Eager load the specific participant for the current user, without trying to load participationType on User model
            ->with(['participants' => function($query) use ($userId) {
                $query->where('users.id', $userId);
            }])
            ->paginate(10);

        // Load all participation types once for efficient lookup in the view
        $participationTypes = ParticipationType::all()->keyBy('id');

        // Temporarily dump the trainings collection for debugging (keep commented until resolved)
        // dd($trainings);

        return view('userPanel.trainingProfileUnProgram', compact('trainings', 'participationTypes'));
    }

    public function show(Training $training)
    {
        // Force a fresh reload of the participants relationship
        $training->refresh();
        
        // Eager load the participants relationship with their pivot data
        $training->load(['participants' => function($query) {
            $query->orderBy('last_name')->orderBy('first_name');
        }, 'competency']);
        
        // Get participation types for display
        $participationTypes = \App\Models\ParticipationType::all()->keyBy('id');
        
        return view('adminPanel.TrainingView', compact('training', 'participationTypes'));
    }

    public function showUnprogrammed($id)
    {
        $training = Training::where('type', 'Unprogrammed')->findOrFail($id);
        return view('userPanel.trainingProfileUnprogramShow', compact('training'));
    }

    public function effectivenessParticipant($id, $type)
    {
        $training = Training::findOrFail($id);
        return view('userPanel.trainingEffectivenessParticipant', compact('training', 'type'));
    }

    public function edit(Training $training)
    {
        $training = Training::findOrFail($training->id);
        $competencies = Competency::orderBy('name')->get();
        $participationTypes = ParticipationType::all()->keyBy('id');
        $users = User::orderBy('last_name')->get();

        $training->load(['participants' => function($query) {
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
                'competency_id' => 'required|exists:competencies,id',
                'core_competency' => 'required|string|in:Foundational/Mandatory,Competency Enhancement,Leadership/Executive Development,Gender and Development (GAD)-Related,Others',
                'period_from' => 'required|integer|digits:4',
                'period_to' => 'required|integer|digits:4|gte:period_from',
                'implementation_date_from' => 'required|date',
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
                'participation_types' => 'nullable|array'
            ]);

            // Update training details
            $training->update($validated);

            // Handle participants
            if ($request->has('participants')) {
                // Get current year for the pivot table
                $currentYear = date('Y');
                
                // Prepare the participants data with pivot attributes
                $participants = [];
                foreach ($request->participants as $userId) {
                    $participants[$userId] = [
                        'participation_type_id' => $request->input("participation_types.$userId"),
                        'year' => $currentYear
                    ];
                }
                
                // Sync participants (this will remove any participants not in the array)
                $training->participants()->sync($participants);
            } else {
                // If no participants were selected, detach all
                $training->participants()->detach();
            }

            return redirect()->route('admin.training-plan')->with('success', 'Training updated successfully.');
        } catch (\Exception $e) {
            \Log::error('Training update error: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Failed to update training: ' . $e->getMessage()]);
        }
    }

    public function trainingPlan()
    {
        $trainings = Training::with('participants')->where('type', 'Program')->get();
        return view('adminPanel.trainingPlan', compact('trainings'));
    }

    public function create()
    {
        $competencies = Competency::orderBy('name')->get();
         $users = User::orderBy('last_name')->get();
        $participationTypes = ParticipationType::all()->keyBy('id');
        return view('adminPanel.createTraining', compact('competencies', 'users', 'participationTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'competency_id' => 'required|exists:competencies,id',
            'core_competency' => 'required|string|in:Foundational/Mandatory,Competency Enhancement,Leadership/Executive Development,Gender and Development (GAD)-Related,Others',
            'core_competency_input' => 'required_if:core_competency,Others|nullable|string|max:255',
            'period_from' => 'required|integer|digits:4',
            'period_to' => 'required|integer|digits:4|gte:period_from',
            'implementation_date_from' => 'required|date',
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
        ]);

        foreach ($validated['participants'] as $participantId) {
            if (!isset($validated['participation_types'][$participantId]) ||
                !ParticipationType::find($validated['participation_types'][$participantId])
            ) {
                return back()->withInput()->withErrors(['participants' => 'All participants must have a valid participation type.']);
            }
        }

        DB::beginTransaction();
        try {
            $training = Training::create([
                'title' => $validated['title'],
                'competency_id' => $validated['competency_id'],
                'core_competency' => $validated['core_competency'] === 'Others' ? $validated['core_competency_input'] : $validated['core_competency'],
                'period_from' => $validated['period_from'],
                'period_to' => $validated['period_to'],
                'implementation_date_from' => $validated['implementation_date_from'],
                'implementation_date_to' => $validated['implementation_date_to'] ?? null,
                'no_of_hours' => $validated['no_of_hours'] ?? null,
                'budget' => $validated['budget'] ?? null,
                'provider' => $validated['provider'] ?? null,
                'dev_target' => $validated['dev_target'] ?? null,
                'performance_goal' => $validated['performance_goal'] ?? null,
                'objective' => $validated['objective'] ?? null,
                'type' => $validated['type'],
                'status' => 'Not Yet Implemented'
            ]);

            $year = date('Y', strtotime($validated['implementation_date_from']));
            foreach ($validated['participants'] as $participantId) {
                $training->participants()->attach($participantId, [
                    'year' => $year,
                    'participation_type_id' => $validated['participation_types'][$participantId]
                ]);
            }

            DB::commit();
            return redirect()->route('admin.training-plan')->with('success', 'Training created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Failed to create training: ' . $e->getMessage()]);
        }
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
                'user_id' => 'required|exists:users,id'
            ]);

            DB::beginTransaction();
            
            $training->participants()->detach($request->user_id);
            
            DB::commit();

            return back()->with('success', 'Participant removed successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Remove participant error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to remove participant: ' . $e->getMessage()]);
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
        $request->validate([
            'type' => 'required|in:Pre-Evaluation,Post-Evaluation,Supervisor-Pre-Evaluation,Supervisor-Post-Evaluation',
            'rating' => 'required_if:type,Pre-Evaluation,Supervisor-Pre-Evaluation|nullable|integer|min:1|max:4',
            'supervisor_proficiency_rating' => 'required_if:type,Post-Evaluation|integer|min:1|max:4',
        ]);
        $training = Training::findOrFail($id);
        if ($request->type === 'Pre-Evaluation') {
            $training->participant_pre_rating = $request->rating;
        } else if ($request->type === 'Post-Evaluation') {
            // If supervisor proficiency rating is present, save it
            if ($request->has('supervisor_proficiency_rating')) {
                $training->supervisor_post_rating = $request->supervisor_proficiency_rating;
            }
            // Note: We are intentionally not saving participant_post_rating from this form
        } else if ($request->type === 'Supervisor-Pre-Evaluation') {
            $training->supervisor_pre_rating = $request->rating;
        } else if ($request->type === 'Supervisor-Post-Evaluation') {
            $training->supervisor_post_rating = $request->rating;
        }
        $training->save();
        return response()->json([
            'success' => true,
            'pre_rating' => $training->participant_pre_rating,
            'post_rating' => $training->participant_post_rating,
            'supervisor_pre_rating' => $training->supervisor_pre_rating,
            'supervisor_post_rating' => $training->supervisor_post_rating,
        ]);
    }

    public function resources(Request $request)
    {
        $query = TrainingMaterial::query();
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhere('competency', 'like', "%$search%")
                  ->orWhere('source', 'like', "%$search%")
                  ->orWhereDate('created_at', $search);
            });
        }
        $materials = $query->orderByDesc('created_at')->get();
        return view('userPanel.trainingResources', compact('materials'));
    }

    public function evalParticipantForm()
    {
        $implementedTrainings = Training::where('status', 'Implemented')->where('type', 'Program')->get();
        return view('userPanel.evalParticipant', compact('implementedTrainings'));
    }

    public function downloadMaterial(TrainingMaterial $material)
    {
        if (!$material->file_path) {
            return back()->with('error', 'No file available for download.');
        }

        $filePath = storage_path('app/public/' . $material->file_path);
        
        if (!file_exists($filePath)) {
            return back()->with('error', 'File not found.');
        }

        return response()->download($filePath);
    }


    public function postEvaluation($id)
    {
        $training = Training::with('participants')->findOrFail($id);
        return view('adminPanel.post_eval', compact('training'));
    }

    public function submitPostEvaluation(Request $request, $id)
    {
        $request->validate([
            'goals' => 'required|integer|min:1|max:4',
            'learning1' => 'required|integer|min:1|max:5',
            'learning2' => 'required|integer|min:1|max:5',
            'learning3' => 'required|integer|min:1|max:5',
            'learning4' => 'required|integer|min:1|max:5',
            'performance1' => 'required|integer|min:1|max:4',
            'workPerformanceChanges' => 'required|string',
            'initiateParticipation' => 'required|in:Yes,No',
            'trainingSuggestions' => 'required|string'
        ]);

        $training = Training::findOrFail($id);
        
        // Check if the training status is 'Implemented'
        if ($training->status !== 'Implemented') {
            return back()->withErrors(['status' => 'Post-evaluation can only be submitted for implemented trainings.']);
        }

        // Calculate average rating from all sections
        $averageRating = round((
            $request->goals + 
            $request->learning1 + 
            $request->learning2 + 
            $request->learning3 + 
            $request->learning4 + 
            $request->performance1
        ) / 6);

        // Store the post-evaluation rating and detailed data
        $training->supervisor_post_rating = $averageRating;
        $training->supervisor_post_evaluation = [
            'goals' => $request->goals,
            'learning1' => $request->learning1,
            'learning2' => $request->learning2,
            'learning3' => $request->learning3,
            'learning4' => $request->learning4,
            'performance1' => $request->performance1,
            'workPerformanceChanges' => $request->workPerformanceChanges,
            'initiateParticipation' => $request->initiateParticipation,
            'trainingSuggestions' => $request->trainingSuggestions
        ];
        $training->save();

        // Get the user ID from the training's first participant
        $userId = $training->participants->first()->id;

        return redirect()->route('admin.viewUserInfo', ['id' => $userId])
            ->with('success', 'Post-evaluation submitted successfully.');
    }
}
