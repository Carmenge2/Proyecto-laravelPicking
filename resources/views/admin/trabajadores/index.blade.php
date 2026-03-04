@extends('layouts.app')

@section('content')
<div class="py-12 bg-orange-50 min-h-screen">
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

    {{-- Enlace volver al panel --}}
    <div class="flex justify-between items-center bg-white p-6 rounded-xl shadow">
      <div>
        <a href="{{ route('admin.dashboard') }}"
           class="inline-block text-orange-500 hover:underline font-medium">
          ← Volver al Panel
        </a>
      </div>
    </div>

    {{-- Header + botón Nuevo --}}
    <div class="flex justify-between items-center bg-white p-6 rounded-xl shadow">
      <h1 class="text-2xl font-semibold text-gray-800">Comerciales</h1>
      <a href="{{ route('admin.trabajadores.create') }}"
         class="bg-orange-400 hover:bg-orange-500 text-white font-semibold px-5 py-2 rounded-lg shadow">
        + Nuevo Comercial
      </a>
    </div>

    {{-- Filtro por nombre completo / correo --}}
    <div class="bg-white p-6 rounded-xl shadow">
      <form action="{{ route('admin.trabajadores.index') }}"
            method="GET"
            class="flex flex-wrap gap-4 items-end">

        <div class="flex-1 min-w-[200px]">
          <label for="search" class="block text-gray-600 font-medium mb-1">Buscar Comercial</label>
          <input type="text"
                 name="search"
                 id="search"
                 value="{{ request('search') }}"
                 placeholder="Nombre completo o email"
                 class="w-full border border-orange-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400">
        </div>

        <div class="flex space-x-2">
          <button type="submit"
                  class="bg-orange-400 hover:bg-orange-500 text-white font-semibold px-5 py-2 rounded-lg shadow">
            Buscar
          </button>
          <a href="{{ route('admin.trabajadores.index') }}"
             class="bg-orange-300 hover:bg-orange-400 text-white font-semibold px-5 py-2 rounded-lg shadow">
            Limpiar
          </a>
        </div>
      </form>
    </div>

{{-- Tabla --}}
<div class="bg-white p-6 rounded-xl shadow overflow-x-auto">
  <table class="min-w-full table-auto">
    <thead>
      <tr class="bg-orange-100 text-left text-gray-800">
        <th class="px-4 py-2">Número Comercial</th>
        <th class="px-4 py-2">Nombre</th>
        <th class="px-4 py-2">Email</th>
        <th class="px-4 py-2">Rol</th>
        <th class="px-4 py-2">Acciones</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-orange-100">
      @foreach($trabajadores as $t)
        <tr class="hover:bg-orange-50">
          <td class="px-4 py-3">{{ $t->id }}</td>
          <td class="px-6 py-4">{{ $t->name }}</td>
          <td class="px-4 py-3">{{ $t->email }}</td>
          <td class="px-4 py-3">{{ ucfirst($t->rol) }}</td>
          <td class="px-4 py-3 space-x-2">
            <a href="{{ route('admin.trabajadores.edit', $t) }}"
               class="text-blue-400 hover:underline">Editar</a>
            <form action="{{ route('admin.trabajadores.destroy', $t) }}"
                  method="POST" class="inline">
              @csrf @method('DELETE')
              <button type="submit"
                      class="text-red-600 hover:underline"
                      onclick="return confirm('¿Borrar este trabajador?')">
                Borrar
              </button>
            </form>
          </td>
        </tr>
      @endforeach
        </tbody>
      </table>

      {{-- Paginación --}}
      <div class="mt-4">
        {{ $trabajadores->links() }}
      </div>
    </div>

  </div>
</div>
@endsection

