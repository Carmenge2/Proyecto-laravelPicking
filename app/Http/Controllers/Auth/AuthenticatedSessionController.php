<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class AuthenticatedSessionController extends Controller
{
    /**
     * Mostrar la vista de login.
     */
    public function create(): View
    {
        // Retorna la vista que muestra el formulario de inicio de sesión
        return view('auth.login');
    }

    /**
     * Manejar una solicitud de autenticación entrante.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Valida y autentica al usuario con los datos del request
        $request->authenticate();

        // Regenera la sesión para evitar fijación de sesión (security best practice)
        $request->session()->regenerate();
        
        // Obtenemos el usuario autenticado
        $user = Auth::user();
        
        // Registramos en log el inicio de sesión con email y rol
        Log::info('Usuario autentificado: ' . $user->email . ' Rol: ' . $user->rol_name);

        // Redirigimos según el rol del usuario
        if ($user->rol === 'admin') {
            Log::info('Redirigiendo a administrador.dashboard');
            return redirect()->intended(route('admin.dashboard'));
        }
        
        if ($user->rol === 'comercial') {
            Log::info('Redirigiendo a comercial.dashboard');
            return redirect()->intended(route('comercial.dashboard'));
        }

        // Si el rol no es ninguno de los esperados, redirige a la raíz
        return redirect('/');
    }

    /**
     * Destruir una sesión autenticada (cerrar sesión).
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Cierra la sesión del usuario en el guard 'web'
        Auth::guard('web')->logout();

        // Invalida la sesión actual para limpiar datos
        $request->session()->invalidate();

        // Genera un nuevo token CSRF para la próxima sesión
        $request->session()->regenerateToken();

        // Redirige al inicio (home) después de cerrar sesión
        return redirect('/');
    }
}
