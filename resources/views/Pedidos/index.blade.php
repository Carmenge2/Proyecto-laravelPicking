@extends('layouts.app')

@section('content')
<div class="py-10 bg-orange-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-6 space-y-6">

        {{--  Volver al panel --}}
        <div class="bg-white p-4 rounded-xl shadow flex justify-between items-center">
            <a href="{{ route('comercial.dashboard') }}"
               class="text-orange-600 hover:text-orange-700 font-semibold">
               ← Volver al Panel
            </a>

        </div>
        {{--  Título --}}
        <h3 class="text-5xl font-extrabold text-orange-600 text-center tracking-wide drop-shadow-md">
            Gestión de Pedidos
        </h3>
        
        {{--  Nuevo Pedido (ICONO) --}}
            <a href="{{ route('pedidos.create') }}"
               class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-xl shadow flex items-center"
               title="Nuevo Pedido">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                     class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </a>



        {{--  FILTROS --}}
        <div class="bg-white p-6 rounded-xl shadow">
            <form action="{{ route('pedidos.index') }}" method="GET" class="flex flex-wrap gap-4 items-end">

                {{-- Buscar por cliente --}}
                <div class="flex-1 min-w-[240px]">
                    <label class="text-gray-700 font-medium">Búsqueda de Cliente</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="w-full border border-orange-200 rounded-lg px-4 py-2 h-11 focus:ring-2 focus:ring-orange-400"
                           placeholder="Nombre comercial, razón social o Código de cliente">
                </div>

                {{-- Fecha --}}
                <div>
                    <label class="text-gray-700 font-medium">Fecha de Entrega</label>
                    <input type="date" name="fecha" value="{{ request('fecha') }}"
                           class="w-full border border-orange-200 rounded-lg px-4 py-2 h-11 focus:ring-2 focus:ring-orange-400">
                </div>

                <!-- Filtrar por estado -->
                <div class="min-w-[160px]">
                    <label for="estado" class="text-gray-700 font-medium">Estado</label>
                    <select name="estado" id="estado"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2
                            focus:outline-none focus:ring-2 focus:ring-orange-400">

                        <option value="">Todos</option>
                        <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="entregado" {{ request('estado') == 'entregado' ? 'selected' : '' }}>Entregado</option>
                        <option value="cancelado" {{ request('estado') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>

                    </select>
                </div>


                {{-- Botón buscar --}}
                <button type="submit"
                        class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg shadow flex items-center"
                        title="Buscar">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                         viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 100-15 7.5 7.5 0 000 15z" />
                    </svg>
                </button>

                {{-- Limpiar filtros --}}
                <a href="{{ route('pedidos.index') }}"
                   class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-lg shadow flex items-center"
                   title="Limpiar filtros">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-6 h-6" fill="none"
                         viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3 4h18l-6 7v5l-6 4v-9L3 4z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9 9l6 6M15 9l-6 6" />
                    </svg>
                </a>
            </form>
        </div>

        {{--  TABLA DE PEDIDOS --}}
        <div class="bg-white p-8 rounded-xl shadow overflow-x-auto">
            <table class="w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-orange-100 text-left text-gray-700 uppercase text-sm tracking-wide">
                        <th class="px-3 py-2">Número</th>
                        <th class="px-3 py-2">Cliente</th>
                        <th class="px-3 py-2">Productos</th>
                        <th class="px-3 py-2">Total</th>
                        <th class="px-3 py-2">Fecha</th>
                        <th class="px-3 py-2">Comercial</th>
                        <th class="px-3 py-2">Estado</th>
                        <th class="px-3 py-2 text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-orange-100 text-gray-800">
                    @foreach($pedidos as $pedido)
                    <tr class="hover:bg-orange-50 transition">

                        <td class="px-2 py-1 leading-tight">{{ $pedido->id }}</td>

                        <td class="px-2 py-1 leading-tight">
                            <span class="font-semibold">{{ $pedido->cliente->nombre_comercial }}</span><br>
                            <span class="text-xs text-gray-500">{{ $pedido->cliente->razon_social }}</span>
                        </td>

                        <td class="px-2 py-1 leading-tight">
                            <ul class="list-disc list-inside text-sm">
                                @foreach($pedido->productos as $producto)
                                    <li>{{ $producto->nombre }} ({{ $producto->pivot->cantidad }})</li>
                                @endforeach
                            </ul>
                        </td>

                        <td class="px-2 py-1 leading-tight font-semibold">
                            {{ number_format($pedido->total, 2, ',', '.') }} €
                        </td>

                        <td class="px-2 py-1 leading-tight">
                            {{ \Carbon\Carbon::parse($pedido->fecha)->format('d/m/Y') }}
                        </td>

                        <td class="px-2 py-1 leading-tight">
                            {{ $pedido->comercial->name ?? '—' }}
                        </td>

                        <td class="px-2 py-1 leading-tight">
                            {{ ucfirst($pedido->estado) }}
                        </td>

                        {{-- ICONOS DE ACCIONES --}}
                        <td class="px-4 py-1 flex justify-center space-x-4">

                            {{-- VER --}}
                            <a href="{{ route('pedidos.show', $pedido) }}"
                               class="text-orange-500 hover:text-orange-700 transition"
                               title="Ver pedido">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="w-6 h-6" fill="none"
                                     viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7S3.732 16.057 2.458 12z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </a>

                            {{-- EDITAR --}}
                            <a href="{{ route('pedidos.edit', $pedido) }}"
                               class="text-blue-500 hover:text-blue-700 transition"
                               title="Editar pedido">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="w-6 h-6" fill="none"
                                     viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M16.862 3.487a2.25 2.25 0 113.182 3.182L7.125 19.587l-4.2.933.933-4.2L16.862 3.487z" />
                                </svg>
                            </a>

                            {{-- BORRAR --}}
                            <form action="{{ route('pedidos.destroy', $pedido) }}"
                                  method="POST" onsubmit="return confirm('¿Borrar este pedido?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:text-red-800 transition" title="Eliminar pedido">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="w-6 h-6" fill="none"
                                         viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
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

            {{-- PAGINACIÓN --}}
            <div class="mt-6">
                {{ $pedidos->appends(request()->only(['search', 'fecha']))->links() }}
            </div>

        </div>
    </div>
</div>
@endsection
