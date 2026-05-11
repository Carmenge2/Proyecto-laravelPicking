<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TrabajadorController extends Controller
{
    // LISTADO
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

    // FORMULARIO CREAR
    public function create()
    {
        return view('admin.trabajadores.create');
    }

    // GUARDAR
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:200',
            'email' => 'required|email|unique:users,email',
        ]);

        User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'rol'      => 'comercial', // 🔥 fijo
            'password' => bcrypt('123'), // 🔥 contraseña por defecto
        ]);

        return redirect()->route('admin.trabajadores.index')
                         ->with('success', 'Comercial creado correctamente.');
    }

    // VER
    public function show(User $trabajador)
    {
        return view('admin.trabajadores.show', compact('trabajador'));
    }

    // FORMULARIO EDITAR
    public function edit(User $trabajador)
    {
        return view('admin.trabajadores.edit', compact('trabajador'));
    }

    // ACTUALIZAR
    public function update(Request $request, User $trabajador)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:200',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($trabajador->id)],
        ]);

        $trabajador->update([
            'name'  => $data['name'],
            'email' => $data['email'],
        ]);

        return redirect()->route('admin.trabajadores.index')
                         ->with('success', 'Comercial actualizado correctamente.');
    }

    // ELIMINAR
    public function destroy(User $trabajador)
    {
        $trabajador->delete();

        return redirect()->route('admin.trabajadores.index')
                         ->with('success', 'Comercial eliminado correctamente.');
    }
}