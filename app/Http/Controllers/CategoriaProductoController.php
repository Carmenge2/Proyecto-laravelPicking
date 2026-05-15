<?php

namespace App\Http\Controllers;

use App\Models\CategoriasProductos;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Controlador de categorías de productos.
 * Gestiona el catálogo visible para todos los usuarios autenticados
 * y las operaciones CRUD de categorías reservadas al administrador.
 * Incluye gestión de imágenes de categoría.
 */
class CategoriaProductoController extends Controller
{
    /**
     * Muestra el catálogo público con todas las categorías.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $categorias = CategoriasProductos::orderBy('nombre')->get();

        return view('catalogo.index', compact('categorias'));
    }

    /**
     * Muestra los productos asociados a una categoría específica.
     *
     * @param int $id Identificador de la categoría
     * @return \Illuminate\View\View
     */
    public function productos($id)
    {
        $categoriaSeleccionada = CategoriasProductos::findOrFail($id);

        $productos = Producto::where('categoria_id', $id)->get();

        return view('catalogo.productos', compact('categoriaSeleccionada', 'productos'));
    }

    /**
     * Muestra el formulario para crear una nueva categoría.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('categorias.create');
    }

    /**
     * Valida y almacena una nueva categoría.
     * Si se adjunta imagen, la guarda en storage/app/public/categorias.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('categorias', 'public');
        }

        CategoriasProductos::create($data);

        return redirect()->route('catalogo.index')
            ->with('success', 'Categoría creada correctamente.');
    }

    /**
     * Muestra el formulario para editar una categoría existente.
     *
     * @param int $id Identificador de la categoría
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $categoria = CategoriasProductos::findOrFail($id);

        return view('categorias.edit', compact('categoria'));
    }

    /**
     * Valida y actualiza una categoría existente.
     * Reemplaza la imagen anterior si se envía una nueva.
     *
     * @param Request $request
     * @param int $id Identificador de la categoría
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $categoria = CategoriasProductos::findOrFail($id);

        $data = $request->validate($this->rules());

        if ($request->hasFile('imagen')) {
            if ($categoria->imagen) {
                Storage::disk('public')->delete($categoria->imagen);
            }
            $data['imagen'] = $request->file('imagen')->store('categorias', 'public');
        }

        $categoria->update($data);

        return redirect()->route('catalogo.productos', $categoria->id)
            ->with('success', 'Categoría actualizada correctamente');
    }

    /**
     * Elimina una categoría y su imagen asociada del disco.
     *
     * @param int $id Identificador de la categoría
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $categoria = CategoriasProductos::findOrFail($id);

        if ($categoria->imagen) {
            Storage::disk('public')->delete($categoria->imagen);
        }

        $categoria->delete();

        return redirect()->route('catalogo.index')
            ->with('success', 'Categoría eliminada correctamente.');
    }

    /**
     * Reglas de validación comunes para la creación y edición de categorías.
     *
     * @return array<string, string>
     */
    private function rules(): array
    {
        return [
            'nombre' => 'required|string|max:255',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ];
    }
}