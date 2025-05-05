<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Training; // Example model
use App\Models\User; // Example model
use PDF;
use Maatwebsite\Excel\Facades\Excel;

class SearchController extends Controller
{
    public function index()
    {
        return view('search');
    }

    public function results(Request $request)
    {
        $query = $request->input();

        // Example query logic
        $results = Training::query()
            ->when($query['type'] === 'training', function ($q) {
                return $q->whereNotNull('training_name');
            })
            ->when($query['type'] === 'user', function ($q) {
                return User::query();
            })
            ->when($query['start_date'], function ($q) use ($query) {
                return $q->where('date', '>=', $query['start_date']);
            })
            ->when($query['end_date'], function ($q) use ($query) {
                return $q->where('date', '<=', $query['end_date']);
            })
            ->when($query['competencies'], function ($q) use ($query) {
                return $q->whereIn('competency', $query['competencies']);
            })
            ->get();

        return view('search', compact('results'));
    }

    public function export(Request $request, $format)
    {
        $results = $this->results($request);

        if ($format === 'pdf') {
            $pdf = PDF::loadView('search', compact('results'));
            return $pdf->download('search_results.pdf');
        }

        if ($format === 'excel') {
            return Excel::download(new SearchExport($results), 'search_results.xlsx');
        }
    }
}