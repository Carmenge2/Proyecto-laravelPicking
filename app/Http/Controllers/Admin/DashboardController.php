<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Controlador del panel de administración.
 * Renderiza la vista del dashboard del administrador.
 */
class DashboardController extends Controller
{
    /**
     * Muestra el panel principal del administrador.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.dashboard');
    }
}
