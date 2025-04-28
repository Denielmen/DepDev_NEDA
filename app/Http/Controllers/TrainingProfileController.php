<?php

namespace App\Http\Controllers;

use App\Models\Training;
use Illuminate\Http\Request;

class TrainingProfileController extends Controller
{
    public function program()
    {
        $trainings = Training::where('type', 'Program')->get();
        return view('userPanel.trainingProfileProgram', compact('trainings'));
    }

    public function unprogrammed()
    {
        $trainings = Training::where('type', 'Unprogrammed')->get();
        return view('userPanel.trainingProfileUnProgram', compact('trainings'));
    }

    public function show($id)
    {
        $training = Training::findOrFail($id);
        return view('userPanel.trainingProfileShow', compact('training'));
    }
} 