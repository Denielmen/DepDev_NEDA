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
    public function viewUserInfo($training_id, $user_id)
    {
        $training = Training::findOrFail($training_id);
        $user = User::findOrFail($user_id);

        // Get or create evaluation record for this training-user combination
        $evaluation = \App\Models\TrainingEvaluation::getOrCreate($training_id, $user_id);

        // Fix certificates that don't have training_id set
        // This will link certificates to trainings based on title and user
        $this->fixCertificateTrainingIds($training, $user);

        return view('adminPanel.viewUserInfo', compact('training', 'user', 'evaluation'));
    }

    public function viewUserInfoUnprog($training_id, $user_id)
    {
        $training = Training::findOrFail($training_id);
        $user = User::findOrFail($user_id);
        return view('adminPanel.viewUserInfoUnprog', compact('training', 'user'));
    }
    // public function viewUserInfoUnprog($training_id, $user_id)
    // {
    //     $training = \App\Models\Training::findOrFail($training_id);
    //     $user = \App\Models\User::findOrFail($user_id);

    //     // Fix certificates that don't have training_id set
    //     // This will link certificates to trainings based on title and user
    //     $this->fixCertificateTrainingIds($training, $user);

    //     return view('adminPanel.viewUserInfoUnprog', compact('training', 'user'));
    // }

    private function fixCertificateTrainingIds($training, $user)
    {
        // Find certificates that don't have training_id set but match this training
        $orphanedCertificates = \App\Models\TrainingMaterial::where('type', 'certificate')
            ->where('user_id', $user->id)
            ->whereNull('training_id')
            ->where(function($query) use ($training) {
                $query->where('title', 'like', '%' . $training->title . '%')
                      ->orWhere('title', $training->title . ' Certificate');
            })
            ->get();

        foreach ($orphanedCertificates as $certificate) {
            $certificate->update(['training_id' => $training->id]);
        }
    }

    public function fixAllCertificates()
    {
        // This method will try to fix all orphaned certificates
        $orphanedCertificates = \App\Models\TrainingMaterial::where('type', 'certificate')
            ->whereNull('training_id')
            ->get();

        $fixed = 0;
        foreach ($orphanedCertificates as $certificate) {
            // Try to find a matching training based on title and user
            $possibleTrainings = Training::where('user_id', $certificate->user_id)
                ->where(function($query) use ($certificate) {
                    $certTitle = str_replace(' Certificate', '', $certificate->title);
                    $query->where('title', 'like', '%' . $certTitle . '%')
                          ->orWhere('title', $certTitle);
                })
                ->get();

            if ($possibleTrainings->count() == 1) {
                $certificate->update(['training_id' => $possibleTrainings->first()->id]);
                $fixed++;
            }
        }

        return response()->json([
            'message' => "Fixed {$fixed} certificates out of {$orphanedCertificates->count()} orphaned certificates."
        ]);
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
