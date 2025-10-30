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


    public function showTrainingEffectiveness(Request $request)
    {
        $sort = $request->input('sort', 'title');
        $order = $request->input('order', 'asc');
        $trainingsQuery = \App\Models\Training::where('type', 'Program');
        if ($sort === 'title') {
            $trainingsQuery->orderBy('title', $order);
        } elseif ($sort === 'created_at') {
            $trainingsQuery->orderBy('created_at', $order);
        } elseif ($sort === 'status') {
            $trainingsQuery->orderByRaw("CASE WHEN status = 'Implemented' THEN 0 ELSE 1 END $order");
        } else {
            $trainingsQuery->orderBy('title', 'asc');
        }
        $trainings = $trainingsQuery->get();

        // Get all competencies used in trainings
        $competencyIds = $trainings->pluck('competency_id')->unique()->filter();

        $competencyCharts = [];
        foreach ($competencyIds as $cid) {
            $compTrainings = $trainings->where('competency_id', $cid);

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
                        return $t->participant_pre_rating ?? $t->supervisor_pre_rating;
                    }), 2);
                    $postAvg = round($yearTrainings->avg(function ($t) {
                        return $t->participant_post_rating ?? $t->supervisor_post_rating;
                    }), 2);
                    $yearly[$year] = [
                        'pre' => $preAvg,
                        'post' => $postAvg,
                    ];
                }
            }
            $competencyCharts[$cid] = $yearly;
        }

        $competencyLabels = \App\Models\Competency::whereIn('id', $competencyIds)->pluck('name', 'id');

        return view('userPanel.trainingEffectiveness', compact(
            'trainings',
            'competencyCharts',
            'competencyLabels'
        ));
    }
}
