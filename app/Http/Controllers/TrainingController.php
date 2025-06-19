<?php

namespace App\Http\Controllers;

use App\Models\Training;
use App\Models\User;
use App\Models\ParticipationType;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    public function create()
    {
        // Only get active users for participant selection
        $users = User::where('is_active', true)->orderBy('last_name')->get();
        $participationTypes = ParticipationType::all();
        return view('adminPanel.createTraining', compact('users', 'participationTypes'));
    }

    public function addParticipants($trainingId)
    {
        $training = Training::findOrFail($trainingId);

        // Only get active users
        $availableUsers = User::where('is_active', true)
            ->orderBy('last_name')
            ->get();

        return view('training.add_participants', compact('training', 'availableUsers'));
    }


    public function showTrainingEffectiveness()
    {
        $trainings = \App\Models\Training::where('type', 'Program')->get();

        // Get all competencies used in trainings
        $competencyIds = $trainings->pluck('competency_id')->unique()->filter();

        $competencyCharts = [];
        foreach ($competencyIds as $cid) {
            $compTrainings = $trainings->where('competency_id', $cid);
            $preAvg = round($compTrainings->avg(function ($t) {
                return $t->participant_pre_rating ?? $t->supervisor_pre_rating;
            }), 2);
            $postAvg = round($compTrainings->avg(function ($t) {
                return $t->participant_post_rating ?? $t->supervisor_post_rating;
            }), 2);
            $competencyCharts[$cid] = [
                'pre' => $preAvg,
                'post' => $postAvg,
            ];
        }

        $competencyLabels = \App\Models\Competency::whereIn('id', $competencyIds)->pluck('name', 'id');

        return view('userPanel.trainingEffectiveness', compact(
            'trainings',
            'competencyCharts',
            'competencyLabels'
        ));
    }
}
