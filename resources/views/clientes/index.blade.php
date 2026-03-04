@extends('layouts.app')

@section('content')
<div class="py-10 bg-orange-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-6 space-y-6">

        {{-- Enlace volver al panel --}}
        <div class="bg-white p-2 rounded-xl shadow flex justify-between items-center">
            <a href="{{ route('comercial.dashboard') }}"
               class="text-orange-500 hover:underline font-medium">
                ← Volver al Panel
            </a>
        </div>

        {{-- Header + botón Nuevo --}}
                <a href="{{ route('clientes.create') }}"
            class="inline-flex items-center justify-center bg-orange-500 hover:bg-orange-600
                    text-white font-semibold px-4 py-2 rounded-xl shadow-md transition"
                title="Nuevo Cliente">

                    <svg xmlns="http://www.w3.org/2000/svg" 
                        fill="none" viewBox="0 0 24 24" 
                        stroke-width="2" stroke="currentColor" 
                        class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 4.5a3.5 3.5 0 110 7 3.5 3.5 0 010-7zM4 20c0-3 4-5 8-5s8 2 8 5v1H4v-1z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19 7v4m2-2h-4" />
                    </svg>

                </a>
       

        {{-- Filtro --}}
        <div class="bg-white p-6 rounded-xl shadow">
            <form action="{{ route('clientes.index') }}" method="GET" class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-[250px]">
                    <label for="search" class="block text-gray-600 mb-1 font-medium">Buscar Cliente</label>
                    <input type="text" name="search" id="search"
                           value="{{ request('search') }}"
                           placeholder="Nombre comercial, código o razón social"
                           class="w-full border border-orange-200 rounded-lg px-4 py-2 h-11 focus:outline-none focus:ring-2 focus:ring-orange-400">
                </div>

                <div class="flex space-x-2" title="Buscar">
                    <button type="submit"
                        class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 100-15 7.5 7.5 0 000 15z" />
                        </svg>
                    </button>

                        <a href="{{ route('clientes.index') }}"
                        class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-lg flex items-center justify-center"
                        title="Limpiar filtros">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor"
                                class="w-6 h-6">
                                <!-- Embudo -->
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 4h18l-6 7v5l-6 4v-9L3 4z" />
                                <!-- X sobre el filtro -->
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 9l6 6M15 9l-6 6" />
                            </svg>
                        </a>

                </div>
            </form>
        </div>

        {{-- Tabla --}}
        <div class="bg-white p-8 rounded-xl shadow overflow-x-auto">
            <table class="w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-orange-100 text-left text-gray-700 uppercase text-sm tracking-wide">
                        <th class="px-3 py-2">Código</th>
                        <th class="px-3 py-2">Nombre Comercial</th>
                        <th class="px-3 py-2">Razón Social</th>
                        <th class="px-3 py-2">Comercial Asignado</th>
                        <th class="px-3 py-2 text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-orange-100 text-gray-800">
                    @foreach($clientes as $cliente)
                    <tr class="hover:bg-orange-50 transition">
                        <td class="px-2 py-0 font-medium leading-tight h-5">{{ $cliente->id }}</td>
                        <td class="px-2 py-0 font-medium leading-tight h-5">{{ $cliente->nombre_comercial }}</td>
                        <td class="px-2 py-0 font-medium leading-tight h-5">{{ $cliente->razon_social ?? '—' }}</td>
                        <td class="px-2 py-0 font-medium leading-tight h-5">{{ $cliente->comercial->name ?? '—' }}</td>

                        <td style=" height:8px;" class="px-4 py-4 text-center space-x-4 flex justify-center">

                            {{-- VER --}}
                            <a href="{{ route('clientes.show', $cliente) }}"
                            class="text-orange-500 hover:text-orange-700 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </a>

                            {{-- EDITAR --}}
                            <a href="{{ route('clientes.edit', $cliente) }}"
                            class="text-blue-500 hover:text-blue-700 transition mx-3">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.862 3.487a2.25 2.25 0 113.182 3.182L7.125 19.587l-4.2.933.933-4.2L16.862 3.487z" />
                                </svg>
                            </a>

                            {{-- BORRAR --}}
                            <form action="{{ route('clientes.destroy', $cliente) }}" method="POST"
                                onsubmit="return confirm('¿Estás seguro que deseas borrar este cliente?')" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </form>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Paginación --}}
            <div class="mt-6">
                {{ $clientes->appends(request()->only('search'))->links() }}
            </div>
        </div>

    </div>
</div>
@endsection
