@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-orange-50 py-12"> {{-- Fondo naranja clarito --}}
  <div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-2xl shadow-lg p-8">

      {{-- Enlace para volver --}}
      <div class="mb-6">
        <a href="{{ route('pedidos.index') }}" class="inline-block text-orange-600 hover:underline">
          ← Volver a Pedidos
        </a>
      </div>

      <h1 class="text-4xl font-extrabold text-gray-800 mb-10 text-center">
        Editar Pedido {{ $pedido->id }}
      </h1>

      @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
          <strong>Completa correctamente el formulario.</strong>
        </div>
      @endif

      <form action="{{ route('pedidos.update', $pedido) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Cliente --}}
        <div class="mb-4 m-5">
          <label for="cliente_id" class="block text-orange-700 mb-1">Cliente *</label>
          <select name="cliente_id" id="cliente_id"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400
                         @error('cliente_id') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                  required>
            <option value="">-- Selecciona cliente --</option>
            @foreach($clientes as $cliente)
              <option value="{{ $cliente->id }}"
                {{ old('cliente_id', $pedido->cliente_id) == $cliente->id ? 'selected' : '' }}>
                {{ $cliente->nombre_comercial }} {{ $cliente->razon_social }}
              </option>
            @endforeach
          </select>
          @error('cliente_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Productos con cantidad --}}
        <div class="mb-4 m-5">
          <label class="block text-orange-700 mb-2">Productos *</label>

          @php
            $productosSeleccionados = old('productos', $pedido->productos->mapWithKeys(function($prod) {
              return [$prod->id => ['selected' => true, 'cantidad' => $prod->pivot->cantidad ?? 1]];
            })->toArray());
          @endphp

          @foreach($productos as $producto)
            @php
              $selected = isset($productosSeleccionados[$producto->id]['selected']) && $productosSeleccionados[$producto->id]['selected'];
              $cantidad = $selected ? ($productosSeleccionados[$producto->id]['cantidad'] ?? 1) : 1;
            @endphp

            <div class="flex items-center mb-2">
              <input
                type="checkbox"
                name="productos[{{ $producto->id }}][selected]"
                id="producto_{{ $producto->id }}"
                value="1"
                {{ $selected ? 'checked' : '' }}
                class="mr-2 accent-orange-400"
              >
              <label for="producto_{{ $producto->id }}" class="mr-4 cursor-pointer text-gray-700">
                {{ $producto->nombre }} - {{ number_format($producto->precio, 2) }}€
              </label>

              <input
                type="number"
                name="productos[{{ $producto->id }}][cantidad]"
                min="1"
                value="{{ $cantidad }}"
                class="w-20 border border-gray-300 rounded px-2 py-1"
                {{ $selected ? '' : 'disabled' }}
              >
            </div>
          @endforeach

          @error('productos')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Fecha --}}
        <div class="mb-4 m-5">
          <label for="fecha" class="block text-orange-700 mb-1">Fecha del Pedido *</label>
          <input type="date" name="fecha" id="fecha"
                 value="{{ old('fecha', $pedido->fecha) }}"
                 class="w-full border border-orange-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400
                        @error('fecha') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                 required>
          @error('fecha')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Estado --}}
        <div class="mb-6 m-5">
          <label for="estado" class="block text-orange-700 mb-1">Estado del Pedido *</label>
          <select name="estado" id="estado"
                  class="w-full border border-orange-300 rounded-lg px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-orange-400
                         @error('estado') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                  required>
            @foreach(['pendiente','entregado','cancelado'] as $estado)
              <option value="{{ $estado }}"
                      {{ old('estado', $pedido->estado) === $estado ? 'selected' : '' }}>
                {{ ucfirst($estado) }}
              </option>
            @endforeach
          </select>
          @error('estado')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Botones --}}
        <div class="mb-6 m-5 flex gap-4">
          <button type="submit" class="bg-orange-400 hover:bg-orange-500 text-white font-semibold py-2 px-6 rounded-lg transition">
            Actualizar Pedido
          </button>
          <a href="{{ route('pedidos.index') }}" class="bg-orange-300 hover:bg-orange-400 text-white font-semibold px-6 py-2 rounded-lg">
            Cancelar
          </a>
        </div>
      </form>

    </div>
  </div>
</div>

<script>
  document.querySelectorAll('input[type=checkbox][name^="productos"]').forEach(function(checkbox) {
    checkbox.addEventListener('change', function() {
      const id = this.id.replace('producto_', '');
      const qtyInput = document.querySelector(`input[name="productos[${id}][cantidad]"]`);
      if (this.checked) {
        qtyInput.disabled = false;
      } else {
        qtyInput.disabled = true;
        qtyInput.value = 1;
      }
    });
  });
</script>
@endsection



