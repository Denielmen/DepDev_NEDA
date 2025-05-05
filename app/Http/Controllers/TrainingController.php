<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    public function create()
    {
        $users = User::all();
        return view('adminPanel.createTraining', compact('users'));
    }
} 