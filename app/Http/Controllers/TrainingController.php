<?php

namespace App\Http\Controllers;

use App\Models\Training;
use App\Models\User;
use App\Models\ParticipationType;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    public function create()
    {
        // Only get active users for participant selection
        $users = User::where('is_active', true)->orderBy('last_name')->get();
        $participationTypes = ParticipationType::all();
        return view('adminPanel.createTraining', compact('users', 'participationTypes'));
    }

    public function addParticipants($trainingId)
    {
        $training = Training::findOrFail($trainingId);

        // Only get active users
        $availableUsers = User::where('is_active', true)
                              ->orderBy('last_name')
                              ->get();

        return view('training.add_participants', compact('training', 'availableUsers'));
    }
}
