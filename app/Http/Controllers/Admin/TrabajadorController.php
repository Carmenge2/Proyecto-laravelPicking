<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

/**
 * Controlador de trabajadores (comerciales).
 * Gestiona el CRUD de usuarios con rol comercial desde el panel de administración.
 * Incluye búsqueda, paginación y asignación automática de contraseña por defecto.
 */
class TrabajadorController extends Controller
{
    /**
     * Muestra el listado paginado de comerciales con búsqueda por nombre o email.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = User::where('rol', 'comercial');

        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email','like', "%{$search}%");
            });
        }

        $trabajadores = $query
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends($request->only('search'));

        return view('admin.trabajadores.index', compact('trabajadores'));
    }

    /**
     * Muestra el formulario para crear un nuevo comercial.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.trabajadores.create');
    }

    /**
     * Valida y crea un nuevo usuario con rol comercial y contraseña por defecto.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'rol'      => 'comercial', // 🔥 fijo
            'password' => bcrypt('123'), // 🔥 contraseña por defecto
        ]);

        return redirect()->route('admin.trabajadores.index')
                         ->with('success', 'Comercial creado correctamente.');
    }

    /**
     * Muestra la ficha de un comercial.
     *
     * @param User $trabajador
     * @return \Illuminate\View\View
     */
    public function show(User $trabajador)
    {
        return view('admin.trabajadores.show', compact('trabajador'));
    }

    /**
     * Muestra el formulario para editar un comercial existente.
     *
     * @param User $trabajador
     * @return \Illuminate\View\View
     */
    public function edit(User $trabajador)
    {
        return view('admin.trabajadores.edit', compact('trabajador'));
    }

    /**
     * Valida y actualiza los datos de un comercial existente.
     *
     * @param Request $request
     * @param User $trabajador
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $trabajador)
    {
        $data = $request->validate($this->rules($trabajador));

        $trabajador->update([
            'name'  => $data['name'],
            'email' => $data['email'],
        ]);

        return redirect()->route('admin.trabajadores.index')
                         ->with('success', 'Comercial actualizado correctamente.');
    }

    /**
     * Elimina un comercial del sistema.
     *
     * @param User $trabajador
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $trabajador)
    {
        $trabajador->delete();

        return redirect()->route('admin.trabajadores.index')
                         ->with('success', 'Comercial eliminado correctamente.');
    }

    /**
     * Reglas de validación comunes para la creación y edición de comerciales.
     *
     * @param User|null $trabajador Usuario a excluir de la regla unique (edición)
     * @return array<string, string|array>
     */
    private function rules(?User $trabajador = null): array
    {
        return [
            'name'  => 'required|string|max:' . ($trabajador ? 200 : 20),
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($trabajador?->id),
            ],
        ];
    }
}