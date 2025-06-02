<?php

namespace App\Http\Controllers;

use App\Models\Training;
use App\Models\User;
use App\Models\TrainingMaterial;
use App\Models\Competency;
use App\Models\ParticipationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrainingProfileController extends Controller
{
    public function program()
    {   
        $competencies = Competency::orderBy('name')->get();
        $trainings = Training::where('type', 'Program')
            ->orderByRaw("CASE WHEN status = 'Pending' THEN 0 ELSE 1 END")
            ->orderBy('status')
            ->paginate(10);
        $competencies = Competency::orderBy('name')->get();
        return view('userPanel.trainingProfileProgram', compact('trainings', 'competencies'));
    }

    public function unprogrammed()
    {
        $trainings = Training::where('type', 'Unprogrammed')->paginate(10);
        return view('userPanel.trainingProfileUnProgram', compact('trainings'));
    }

    public function show($id)
    {
        $training = Training::with('participants')->findOrFail($id);
        return view('userPanel.trainingProfileShow', compact('training'));
    }

    public function effectivenessParticipant($id, $type)
    {
        $training = Training::findOrFail($id);
        return view('userPanel.trainingEffectivenessParticipant', compact('training', 'type'));
    }

    public function edit(Training $training)
    {
        $competencies = Competency::orderBy('name')->get();
        return view('adminPanel.editTraining', compact('training', 'competencies'));
    }

    public function update(Request $request, Training $training)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'competency_id' => 'required|exists:competencies,id',
            'implementation_date_from' => 'required|date',
            'implementation_date_to' => 'required|date',
            'no_of_hours' => 'nullable|numeric',
            'provider' => 'nullable|string|max:255',
            'dev_target' => 'nullable|string',
            'performance_goal' => 'nullable|string',
            'objective' => 'nullable|string',
            'type' => 'required|in:Program,Unprogrammed'
        ]);

        $training->update($request->all());
        return redirect()->route('admin.training-plan')->with('success', 'Training updated successfully.');
    }

    public function trainingPlan()
    {
        $trainings = Training::with('participants')->where('type', 'Program')->get();
        return view('adminPanel.trainingPlan', compact('trainings'));
    }

    public function create()
    {
        $competencies = \App\Models\Competency::orderBy('name')->get();
        $users = \App\Models\User::orderBy('last_name')->get();
        $participationTypes = \App\Models\ParticipationType::all();
        return view('adminPanel.createTraining', compact('competencies', 'users', 'participationTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'competency_id' => 'required|exists:competencies,id',
            'core_competency' => 'required|string|in:Foundational/Mandatory,Competency Enhancement,Leadership/Executive Development,Gender and Development (GAD)-Related,Others',
            'core_competency_input' => 'required_if:core_competency,Others|nullable|string|max:255',
            'period_from' => 'required|date',
            'period_to' => 'required|date|after_or_equal:period_from',
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
            if (
                !isset($validated['participation_types'][$participantId]) ||
                !\App\Models\ParticipationType::find($validated['participation_types'][$participantId])
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
            'user_id' => 'required|exists:users,id'
        ]);

        // Check if user is already a participant
        if ($training->participants()->where('user_id', $request->user_id)->exists()) {
            return back()->with('error', 'User is already a participant in this training.');
        }

        // Add the participant
        $training->participants()->attach($request->user_id);

        return back()->with('success', 'Participant added successfully.');
    }

    public function removeParticipant(Training $training, Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $training->participants()->detach($request->user_id);

        return back()->with('success', 'Participant removed successfully.');
    }

    public function destroy(Training $training)
    {
        // Delete the training
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
