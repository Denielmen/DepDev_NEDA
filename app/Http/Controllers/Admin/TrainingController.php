<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Training;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    public function index()
    {
        $trainings = Training::where('type', 'Program')->get();
        return view('adminPanel.trainingPlan', compact('trainings'));
    }

    public function unprogrammed()
    {
        $trainings = Training::where('type', 'Unprogrammed')->get();
        return view('adminPanel.trainingPlanUnProg', compact('trainings'));
    }

    public function create()
    {
        return view('adminPanel.trainingPlanCreate');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'competency' => 'required|string|max:255',
            'implementation_date' => 'required|date',
            'provider' => 'nullable|string|max:255',
            'type' => 'required|in:Program,Unprogrammed',
        ]);

        Training::create($request->all());

        return redirect()->route('admin.training-plan')
            ->with('success', 'Training created successfully.');
    }

    public function edit(Training $training)
    {
        return view('adminPanel.trainingPlanEdit', compact('training'));
    }

    public function update(Request $request, Training $training)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'competency' => 'required|string|max:255',
            'implementation_date' => 'required|date',
            'provider' => 'nullable|string|max:255',
            'type' => 'required|in:Program,Unprogrammed',
        ]);

        $training->update($request->all());

        return redirect()->route('admin.training-plan')
            ->with('success', 'Training updated successfully.');
    }

    public function destroy(Training $training)
    {
        $training->delete();
        return redirect()->route('admin.training-plan')
            ->with('success', 'Training deleted successfully.');
    }
} 