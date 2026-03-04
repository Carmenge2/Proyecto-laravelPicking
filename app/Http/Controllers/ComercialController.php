<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ComercialController extends Controller
{
    // Este método será el que se ejecuta cuando un comercial accede a /comercial/dashboard
    public function index()
    {
        // Retorna la vista del dashboard de comerciales
        return view('comercial.dashboard');  // Aquí, crea una vista en resources/views/comercial/dashboard.blade.php
    }
}
