@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-orange-50 py-12">

    <!-- VOLVER -->
    <div class="max-w-3xl mx-auto px-6 mb-6">
        <a href="{{ route('admin.dashboard') }}"
           class="text-orange-600 hover:text-orange-700 font-semibold">
            ← Volver al Panel
        </a>
    </div>

    <!-- CONTENIDO -->
    <div class="max-w-3xl mx-auto px-6">

        <h1 class="text-3xl font-semibold mb-6 text-orange-700 text-center">
            Nuevo Pedido
        </h1>

        <div class="bg-white rounded-2xl shadow-lg p-8">

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <strong>Completa correctamente el formulario.</strong>
                </div>
            @endif

            <form action="{{ route('pedidos.store') }}" method="POST">
                @csrf

                <!-- CLIENTE -->
                <div class="mb-6">
                    <label class="block text-orange-700 mb-3 font-semibold">Cliente *</label>
                    <select name="cliente_id"
                            class="w-full border border-orange-300 rounded-lg px-4 py-2">
                        <option value="">-- Selecciona cliente --</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}"
                                {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                {{ $cliente->nombre_comercial }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- PRODUCTOS -->
                <div class="mb-6">
                    <label class="block text-orange-700 mb-3 font-semibold">Productos *</label>

                    @foreach($categorias as $categoria)

                        <details class="mb-4 border rounded-lg">
                            <summary class="cursor-pointer px-4 py-2 bg-orange-100 font-bold text-orange-700">
                                {{ $categoria->nombre }}
                            </summary>

                            <div class="p-4">

                                @forelse($categoria->productos as $producto)

                                    <div class="flex justify-between items-center mb-2 bg-orange-50 p-3 rounded">

                                        <div class="{{ $producto->estado === 'agotado' ? 'line-through text-gray-400' : '' }}">
                                            {{ $producto->nombre }}
                                            <span class="text-sm text-orange-500">
                                                ({{ number_format($producto->precio, 2) }}€ - {{ ucfirst($producto->estado) }})
                                            </span>
                                        </div>

                                        @if($producto->estado !== 'agotado')
                                            <input
                                                type="number"
                                                name="productos[{{ $producto->id }}][cantidad]"
                                                min="0"
                                                value="{{ old('productos.'.$producto->id.'.cantidad', 0) }}"
                                                data-precio="{{ $producto->precio }}"
                                                class="w-20 border border-orange-300 rounded px-2 py-1 producto-cantidad"
                                            >
                                        @endif

                                    </div>

                                @empty
                                    <p class="text-orange-500">Sin productos</p>
                                @endforelse

                            </div>
                        </details>

                    @endforeach

                    @error('productos')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- TOTAL -->
                <div class="text-lg font-semibold text-orange-700 mb-6">
                    Total del pedido: <span id="totalPedido">0.00</span> €
                </div>

                <!-- FECHA -->
                <div class="mb-4">
                    <label class="block text-orange-700 mb-1">Fecha de Entrega*</label>
                    <input type="date"
                           name="fecha"
                           value="{{ old('fecha', date('Y-m-d')) }}"
                           class="w-full border border-orange-300 rounded-lg px-4 py-2">
                </div>

                <!-- ESTADO -->
                <div class="mb-6">
                    <label class="block text-orange-700 mb-1">Estado *</label>
                    <select name="estado"
                            class="w-full border border-orange-300 rounded-lg px-4 py-2">

                        <option value="pendiente" {{ old('estado') == 'pendiente' ? 'selected' : '' }}>
                            Pendiente
                        </option>

                        <option value="enviado" {{ old('estado') == 'enviado' ? 'selected' : '' }}>
                            Enviado
                        </option>

                        <option value="cancelado" {{ old('estado') == 'cancelado' ? 'selected' : '' }}>
                            Cancelado
                        </option>

                    </select>
                </div>

                <!-- BOTONES -->
                <div class="flex justify-between items-center">
                    <a href="{{ route('pedidos.index') }}"
                       class="text-orange-600 hover:underline">
                        ← Cancelar
                    </a>

                    <button type="submit"
                            class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded">
                        Guardar Pedido
                    </button>

                </div>

            </form>
        </div>
    </div>
</div>

<!-- SCRIPT TOTAL -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    function actualizarTotal() {
        let total = 0;

        document.querySelectorAll('.producto-cantidad').forEach(function(input) {
            const cantidad = parseFloat(input.value) || 0;
            const precio = parseFloat(input.dataset.precio) || 0;

            total += cantidad * precio;
        });

        document.getElementById('totalPedido').textContent = total.toFixed(2);
    }

    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('producto-cantidad')) {
            actualizarTotal();
        }
    });

    actualizarTotal();
});
</script>

@endsection