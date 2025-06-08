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
        
        $results = collect();

        // If no types specified, search all types
        if (empty($types)) {
            $types = ['Training', 'User', 'Training Material'];
        }

        // Search users
        if (in_array('User', $types)) {
            $users = User::query()
                ->when($query, function($q) use ($query) {
                    $q->where(function($q) use ($query) {
                        $q->where('first_name', 'like', "%{$query}%")
                          ->orWhere('last_name', 'like', "%{$query}%");
                    });
                })
                ->when($division, function($q) use ($division) {
                    $q->where('division', $division);
                })
                ->when($position, function($q) use ($position) {
                    $q->where('position', $position);
                })
                ->get()
                ->map(function($user) {
                    $user->search_type = 'user';
                    return $user;
                });
            $results = $results->concat($users);
        }
// Search trainings
if (in_array('Training', $types)) {
    $trainings = Training::query()
        ->with('trainingMaterials') // Eager load trainingMaterials
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
        ->when($year, function ($q) use ($year) {
            $q->where(function ($q) use ($year) {
                $q->whereYear('period_from', '<=', $year)
                  ->whereYear('period_to', '>=', $year);
            });
        })
        ->when($competencies, function ($q) use ($competencies) {
            $q->whereIn('competency_id', $competencies);
        })
        ->with('participants') // Eager load participants
        ->get()
        ->map(function ($training) {
            $training->search_type = 'training';

            // Map participants
            $training->participants = $training->participants->map(function ($participant) {
                return [
                    'id' => $participant->id,
                    'name' => $participant->first_name . ' ' . $participant->last_name,
                ];
            });

            // Include training materials uploaded by users that match the training title and source
            $training->relatedMaterials = TrainingMaterial::query()
                ->where('title', 'like', "%{$training->title}%") // Match materials by title
                ->where('source', 'like', "%{$training->source}%") // Verify source matches
                ->get();

            return $training;
        });

    $results = $results->concat($trainings);
}

        // Search training materials
        if (in_array('Training Material', $types)) {
            $materials = TrainingMaterial::query()
                ->when($query, function($q) use ($query) {
                    $q->where(function($q) use ($query) {
                        $q->where('title', 'like', "%{$query}%")
                          ->orWhereHas('competency', function($subQ) use ($query) {
                              $subQ->where('name', 'like', "%{$query}%");
                          })
                          ->orWhereHas('training', function($subQ) use ($query) {
                              $subQ->where('title', 'like', "%{$query}%");
                          });
                    });
                })
                ->when($competencies, function($q) use ($competencies) {
                    $q->whereIn('competency_id', $competencies);
                })
                ->get()
                ->map(function($material) {
                    $material->search_type = 'training_material';
                    return $material;
                });
            $results = $results->concat($materials);
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
        // Get the search results
        $results = $this->results($request);
        
        if ($format === 'pdf') {
            $competencies = Competency::all();
            $pdf = PDF::loadView('search', ['competencies' => $competencies, 'results' => $results]);
            return $pdf->download('search-results.pdf');
        } else if ($format === 'excel') {
            return Excel::download(new SearchExport($results), 'search-results.xlsx');
        }
        
        return back()->with('error', 'Invalid export format');
    }
}