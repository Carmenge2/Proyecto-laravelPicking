@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-orange-50 py-12">
  <div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-2xl shadow-lg p-8">

      {{-- Enlace para volver al panel comercial --}}
      <div class="mb-6">
        <a href="{{ route('comercial.dashboard') }}"
           class="inline-block text-orange-400 hover:underline">
          ← Volver al Panel
        </a>
      </div>

      <h1 class="text-3xl font-semibold mb-6 text-orange-700 text-center p-6">Nuevo Cliente</h1>

      @if ($errors->any())
        <div class="alert alert-danger mb-6">
          <h5>Completa correctamente el formulario.</h5>
        </div>
      @endif

      <hr class="my-6">

      <form action="{{ route('clientes.store') }}" method="POST">
        @csrf

        <div class="mb-4 m-5">
          <label for="nombre_comercial" class="block text-gray-700 mb-1">Nombre Comercial *</label>
          <input type="text" name="nombre_comercial" id="nombre_comercial"
                 class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400"
                 value="{{ old('nombre_comercial') }}" required>
        </div>

        <div class="mb-4 m-5">
          <label for="razon_social" class="block text-gray-700 mb-1">Razón Social *</label>
          <input type="text" name="razon_social" id="razon_social"
                 class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400"
                 value="{{ old('razon_social') }}" required>
        </div>

        <div class="mb-4 m-5">
          <label for="comercial_id" class="block text-gray-700 mb-1">Comercial asignado *</label>
          <select name="comercial_id" id="comercial_id"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400"
                  required @if(count($comerciales) === 1) disabled @endif>
              <option value="">Selecciona un comercial</option>
              @foreach($comerciales as $id => $nombre)
                  <option value="{{ $id }}"
                      {{ old('comercial_id', $comercialSeleccionado) == $id ? 'selected' : '' }}>
                      {{ $nombre }}
                  </option>
              @endforeach
          </select>

          {{-- Input oculto solo si hay un único comercial (para enviar el valor aunque el select esté disabled) --}}
          @if(count($comerciales) === 1)
              <input type="hidden" name="comercial_id" value="{{ $comercialSeleccionado }}">
          @endif
        </div>

        <div class="mb-4 m-5">
          <label for="email" class="block text-gray-700 mb-1">Email *</label>
          <input type="email" name="email" id="email"
                 class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400"
                 value="{{ old('email') }}">
        </div>

        <div class="mb-4 m-5">
          <label for="telefono" class="block text-gray-700 mb-1">Teléfono *</label>
          <input type="text" name="telefono" id="telefono"
                 class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400"
                 value="{{ old('telefono') }}">
        </div>

        <div class="mb-4 m-5">
          <label for="direccion" class="block text-gray-700 mb-1">Dirección *</label>
          <input type="text" name="direccion" id="direccion"
                 class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400"
                 value="{{ old('direccion') }}">
        </div>

        <div class="mb-4 m-5">
          <label for="tipo_negocio" class="block text-gray-700 mb-1">Tipo de Negocio *</label>
          <input type="text" name="tipo_negocio" id="tipo_negocio"
                 class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400"
                 value="{{ old('tipo_negocio') }}">
        </div>

        <div class="mb-6 m-5">
          <button type="submit"
                  class="bg-orange-400 hover:bg-orange-500 text-white font-semibold px-6 py-2 rounded-lg mr-4">
            Guardar
          </button>
          <a href="{{ route('clientes.index') }}"
             class="bg-orange-300 hover:bg-orange-400 text-white font-semibold px-6 py-2 rounded-lg">
            Cancelar
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

