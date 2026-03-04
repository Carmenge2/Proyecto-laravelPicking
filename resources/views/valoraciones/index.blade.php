@extends('layouts.app')

@section('content')
<div class="py-12 bg-orange-50 min-h-screen">
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

    {{-- Enlace volver --}}
    <div class="flex justify-between items-center bg-white p-6 rounded-xl shadow">
      <a href="{{ route('login') }}"
         class="inline-block text-orange-500 hover:underline font-medium">
        ← Volver al Panel
      </a>
    </div>

    {{-- Header + botón Nuevo --}}
    <div class="flex justify-between items-center bg-white p-6 rounded-xl shadow">
      <h1 class="text-2xl font-semibold text-gray-800">Valoraciones</h1>
      <a href="{{ route('valoraciones.create') }}"
         class="bg-orange-400 hover:bg-orange-500 text-white font-semibold px-5 py-2 rounded-lg">
        + Nueva Valoración
      </a>
    </div>

    {{-- Filtro por puntuación --}}
    <div class="bg-white p-6 rounded-xl shadow">
      <form action="{{ route('valoraciones.index') }}" method="GET" class="flex items-end gap-4 flex-wrap">
        <div class="flex-1 min-w-[200px]">
          <label for="valoracion" class="block text-orange-500 mb-1">Filtrar por puntuación:</label>
          <select name="valoracion" id="valoracion"
                  class="w-full border border-orange-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400">
            <option value="">Todas</option>
            @for($i = 1; $i <= 5; $i++)
              <option value="{{ $i }}" {{ request('valoracion') == $i ? 'selected' : '' }}>
                {{ $i }} estrella{{ $i > 1 ? 's' : '' }}
              </option>
            @endfor
          </select>
        </div>
        <div class="flex space-x-2">
          <button type="submit"
                  class="bg-orange-400 hover:bg-orange-500 text-white font-semibold px-4 py-2 rounded-lg">
            Buscar
          </button>
          <a href="{{ route('valoraciones.index') }}"
             class="bg-orange-300 hover:bg-orange-400 text-white font-semibold px-4 py-2 rounded-lg">
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
            <th class="px-4 py-2">Número Valoración</th>
            <th class="px-4 py-2">Cliente</th>
            <th class="px-4 py-2">Puntuación</th>
            <th class="px-4 py-2">Comentario</th>
            <th class="px-4 py-2">Acciones</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-orange-100">
          @foreach($valoraciones as $v)
          <tr class="hover:bg-orange-50">
            <td class="px-4 py-3">{{ $v->id }}</td>
            <td class="px-6 py-4">{{ $v->cliente->nombre_comercial }}</td>
            <td class="px-4 py-3">{{ $v->valoracion }}</td>
            <td class="px-4 py-3">{{ Str::limit($v->comentario, 50) }}</td>
            <td class="px-4 py-3 space-x-2">
              <a href="{{ route('valoraciones.edit', $v) }}"
                 class="text-blue-400 hover:underline">Editar</a>
              <form action="{{ route('valoraciones.destroy', $v) }}" method="POST" class="inline">
                @csrf @method('DELETE')
                <button type="submit"
                        class="text-red-600 hover:underline"
                        onclick="return confirm('¿Borrar esta valoración?')">
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
        {{ $valoraciones->links() }}
      </div>
    </div>
  </div>
</div>
@endsection

