<?php

namespace App\Http\Controllers;

use App\Models\Training;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function viewUserInfo($id)
    {
        $training = Training::findOrFail($id);
        return view('adminPanel.viewUserInfo', compact('training'));
    }

    public function viewUserInfoUnprog($id)
    {
        $training = Training::findOrFail($id);
        return view('adminPanel.viewUserInfoUnprog', compact('training'));
    }
} 