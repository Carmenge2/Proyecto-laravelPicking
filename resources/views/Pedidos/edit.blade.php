@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-orange-50 py-12">

    {{-- VOLVER --}}
    <div class="max-w-5xl mx-auto px-2 mb-6">
        <a href="{{ route('pedidos.index') }}"
           class="text-orange-600 hover:text-orange-700 font-semibold">
            ← Volver a Pedidos
        </a>
    </div>

    <div class="max-w-6xl mx-auto px-2">

        {{-- TÍTULO --}}
        <h1 class="text-4xl font-extrabold text-orange-600 text-center mb-8">
            Editar Pedido {{ $pedido->id }}
        </h1>

        {{-- TARJETA --}}
        <div class="bg-white shadow-xl rounded-2xl p-8">

            {{-- ERRORES --}}
            @if ($errors->any())
                <div class="mb-6 bg-red-100 border border-red-300 text-red-700 p-2 rounded-xl">
                    <strong>Completa correctamente el formulario.</strong>
                </div>
            @endif

            <form action="{{ route('pedidos.update', $pedido) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- CLIENTE --}}
                <div class="mb-6">
                    <label class="block text-orange-700 font-semibold mb-2">
                        Cliente *
                    </label>

                    <select name="cliente_id"
                            class="w-full border border-orange-300 rounded-xl px-2 py-3 focus:outline-none focus:ring-2 focus:ring-orange-400">

                        <option value="">-- Selecciona cliente --</option>

                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}"
                                {{ old('cliente_id', $pedido->cliente_id) == $cliente->id ? 'selected' : '' }}>
                                {{ $cliente->nombre_comercial }}
                            </option>
                        @endforeach

                    </select>
                </div>

                {{-- PRODUCTOS --}}
                <div class="mb-6">

                    <label class="block text-orange-700 font-semibold mb-3">
                        Productos *
                    </label>

                    @php
                        $productosSeleccionados = old('productos', $pedido->productos->mapWithKeys(function($p) {
                            return [$p->id => ['cantidad' => $p->pivot->cantidad ?? 1]];
                        })->toArray());
                    @endphp

                    @foreach($categorias as $categoria)

                        <details open class="mb-4 border border-orange-200 rounded-xl overflow-hidden">

                            <summary class="cursor-pointer px-2 py-3 bg-orange-100 font-bold text-orange-700">
                                {{ $categoria->nombre }}
                            </summary>

                            <div class="p-3 bg-white space-y-2">

                                @forelse($categoria->productos as $producto)

                                    @php
                                        $cantidad = $productosSeleccionados[$producto->id]['cantidad'] ?? 0;
                                        $agotado = $producto->estado === 'agotado';
                                    @endphp

                                    <div class="flex justify-between items-center bg-orange-50 border border-orange-100 rounded-xl px-2 py-3">

                                        <div class="{{ $agotado ? 'line-through opacity-50' : '' }}">
                                            <p class="font-semibold text-gray-800">
                                                {{ $producto->nombre }}
                                            </p>

                                            <p class="text-sm text-orange-500">
                                                {{ number_format($producto->precio,2) }}€
                                                — {{ ucfirst($producto->estado) }}
                                            </p>
                                        </div>

                                        @if(!$agotado)

                                            <input
                                                type="number"
                                                name="productos[{{ $producto->id }}][cantidad]"
                                                min="0"
                                                value="{{ $cantidad }}"
                                                data-precio="{{ $producto->precio }}"
                                                class="w-24 border border-orange-300 rounded-lg px-3 py-2 cantidad-input focus:outline-none focus:ring-2 focus:ring-orange-400"
                                            >

                                        @endif

                                    </div>

                                @empty

                                    <p class="text-orange-500 px-2 py-2">
                                        Sin productos
                                    </p>

                                @endforelse

                            </div>

                        </details>

                    @endforeach

                </div>

                {{-- TOTAL --}}
                <div class="mb-8">

                    <div class="bg-orange-50 border border-orange-100 rounded-xl px-6 py-5">

                        <p class="text-lg font-semibold text-orange-700">
                            Total del pedido
                        </p>

                        <p class="text-3xl font-extrabold text-orange-600 mt-1">
                            <span id="totalPedido">0.00</span> €
                        </p>

                    </div>

                </div>

                {{-- FECHA --}}
                <div class="mb-6">

                    <label class="block text-orange-700 font-semibold mb-2">
                        Fecha de Entrega *
                    </label>

                    <input type="date"
                           name="fecha"
                           min="{{ date('Y-m-d') }}"
                           value="{{ old('fecha', $pedido->fecha) }}"
                           class="w-full border border-orange-300 rounded-xl px-2 py-3 focus:outline-none focus:ring-2 focus:ring-orange-400">

                </div>

                {{-- ESTADO --}}
                <div class="mb-8">

                    <label class="block text-orange-700 font-semibold mb-2">
                        Estado *
                    </label>

                    <select name="estado"
                            class="w-full border border-orange-300 rounded-xl px-2 py-3 focus:outline-none focus:ring-2 focus:ring-orange-400">

                        @foreach(['pendiente','enviado','cancelado'] as $estado)

                            <option value="{{ $estado }}"
                                {{ old('estado', $pedido->estado) == $estado ? 'selected' : '' }}>
                                {{ ucfirst($estado) }}
                            </option>

                        @endforeach

                    </select>

                </div>

                {{-- BOTONES --}}
                <div class="flex justify-between items-center">

                    <a href="{{ route('pedidos.index') }}"
                       class="text-orange-600 hover:text-orange-700 font-semibold">
                        ← Cancelar
                    </a>

                    <button type="submit"
                            class="px-8 py-3 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-xl shadow-lg transition">
                        Actualizar Pedido
                    </button>

                </div>

            </form>

        </div>

    </div>
</div>

{{-- SCRIPT TOTAL --}}
<script>
function actualizarTotal() {

    let total = 0;

    document.querySelectorAll('.cantidad-input').forEach(input => {

        const precio = parseFloat(input.dataset.precio || 0);
        const cantidad = parseInt(input.value || 0);

        if (cantidad > 0) {
            total += precio * cantidad;
        }

    });

    document.getElementById('totalPedido').textContent = total.toFixed(2);
}

document.addEventListener('input', function(e) {

    if (e.target.classList.contains('cantidad-input')) {
        actualizarTotal();
    }

});

window.addEventListener('DOMContentLoaded', actualizarTotal);
</script>

@endsection