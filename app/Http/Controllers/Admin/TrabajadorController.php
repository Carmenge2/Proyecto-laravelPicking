<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TrabajadorController extends Controller
{
    // Mostrar listado de trabajadores con rol 'comercial', con búsqueda y paginación
    public function index(Request $request)
    {
        // Definimos los roles a filtrar (solo 'comercial')
        $roles = ['comercial'];

        // Construimos la consulta base para obtener usuarios con esos roles
        $query = User::whereIn('rol', $roles);

        // Si se envía parámetro de búsqueda, filtramos usuarios por nombre o email que coincidan parcialmente
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email','like', "%{$search}%");
            });
        }

        // Ejecutamos la consulta, ordenamos por fecha de creación descendente, paginamos de 10 en 10,
        // y mantenemos el parámetro 'search' en la paginación
        $trabajadores = $query
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends($request->only('search'));

        // Retornamos la vista con la variable $trabajadores
        return view('admin.trabajadores.index', compact('trabajadores'));
    }

    // Mostrar formulario para crear nuevo trabajador
    public function create()
    {
        // Definimos la lista de roles disponibles (solo 'comercial')
        $roles = ['comercial' => 'Comercial'];
        return view('admin.trabajadores.create', compact('roles'));
    }

    // Guardar nuevo trabajador validando datos
    public function store(Request $request)
    {
        // Validamos datos recibidos del formulario
        $data = $request->validate([
            'name'     => 'required|string|max:200',
            'email'    => 'required|email|unique:users,email', // email único en tabla users
            'rol'      => ['required', Rule::in(['comercial'])], // rol debe ser 'comercial'
            'password' => 'required|min:3|confirmed', // password confirmado (campo password_confirmation)
        ]);

        // Creamos nuevo usuario con los datos validados y encriptamos la contraseña
        User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'rol'      => $data['rol'],
            'password' => bcrypt($data['password']),
        ]);

        // Redireccionamos al listado con mensaje de éxito
        return redirect()->route('admin.trabajadores.index')
                         ->with('success', 'Comercial creado.');
    }

    // Mostrar información detallada de un trabajador específico
    public function show(User $trabajador)
    {
        return view('admin.trabajadores.show', compact('trabajador'));
    }

    // Mostrar formulario para editar un trabajador
    public function edit(User $trabajador)
    {
        // Lista de roles disponibles (solo 'comercial')
        $roles = ['comercial' => 'Comercial'];
        return view('admin.trabajadores.edit', compact('trabajador', 'roles'));
    }

    // Actualizar datos del trabajador validando la información
    public function update(Request $request, User $trabajador)
    {
        // Validamos datos, para email ignoramos el email actual del trabajador para permitir mantenerlo
        $data = $request->validate([
            'name'     => 'required|string|max:200',
            'email'    => ['required', 'email', Rule::unique('users', 'email')->ignore($trabajador->id)],
            'rol'      => ['required', Rule::in(['comercial'])],
            'password' => 'nullable|min:3|confirmed', // password es opcional para actualizar
        ]);

        // Actualizamos los datos básicos
        $trabajador->fill([
            'name'  => $data['name'],
            'email' => $data['email'],
            'rol'   => $data['rol'],
        ]);

        // Si se proporciona password nuevo, se encripta y actualiza
        if (!empty($data['password'])) {
            $trabajador->password = bcrypt($data['password']);
        }

        // Guardamos cambios en base de datos
        $trabajador->save();

        // Redireccionamos al listado con mensaje de éxito
        return redirect()->route('admin.trabajadores.index')
                         ->with('success', 'Comercial actualizado.');
    }

    // Eliminar un trabajador de la base de datos
    public function destroy(User $trabajador)
    {
        $trabajador->delete();

        // Redireccionamos al listado con mensaje de éxito
        return redirect()->route('admin.trabajadores.index')
                         ->with('success', 'Comercial eliminado correctamente.');
    }
}
