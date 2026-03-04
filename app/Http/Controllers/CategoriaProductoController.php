<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\CategoriasProductos;
use App\Models\Producto;

class CategoriaProductoController extends Controller
{
    // INDEX → muestra las categorías (círculos)
public function index(Request $request)
{
    $categorias = CategoriasProductos::orderBy('nombre')->get();

    $productos = null;

    if ($request->categoria) {
        $productos = Producto::where('categoria_id', $request->categoria)->get();
    }

    return view('catalogo.index', compact('categorias', 'productos'));
}
}

