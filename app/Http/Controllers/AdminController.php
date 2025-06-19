<?php

namespace App\Http\Controllers;

use App\Models\Training;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TrainingsExport;
use App\Models\Competency;

class AdminController extends Controller
{
    public function viewUserInfo($id)
    {
        $training = Training::findOrFail($id);
        $user = $training->participants->first(); // Get the first participant
        return view('adminPanel.viewUserInfo', compact('training', 'user'));
    }

    public function viewUserInfoUnprog($id)
    {
        $training = Training::findOrFail($id);
        $user = User::findOrFail($training->user_id); // Get the creator of the training
        return view('adminPanel.viewUserInfoUnprog', compact('training', 'user'));
    }

    public function reports()
    {
        // Fetch all trainings with their relationships
        $allTrainings = Training::with(['competency', 'participants', 'participants_2025', 'participants_2026', 'participants_2027'])
            ->orderBy('core_competency')
            ->where('type', 'Program') // Filter for programmed trainings
            ->get();

        // Group the trainings by core_competency and sort each group by created_at descending
        $trainings = $allTrainings->groupBy('core_competency')->map(function ($group) {
            return $group->sortByDesc('created_at');
        });

        return view('adminPanel.report', compact('trainings'));
    }

    // Export Reports to PDF
    public function exportPdf()
    {
        $allTrainings = Training::with(['competency', 'participants', 'participants_2025', 'participants_2026', 'participants_2027'])
            ->orderBy('core_competency')
            ->get();

        // Group the trainings by core_competency and sort each group by created_at descending
        $trainings = $allTrainings->groupBy('core_competency')->map(function ($group) {
            return $group->sortByDesc('created_at');
        });

        $pdf = Pdf::loadView('adminPanel.reports.pdf', compact('trainings'));
        return $pdf->download('training_report.pdf');
    }

    // Export Reports to Excel
    public function exportExcel()
    {
        $trainings = Training::with(['competency', 'participants', 'participants_2025', 'participants_2025', 'participants_2026', 'participants_2027'])
            ->orderBy('core_competency')
            ->get();

        return Excel::download(new TrainingsExport($trainings), 'training_report.xlsx');
    }

    public function participants()
    {
        $users = User::orderBy('is_active', 'desc')
            ->orderBy('last_name', 'asc')
            ->paginate(5); // Show 15 users per page
        $positions = User::distinct()->pluck('position')->filter()->values()->toArray();

        return view('adminPanel.listOfUser', compact('users', 'positions'));
    }

    public function welcomeAdmin()
    {
        // Get all programmed trainings with ratings and competencies
        $trainings = Training::with(['competency', 'participants'])
            ->where('type', 'Program')
            ->get();

        // Group by competency
        $competencyCharts = [];
        $competencyLabels = Competency::pluck('name', 'id');

        foreach ($trainings->groupBy('competency_id') as $cid => $groupedTrainings) {
            // Group by year
            $yearly = [];
            foreach (
                $groupedTrainings->groupBy(function ($t) {
                    return $t->implementation_date_from
                        ? date('Y', strtotime($t->implementation_date_from))
                        : null; // or return 'No Date' if you want a label
                }) as $year => $yearTrainings
            ) {
                // Average all ratings for this year and competency
                $ratings = [];
                foreach ($yearTrainings as $training) {
                    if ($training->participant_post_rating !== null) {
                        $ratings[] = $training->participant_post_rating;
                    } elseif ($training->supervisor_post_rating !== null) {
                        $ratings[] = $training->supervisor_post_rating;
                    }
                }
                $yearly[$year] = count($ratings) ? round(array_sum($ratings) / count($ratings), 2) : null;
            }
            $competencyCharts[$cid] = $yearly;
        }

        return view('adminPanel.welcomeAdmin', compact('competencyCharts', 'competencyLabels'));
    }
}
