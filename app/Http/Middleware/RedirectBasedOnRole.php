<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RedirectBasedOnRole
{
    public function handle(Request $request, Closure $next, ?string $roles = null): Response
    {
        // Si es la ruta genérica "dashboard"
        if ($request->routeIs('dashboard') && Auth::check()) {
            return Auth::user()->rol === 'admin'
                ? redirect()->route('admin.dashboard')
                : redirect()->route('comercial.dashboard');
        }

        // Si nos pasaron roles como "admin|comercial" o "admin,comercial"
        if ($roles && Auth::check()) {
            // creamos un array de roles permitidos
            $allowed = preg_split('/[|,]/', $roles);
            if (! in_array(Auth::user()->rol, $allowed, true)) {
                // rol NO permitido: redirigimos al suyo
                return Auth::user()->rol === 'admin'
                    ? redirect()->route('admin.dashboard')
                    : redirect()->route('comercial.dashboard');
            }
        }

        return $next($request);
    }
}
