<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\CategoriasProductos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    // LISTADO
    public function index(Request $request)
    {
        $query = Pedido::with(['cliente', 'productos', 'comercial'])
            ->orderByDesc('created_at');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->whereHas('cliente', function ($q) use ($search) {
                $q->where('nombre_comercial', 'like', "%{$search}%")
                  ->orWhere('razon_social', 'like', "%{$search}%");
            });
        }

        if ($request->filled('fecha')) {
            $query->whereDate('fecha', $request->fecha);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $pedidos = $query->paginate(10)->appends($request->all());

        return view('pedidos.index', compact('pedidos'));
    }

    // FORMULARIO CREAR
    public function create()
    {
        $clientes = Cliente::orderBy('nombre_comercial')->get();

        // 🔥 TODAS las categorías con TODOS los productos
        $categorias = CategoriasProductos::with(['productos' => function ($q) {
            $q->orderBy('nombre');
        }])->orderBy('nombre')->get();

        return view('pedidos.create', compact('clientes', 'categorias'));
    }

    // GUARDAR PEDIDO
    public function store(Request $request)
    {
        $data = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'productos'  => 'required|array',
            'productos.*.cantidad' => 'nullable|integer|min:0',
            'fecha'      => 'required|date',
            'estado'     => 'required|in:pendiente,enviado,cancelado',
        ]);

        $productosSeleccionados = collect($data['productos'])
            ->filter(fn($p) => isset($p['cantidad']) && $p['cantidad'] > 0)
            ->mapWithKeys(fn($p, $id) => [
                (int)$id => ['cantidad' => $p['cantidad']]
            ]);

        if ($productosSeleccionados->isEmpty()) {
            return back()->withErrors([
                'productos' => 'Debes seleccionar al menos un producto.'
            ])->withInput();
        }

        $productosDB = Producto::whereIn('id', $productosSeleccionados->keys())->get();

        $total = 0;

        foreach ($productosDB as $producto) {
            $cantidad = $productosSeleccionados[$producto->id]['cantidad'];
            $total += $producto->precio * $cantidad;
        }

        $pedido = Pedido::create([
            'cliente_id'   => $data['cliente_id'],
            'fecha'        => $data['fecha'],
            'estado'       => $data['estado'],
            'total'        => $total,
            'comercial_id' => Auth::id(),
        ]);

        $pedido->productos()->attach($productosSeleccionados->toArray());

        return redirect()->route('pedidos.index')
            ->with('success', 'Pedido creado correctamente.');
    }

    // VER PEDIDO
    public function show(Pedido $pedido)
    {
        $pedido->load(['cliente', 'productos', 'comercial']);

        return view('pedidos.show', compact('pedido'));
    }

    // FORMULARIO EDITAR
    public function edit(Pedido $pedido)
    {
        $clientes = Cliente::orderBy('nombre_comercial')->get();

        $categorias = CategoriasProductos::with(['productos' => function ($q) {
            $q->orderBy('nombre');
        }])->orderBy('nombre')->get();

        return view('pedidos.edit', compact('pedido', 'clientes', 'categorias'));
    }

    // ACTUALIZAR PEDIDO
    public function update(Request $request, Pedido $pedido)
    {
        $data = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'productos'  => 'required|array',
            'productos.*.cantidad' => 'nullable|integer|min:0',
            'fecha'      => 'required|date',
            'estado'     => 'required|in:pendiente,enviado,cancelado',
        ]);

        $productosSeleccionados = collect($data['productos'])
            ->filter(fn($p) => isset($p['cantidad']) && $p['cantidad'] > 0)
            ->mapWithKeys(fn($p, $id) => [
                (int)$id => ['cantidad' => $p['cantidad']]
            ]);

        if ($productosSeleccionados->isEmpty()) {
            return back()->withErrors([
                'productos' => 'Debes seleccionar al menos un producto.'
            ])->withInput();
        }

        $productosDB = Producto::whereIn('id', $productosSeleccionados->keys())->get();

        $total = 0;

        foreach ($productosDB as $producto) {
            $cantidad = $productosSeleccionados[$producto->id]['cantidad'];
            $total += $producto->precio * $cantidad;
        }

        $pedido->update([
            'cliente_id'   => $data['cliente_id'],
            'fecha'        => $data['fecha'],
            'estado'       => $data['estado'],
            'total'        => $total,
            'comercial_id' => Auth::id(),
        ]);

        $pedido->productos()->sync($productosSeleccionados->toArray());

        return redirect()->route('pedidos.index')
            ->with('success', 'Pedido actualizado correctamente.');
    }

    // ELIMINAR
    public function destroy(Pedido $pedido)
    {
        $pedido->delete();

        return redirect()->route('pedidos.index')
            ->with('success', 'Pedido eliminado correctamente.');
    }
}