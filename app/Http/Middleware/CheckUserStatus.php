<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is logged in
        if (Auth::check()) {
            $user = Auth::user();
            
            // Log for debugging
            Log::info('CheckUserStatus middleware running for user: ' . $user->id . ', is_active: ' . ($user->is_active ? 'true' : 'false'));
            
            if (!$user->is_active) {
                // Log out the user
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                // Redirect to login with message
                return redirect()->route('login')
                    ->with('error', 'Your account has been disabled. Please contact the administrator.');
            }
        }

        return $next($request);
    }
}

