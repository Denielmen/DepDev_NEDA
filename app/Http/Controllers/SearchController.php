<?php

namespace App\Http\Controllers;

use App\Exports\SearchExport;
use App\Models\Competency; // Example model
use App\Models\Training; // Example model
use App\Models\TrainingMaterial; // Import TrainingMaterial model
use App\Models\User; // Import Competency modelse PDF;
use Barryvdh\DomPDF\Facade\PDF;
use Carbon\Carbon;
use Illuminate\Http\Request; // Assuming SearchExport is in App\\Exports
use Illuminate\Support\Collection; // Import Carbon for date formatting
use Maatwebsite\Excel\Facades\Excel;

class SearchController extends Controller
{
    public function index()
    {
        // Get unique divisions and positions for the filters
        $divisions = User::select('division')->distinct()->pluck('division');
        $positions = User::select('position')->distinct()->pluck('position');
        $competencies = Competency::all();

        // Initialize empty results collection
        $results = new Collection;

        return view('search', compact('divisions', 'positions', 'competencies', 'results'));
    }

    public function results(Request $request)
    {
        $query = $request->input('keyword');
        $types = $request->input('type', []); // Now handles multiple types
        $year = $request->input('year');
        $competencies = $request->input('competencies', []);
        $division = $request->input('division');
        $position = $request->input('position');
        $status = $request->input('status');

        $materialType = $request->input('material_type');

        $results = collect();

        // If no types specified, search all types
        if (empty($types)) {
            $types = ['Training', 'User', 'Training Material'];
        }

        // Search users
        if (in_array('User', $types)) {
            $users = User::query()
                ->when($query, function ($q) use ($query) {
                    $q->where(function ($q) use ($query) {
                        $q->where('first_name', 'like', "%{$query}%")
                            ->orWhere('last_name', 'like', "%{$query}%");
                    });
                })
                ->when($division, function ($q) use ($division) {
                    $q->where('division', $division);
                })
                ->when($position, function ($q) use ($position) {
                    $q->where('position', $position);
                })
                ->get()
                ->map(function ($user) {
                    $user->search_type = 'user';

                    return $user;
                });
            $results = $results->concat($users);
        }
        // Search trainings
        if (in_array('Training', $types)) {
            $trainings = Training::query()
                ->when($year, function ($q) use ($year) {
                    $q->where(function ($q) use ($year) {
                        $q->where(function ($subQ) use ($year) {
                            // For Program type: year between period_from and period_to
                            $subQ->where('type', 'Program')
                                ->whereYear('period_from', '<=', $year)
                                ->whereYear('period_to', '>=', $year);
                        })
                            ->orWhere(function ($subQ) use ($year) {
                                // For Unprogrammed type: year matches implementation_date
                                $subQ->where('type', 'Unprogrammed')
                                    ->whereYear('implementation_date_from', '=', $year);
                            });
                    });
                })
                ->when($query, function ($q) use ($query) {
                    $q->where(function ($q) use ($query) {
                        $q->where('title', 'like', "%{$query}%")
                            ->orWhereHas('participants', function ($subQ) use ($query) {
                                $subQ->where(function ($subQ) use ($query) {
                                    $subQ->where('first_name', 'like', "%{$query}%")
                                        ->orWhere('last_name', 'like', "%{$query}%");
                                });
                            })
                            ->orWhereHas('competency', function ($subQ) use ($query) {
                                $subQ->where('name', 'like', "%{$query}%");
                            });
                    });
                })
                ->when($competencies, function ($q) use ($competencies) {
                    $q->whereIn('competency_id', $competencies);
                })
                ->when($status, function ($q) use ($status, $year) {
                    if ($status === 'Implemented') {
                        if ($year) {
                            $q->whereNotNull('period_to')
                                ->whereYear('period_from', '<=', $year)
                                ->whereYear('period_to', '>=', $year);
                        } else {
                            $q->whereNotNull('period_to');
                        }
                    } elseif ($status === 'Not Yet Implemented') {
                        if ($year) {
                            $q->whereNull('period_to')
                                ->where(function ($q2) use ($year) {
                                    $q2->whereYear('period_from', '<=', $year)
                                        ->whereYear('period_to', '>=', $year);
                                })
                                ->orWhere('status', 'Pending')
                                ->orWhere('status', 'Not Yet Implemented');
                        } else {
                            $q->whereNull('period_to')
                                ->orWhere('status', 'Pending')
                                ->orWhere('status', 'Not Yet Implemented');
                        }
                    }
                })
                ->with('participants')
                ->get()
                ->map(function ($training) {
                    $training->search_type = 'training';

                    // For each participant, set year as their pivot year
                    $training->participants = $training->participants->map(function ($participant) {
                        $participantData = [
                            'id' => $participant->id,
                            'name' => $participant->first_name.' '.$participant->last_name,
                        ];
                        if (isset($participant->pivot) && isset($participant->pivot->year)) {
                            $participantData['year'] = $participant->pivot->year;
                        }

                        return $participantData;
                    });

                    $training->relatedMaterials = TrainingMaterial::query()
                        ->where('title', 'like', "%{$training->title}%")
                        ->where('source', 'like', "%{$training->source}%")
                        ->get();

                    return $training;
                });
            $results = $results->concat($trainings);
        }

        // Search training materials grouped by training
        if (in_array('Training Material', $types)) {
            // Build a trainings query constrained by the selected material type
            $trainingsQuery = Training::query()
                ->whereHas('materials', function ($q) use ($materialType, $query, $competencies) {
                    // Apply material-type-specific constraints
                    if ($materialType === 'material') {
                        $q->where('type', 'material')->whereNotNull('file_path');
                    } elseif ($materialType === 'link') {
                        $q->where('type', 'link')->whereNotNull('link');
                    } elseif ($materialType === 'certificate') {
                        $q->where('type', 'certificate')->whereNotNull('file_path');
                    } else {
                        $q->whereIn('type', ['material', 'link', 'certificate']);
                    }

                    // Keyword filter on material title or competency
                    if ($query) {
                        $q->where(function ($inner) use ($query) {
                            $inner->where('title', 'like', "%{$query}%");
                        });
                    }

                    if (!empty($competencies)) {
                        $q->whereIn('competency_id', $competencies);
                    }
                })
                // Also allow keyword on training title
                ->when($query, function ($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%");
                })
                ->with(['materials' => function ($q) use ($materialType) {
                    if ($materialType === 'material') {
                        $q->where('type', 'material')->whereNotNull('file_path');
                    } elseif ($materialType === 'link') {
                        $q->where('type', 'link')->whereNotNull('link');
                    } elseif ($materialType === 'certificate') {
                        $q->where('type', 'certificate')->whereNotNull('file_path');
                    } else {
                        $q->whereIn('type', ['material', 'link', 'certificate']);
                    }
                }, 'materials.user', 'materials.competency']);

            $results = $trainingsQuery->paginate(30);
            $results->getCollection()->transform(function ($training) {
                $training->search_type = 'training_material_group';
                return $training;
            });
        }

        // Get all data needed for the view
        $divisions = User::select('division')->distinct()->pluck('division');
        $positions = User::select('position')->distinct()->pluck('position');
        $competencies = Competency::all();

        // Create a map of competency IDs to names for the filter tags
        $availableCompetencies = $competencies->pluck('name', 'id')->toArray();

        return view('search', compact(
            'results',
            'divisions',
            'positions',
            'competencies',
            'availableCompetencies'
        ));
    }

    public function export(Request $request, $format)
    {
        // Get the search results using the same logic as the results method
        $keyword = $request->input('keyword');
        $types = $request->input('type', []);
        $year = $request->input('year');
        $competencies = $request->input('competencies', []);
        $division = $request->input('division');
        $position = $request->input('position');

        $results = collect();

        // Search in trainings
        if (empty($types) || in_array('Training', $types)) {
            $trainingQuery = Training::query();
            if ($keyword) {
                $trainingQuery->where('title', 'like', "%{$keyword}%");
            }
            if ($year) {
                $trainingQuery->whereYear('implementation_date_from', '=', $year);
            }
            if (! empty($competencies)) {
                $trainingQuery->whereIn('competency_id', $competencies);
            }
            $trainings = $trainingQuery->with(['competency', 'participants'])->get();
            foreach ($trainings as $training) {
                $training->search_type = 'training';

                // Get the period of implementation dates
                $periodStart = null;
                $periodEnd = null;

                if ($training->type === 'Program') {
                    $periodStart = $training->period_from;
                    $periodEnd = $training->period_to;
                } elseif ($training->type === 'Unprogrammed') {
                    $periodStart = $training->implementation_date_from ? $training->implementation_date_from->format('Y-m-d') : null;
                    $periodEnd = $training->implementation_date_to ? $training->implementation_date_to->format('Y-m-d') : null;
                }

                $training->participants = $training->participants->map(function ($participant) use ($periodStart, $periodEnd) {
                    $participantData = [
                        'id' => $participant->id,
                        'name' => $participant->first_name.' '.$participant->last_name,
                    ];

                    // Add period of implementation if dates are available
                    if ($periodStart && $periodEnd) {
                        $participantData['period'] = $periodStart.' - '.$periodEnd;
                    }

                    return $participantData;
                });

                $results->push($training);
            }
        }

        // Search in users
        if (empty($types) || in_array('User', $types)) {
            $userQuery = User::query();
            if ($keyword) {
                $userQuery->where(function ($query) use ($keyword) {
                    $query->where('first_name', 'like', "%{$keyword}%")
                        ->orWhere('last_name', 'like', "%{$keyword}%")
                        ->orWhere('mid_init', 'like', "%{$keyword}%");
                });
            }
            if ($division) {
                $userQuery->where('division', $division);
            }
            if ($position) {
                $userQuery->where('position', $position);
            }
            $users = $userQuery->get();
            foreach ($users as $user) {
                $user->search_type = 'user';
                $results->push($user);
            }
        }

        // Search in training materials
        if (empty($types) || in_array('Training Material', $types)) {
            $materialQuery = TrainingMaterial::query();
            if ($keyword) {
                $materialQuery->where('title', 'like', "%{$keyword}%");
            }
            if (! empty($competencies)) {
                $materialQuery->whereIn('competency_id', $competencies);
            }
            $materials = $materialQuery->with(['competency', 'user'])->get();
            foreach ($materials as $material) {
                $material->search_type = 'training_material';
                $results->push($material);
            }
        }

        if ($format === 'pdf') {
            $pdf = PDF::loadView('search.pdf', compact('results'))
                ->setPaper('a4', 'landscape');

            return $pdf->download('search-results.pdf');
        } elseif ($format === 'excel') {
            return Excel::download(new SearchExport($results), 'search-results.xlsx');
        }

        return back()->with('error', 'Invalid export format');

    }
}
