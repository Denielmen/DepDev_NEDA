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
        $trainings = Training::where('type', 'Program')
            ->orderByRaw("CASE WHEN status = 'Pending' THEN 0 ELSE 1 END")
            ->orderBy('status')
            ->paginate(10);
        return view('userPanel.trainingProfileProgram', compact('trainings'));
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
            'implementation_date' => 'required|date',
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
        $users = User::where('is_active', true)->get();
        $competencies = Competency::orderBy('name')->get();
        $participationTypes = ParticipationType::orderBy('name')->get();
        return view('adminPanel.createTraining', compact('users', 'competencies', 'participationTypes'));
    }

    public function store(Request $request)
    {
        try {
            \Log::info('Training creation request data:', $request->all());

            // Validate the request
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'competency_id' => 'required|exists:competencies,id',
                'period_from' => 'required|date',
                'period_to' => 'required|date|after_or_equal:period_from',
                'implementation_date' => 'required|date',
                'no_of_hours' => 'nullable|numeric',
                'budget' => 'nullable|numeric',
                'provider' => 'nullable|string|max:255',
                'superior' => 'nullable|string|max:255',
                'dev_target' => 'nullable|string',
                'performance_goal' => 'nullable|string',
                'objective' => 'nullable|string',
                'type' => 'required|in:Program,Unprogrammed',
                'participants' => 'required|array',
                'participants.*' => 'exists:users,id',
                'participation_types' => 'required|array',
                'participation_types.*' => 'exists:participation_types,id'
            ]);

            \Log::info('Validated data:', $validated);

            DB::beginTransaction();

            try {
                // Create the training
                $training = Training::create([
                    'title' => $validated['title'],
                    'competency_id' => $validated['competency_id'],
                    'period_from' => $validated['period_from'],
                    'period_to' => $validated['period_to'],
                    'implementation_date' => $validated['implementation_date'],
                    'no_of_hours' => $validated['no_of_hours'],
                    'budget' => $validated['budget'],
                    'provider' => $validated['provider'],
                    'superior' => $validated['superior'],
                    'dev_target' => $validated['dev_target'],
                    'performance_goal' => $validated['performance_goal'],
                    'objective' => $validated['objective'],
                    'type' => $validated['type'],
                    'status' => 'pending'
                ]);

                \Log::info('Training created:', ['training_id' => $training->id]);

                // Attach participants with their participation types
                $participants = $validated['participants'];
                $participationTypes = $validated['participation_types'];

                \Log::info('Attaching participants:', [
                    'participants' => $participants,
                    'participation_types' => $participationTypes
                ]);

                foreach ($participants as $participantId) {
                    if (isset($participationTypes[$participantId])) {
                        $training->participants()->attach($participantId, [
                            'participation_type_id' => $participationTypes[$participantId]
                        ]);
                        \Log::info('Attached participant:', [
                            'training_id' => $training->id,
                            'participant_id' => $participantId,
                            'participation_type_id' => $participationTypes[$participantId]
                        ]);
                    } else {
                        \Log::warning('Missing participation type for participant:', [
                            'training_id' => $training->id,
                            'participant_id' => $participantId
                        ]);
                    }
                }

                DB::commit();
                \Log::info('Training creation completed successfully');

                return redirect()->route('admin.training-plan')
                    ->with('success', 'Training created successfully.');
            } catch (\Exception $e) {
                DB::rollBack();
                \Log::error('Error in transaction:', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                throw $e;
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error:', [
                'errors' => $e->errors(),
                'input' => $request->all()
            ]);
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Error creating training:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withInput()
                ->with('error', 'Error creating training: ' . $e->getMessage());
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
            'type' => 'required|in:Pre-Evaluation,Post-Evaluation',
            'rating' => 'required|integer|min:1|max:4',
        ]);
        $training = Training::findOrFail($id);
        if ($request->type === 'Pre-Evaluation') {
            $training->participant_pre_rating = $request->rating;
        } else {
            $training->participant_post_rating = $request->rating;
        }
        $training->save();
        return response()->json([
            'success' => true,
            'pre_rating' => $training->participant_pre_rating,
            'post_rating' => $training->participant_post_rating,
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
} 