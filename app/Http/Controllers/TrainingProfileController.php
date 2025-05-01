<?php

namespace App\Http\Controllers;

use App\Models\Training;
use Illuminate\Http\Request;

class TrainingProfileController extends Controller
{
    public function program()
    {
        $trainings = Training::where('type', 'Program')->get();
        return view('userPanel.trainingProfileProgram', compact('trainings'));
    }

    public function unprogrammed()
    {
        $trainings = Training::where('type', 'Unprogrammed')->get();
        return view('userPanel.trainingProfileUnProgram', compact('trainings'));
    }

    public function show($id)
    {
        $training = Training::findOrFail($id);
        return view('userPanel.trainingProfileShow', compact('training'));
    }

 public function edit(Request $request)
 {
     $trainingID = $request-> query('id');
     $training = Training::findOrFail($trainingID);
        return view('adminPanel.editTraining', compact('training'));
 }  

 public function update(Request $request)
 {
     $trainingID = $request->input('id');
     $training = Training::findOrFail($trainingID);

     $request->validate([
        'title' => 'required|string|max:255',
        'competency' => 'required|string|max:255',
        'year' => 'required|date',
        'budget' => 'nullable|numeric',
        'hours' => 'nullable|numeric',
        'provider' => 'nullable|string|max:255',
        'dev_target' => 'nullable|string',
        'performance_goal' => 'nullable|string',
        'objective' => 'nullable|string',
    ]);
     $training->update($request->all());
     return redirect()->route('admin.training-plan')->with('success', 'Training updated successfully.');
 }

    public function trainingPlan()
    {
        $trainings = Training::all();
        return view('adminPanel.trainingPlan', compact('trainings'));
    }

    public function create()
    {
        return view('adminPanel.createTraining');
    }

} 