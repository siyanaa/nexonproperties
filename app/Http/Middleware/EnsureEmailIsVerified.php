<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Check if the user is authenticated and if their email is verified
        if (Auth::check() && is_null(Auth::user()->email_verified_at)) {
            Auth::logout(); // Log the user out
            return redirect()->route('login')->withErrors(['email' => 'Please verify your email before accessing this page.']);
        }

        return $next($request);
    }
}