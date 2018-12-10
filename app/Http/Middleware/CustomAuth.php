<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CustomAuth {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null) {
        if ($request->session()->get('auth_token') !== null) {
            $user = $request->session()->get('user');
            Auth::login($user);
            if (Auth::user() !== null && Auth::user()->email === 'salvador@gmail.com') {
                return $next($request);
            }
        }
        // if the session does not have 'authenticated' forget the user and redirect to login

        return redirect()->route('login')->withErrors('No tienes permiso para acceder a la página de administración');
    }
}
