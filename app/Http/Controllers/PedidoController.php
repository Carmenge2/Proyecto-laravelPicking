<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    // Lista los pedidos con filtros y paginación
    public function index(Request $request)
    {
        // Cargamos relaciones cliente, productos y comercial
        $query = Pedido::with(['cliente', 'productos', 'comercial'])
                    ->orderByDesc('created_at');

        //  Filtro por cliente (nombre o razón social)
        if ($request->filled('search')) {
            $search = $request->search;

            $query->whereHas('cliente', function ($q) use ($search) {
                $q->where('nombre_comercial', 'like', "%{$search}%")
                ->orWhere('razon_social', 'like', "%{$search}%");
            });
        }

        //  Filtro por fecha
        if ($request->filled('fecha')) {
            $query->whereDate('fecha', $request->fecha);
        }

        //  Filtro por estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        //  Paginación con filtros persistentes
        $pedidos = $query->paginate(10)->appends($request->all());

        return view('pedidos.index', compact('pedidos'));
    }

    // Mostrar formulario para crear un nuevo pedido
    public function create()
    {
        // Obtenemos todos los clientes y productos ordenados para el formulario
        $clientes = Cliente::orderBy('nombre_comercial')->get();
        $productos = Producto::orderBy('nombre')->get();

        return view('pedidos.create', compact('clientes', 'productos'));
    }

    // Guardar un pedido nuevo en la base de datos
    public function store(Request $request)
    {
        // Validamos los datos recibidos
        $data = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'productos'  => 'required|array',
            'productos.*.selected' => 'nullable|in:1', // El producto está seleccionado si viene marcado
            'productos.*.cantidad' => 'required_with:productos.*.selected|integer|min:1', // Cantidad requerida solo si está seleccionado
            'fecha'      => 'required|date',
            'estado'     => 'required|in:pendiente,entregado,cancelado',
        ]);

        // Filtramos solo los productos seleccionados con su cantidad
        $productosSeleccionados = collect($data['productos'])
            ->filter(fn($producto) => isset($producto['selected']) && $producto['selected'] == 1)
            ->mapWithKeys(fn($producto, $id) => [(int)$id => ['cantidad' => $producto['cantidad']]]);

        // Validamos que haya al menos un producto seleccionado
        if ($productosSeleccionados->isEmpty()) {
            return back()->withErrors(['productos' => 'Debe seleccionar al menos un producto con cantidad válida.'])->withInput();
        }

        // Calculamos el total sumando precio por cantidad de cada producto
        $total = 0;
        foreach ($productosSeleccionados as $productoId => $info) {
            $producto = Producto::findOrFail($productoId);
            $total += $producto->precio * $info['cantidad'];
        }

        // Asignamos el comercial que crea el pedido (usuario autenticado)
        $comercialId = auth()->check() ? auth()->id() : null;

        // Creamos el pedido en la base de datos
        $pedido = Pedido::create([
            'cliente_id' => $data['cliente_id'],
            'fecha'      => $data['fecha'],
            'estado'     => $data['estado'],
            'total'      => $total,
            'comercial_id' => $comercialId,
        ]);

        // Asociamos los productos con sus cantidades al pedido (tabla pivot)
        $pedido->productos()->attach($productosSeleccionados->toArray());

        // Redirigimos con mensaje de éxito
        return redirect()->route('pedidos.index')
                         ->with('success', 'Pedido creado correctamente.');
    }

    // Mostrar detalle de un pedido
    public function show(Pedido $pedido)
    {
        // Cargamos relaciones necesarias para la vista
        $pedido->load(['cliente', 'productos', 'comercial']);

        return view('pedidos.show', compact('pedido'));
    }

    // Mostrar formulario para editar un pedido existente
    public function edit(Pedido $pedido)
    {
        // Obtenemos clientes y productos para el formulario
        $clientes = Cliente::orderBy('nombre_comercial')->get();
        $productos = Producto::orderBy('nombre')->get();

        return view('pedidos.edit', compact('pedido', 'clientes', 'productos'));
    }

    // Actualizar un pedido en la base de datos
    public function update(Request $request, Pedido $pedido)
    {
        // Validamos datos similares a store()
        $data = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'productos'  => 'required|array',
            'productos.*.selected' => 'nullable|in:1',
            'productos.*.cantidad' => 'required_with:productos.*.selected|integer|min:1',
            'fecha'      => 'required|date',
            'estado'     => 'required|in:pendiente,entregado,cancelado',
        ]);

        // Filtramos productos seleccionados con cantidades
        $productosSeleccionados = collect($data['productos'])
            ->filter(fn($producto) => isset($producto['selected']) && $producto['selected'] == 1)
            ->mapWithKeys(fn($producto, $id) => [(int)$id => ['cantidad' => $producto['cantidad']]]);

        // Validamos que no esté vacío
        if ($productosSeleccionados->isEmpty()) {
            return back()->withErrors(['productos' => 'Debe seleccionar al menos un producto con cantidad válida.'])->withInput();
        }

        // Calculamos total actualizado
        $total = 0;
        foreach ($productosSeleccionados as $productoId => $info) {
            $producto = Producto::findOrFail($productoId);
            $total += $producto->precio * $info['cantidad'];
        }

        // Actualizamos comercial asignado (el usuario logueado)
        $comercialId = $pedido->comercial_id ?? (auth()->check() ? auth()->id() : null);

        // Actualizamos el pedido con los nuevos datos
        $pedido->update([
            'cliente_id' => $data['cliente_id'],
            'fecha'      => $data['fecha'],
            'estado'     => $data['estado'],
            'total'      => $total,
            'comercial_id' => Auth::id(),
        ]);

        // Sincronizamos los productos con sus cantidades (tabla pivot)
        $pedido->productos()->sync($productosSeleccionados->toArray());

        // Redirigimos con mensaje de éxito
        return redirect()->route('pedidos.index')
                         ->with('success', 'Pedido actualizado correctamente.');
    }

    // Eliminar un pedido
    public function destroy(Pedido $pedido)
    {
        // Eliminamos el pedido
        $pedido->delete();

        // Redirigimos con mensaje de éxito
        return redirect()->route('pedidos.index')
                         ->with('success', 'Pedido eliminado correctamente.');
    }


}
