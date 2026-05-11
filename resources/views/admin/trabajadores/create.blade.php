@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-orange-50 py-12">
  <div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-2xl shadow-lg p-8">

      {{-- Enlace volver al panel --}}
      <div class="mb-6">
        <a href="{{ route('admin.dashboard') }}"
           class="inline-block text-orange-500 hover:underline m-3 font-medium">
          ← Volver al Panel
        </a>
      </div>

      <h1 class="text-3xl font-semibold mb-6 text-orange-800 text-center p-6">
        Nuevo Comercial
      </h1>

      @if ($errors->any())
        <div class="alert alert-danger mb-6 bg-orange-100 border border-orange-300 text-orange-700 p-4 rounded-lg">
          <h5 class="font-semibold mb-2">Completa correctamente el formulario.</h5>
        </div>
      @endif

      <form action="{{ route('admin.trabajadores.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 gap-4">
          <div class="m-5">
            <label class="block text-gray-700 font-medium">Nombre completo *</label>
            <input type="text" name="name"
                   value="{{ old('name') }}"
                   class="w-full border border-orange-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400">
          </div>

          <div class="m-5">
            <label class="block text-gray-700 font-medium">Email *</label>
            <input type="email" name="email"
                   value="{{ old('email') }}"
                   class="w-full border border-orange-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400">
          </div>

        <div class="mt-6 m-5 p-4 flex space-x-4">
          <button type="submit"
                  class="bg-orange-400 hover:bg-orange-500 text-white font-semibold px-6 py-2 rounded-lg shadow">
            Guardar
          </button>
          <a href="{{ route('admin.trabajadores.index') }}"
             class="bg-orange-300 hover:bg-orange-400 text-white font-semibold px-6 py-2 rounded-lg shadow inline-block text-center">
            Cancelar
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
