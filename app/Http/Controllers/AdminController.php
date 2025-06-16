<?php

namespace App\Http\Controllers;

use App\Models\Training;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TrainingsExport;

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
        $users = User::all();
        $positions = User::distinct()->pluck('position')->filter()->values()->toArray();

        return view('adminPanel.listOfUser', compact('users', 'positions'));
    }
} 