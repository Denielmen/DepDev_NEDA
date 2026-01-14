<?php

namespace App\Http\Controllers;

use App\Exports\SearchExport;
use App\Models\Competency; // Example model
use App\Models\Training; // Example model
use App\Models\TrainingMaterial; // Import TrainingMaterial model
use App\Models\User; // Import Competency modelse PDF;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
                ->when($materialType === 'material', function ($q) {
                    $q->whereNotNull('file_path');
                })
                ->when($materialType === 'link', function ($q) {
                    $q->whereNotNull('link');
                })
                ->paginate(30);
            $materials->getCollection()->transform(function ($material) {
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

    public function export(Request $request)
    {
        // rebuild results using the same request inputs
        $results = $this->buildResultsFromRequest($request);

        // debug: optional log to check results count
        // \Log::debug('Export results count: ' . $results->count());

        $format = $request->query('format', 'pdf');

        if ($format === 'pdf') {
            $data = ['results' => $results];
            $pdf = Pdf::loadView('search.pdf', $data)
                      ->setPaper('a4', 'landscape');
            return $pdf->download('search-results.pdf');
        }

        if ($format === 'excel') {
            // your existing excel export code
            // return Excel::download(new \App\Exports\SearchExport($results), 'search-results.xlsx');
            abort(501, 'Excel export not implemented in this snippet.');
        }

        abort(400, 'Invalid export format');
    }

    private function buildResultsFromRequest(Request $request): Collection
    {
        $keyword = $request->input('keyword');
        $year = $request->input('year');
        $status = $request->input('status');
        $types = (array) $request->input('type', []);

        $results = collect();

        // Trainings
        $trainings = Training::with(['competency', 'participants'])
            ->when($keyword, fn($q) => $q->where('title', 'like', "%{$keyword}%"))
            ->when($year, fn($q) => $q->whereYear('date', $year))
            ->when($status, fn($q) => $q->where('status', $status))
            ->get();

        foreach ($trainings as $t) {
            if (!empty($types) && !in_array('training', $types)) continue;
            $results->push((object) [
                'search_type' => 'training',
                'title' => $t->title,
                'competency' => $t->competency ?? null,
                'participants' => $t->participants ?? null,
                'status' => $t->status ?? null,
                'last_modified' => $t->updated_at ?? $t->created_at,
            ]);
        }

        // Users
        $users = User::query()
            ->when($keyword, fn($q) => $q->where(function($q2) use ($keyword) {
                $q2->where('first_name', 'like', "%{$keyword}%")
                   ->orWhere('last_name', 'like', "%{$keyword}%");
            }))
            ->when($status, fn($q) => $q->where('status', $status))
            ->get();

        foreach ($users as $u) {
            if (!empty($types) && !in_array('user', $types)) continue;
            $results->push((object) [
                'search_type' => 'user',
                'first_name' => $u->first_name,
                'last_name' => $u->last_name,
                'position' => $u->position ?? null,
            ]);
        }

        // Training materials
        $materials = TrainingMaterial::with(['competency', 'user'])
            ->when($keyword, fn($q) => $q->where('title', 'like', "%{$keyword}%"))
            ->get();

        foreach ($materials as $m) {
            if (!empty($types) && !in_array('training_material', $types)) continue;
            $results->push((object) [
                'search_type' => 'training_material',
                'title' => $m->title,
                'competency' => $m->competency ?? null,
                'user' => $m->user ?? null,
                'last_modified' => $m->updated_at ?? $m->created_at,
            ]);
        }

        return $results;
    }
}
