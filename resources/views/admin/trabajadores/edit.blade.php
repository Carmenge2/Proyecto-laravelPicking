@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-orange-50 py-12">
  <div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-2xl shadow-lg p-8 border border-orange-200">

      {{-- Enlace volver al panel --}}
      <div class="mb-6 p-3">
        <a href="{{ route('admin.dashboard') }}"
           class="inline-block text-orange-600 hover:underline font-medium">
          ← Volver al Panel
        </a>
      </div>

      <h1 class="text-3xl font-semibold mb-6 text-orange-800 text-center p-6">
        Editar Comercial {{ $trabajador->id }}
      </h1>

      @if ($errors->any())
        <div class="bg-orange-100 border border-orange-300 text-orange-800 rounded-lg p-4 mb-6">
          <h5 class="font-semibold">Completa correctamente el formulario.</h5>
        </div>
      @endif

      <form action="{{ route('admin.trabajadores.update', $trabajador) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-4">
          <div class="m-5">
            <label class="block text-gray-700 font-medium">Nombre completo *</label>
            <input type="text" name="name"
                   value="{{ old('name', $trabajador->name) }}"
                   class="w-full border border-orange-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400">
          </div>

          <div class="m-5">
            <label class="block text-gray-700 font-medium">Email *</label>
            <input type="email" name="email"
                   value="{{ old('email', $trabajador->email) }}"
                   class="w-full border border-orange-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400">
          </div>

          <div class="m-5">
            <label class="block text-gray-700 font-medium">Rol *</label>
            <select name="rol"
                    class="w-full border border-orange-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400">
              @foreach($roles as $key => $label)
                <option value="{{ $key }}"
                  {{ old('rol', $trabajador->rol) === $key ? 'selected' : '' }}>
                  {{ $label }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="m-5">
            <label class="block text-gray-700 font-medium">Nueva contraseña (opcional)</label>
            <input type="password" name="password"
                   class="w-full border border-orange-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400">
          </div>

          <div class="m-5">
            <label class="block text-gray-700 font-medium">Repetir contraseña</label>
            <input type="password" name="password_confirmation"
                   class="w-full border border-orange-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400">
          </div>
        </div>

        <div class="mt-6 m-5 p-4 flex space-x-4">
          <button type="submit"
                  class="bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 px-6 rounded-lg transition shadow">
            Actualizar
          </button>
          <a href="{{ route('admin.trabajadores.index') }}"
             class="bg-orange-200 hover:bg-orange-300 text-orange-900 font-semibold py-2 px-6 rounded-lg transition shadow">
            Cancelar
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
