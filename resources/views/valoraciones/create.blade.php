@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-orange-50 py-12">
  <div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-2xl shadow-lg p-8">

      {{-- Volver a índice --}}
      <div class="mb-6 p-3">
        <a href="{{ route('valoraciones.index') }}"
           class="inline-block text-orange-500 hover:underline font-medium">
          ← Volver a Valoraciones
        </a>
      </div>

      <h1 class="text-3xl font-semibold mb-6 text-orange-700 text-center p-6">
        Nueva Valoración
      </h1>

      @if($errors->any())
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
        <strong class="font-bold">Completa correctamente el formulario.</strong>
      </div>
      @endif

      <form action="{{ route('valoraciones.store') }}" method="POST">
        @csrf

        <div class="mb-6">
          <label class="block text-gray-600 font-medium mb-2">Cliente *</label>
          <select name="cliente_id" required
                  class="w-full border border-orange-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400">
            <option value="">-- Selecciona un cliente --</option>
            @foreach($clientes as $cliente)
              <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                {{ $cliente->nombre_comercial }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="mb-6">
          <label class="block text-gray-600 font-medium mb-2">Valoración *</label>
          <select name="valoracion" required
                  class="w-full border border-orange-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400">
            @for($i=1; $i<=5; $i++)
              <option value="{{ $i }}" {{ old('valoracion') == $i ? 'selected' : '' }}>
                {{ $i }} estrella{{ $i > 1 ? 's' : '' }}
              </option>
            @endfor
          </select>
        </div>

        <div class="mb-6">
          <label class="block text-gray-600 font-medium mb-2">Comentario</label>
          <textarea name="comentario" rows="4"
                    class="w-full border border-orange-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400"
                    placeholder="Opcional">{{ old('comentario') }}</textarea>
        </div>

        <div class="mt-6 flex space-x-4">
          <button type="submit"
                  class="bg-orange-400 hover:bg-orange-500 text-white font-semibold px-5 py-2 rounded-lg">
            Guardar
          </button>
          <a href="{{ route('valoraciones.index') }}"
             class="bg-orange-300 hover:bg-orange-400 text-white font-semibold px-5 py-2 rounded-lg">
            Cancelar
          </a>
        </div>

      </form>

    </div>
  </div>
</div>
@endsection

