<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Training; // Example model
use App\Models\User; // Example model
use App\Models\TrainingMaterial; // Import TrainingMaterial model
use App\Models\Competency; // Import Competency modelse PDF;
use Barryvdh\DomPDF\Facade\PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SearchExport; // Assuming SearchExport is in App\\Exports
use Carbon\Carbon; // Import Carbon for date formatting
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class SearchController extends Controller
{
    public function index()
    {
        // Get unique divisions and positions for the filters
        $divisions = User::select('division')->distinct()->pluck('division');
        $positions = User::select('position')->distinct()->pluck('position');
        $competencies = Competency::all();

        // Initialize empty results collection
        $results = new Collection();

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
                    $training->participants = $training->participants->map(function ($participant) {
                        return [
                            'id' => $participant->id,
                            'name' => $participant->first_name . ' ' . $participant->last_name,
                        ];
                    });
                    $training->relatedMaterials = TrainingMaterial::query()
                        ->where('title', 'like', "%{$training->title}%")
                        ->where('source', 'like', "%{$training->source}%")
                        ->get();
                    return $training;
                });
            $results = $results->concat($trainings);
        }

        // Search training materials
        if (in_array('Training Material', $types)) {
            $materials = TrainingMaterial::query()
                ->when($query, function ($q) use ($query) {
                    $q->where(function ($q) use ($query) {
                        $q->where('title', 'like', "%{$query}%")
                            ->orWhereHas('competency', function ($subQ) use ($query) {
                                $subQ->where('name', 'like', "%{$query}%");
                            })
                            ->orWhereHas('training', function ($subQ) use ($query) {
                                $subQ->where('title', 'like', "%{$query}%");
                            });
                    });
                })
                ->when($competencies, function ($q) use ($competencies) {
                    $q->whereIn('competency_id', $competencies);
                })
                ->where('type', 'material')
                ->when($materialType === 'material', function($q) {
                    $q->whereNotNull('file_path');
                })
                ->when($materialType === 'link', function($q) {
                    $q->whereNotNull('link');
                })
                ->paginate(10);
            $materials->getCollection()->transform(function($material) {
                $material->search_type = 'training_material';
                return $material;
            });
            $results = $materials;
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
            if (!empty($competencies)) {
                $trainingQuery->whereIn('competency_id', $competencies);
            }
            $trainings = $trainingQuery->with(['competency', 'participants'])->get();
            foreach ($trainings as $training) {
                $training->search_type = 'training';
                // Removed explicit formatting of participants for PDF export
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
            if (!empty($competencies)) {
                $materialQuery->whereIn('competency_id', $competencies);
            }
            $materials = $materialQuery->with(['competency', 'user'])->get();
            foreach ($materials as $material) {
                $material->search_type = 'training_material';
                $results->push($material);
            }
        }

        if ($format === 'pdf') {
            $pdf = PDF::loadView('search.pdf', compact('results'));
            return $pdf->download('search-results.pdf');
        } else if ($format === 'excel') {
            return Excel::download(new SearchExport($results), 'search-results.xlsx');
        }

        return back()->with('error', 'Invalid export format');
    }
}
