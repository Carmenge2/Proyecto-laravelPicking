@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-orange-50 py-12">

    <div class="max-w-7xl mx-auto px-4">

        {{-- VOLVER --}}
        <div class="mb-6">
            <a href="{{ route('comercial.dashboard') }}"
               class="text-orange-600 hover:text-orange-700 font-semibold">
                ← Volver al Panel
            </a>
        </div>

        {{-- CABECERA --}}
        <div class="flex-center items-center mb-8">

        <h3 class="text-5xl font-extrabold text-orange-600 text-center tracking-wide drop-shadow-md">
            Gestión de Clientes
        </h3>

            <a href="{{ route('clientes.create') }}"
               class="inline-flex items-center justify-center bg-orange-500 hover:bg-orange-600
                      text-white font-semibold px-6 py-3 rounded-xl shadow-lg transition">

                <svg xmlns="http://www.w3.org/2000/svg"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke-width="2"
                     stroke="currentColor"
                     class="w-6 h-6 mr-2">

                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 4.5a3.5 3.5 0 110 7 3.5 3.5 0 010-7zM4 20c0-3 4-5 8-5s8 2 8 5v1H4v-1z" />

                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M19 7v4m2-2h-4" />
                </svg>

                Nuevo Cliente
            </a>

        </div>

        {{-- FILTRO --}}
        <div class="bg-white shadow-xl rounded-2xl p-8 mb-8">

            <form action="{{ route('clientes.index') }}"
                  method="GET"
                  class="flex flex-wrap gap-4 items-end">

                <div class="flex-1 min-w-[300px]">

                    <label for="search"
                           class="block text-orange-700 font-semibold mb-2">
                        Buscar Cliente
                    </label>

                    <input type="text"
                           name="search"
                           id="search"
                           value="{{ request('search') }}"
                           placeholder="Nombre comercial, código o razón social"
                           class="w-full border border-orange-300 rounded-xl px-4 py-3
                                  focus:outline-none focus:ring-2 focus:ring-orange-400">

                </div>

                <div class="flex gap-2">

                    {{-- BUSCAR --}}
                    <button type="submit"
                            class="bg-orange-500 hover:bg-orange-600 text-white
                                   px-5 py-3 rounded-xl shadow transition">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-5 h-5"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke-width="2"
                             stroke="currentColor">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 100-15 7.5 7.5 0 000 15z" />

                        </svg>

                    </button>

                    {{-- LIMPIAR --}}
                    <a href="{{ route('clientes.index') }}"
                       class="bg-gray-400 hover:bg-gray-500 text-white
                              px-5 py-3 rounded-xl shadow transition">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke-width="2"
                             stroke="currentColor"
                             class="w-5 h-5">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M3 4h18l-6 7v5l-6 4v-9L3 4z" />

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M9 9l6 6M15 9l-6 6" />
                        </svg>

                    </a>

                </div>

            </form>

        </div>

{{-- TABLA DE CLIENTES --}}
<div class="bg-white p-8 rounded-xl shadow overflow-x-auto">

    <table class="w-full table-auto border-collapse">

        <thead>
            <tr class="bg-orange-100 text-left text-gray-700 uppercase text-sm tracking-wide">

                <th class="px-3 py-2">
                    Código
                </th>

                <th class="px-3 py-2">
                    Nombre Comercial
                </th>

                <th class="px-3 py-2">
                    Razón Social
                </th>

                <th class="px-3 py-2">
                    Comercial Asignado
                </th>

                <th class="px-3 py-2 text-center">
                    Acciones
                </th>

            </tr>
        </thead>

        <tbody class="divide-y divide-orange-100 text-gray-800">

            @foreach($clientes as $cliente)

                <tr class="hover:bg-orange-50 transition">

                    {{-- CÓDIGO --}}
                    <td class="px-2 py-1 leading-tight font-semibold">
                        {{ $cliente->id }}
                    </td>

                    {{-- NOMBRE COMERCIAL --}}
                    <td class="px-2 py-1 leading-tight">
                        <span class="font-semibold">
                            {{ $cliente->nombre_comercial }}
                        </span>
                    </td>

                    {{-- RAZÓN SOCIAL --}}
                    <td class="px-2 py-1 leading-tight">
                        <span class="text-gray-500">
                            {{ $cliente->razon_social ?? '—' }}
                        </span>
                    </td>

                    {{-- COMERCIAL --}}
                    <td class="px-2 py-1 leading-tight">
                        {{ $cliente->comercial->name ?? '—' }}
                    </td>

                    {{-- ACCIONES --}}
                    <td class="px-4 py-1 flex justify-center space-x-4">

                        {{-- VER --}}
                        <a href="{{ route('clientes.show', $cliente) }}"
                           class="text-orange-500 hover:text-orange-700 transition"
                           title="Ver cliente">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-6 h-6"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="2"
                                 stroke="currentColor">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />

                            </svg>

                        </a>

                        {{-- EDITAR --}}
                        <a href="{{ route('clientes.edit', $cliente) }}"
                           class="text-blue-500 hover:text-blue-700 transition"
                           title="Editar cliente">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-6 h-6"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="2"
                                 stroke="currentColor">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M16.862 3.487a2.25 2.25 0 113.182 3.182L7.125 19.587l-4.2.933.933-4.2L16.862 3.487z" />

                            </svg>

                        </a>

                        {{-- BORRAR --}}
                        <form action="{{ route('clientes.destroy', $cliente) }}"
                              method="POST"
                              onsubmit="return confirm('¿Estás seguro que deseas borrar este cliente?')">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="text-red-600 hover:text-red-800 transition"
                                    title="Eliminar cliente">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="w-6 h-6"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke-width="2"
                                     stroke="currentColor">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M6 18L18 6M6 6l12 12" />

                                </svg>

                            </button>

                        </form>

                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>

    {{-- PAGINACIÓN --}}
    <div class="mt-6">
        {{ $clientes->appends(request()->only('search'))->links() }}
    </div>

</div>
            {{-- PAGINACIÓN --}}
            <div class="mt-8">
                {{ $clientes->appends(request()->only('search'))->links() }}
            </div>

        </div>

    </div>
</div>
@endsection