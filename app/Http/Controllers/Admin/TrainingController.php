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
            'competency_id' => 'required|exists:competencies,id',
            'core_competency' => 'required|string|in:Foundational/Mandatory,Competency Enhancement,Leadership/Executive Development,Gender and Development (GAD)-Related,Others',
            'period_from' => 'required|date',
            'period_to' => 'required|date',
            'implementation_date' => 'required|date',
            'budget' => 'nullable|numeric',
            'no_of_hours' => 'nullable|integer',
            'superior' => 'nullable|string|max:255',
            'provider' => 'nullable|string|max:255',
            'dev_target' => 'nullable|string',
            'performance_goal' => 'nullable|string',
            'objective' => 'nullable|string',
            'type' => 'required|in:Program,Unprogrammed',
            'participants' => 'required|array|min:1',
            'participants.*' => 'exists:users,id',
            'participation_types' => 'required|array',
            'participation_types.*' => 'exists:participation_types,id'
        ]);

        $training = Training::create($request->all());

        // Attach participants with their participation types
        foreach ($request->participants as $participantId) {
            $participationTypeId = $request->participation_types[$participantId] ?? null;
            if ($participationTypeId) {
                $training->participants()->attach($participantId, [
                    'participation_type_id' => $participationTypeId
                ]);
            }
        }

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