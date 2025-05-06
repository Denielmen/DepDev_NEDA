<?php

namespace App\Http\Controllers;

use App\Models\Training;
use App\Models\User;
use Illuminate\Http\Request;

class TrainingProfileController extends Controller
{
    public function program()
    {
        $trainings = Training::where('type', 'Program')->paginate(10);
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
            'type' => 'required|in:Program,Unprogrammed',
            'participation_type' => 'required|in:Resource Person,Participant',
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
            'participation_type' => 'required|in:Resource Person,Participant',
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
} 