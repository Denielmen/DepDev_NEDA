<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'last_name' => 'required|string|max:50',
            'first_name' => 'required|string|max:50',
            'mid_init' => 'nullable|string|max:10',
            'position' => 'required|string|max:100',
            'office' => 'required|string|max:100',
            'years_in_position' => 'required|integer',
            'years_in_csc' => 'required|integer',
            'division' => 'required|string|max:100',
            'salary_grade' => 'required|integer',
            'role' => 'required|string|max:50',
            'superior' => 'nullable|string|max:100',
        ]);

        // Create the user
        User::create([
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'mid_init' => $request->mid_init,
            'position' => $request->position,
            'office' => $request->office,
            'years_in_position' => $request->years_in_position,
            'years_in_csc' => $request->years_in_csc,
            'division' => $request->division,
            'salary_grade' => $request->salary_grade,
            'role' => $request->role,
            'superior' => $request->superior,
            'password' => Hash::make('defaultpassword'), // Replace with actual password logic
        ]);

        return redirect()->route('login')->with('status', 'Registration successful. Please log in.');
    }
}