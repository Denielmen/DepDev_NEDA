<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class AccountController extends Controller
{
    /**
     * Display a listing of user accounts.
     */
    public function index()
    {
        // Fetch all users
        $users = User::all();

        // Return the view with user data
        return view('adminPanel.accounts', compact('users'));
    }
}
