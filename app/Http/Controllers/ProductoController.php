<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\CategoriasProductos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    public function index()
    {
        $categorias = CategoriasProductos::orderBy('nombre')->get();
        return view('productos.index', compact('categorias'));
    }

    public function create()
    {
        $categorias = CategoriasProductos::orderBy('nombre')->get();
        $categoriaSeleccionada = request('categoria_id');

        return view('productos.create', compact('categorias', 'categoriaSeleccionada'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255|unique:productos,nombre',
            'descripcion' => 'nullable|string|max:1000',
            'precio' => 'required|numeric|min:0',
            'estado' => 'required|in:disponible,agotado,pre-venta',
            'stock' => 'required|integer|min:0|max:9999',
            'categoria_id' => 'required|exists:categorias_productos,id',
            'imagen' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        $producto = Producto::create($data);

        return redirect()->route('catalogo.productos', $producto->categoria_id)
            ->with('success', 'Producto creado correctamente.');
    }

    public function showPublico(Producto $producto)
    {
        $producto->load('categoria');
        return view('productos.detail', compact('producto'));
    }

    public function edit(Producto $producto)
    {
        $categorias = CategoriasProductos::orderBy('nombre')->get();
        return view('productos.edit', compact('producto', 'categorias'));
    }

    public function update(Request $request, Producto $producto)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255|unique:productos,nombre,' . $producto->id,
            'descripcion' => 'nullable|string|max:1000',
            'precio' => 'required|numeric|min:0',
            'estado' => 'required|in:disponible,agotado,pre-venta',
            'stock' => 'required|integer|min:0|max:9999',
            'categoria_id' => 'required|exists:categorias_productos,id',
            'imagen' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('imagen')) {

            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }

            $data['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        $producto->update($data);

        return redirect()->route('catalogo.productos', $producto->categoria_id)
            ->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Producto $producto)
    {
        if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
        }

        $categoria_id = $producto->categoria_id;

        $producto->delete();

        return redirect()->route('catalogo.productos', $categoria_id)
            ->with('success', 'Producto eliminado correctamente.');
    }
}