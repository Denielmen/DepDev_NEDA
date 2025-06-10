<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Training; // Ensure the Training model is imported
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    public function create()
    {
        $users = User::all();
        return view('adminPanel.createTraining', compact('users'));
    }
    public function showTrainingEffectiveness()
    {
        // Fetch trainings from the database
        $trainings = Training::all(); // Adjust query as needed to fetch relevant data

        // Pass the trainings data to the view
        return view('userPanel.trainingEffectiveness', compact('trainings'));
    }
}