@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        <x-ui.back-link :href="route('pedidos.index')" label="Volver a Pedidos"/>

        <x-ui.card>
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Editar Pedido #{{ $pedido->id }}</h1>

            @if ($errors->any())
                <x-ui.alert type="error" class="mb-6">
                    Completa correctamente el formulario.
                </x-ui.alert>
            @endif

            <form action="{{ route('pedidos.update', $pedido) }}" method="POST">
                @csrf
                @method('PUT')

                <x-ui.form-select name="cliente_id" label="Cliente" :required="true">
                    <option value="">-- Selecciona cliente --</option>
                    @foreach($clientes as $cliente)
                        <option value="{{ $cliente->id }}" {{ old('cliente_id', $pedido->cliente_id) == $cliente->id ? 'selected' : '' }}>
                            {{ $cliente->nombre_comercial }}
                        </option>
                    @endforeach
                </x-ui.form-select>

                {{-- Productos --}}
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Productos <span class="text-red-500">*</span></label>

                    @php
                        $productosSeleccionados = old('productos', $pedido->productos->mapWithKeys(function($p) {
                            return [$p->id => ['cantidad' => $p->pivot->cantidad ?? 1]];
                        })->toArray());
                    @endphp

                    @foreach($categorias as $categoria)
                        <details open class="mb-3 border border-orange-200 rounded-xl overflow-hidden">
                            <summary class="cursor-pointer px-4 py-3 bg-orange-50 font-medium text-sm text-gray-800 hover:bg-orange-100 transition">
                                {{ $categoria->nombre }}
                            </summary>
                            <div class="p-4 space-y-2">
                                @forelse($categoria->productos as $producto)
                                    @php
                                        $cantidad = $productosSeleccionados[$producto->id]['cantidad'] ?? 0;
                                        $agotado = $producto->estado === 'agotado';
                                    @endphp
                                    <div class="flex justify-between items-center bg-gray-50 rounded-lg px-4 py-2.5">
                                        <div class="{{ $agotado ? 'line-through text-gray-400' : 'text-sm text-gray-800' }}">
                                            {{ $producto->nombre }}
                                            <span class="text-xs text-gray-500 ml-1">
                                                ({{ number_format($producto->precio, 2) }}€ · {{ ucfirst($producto->estado) }})
                                            </span>
                                        </div>
                                        @if(!$agotado)
                                            <input type="number"
                                                   name="productos[{{ $producto->id }}][cantidad]"
                                                   min="0"
                                                   value="{{ $cantidad }}"
                                                   data-precio="{{ $producto->precio }}"
                                                   class="w-20 border border-orange-200 rounded-lg px-3 py-1.5 text-sm text-center focus:ring-2 focus:ring-orange-400 focus:border-orange-400 cantidad-input">
                                        @endif
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-500">Sin productos</p>
                                @endforelse
                            </div>
                        </details>
                    @endforeach
                </div>

                {{-- Total --}}
                <div class="bg-orange-50 rounded-xl px-4 py-3 mb-5 flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-700">Total del pedido</span>
                    <span class="text-lg font-bold text-orange-600"><span id="totalPedido">0.00</span> €</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <x-ui.form-input name="fecha" label="Fecha de Entrega" type="date" :value="$pedido->fecha" :required="true"/>

                    <x-ui.form-select name="estado" label="Estado" :required="true">
                        @foreach(['pendiente','enviado','cancelado'] as $estado)
                            <option value="{{ $estado }}" {{ old('estado', $pedido->estado) == $estado ? 'selected' : '' }}>
                                {{ ucfirst($estado) }}
                            </option>
                        @endforeach
                    </x-ui.form-select>
                </div>

                <div class="flex items-center gap-3 pt-4">
                    <x-ui.button type="submit">Actualizar Pedido</x-ui.button>
                    <x-ui.button variant="secondary" href="{{ route('pedidos.index') }}">Cancelar</x-ui.button>
                </div>
            </form>
        </x-ui.card>

    </div>
</div>
@endsection

@push('scripts')
<script>
function actualizarTotal() {
    let total = 0;
    document.querySelectorAll('.cantidad-input').forEach(input => {
        const precio = parseFloat(input.dataset.precio || 0);
        const cantidad = parseInt(input.value || 0);
        if (cantidad > 0) total += precio * cantidad;
    });
    document.getElementById('totalPedido').textContent = total.toFixed(2);
}

document.addEventListener('input', function(e) {
    if (e.target.classList.contains('cantidad-input')) actualizarTotal();
});

window.addEventListener('DOMContentLoaded', actualizarTotal);
</script>
@endpush