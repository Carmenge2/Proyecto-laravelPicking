<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ClienteController extends Controller
{
    use AuthorizesRequests;

    /**
     * Mostrar listado de clientes.
     */
    public function index(Request $request)
    {
        $query = Cliente::with('comercial')
            ->orderBy('nombre_comercial')
            ->orderBy('razon_social');

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function($q) use ($search) {

                $q->where('nombre_comercial', 'like', "%{$search}%")
                  ->orWhere('id', $search)
                  ->orWhere('razon_social', 'like', "%{$search}%");

            });
        }

        $clientes = $query->paginate(10);

        return view('clientes.index', compact('clientes'));
    }

    /**
     * Formulario para crear un cliente nuevo.
     */
    public function create()
    {
        $user = Auth::user();

        if ($user->rol === 'comercial') {

            $comerciales = collect([
                $user->id => $user->name
            ]);

            $comercialSeleccionado = $user->id;

        } else {

            $comerciales = User::whereIn('rol', ['comercial', 'admin'])
                ->pluck('name', 'id');

            $comercialSeleccionado = null;
        }

        return view(
            'clientes.create',
            compact('comerciales', 'comercialSeleccionado')
        );
    }

    /**
     * Valida y almacena el nuevo cliente.
     */
    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        // Si es comercial, asigna automáticamente el comercial logueado
        if (Auth::user()->rol === 'comercial') {
            $data['comercial_id'] = Auth::id();
        }

        Cliente::create($data);

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente creado correctamente.');
    }

    /**
     * Muestra los detalles de un cliente.
     */
    public function show(Cliente $cliente)
    {
        $this->authorize('view', $cliente);

        return view('clientes.show', compact('cliente'));
    }

    /**
     * Formulario para editar un cliente existente.
     */
    public function edit(Cliente $cliente)
    {
        $this->authorize('update', $cliente);

        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Valida y actualiza el cliente.
     */
    public function update(Request $request, Cliente $cliente)
    {
        $this->authorize('update', $cliente);

        $data = $request->validate($this->rules());

        $cliente->update($data);

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente actualizado correctamente.');
    }

    /**
     * Elimina un cliente.
     */
    public function destroy(Cliente $cliente)
    {
        $this->authorize('delete', $cliente);

        $cliente->delete();

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente eliminado correctamente.');
    }

    /**
     * Reglas de validación comunes.
     */
    private function rules(): array
    {
        return [

            'nombre_comercial' => 'required|string|max:20',
            'razon_social'     => 'required|string|max:20',
            'email'            => 'nullable|email|max:30',
            'direccion'        => 'nullable|string|max:50',
            'telefono'         => 'nullable|string|max:9',
            'tipo_negocio'     => 'nullable|string|max:20',
            'comercial_id'     => 'exists:users,id',

        ];
    }
}