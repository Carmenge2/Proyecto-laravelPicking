@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-orange-50 py-12">
  <div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-2xl shadow-lg p-8">

      {{-- Enlace volver --}}
      <div class="mb-6">
        <a href="{{ route('admin.dashboard') }}"
           class="inline-block text-orange-700 hover:underline">
          ← Volver al Panel
        </a>
      </div>

      <h1 class="text-3xl font-semibold mb-6 text-orange-700 text-center p-6">
        Nuevo Pedido
      </h1>

      @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
          <strong>Completa correctamente el formulario.</strong>
        </div>
      @endif

      <hr class="my-6">

      <form action="{{ route('pedidos.store') }}" method="POST">
        @csrf

        {{-- Cliente --}}
        <div class="mb-4 m-5">
          <label for="cliente_id" class="block text-gray-700 mb-1">Cliente *</label>
          <select name="cliente_id" id="cliente_id"
                  class="w-full border border-orange-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400
                         @error('cliente_id') border-red-500 focus:ring-red-500 @enderror"
                  required>
            <option value="">-- Selecciona cliente --</option>
            @foreach($clientes as $cliente)
              <option value="{{ $cliente->id }}"
                      {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                  {{ $cliente->nombre_comercial }}
              </option>
            @endforeach
          </select>
          @error('cliente_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Productos con cantidad --}}
        <div class="mb-4 m-5">
          <label class="block text-gray-700 mb-2">Productos *</label>

          @foreach($productos as $producto)
            @php
              $selected = old("productos.{$producto->id}.selected");
              $cantidad = old("productos.{$producto->id}.cantidad", 1);
            @endphp

            <div class="flex items-center mb-2">
              <input
                type="checkbox"
                name="productos[{{ $producto->id }}][selected]"
                id="producto_{{ $producto->id }}"
                value="1"
                {{ $selected ? 'checked' : '' }}
                class="mr-2 producto-checkbox accent-orange-500"
                data-precio="{{ $producto->precio }}"
              >
              <label for="producto_{{ $producto->id }}" class="mr-4 cursor-pointer">
                {{ $producto->nombre }} - {{ number_format($producto->precio, 2) }}€
              </label>

              <input
                type="number"
                name="productos[{{ $producto->id }}][cantidad]"
                min="1"
                value="{{ $cantidad }}"
                class="w-20 border border-gray-300 rounded px-2 py-1 producto-cantidad"
                data-id="{{ $producto->id }}"
                data-precio="{{ $producto->precio }}"
                {{ $selected ? '' : 'disabled' }}
              >
            </div>
          @endforeach

          @error('productos')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Total dinámico --}}
        <div class="mt-6 m-5 text-lg font-semibold text-orange-700">
          Total del pedido: <span id="totalPedido">0.00</span> €
        </div>

        {{-- Fecha del pedido --}}
        <div class="mb-4 m-5">
          <label for="fecha" class="block text-gray-700 mb-1">Fecha del pedido *</label>
          <input
            type="date"
            name="fecha"
            id="fecha"
            class="w-full border border-orange-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400
                   @error('fecha') border-red-500 focus:ring-red-500 @enderror"
            value="{{ old('fecha', date('Y-m-d')) }}"
            required
          >
          @error('fecha')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Estado --}}
        <div class="mb-6 m-5">
          <label for="estado" class="block text-gray-700 mb-1">Estado del Pedido *</label>
          <select name="estado" id="estado"
                  class="w-full border border-orange-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400
                         @error('estado') border-red-500 focus:ring-red-500 @enderror"
                  required>
            @foreach(['pendiente','enviado','cancelado'] as $estado)
              <option value="{{ $estado }}"
                      {{ old('estado') === $estado ? 'selected' : '' }}>
                {{ ucfirst($estado) }}
              </option>
            @endforeach
          </select>
          @error('estado')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Botones --}}
        <div class="mb-6 m-5 flex space-x-4">
          <button type="submit"
                  class="bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded px-6 py-2 transition">
            Guardar Pedido
          </button>
          <a href="{{ route('pedidos.index') }}"
             class="bg-orange-300 hover:bg-orange-400 text-white font-semibold px-6 py-2 rounded-lg">
            Cancelar
          </a>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  function actualizarTotal() {
    let total = 0;
    document.querySelectorAll('.producto-checkbox').forEach(function(checkbox) {
      const id = checkbox.id.replace('producto_', '');
      const cantidadInput = document.querySelector(`input[name="productos[${id}][cantidad]"]`);
      const precio = parseFloat(checkbox.dataset.precio || 0);
      const cantidad = parseInt(cantidadInput.value || 1);
      if (checkbox.checked) {
        total += precio * cantidad;
      }
    });
    document.getElementById('totalPedido').textContent = total.toFixed(2);
  }

  document.querySelectorAll('.producto-checkbox').forEach(function(checkbox) {
    checkbox.addEventListener('change', function() {
      const id = this.id.replace('producto_', '');
      const qtyInput = document.querySelector(`input[name="productos[${id}][cantidad]"]`);
      qtyInput.disabled = !this.checked;
      if (!this.checked) qtyInput.value = 1;
      actualizarTotal();
    });
  });

  document.querySelectorAll('.producto-cantidad').forEach(function(input) {
    input.addEventListener('input', actualizarTotal);
  });

  window.addEventListener('DOMContentLoaded', actualizarTotal);
</script>
@endsection