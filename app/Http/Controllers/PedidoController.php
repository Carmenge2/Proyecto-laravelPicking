<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\CategoriasProductos;
use App\Services\PedidoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * Controlador de pedidos.
 * Gestiona el ciclo completo de vida de los pedidos: listado filtrado,
 * creación, visualización, edición y eliminación.
 * Delega la lógica de negocio a PedidoService para mantener los
 * controladores limpios y testables.
 */
class PedidoController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        protected PedidoService $pedidoService
    ) {}

    /**
     * Muestra el listado paginado de pedidos con filtros.
     * Permite filtrar por nombre del cliente, fecha de entrega y estado.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
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

        $pedidos = $query->paginate(10)->appends(
            $request->only(['search', 'fecha', 'estado'])
        );

        return view('pedidos.index', compact('pedidos'));
    }

    /**
     * Muestra el formulario para crear un nuevo pedido.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $clientes = Cliente::orderBy('nombre_comercial')->get();

        $categorias = CategoriasProductos::with([
            'productos' => function ($q) {
                $q->orderBy('nombre');
            }
        ])->orderBy('nombre')->get();

        return view('pedidos.create', compact(
            'clientes',
            'categorias'
        ));
    }

    /**
     * Guarda un nuevo pedido.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        $productosSeleccionados = $this->pedidoService
            ->filtrarProductos($data['productos']);

        if ($productosSeleccionados->isEmpty()) {
            return back()->withErrors([
                'productos' => 'Debes seleccionar al menos un producto.'
            ])->withInput();
        }

        $total = $this->pedidoService
            ->calcularTotal($productosSeleccionados);

        $pedido = Pedido::create([
            'cliente_id'   => $data['cliente_id'],
            'fecha'        => $data['fecha'],
            'estado'       => $data['estado'],
            'total'        => $total,
            'comercial_id' => Auth::id(),
        ]);

        $pedido->productos()->attach(
            $productosSeleccionados->toArray()
        );

        return redirect()
            ->route('pedidos.index')
            ->with('success', 'Pedido creado correctamente.');
    }

    /**
     * Muestra un pedido específico.
     *
     * @param Pedido $pedido
     * @return \Illuminate\View\View
     */
    public function show(Pedido $pedido)
    {
        $this->authorize('view', $pedido);

        $pedido->load([
            'cliente',
            'productos',
            'comercial'
        ]);

        return view('pedidos.show', compact('pedido'));
    }

    /**
     * Formulario de edición.
     *
     * @param Pedido $pedido
     * @return \Illuminate\View\View
     */
    public function edit(Pedido $pedido)
    {
        $this->authorize('update', $pedido);

        $clientes = Cliente::orderBy('nombre_comercial')->get();

        $categorias = CategoriasProductos::with([
            'productos' => function ($q) {
                $q->orderBy('nombre');
            }
        ])->orderBy('nombre')->get();

        return view('pedidos.edit', compact(
            'pedido',
            'clientes',
            'categorias'
        ));
    }

    /**
     * Actualiza un pedido.
     *
     * @param Request $request
     * @param Pedido $pedido
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Pedido $pedido)
    {
        $this->authorize('update', $pedido);

        $data = $request->validate($this->rules());

        $productosSeleccionados = $this->pedidoService
            ->filtrarProductos($data['productos']);

        if ($productosSeleccionados->isEmpty()) {
            return back()->withErrors([
                'productos' => 'Debes seleccionar al menos un producto.'
            ])->withInput();
        }

        $total = $this->pedidoService
            ->calcularTotal($productosSeleccionados);

        $updateData = [
            'cliente_id' => $data['cliente_id'],
            'fecha'      => $data['fecha'],
            'estado'     => $data['estado'],
            'total'      => $total,
        ];

        if (Auth::user()->rol === 'comercial') {
            // Solo los comerciales deben (re)asignarse como responsable del pedido.
            $updateData['comercial_id'] = Auth::id();
        }

        $pedido->update($updateData);

        $pedido->productos()->sync(
            $productosSeleccionados->toArray()
        );

        return redirect()
            ->route('pedidos.index')
            ->with('success', 'Pedido actualizado correctamente.');
    }

    /**
     * Elimina un pedido.
     *
     * @param Pedido $pedido
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Pedido $pedido)
    {
        $this->authorize('delete', $pedido);

        $pedido->delete();

        return redirect()
            ->route('pedidos.index')
            ->with('success', 'Pedido eliminado correctamente.');
    }

    /**
     * Reglas de validación.
     *
     * @return array<string, string>
     */
    private function rules(): array
    {
        return [
            'cliente_id'           => 'required|exists:clientes,id',
            'productos'            => 'required|array',
            'productos.*.cantidad' => 'nullable|integer|min:0',
            'fecha'                => 'required|date',
            'estado'               => 'required|in:pendiente,enviado,cancelado',
        ];
    }
}