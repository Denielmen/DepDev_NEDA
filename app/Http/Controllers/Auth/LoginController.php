<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    // Replace the trait with our own implementation
    protected function username()
    {
        return 'user_id';
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    protected function attemptLogin(Request $request)
    {
        return Auth::attempt(
            $request->only($this->username(), 'password'),
            $request->filled('remember')
        );
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        return redirect()->intended($this->redirectTo);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    protected function incrementLoginAttempts(Request $request)
    {
        // Implementation for throttling if needed
    }

    protected $redirectTo = RouteServiceProvider::HOME;

    public function login(Request $request)
    {
        $this->validateLogin($request);

        // Check if the user exists and is active
        $user = User::where($this->username(), $request->{$this->username()})->first();
        
        if ($user && !$user->is_active) {
            Log::info('Login attempt by inactive user: ' . $user->id);
            
            // Throw validation exception for inactive user
            throw ValidationException::withMessages([
                $this->username() => ['Your account has been disabled. Please contact the administrator.'],
            ]);
        }

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            event(new \Illuminate\Auth\Events\Lockout($request));

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }

            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }

    protected function sendLockoutResponse(Request $request)
    {
        $seconds = RateLimiter::availableIn($this->throttleKey($request));

        throw ValidationException::withMessages([
            $this->username() => [trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ])],
        ])->status(Response::HTTP_TOO_MANY_REQUESTS);
    }

    protected function throttleKey(Request $request)
    {
        return Str::lower($request->{$this->username()}).'|'.$request->ip();
    }
}