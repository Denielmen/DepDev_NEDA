<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Training; // Example model
use App\Models\User; // Example model
use App\Models\TrainingMaterial; // Import TrainingMaterial model
use App\Models\Competency; // Import Competency model
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SearchExport; // Assuming SearchExport is in App\\Exports
use Carbon\Carbon; // Import Carbon for date formatting
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class SearchController extends Controller
{
    public function index()
    {
        // Get unique divisions for the filter
        $divisions = User::select('division')->distinct()->pluck('division');
        
        // Initialize empty results collection
        $results = new Collection();
        
        return view('search', compact('divisions', 'results'));
    }

    public function results(Request $request)
    {
        $query = $request->input('keyword');
        $type = $request->input('type');
        $year = $request->input('year');
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        $competencies = $request->input('competencies', []);
        $user_id = $request->input('user_id');
        $participation_type = $request->input('participation_type');
        
        $results = collect();

        // If no type specified, search all types
        if (empty($type)) {
            // Search users based on name or supervisor
            $users = User::query()
                ->when($query, function($q) use ($query) {
                    $q->where(function($q) use ($query) {
                        $q->where('first_name', 'like', "%{$query}%")
                          ->orWhere('last_name', 'like', "%{$query}%")
                          ->orWhere('superior', 'like', "%{$query}%")
                          ->orWhere('position', 'like', "%{$query}%");
                    });
                })
                ->when($user_id, function($q) use ($user_id) {
                    $q->where('id', $user_id);
                })
                ->get()
                ->map(function($user) {
                    $user->search_type = 'user';
                    return $user;
                });
            $results = $results->concat($users);

            // Search trainings based on various criteria
            $trainings = Training::query()
                ->when($query, function($q) use ($query) {
                    $q->where(function($q) use ($query) {
                        $q->where('title', 'like', "%{$query}%")
                          ->orWhereHas('participants', function($subQ) use ($query) {
                              $subQ->where(function($subQ) use ($query) {
                                  $subQ->where('first_name', 'like', "%{$query}%")
                                      ->orWhere('last_name', 'like', "%{$query}%")
                                      ->orWhere('participation_type', 'like', "%{$query}%");
                              });
                          })
                          ->orWhereHas('competency', function($subQ) use ($query) {
                              $subQ->where('name', 'like', "%{$query}%");
                          });
                    });
                })
                ->when($year, function($q) use ($year) {
                    $q->whereYear('implementation_date_from', $year);
                })
                ->when($dateFrom, function($q) use ($dateFrom) {
                    $q->where('implementation_date_from', '>=', $dateFrom);
                })
                ->when($dateTo, function($q) use ($dateTo) {
                    $q->where('implementation_date_from', '<=', $dateTo);
                })
                ->when($competencies, function($q) use ($competencies) {
                    $q->whereIn('competency_id', $competencies);
                })
                ->when($participation_type, function($q) use ($participation_type) {
                    $q->whereHas('participants', function($subQ) use ($participation_type) {
                        $subQ->where('participation_type', $participation_type);
                    });
                })
                ->get()
                ->map(function($training) {
                    $training->search_type = 'training';
                    return $training;
                });
            $results = $results->concat($trainings);

            // Search training materials
            $materials = TrainingMaterial::query()
                ->when($query, function($q) use ($query) {
                    $q->where(function($q) use ($query) {
                        $q->where('file_name', 'like', "%{$query}%")
                          ->orWhereHas('user', function($subQ) use ($query) {
                              $subQ->where(function($subQ) use ($query) {
                                  $subQ->where('first_name', 'like', "%{$query}%")
                                       ->orWhere('last_name', 'like', "%{$query}%")
                                       ->orWhere('superior', 'like', "%{$query}%")
                                       ->orWhere('position', 'like', "%{$query}%");
                              });
                          })
                          ->orWhereHas('competency', function($subQ) use ($query) {
                              $subQ->where('name', 'like', "%{$query}%");
                          })
                          ->orWhereHas('training', function($subQ) use ($query) {
                              $subQ->where('title', 'like', "%{$query}%")
                                   ->orWhereHas('participants', function($subQ) use ($query) {
                                       $subQ->where(function($subQ) use ($query) {
                                           $subQ->where('first_name', 'like', "%{$query}%")
                                                ->orWhere('last_name', 'like', "%{$query}%")
                                                ->orWhere('participation_type', 'like', "%{$query}%");
                                       });
                                   });
                          });
                    });
                })
                ->get()
                ->map(function($material) {
                    $material->search_type = 'material';
                    return $material;
                });
            $results = $results->concat($materials);

        } else { // Specific type search
            if ($type === 'user') {
                $users = User::query()
                    ->when($query, function($q) use ($query) {
                        $q->where(function($q) use ($query) {
                            $q->where('first_name', 'like', "%{$query}%")
                              ->orWhere('last_name', 'like', "%{$query}%")
                              ->orWhere('superior', 'like', "%{$query}%")
                              ->orWhere('position', 'like', "%{$query}%");
                        });
                    })
                    ->when($user_id, function($q) use ($user_id) {
                        $q->where('id', $user_id);
                    })
                    ->get()
                    ->map(function($user) {
                        $user->search_type = 'user';
                        return $user;
                    });
                $results = $results->concat($users);
            }

            if ($type === 'training') {
                $trainings = Training::query()
                    ->when($query, function($q) use ($query) {
                        $q->where(function($q) use ($query) {
                            $q->where('title', 'like', "%{$query}%")
                              ->orWhereHas('participants', function($subQ) use ($query) {
                                  $subQ->where(function($subQ) use ($query) {
                                      $subQ->where('first_name', 'like', "%{$query}%")
                                          ->orWhere('last_name', 'like', "%{$query}%")
                                          ->orWhere('participation_type', 'like', "%{$query}%");
                                  });
                              })
                              ->orWhereHas('competency', function($subQ) use ($query) {
                                  $subQ->where('name', 'like', "%{$query}%");
                              });
                        });
                    })
                    ->when($year, function($q) use ($year) {
                        $q->whereYear('implementation_date_from', $year);
                    })
                    ->when($dateFrom, function($q) use ($dateFrom) {
                        $q->where('implementation_date_from', '>=', $dateFrom);
                    })
                    ->when($dateTo, function($q) use ($dateTo) {
                        $q->where('implementation_date_to', '<=', $dateTo);
                    })
                    ->when($competencies, function($q) use ($competencies) {
                        $q->whereIn('competency_id', $competencies);
                    })
                    ->when($participation_type, function($q) use ($participation_type) {
                        $q->whereHas('participants', function($subQ) use ($participation_type) {
                            $subQ->where('participation_type', $participation_type);
                        });
                    })
                    ->get()
                    ->map(function($training) {
                        $training->search_type = 'training';
                        return $training;
                    });
                $results = $results->concat($trainings);
            }

            if ($type === 'material') {
                $materials = TrainingMaterial::query()
                    ->when($query, function($q) use ($query) {
                        $q->where(function($q) use ($query) {
                            $q->where('uploader_name', 'like', "%{$query}%")
                              ->orWhereHas('competency', function($subQ) use ($query) {
                                  $subQ->where('name', 'like', "%{$query}%");
                              })
                              ->orWhereHas('training', function($subQ) use ($query) {
                                  $subQ->where('title', 'like', "%{$query}%");
                              })
                              ->orWhere('filename', 'like', "%{$query}%");
                        });
                    })
                    ->get()
                    ->map(function($material) {
                        $material->search_type = 'material';
                        return $material;
                    });
                $results = $results->concat($materials);
            }
        }

        return view('search', [
            'results' => $results,
            'divisions' => User::select('division')->distinct()->pluck('division')
        ]);
    }

    public function export(Request $request, $format)
    {
        // Get the search results
        $results = $this->results($request);
        
        if ($format === 'pdf') {
            $pdf = PDF::loadView('search.export', ['results' => $results]);
            return $pdf->download('search-results.pdf');
        } else if ($format === 'excel') {
            return Excel::download(new SearchExport($results), 'search-results.xlsx');
        }
        
        return back()->with('error', 'Invalid export format');
    }
}
