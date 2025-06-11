<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    // This controller handles the evaluation process for users.
    // It includes methods for displaying the evaluation form and handling submissions.

    /**
     * Display the evaluation form.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('userPanel.evaluation'); // Replace with your actual view
    }

    public function store(Request $request)
    {
        // Handle form submission logic here
    }

    public function evalParticipant()
    {
        return view('userPanel.evalParticipant'); // Replace with your actual view
    }

    public function evalSupervisor()
    {
        return view('userPanel.evalSupervisor'); // Replace with your actual view
    }
}
