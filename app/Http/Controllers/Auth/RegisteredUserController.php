<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create()
    {
        // If user is authenticated and not an admin, redirect to home
        if (Auth::check() && Auth::user()->role !== 'Admin') {
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
            'email' => 'required|string|email|max:255|unique:users,email',
            'last_name' => 'required|string|max:50',
            'first_name' => 'required|string|max:50',
            'mid_init' => 'nullable|string|max:10',
            'position' => 'required|string|max:100',
            'position_start_date' => 'required|date|before_or_equal:today',
            'years_in_csc' => 'nullable|integer',
            'government_start_date' => 'required|date|before_or_equal:today',
            'division' => 'required|string|max:100',
            'salary_grade' => 'required|integer',
            'role' => 'required|string|max:50',
            'superior' => 'nullable|string|max:100',
            'password' => 'required|string|min:8|confirmed',
            'is_superior_eligible' => 'boolean',
        ]);

        // Calculate years in government from government_start_date
        $governmentStartDate = new \DateTime($request->government_start_date);
        $today = new \DateTime();
        $yearsInGovernment = $today->diff($governmentStartDate)->y;

        // Log for debugging
        \Log::info('Registration attempt:', [
            'user_id' => $request->user_id,
            'email' => $request->email,
            'years_in_csc_from_form' => $request->years_in_csc,
            'calculated_years' => $yearsInGovernment
        ]);

        // Create the user in the database
        try {
            $user = User::create([
                'user_id' => $request->user_id, // Use the user-provided ID add by Deniel
                'email' => $request->email,
                'last_name' => $request->last_name,
                'first_name' => $request->first_name,
                'mid_init' => $request->mid_init,
                'position' => $request->position,
                'position_start_date' => $request->position_start_date,
                'years_in_csc' => $yearsInGovernment, // Store calculated years from government_start_date
                'government_start_date' => $request->government_start_date,
                'division' => $request->division,
                'salary_grade' => $request->salary_grade,
                'role' => $request->role,
                'superior' => $request->superior,
                'password' => Hash::make($request->password),
                'is_superior_eligible' => $request->boolean('is_superior_eligible'),
            ]);

            \Log::info('User created successfully:', ['user_id' => $user->id, 'email' => $user->email]);
        } catch (\Exception $e) {
            \Log::error('User creation failed:', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);
            return redirect()->back()->withInput()->with('error', 'Registration failed: ' . $e->getMessage());
        }

        // // Update the user_id to include the prefix and the user's ID
        // $user->update([
        //     'user_id' => 'DepDev_' . $user->id,
        // ]);

        // If the user is authenticated (admin), redirect back to participants list
        if (Auth::check()) {
            return redirect()->route('admin.participants')->with('status', 'User registered successfully.');
        }

        // For guest users, redirect to login
        return redirect()->route('login')->with('status', 'Registration successful. Please log in.');
    }
}