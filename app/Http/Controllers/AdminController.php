<?php

namespace App\Http\Controllers;

use App\Exports\TrainingsExport;
use App\Models\Competency;
use App\Models\Training;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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

        // Get or create evaluation record for this training-user combination
        $evaluation = \App\Models\TrainingEvaluation::getOrCreate($training_id, $user_id);

        return view('adminPanel.viewUserInfoUnprog', compact('training', 'user', 'evaluation'));
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
            ->where(function ($query) use ($training) {
                $query->where('title', 'like', '%'.$training->title.'%')
                    ->orWhere('title', $training->title.' Certificate');
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
                ->where(function ($query) use ($certificate) {
                    $certTitle = str_replace(' Certificate', '', $certificate->title);
                    $query->where('title', 'like', '%'.$certTitle.'%')
                        ->orWhere('title', $certTitle);
                })
                ->get();

            if ($possibleTrainings->count() == 1) {
                $certificate->update(['training_id' => $possibleTrainings->first()->id]);
                $fixed++;
            }
        }

        return response()->json([
            'message' => "Fixed {$fixed} certificates out of {$orphanedCertificates->count()} orphaned certificates.",
        ]);
    }

    public function reports(Request $request)
    {
        $search = $request->input('search');
        $year = $request->input('year') ?? date('Y');

        // Fetch all trainings with competency relationship
        $query = Training::with(['competency'])
            ->where('type', 'Program');

        // Add search functionality for core competency
        if ($search) {
            $query->where('core_competency', 'like', "%{$search}%");
        }

        $allTrainings = $query->orderBy('core_competency')->get();

        // Define the years array for the three-year range
        $years = [$year, $year + 1, $year + 2];

        // Attach participants for a three-year range to each training
        foreach ($allTrainings as $training) {
            $participantsForYears = [];
            foreach ($years as $yr) {
                $participantsForYears[$yr] = $training->participants_year($yr)->get();
            }
            $training->setAttribute('participants_for_years', $participantsForYears);
        }

        // Group the trainings by core_competency and sort each group by created_at descending
        $trainings = $allTrainings->groupBy('core_competency')->map(function ($group) {
            return $group->sortByDesc('created_at');
        });

        return view('adminPanel.report', compact('trainings', 'search', 'year'));
    }

    // Export Reports to PDF
    public function exportPdf($year = null)
    {
        if (!$year) {
            $year = request('year') ?? date('Y');
        }
        $allTrainings = Training::with(['competency'])
            ->where('type', 'Program')
            ->orderBy('core_competency')
            ->get();

        $years = [$year, $year + 1, $year + 2];
        foreach ($allTrainings as $training) {
            $participantsForYears = [];
            foreach ($years as $yr) {
                $participantsForYears[$yr] = $training->participants_year($yr)->get();
            }
            $training->setAttribute('participants_for_years', $participantsForYears);
        }

        $trainings = $allTrainings->groupBy('core_competency')->map(function ($group) {
            return $group->sortByDesc('created_at');
        });

        $pdf = Pdf::loadView('adminPanel.reports.pdf', compact('trainings', 'year'));

        return $pdf->download('training_report.pdf');
    }

    // Export Reports to Excel
    public function exportExcel($year = null)
    {
        if (!$year) {
            $year = request('year') ?? date('Y');
        }
        $allTrainings = Training::with(['competency'])
            ->where('type', 'Program')
            ->orderBy('core_competency')
            ->get();

        $years = [$year, $year + 1, $year + 2];
        foreach ($allTrainings as $training) {
            $participantsForYears = [];
            foreach ($years as $yr) {
                $participantsForYears[$yr] = $training->participants_year($yr)->get();
            }
            $training->setAttribute('participants_for_years', $participantsForYears);
        }

        return Excel::download(new TrainingsExport($allTrainings, $year), 'training_report.xlsx');
    }

    public function participants(Request $request)
    {
        $status = $request->get('status', 'active'); // Default to active
        $positionFilter = $request->get('position'); // Get position filter
        $searchQuery = $request->get('search'); // Get search query

        $query = User::query();

        // Filter by status
        if ($status === 'active') {
            $query->where('is_active', true);
        } elseif ($status === 'inactive') {
            $query->where('is_active', false);
        }

        // Filter by position if specified
        if ($positionFilter && $positionFilter !== 'all') {
            $query->where('position', $positionFilter);
        }

        // Filter by search query if specified
        if ($searchQuery && trim($searchQuery) !== '') {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('user_id', 'like', '%'.$searchQuery.'%')
                    ->orWhere('first_name', 'like', '%'.$searchQuery.'%')
                    ->orWhere('last_name', 'like', '%'.$searchQuery.'%')
                    ->orWhere('position', 'like', '%'.$searchQuery.'%')
                    ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ['%'.$searchQuery.'%'])
                    ->orWhereRaw("CONCAT(last_name, ', ', first_name) LIKE ?", ['%'.$searchQuery.'%']);
            });
        }

        // If filtering by position or search, don't paginate to show all results
        if (($positionFilter && $positionFilter !== 'all') || ($searchQuery && trim($searchQuery) !== '')) {
            $users = $query->orderBy('last_name', 'asc')->get();
            // Convert to a paginator-like object for compatibility with the view
            $perPage = max($users->count(), 1); // Ensure per page is never 0 to avoid division by zero
            $users = new \Illuminate\Pagination\LengthAwarePaginator(
                $users,
                $users->count(),
                $perPage, // Use safe per page value
                1, // Current page
                [
                    'path' => $request->url(),
                    'pageName' => 'page',
                ]
            );
            $users->appends($request->only(['status', 'position', 'search']));
        } else {
            // Normal pagination when not filtering
            $users = $query->orderBy('last_name', 'asc')
                ->paginate(30)
                ->appends(['status' => $status]); // Preserve status in pagination links
        }

        $positions = User::distinct()
            ->pluck('position')
            ->filter(function ($position) {
                return ! empty(trim($position));
            })
            ->map(function ($position) {
                return trim($position);
            })
            ->sort()
            ->values()
            ->toArray();

        return view('adminPanel.listOfUser', compact('users', 'positions', 'status', 'positionFilter', 'searchQuery'));
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
