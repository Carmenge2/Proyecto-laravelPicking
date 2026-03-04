@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-orange-50 py-12"> {{-- Fondo naranja clarito --}}
  <div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-2xl shadow-lg p-8">

      {{-- Enlace para volver --}}
      <div class="mb-6">
        <a href="{{ route('clientes.index') }}" class="inline-block text-orange-600 hover:underline">
          ← Volver a Clientes
        </a>
      </div>

      <h1 class="text-3xl font-semibold mb-6 text-orange-800 text-center p-6">
        Editar Cliente {{ $cliente->nombre_comercial }}
      </h1>

      @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
          <strong>Completa correctamente el formulario.</strong>
          <ul class="mt-2 list-disc list-inside">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form action="{{ route('clientes.update', $cliente) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4 m-5">
          <label for="nombre_comercial" class="block text-gray-700 mb-1">Nombre Comercial *</label>
          <input
            type="text"
            name="nombre_comercial"
            id="nombre_comercial"
            value="{{ old('nombre_comercial', $cliente->nombre_comercial) }}"
            required
            class="w-full border border-gray-300 rounded-lg px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 @error('nombre_comercial') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
          >
          @error('nombre_comercial')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <div class="mb-4 m-5">
          <label for="razon_social" class="block text-gray-700 mb-1">Razón Social *</label>
          <input
            type="text"
            name="razon_social"
            id="razon_social"
            value="{{ old('razon_social', $cliente->razon_social) }}"
            required
            class="w-full border border-gray-300 rounded-lg px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 @error('razon_social') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
          >
          @error('razon_social')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <div class="mb-4 m-5">
          <label for="email" class="block text-gray-700 mb-1">Email</label>
          <input
            type="email"
            name="email"
            id="email"
            value="{{ old('email', $cliente->email) }}"
            class="w-full border border-gray-300 rounded-lg px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 @error('email') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
          >
          @error('email')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <div class="mb-4 m-5">
          <label for="telefono" class="block text-gray-700 mb-1">Teléfono</label>
          <input
            type="text"
            name="telefono"
            id="telefono"
            value="{{ old('telefono', $cliente->telefono) }}"
            class="w-full border border-gray-300 rounded-lg px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 @error('telefono') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
          >
          @error('telefono')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <div class="mb-4 m-5">
          <label for="direccion" class="block text-gray-700 mb-1">Dirección</label>
          <input
            type="text"
            name="direccion"
            id="direccion"
            value="{{ old('direccion', $cliente->direccion) }}"
            class="w-full border border-gray-300 rounded-lg px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 @error('direccion') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
          >
          @error('direccion')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <div class="mb-4 m-5">
          <label for="tipo_negocio" class="block text-gray-700 mb-1">Tipo de Negocio</label>
          <input
            type="text"
            name="tipo_negocio"
            id="tipo_negocio"
            value="{{ old('tipo_negocio', $cliente->tipo_negocio) }}"
            class="w-full border border-gray-300 rounded-lg px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 @error('tipo_negocio') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
          >
          @error('tipo_negocio')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <div class="mb-6 m-5 flex gap-4">
          <button type="submit" 
                  class="bg-orange-400 hover:bg-orange-500 text-white font-semibold py-2 px-6 rounded-lg transition">
            Actualizar
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
