<?php

namespace App\Http\Controllers\Auth;

use App\Models\History;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\UtilityFunctions;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Override credentials method to include email verification check
     */
    protected function credentials(Request $request)
    {
        // Check if the email_verified_at field is not null
        return $request->only($this->username(), 'password');
    }

    /**
     * Customize the login failed response to give specific feedback
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $errors = [$this->username() => trans('auth.failed')];

        // Check if the user exists but is not verified
        if ($user = \App\Models\User::where($this->username(), $request->{$this->username()})->first()) {
            if (is_null($user->email_verified_at)) {
                // Provide a specific message when the email is not verified
                $errors = [$this->username() => 'Your email is not verified. Please verify your email to continue.'];
            }
        }

        throw ValidationException::withMessages($errors);
    }

    /**
     * Custom handling after successful authentication
     */
    protected function authenticated(Request $request, $user)
    {
        // Ensure the email is verified before allowing login
        if (is_null($user->email_verified_at)) {
            Auth::logout();
            return redirect()->route('login')->withErrors(['email' => 'Please verify your email before logging in.']);
        }
    
        // Log the login event if the email is verified
        History::create([
            'description' => 'Logged in',
            'user_id' => $user->id,
            'type' => 0,
            'ip_address' => UtilityFunctions::getuserIP()
        ]);
    
        // Redirect based on user role
        if ($user->role_id == 3) {
            return redirect()->route('index'); 
        } else {
            return redirect()->route('admin.index'); 
        }
    }
    /**
     * Logout the user and log the event
     */
    public function logout()
    {
        if (Auth::check()) {
            History::create([
                'description' => 'Logged out',
                'user_id' => Auth::user()->id,
                'type' => 0,
                'ip_address' => UtilityFunctions::getuserIP()
            ]);
        }
        Auth::logout();
        return redirect('/login')->with('status', 'Successfully logged out.');
    }
}