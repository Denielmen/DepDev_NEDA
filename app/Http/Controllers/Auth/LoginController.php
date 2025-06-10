<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle the login request.
     */
    public function login(Request $request)
    {
        // Validate the user_id and password fields
        $request->validate([
            'user_id' => 'required|string',
            'password' => 'required|string',
        ]);

        // Attempt to authenticate using user_id, password, and active status
        if (Auth::attempt(['user_id' => $request->user_id, 'password' => $request->password, 'is_active' => true])) {
            $request->session()->regenerate();
            // Redirect to the home route
            return redirect()->route('home');
        }

        // Return back with an error if authentication fails
        return back()->withErrors([
            'user_id' => 'The provided credentials do not match our records.',
        ]);
    }
}
