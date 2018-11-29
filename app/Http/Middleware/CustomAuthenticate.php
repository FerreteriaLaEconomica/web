<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CustomAuthenticate {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null) {
        // if the session does not have 'authenticated' forget the user and redirect to login
        if ($request->session()->get('auth_token') !== null) {
            $user = $request->session()->get('user');
            Auth::login($user);
            return $next($request);
        }
        $request->session()->forget('auth_token');
        $request->session()->forget('user');
        return redirect()->route('login')->withErrors('Your session has expired.');
    }
}
