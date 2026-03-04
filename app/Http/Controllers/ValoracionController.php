<?php

namespace App\Http\Controllers;

use App\Models\Valoracion;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ValoracionController extends Controller
{
    /**
     * Mostrar listado de valoraciones, con filtro opcional por puntuación.
     */
    public function index(Request $request)
    {
        $query = Valoracion::with('cliente')->orderBy('created_at', 'desc');

        if ($request->filled('valoracion')) {
            $query->where('valoracion', $request->valoracion);
        }

        $valoraciones = $query->paginate(10)
                              ->appends($request->only('valoracion'));

        return view('valoraciones.index', compact('valoraciones'));
    }

    /**
     * Formulario para crear una nueva valoración.
     */
    public function create()
    {
        $clientes = Cliente::orderBy('nombre_comercial')->get();
        return view('valoraciones.create', compact('clientes'));
    }

    /**
     * Almacena una valoración nueva.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'valoracion' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string',
        ], [
            'cliente_id.required' => 'El campo cliente es obligatorio.',
            'cliente_id.exists'   => 'El cliente seleccionado no es válido.',
        ]);

        Valoracion::create($data);

        return redirect()
            ->route('valoraciones.index')
            ->with('success', 'Valoración creada correctamente.');
    }

    /**
     * Muestra una valoración concreta.
     */
    public function show(Valoracion $valoracion)
    {
        $valoracion->load('cliente');
        return view('valoraciones.show', compact('valoracion'));
    }

    /**
     * Formulario para editar una valoración existente.
     */
    public function edit(Valoracion $valoracion)
    {
        $clientes = Cliente::orderBy('nombre_comercial')->get();
        return view('valoraciones.edit', compact('valoracion', 'clientes'));
    }

    /**
     * Actualiza la valoración.
     */
    public function update(Request $request, Valoracion $valoracion)
    {
               $data = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'valoracion' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string',
        ], [
            'cliente_id.required' => 'El campo cliente es obligatorio.',
            'cliente_id.exists'   => 'El cliente seleccionado no es válido.',
        ]);


        $valoracion->update($data);

        return redirect()
            ->route('valoraciones.index')
            ->with('success', 'Valoración actualizada correctamente.');
    }

    /**
     * Elimina una valoración.
     */
    public function destroy(Valoracion $valoracion)
    {
        $valoracion->delete();

        return redirect()
            ->route('valoraciones.index')
            ->with('success', 'Valoración eliminada correctamente.');
    }
}

