<?php

namespace App\Http\Controllers;

use App\Models\Training;
use App\Models\User;
use App\Models\TrainingMaterial;
use Illuminate\Http\Request;

class TrainingProfileController extends Controller
{
    public function program()
    {
        $trainings = Training::with('tthRecords')
            ->where('type', 'Program')
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

    public function edit(Request $request)
    {
        $trainingID = $request->query('id');
        $training = Training::with('participants')->findOrFail($trainingID);
        return view('adminPanel.editTraining', compact('training'));
    }  

    public function update(Request $request)
    {
        $trainingID = $request->input('id');
        $training = Training::findOrFail($trainingID);

        $request->validate([
            'title' => 'required|string|max:255',
            'competency' => 'required|string|max:255',
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
        return view('adminPanel.createTraining', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'competency' => 'required|string|max:255',
            'implementation_date' => 'required|date',
            'no_of_hours' => 'nullable|numeric',
            'provider' => 'nullable|string|max:255',
            'dev_target' => 'nullable|string',
            'performance_goal' => 'nullable|string',
            'objective' => 'nullable|string',
            'participants' => 'nullable|array',
            'participants.*' => 'exists:users,id'
        ]);

        // Create training data with type always set to Program
        $trainingData = $request->except('participants');
        $trainingData['type'] = 'Program';

        $training = Training::create($trainingData);

        // Add participants if any were selected
        if ($request->has('participants')) {
            $training->participants()->attach($request->participants);
        }

        return redirect()->route('admin.training-plan')
            ->with('success', 'Training created successfully.');
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