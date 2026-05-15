<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\CategoriasProductos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Controlador de productos.
 * Gestiona el ciclo completo de vida de los productos del catálogo:
 * listado agrupado por categorías, creación, visualización pública, edición y eliminación.
 * Incluye gestión de imágenes con almacenamiento en disco público.
 */
class ProductoController extends Controller
{
    /**
     * Muestra el panel de productos agrupados por categorías.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $categorias = CategoriasProductos::orderBy('nombre')->get();
        return view('productos.index', compact('categorias'));
    }

    /**
     * Muestra el formulario para crear un nuevo producto.
     * Puede recibir una categoría preseleccionada por query string.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $categorias = CategoriasProductos::orderBy('nombre')->get();
        $categoriaSeleccionada = request('categoria_id');

        return view('productos.create', compact('categorias', 'categoriaSeleccionada'));
    }

    /**
     * Valida y almacena un nuevo producto en el catálogo.
     * Si se adjunta una imagen, la guarda en storage/app/public/productos.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        $producto = Producto::create($data);

        return redirect()->route('catalogo.productos', $producto->categoria_id)
            ->with('success', 'Producto creado correctamente.');
    }

    /**
     * Muestra la ficha pública de un producto dentro del catálogo.
     *
     * @param Producto $producto
     * @return \Illuminate\View\View
     */
    public function showPublico(Producto $producto)
    {
        $producto->load('categoria');
        return view('productos.detail', compact('producto'));
    }

    /**
     * Muestra el formulario para editar un producto existente.
     *
     * @param Producto $producto
     * @return \Illuminate\View\View
     */
    public function edit(Producto $producto)
    {
        $categorias = CategoriasProductos::orderBy('nombre')->get();
        return view('productos.edit', compact('producto', 'categorias'));
    }

    /**
     * Valida y actualiza un producto existente.
     * Si se envía una nueva imagen, elimina la anterior y guarda la nueva.
     *
     * @param Request $request
     * @param Producto $producto
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Producto $producto)
    {
        $data = $request->validate($this->rules($producto));

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

    /**
     * Elimina un producto del catálogo y su imagen asociada del disco.
     *
     * @param Producto $producto
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Reglas de validación comunes para la creación y edición de productos.
     * Si se proporciona un producto existente, excluye su ID de la regla unique.
     *
     * @param Producto|null $producto Producto a excluir de la regla unique (edición)
     * @return array<string, string>
     */
    private function rules(?Producto $producto = null): array
    {
        $uniqueRule = 'unique:productos,nombre' . ($producto ? ',' . $producto->id : '');

        return [
            'nombre'      => 'required|string|max:255|' . $uniqueRule,
            'descripcion' => 'nullable|string|max:1000',
            'precio'      => 'required|numeric|min:0',
            'estado'      => 'required|in:disponible,agotado,pre-venta',
            'stock'       => 'required|integer|min:0|max:9999',
            'categoria_id'=> 'required|exists:categorias_productos,id',
            'imagen'      => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ];
    }
}