<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create()
    {
        // If user is authenticated and not an admin, redirect to home
        if (auth()->check() && auth()->user()->role !== 'Admin') {
            return redirect()->route('user.home');
        }
        
        // If user is admin or guest, show registration form
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|string|unique:users,user_id', // add by deniel
            'last_name' => 'required|string|max:50',
            'first_name' => 'required|string|max:50',
            'mid_init' => 'nullable|string|max:10',
            'position' => 'required|string|max:100',
            'years_in_position' => 'required|integer',
            'years_in_csc' => 'required|integer',
            'division' => 'required|string|max:100',
            'salary_grade' => 'required|integer',
            'role' => 'required|string|max:50',
            'superior' => 'nullable|string|max:100',
            'password' => 'required|string|min:8|confirmed',
            'is_superior_eligible' => 'boolean',
        ]);

        // Create the user in the database
        $user = User::create([
            'user_id' => $request->user_id, // Use the user-provided ID add by Deniel
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'mid_init' => $request->mid_init,
            'position' => $request->position,
            'years_in_position' => $request->years_in_position,
            'years_in_csc' => $request->years_in_csc,
            'division' => $request->division,
            'salary_grade' => $request->salary_grade,
            'role' => $request->role,
            'superior' => $request->superior,
            'password' => Hash::make($request->password),
            'is_superior_eligible' => $request->boolean('is_superior_eligible'),
        ]);

        // // Update the user_id to include the prefix and the user's ID
        // $user->update([
        //     'user_id' => 'DepDev_' . $user->id,
        // ]);

        // If the user is authenticated (admin), redirect back to participants list
        if (auth()->check()) {
            return redirect()->route('admin.participants')->with('status', 'User registered successfully.');
        }

        // For guest users, redirect to login
        return redirect()->route('login')->with('status', 'Registration successful. Please log in.');
    }
}