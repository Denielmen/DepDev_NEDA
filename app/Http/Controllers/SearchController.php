<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Training; // Example model
use App\Models\User; // Example model
use App\Models\TrainingMaterial; // Import TrainingMaterial model
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SearchExport; // Assuming SearchExport is in App\\\\Exports
use Carbon\Carbon; // Import Carbon for date formatting

class SearchController extends Controller
{
    public function index()
    {
        // Pass an empty collection initially when showing the search form
        return view('search', ['results' => collect()]);
    }

    /**
     * Get the search results data based on the request.
     *
     * @param Request $request
     * @return \Illuminate\Support\Collection
     */
    protected function getSearchResultsData(Request $request)
    {
        $keyword = $request->input('keyword');
        $type = $request->input('type');
        $year = $request->input('year');
        $competencies = $request->input('competencies');

        $trainingResults = collect();
        $userResults = collect();
        $trainingMaterialResults = collect(); // Collection for TrainingMaterial results

        // Search Trainings
        if ($type === 'training' || empty($type)) {
            $trainingQuery = Training::query();

            // Apply keyword search to Training model fields AND related participant fields
            if (!empty($keyword)) {
                $trainingQuery->where(function ($q) use ($keyword) {
                    // Search training's own fields
                    $q->where('title', 'like', '%' . $keyword . '%')
                      ->orWhere('provider', 'like', '%' . $keyword . '%')
                      ->orWhere('superior', 'like', '%' . $keyword . '%')
                      ->orWhere('dev_target', 'like', '%' . $keyword . '%')
                      ->orWhere('performance_goal', 'like', '%' . $keyword . '%')
                      ->orWhere('objective', 'like', '%' . $keyword . '%');

                    // Search related participants' fields (assuming 'participants' relationship exists)
                    // This finds trainings where any participant matches the keyword
                    $q->orWhereHas('participants', function($q) use ($keyword) {
                        $q->where('first_name', 'like', '%' . $keyword . '%')
                          ->orWhere('last_name', 'like', '%' . $keyword . '%')
                          ->orWhere('position', 'like', '%' . $keyword . '%')
                          ->orWhere('division', 'like', '%' . $keyword . '%')
                          ->orWhere('superior', 'like', '%' . $keyword . '%');
                    });
                });
            }

            // Apply Year filter to implementation_date
            if (!empty($year)) {
                $trainingQuery->whereYear('implementation_date', $year);
            }

            // Apply Competencies filter (assuming competency_id column or relationship)
            if (!empty($competencies)) {
                 // If competency_id column exists:
                 $trainingQuery->whereIn('competency_id', $competencies);

                 // If Training has a many-to-many relationship with Competency:
                 // $trainingQuery->whereHas('competencies', function ($q) use ($competencies) {\n                 //     $q->whereIn('competencies.id', $competencies);\n                 // });
            }

            // Eager load relationships if you want to display related data in results
            // $trainingQuery->with(['participants', 'competency']); // Assuming relationships exist

            $trainingResults = $trainingQuery->get();

            // Add a 'type' identifier to results for easier handling in the view
            $trainingResults = $trainingResults->map(function ($item) {
                $item->search_type = 'training';
                return $item;
            });
        }

        // Search Users
        if ($type === 'user' || empty($type)) {
            $userQuery = User::query();

            // Apply keyword search to User model fields AND related training fields
            if (!empty($keyword)) {
                $userQuery->where(function ($q) use ($keyword) {
                    // Search user's own fields
                    $q->where('first_name', 'like', '%' . $keyword . '%')
                      ->orWhere('last_name', 'like', '%' . $keyword . '%')
                      ->orWhere('position', 'like', '%' . $keyword . '%')
                      ->orWhere('division', 'like', '%' . $keyword . '%')
                      ->orWhere('superior', 'like', '%' . $keyword . '%');

                    // Search related trainings' fields (assuming 'trainings' relationship exists)
                    // This finds users who participated in trainings matching the keyword
                    $q->orWhereHas('trainings', function($q) use ($keyword) {
                        $q->where('title', 'like', '%' . $keyword . '%')
                          ->orWhere('provider', 'like', '%' . $keyword . '%')
                          ->orWhere('superior', 'like', '%' . $keyword . '%')
                          ->orWhere('performance_goal', 'like', '%' . $keyword . '%');
                    });
                });
            }

            // Apply Year filter to related trainings' implementation_date
            // This finds users who participated in any training in the specified year
            if (!empty($year)) {
                 $userQuery->whereHas('trainings', function($q) use ($year) {
                     $q->whereYear('implementation_date', $year);
                 });
            }

            // Apply Competencies filter to related trainings' competency_id
            // This finds users who participated in any training with the specified competencies
            if (!empty($competencies)) {
                 $userQuery->whereHas('trainings', function($q) use ($competencies) {
                     // If competency_id column exists on trainings table:
                     $q->whereIn('competency_id', $competencies);

                     // If Training has a many-to-many relationship with Competency:
                     // $q->whereHas('competencies', function ($q) use ($competencies) {\n                     //     $q->whereIn('competencies.id', $competencies);\n                     // });
                 });
            }


            // Eager load relationships if you want to display related data in results
            // $userQuery->with(['trainings', 'department']);

            $userResults = $userQuery->get();

             // Add a 'type' identifier to results for easier handling in the view
            $userResults = $userResults->map(function ($item) {
                $item->search_type = 'user';
                return $item;
            });
        }

        // Search Training Materials
        if ($type === 'training_material' || empty($type)) {
            $trainingMaterialQuery = TrainingMaterial::query();

            // Apply keyword search to TrainingMaterial model fields
            if (!empty($keyword)) {
                $trainingMaterialQuery->where('title', 'like', '%' . $keyword . '%')
                                      ->orWhere('description', 'like', '%' . $keyword . '%')
                                      ->orWhere('file_name', 'like', '%' . $keyword . '%');
            }

            // Apply Competencies filter
            if (!empty($competencies)) {
                 $trainingMaterialQuery->whereIn('competency_id', $competencies);
            }

            // Note: The 'year' filter is not directly applicable to TrainingMaterial
            // based on common fields. If you have a date field (like created_at)
            // you could add a year filter here if needed.

            // Eager load relationships if needed (e.g., competency)
            // $trainingMaterialQuery->with('competency');

            $trainingMaterialResults = $trainingMaterialQuery->get();

            // Add a 'type' identifier to results
            $trainingMaterialResults = $trainingMaterialResults->map(function ($item) {
                $item->search_type = 'training_material';
                return $item;
            });
        }


        // Combine results if no specific type was selected
        if (empty($type)) {
            return $trainingResults->merge($userResults)->merge($trainingMaterialResults);
        } elseif ($type === 'training') {
            return $trainingResults;
        } elseif ($type === 'user') {
            return $userResults;
        } elseif ($type === 'training_material') { // Handle training_material type
            return $trainingMaterialResults;
        }

        return collect(); // Return empty collection if type is invalid
    }

    public function results(Request $request)
    {
        $results = $this->getSearchResultsData($request);

        // Pass the actual results data to the view
        return view('search', compact('results'));
    }

    public function export(Request $request, $format)
    {
        // Get the actual results data for export
        $results = $this->getSearchResultsData($request);

        if ($format === 'pdf') {
            // Pass the actual results data to the PDF view
            // You might need a different PDF view structure to handle mixed results
            $pdf = PDF::loadView('search_results_pdf', compact('results')); // Assuming a dedicated view for PDF
            return $pdf->download('search_results.pdf');
        }

        if ($format === 'excel') {
            // Pass the actual results data to the Excel export class
            // Your SearchExport class will need to handle the mixed data types
            return Excel::download(new SearchExport($results), 'search_results.xlsx');
        }

        // Handle unsupported formats
        abort(400, 'Unsupported export format.');
    }
}
