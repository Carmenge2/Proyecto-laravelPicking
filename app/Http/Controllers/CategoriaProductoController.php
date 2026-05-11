<?php

namespace App\Http\Controllers;

use App\Models\CategoriasProductos;
use App\Models\Producto;
use Illuminate\Http\Request;

class CategoriaProductoController extends Controller
{
    // LISTADO DE CATEGORÍAS
    public function index()
    {
        $categorias = CategoriasProductos::orderBy('nombre')->get();

        return view('catalogo.index', compact('categorias'));
    }

    // PRODUCTOS DE UNA CATEGORÍA
    public function productos($id)
    {
        $categoriaSeleccionada = CategoriasProductos::findOrFail($id);

        $productos = Producto::where('categoria_id', $id)->get();

        return view('catalogo.productos', compact('categoriaSeleccionada', 'productos'));
    }

    // FORMULARIO CREAR
    public function create()
    {
        return view('categorias.create');
    }

    // GUARDAR NUEVA CATEGORÍA
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'imagen' => 'nullable|image|max:2048',
        ], [
            'required' => 'Debes completar los campos obligatorios.',
        ]);

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('categorias', 'public');
        }

        CategoriasProductos::create($data);

        return redirect()->route('catalogo.index')
            ->with('success', 'Categoría creada correctamente.');
    }

    // FORMULARIO EDITAR
    public function edit($id)
    {
        $categoria = CategoriasProductos::findOrFail($id);

        return view('categorias.edit', compact('categoria'));
    }

    // ACTUALIZAR CATEGORÍA
    public function update(Request $request, $id)
    {
        $categoria = CategoriasProductos::findOrFail($id);

        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'imagen' => 'nullable|image|max:2048',
        ], [
            'required' => 'Debes completar los campos obligatorios.',
        ]);

        // Si sube nueva imagen, la guardamos
        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('categorias', 'public');
        }

        $categoria->update($data);

       return redirect()->route('catalogo.productos', $categoria->id)
        ->with('success', 'Categoría actualizada correctamente');
    }

    // ELIMINAR CATEGORÍA
    public function destroy($id)
    {
        $categoria = CategoriasProductos::findOrFail($id);

        $categoria->delete();

        return redirect()->route('catalogo.index')
            ->with('success', 'Categoría eliminada correctamente.');
    }
}