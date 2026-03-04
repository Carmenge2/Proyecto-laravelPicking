<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (Auth::check()) {
            // Si el usuario está autenticado, continua la solicitud.
            return $next($request);
        }

        // Si el usuario no está autenticado, redirige a la página de login.
        return redirect()->route('login');
    }
}
