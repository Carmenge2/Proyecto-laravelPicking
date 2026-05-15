@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        {{-- Cabecera --}}
        <x-ui.page-header title="Pedidos" actionLabel="Crear Pedido" :actionRoute="route('pedidos.create')"/>

        {{-- Filtros --}}
        <x-ui.card>
            <form action="{{ route('pedidos.index') }}" method="GET" class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Cliente</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Nombre comercial o razón social"
                           class="w-full border border-orange-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition">
                </div>
                <div class="min-w-[160px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Fecha entrega</label>
                    <input type="date" name="fecha" value="{{ request('fecha') }}"
                           class="w-full border border-orange-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition">
                </div>
                <div class="min-w-[140px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Estado</label>
                    <select name="estado"
                            class="w-full border border-orange-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition">
                        <option value="">Todos</option>
                        <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="enviado" {{ request('estado') == 'enviado' ? 'selected' : '' }}>Enviado</option>
                        <option value="cancelado" {{ request('estado') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <x-ui.button type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 100-15 7.5 7.5 0 000 15z"/>
                        </svg>
                        Buscar
                    </x-ui.button>
                    <x-ui.button variant="secondary" href="{{ route('pedidos.index') }}">Limpiar</x-ui.button>
                </div>
            </form>
        </x-ui.card>

        {{-- Tabla --}}
        @if($pedidos->isEmpty())
            <x-ui.card>
                <x-ui.empty-state message="No hay pedidos registrados." actionLabel="Crear Pedido" :actionRoute="route('pedidos.create')"/>
            </x-ui.card>
        @else
            <x-ui.table :headers="['N.º', 'Cliente', 'Total', 'Fecha', 'Comercial', 'Estado', 'Acciones']">
                @foreach($pedidos as $pedido)
                    <tr class="hover:bg-orange-50/50 transition">
                        <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $pedido->id }}</td>
                        <td class="px-4 py-3">
                            <p class="text-sm font-semibold text-gray-800">{{ $pedido->cliente->nombre_comercial }}</p>
                            <p class="text-xs text-gray-500">{{ $pedido->cliente->razon_social }}</p>
                        </td>
                        <td class="px-4 py-3 text-sm font-semibold text-gray-900">{{ number_format($pedido->total, 2, ',', '.') }} €</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $pedido->created_at->format('d/m/Y') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $pedido->comercial->name ?? '—' }}</td>
                        <td class="px-4 py-3">
                            <x-ui.badge type="{{ $pedido->estado }}">{{ ucfirst($pedido->estado) }}</x-ui.badge>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('pedidos.show', $pedido) }}" class="text-orange-500 hover:text-orange-700 transition" title="Ver" aria-label="Ver pedido">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('pedidos.edit', $pedido) }}" class="text-blue-500 hover:text-blue-700 transition" title="Editar" aria-label="Editar pedido">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"/>
                                    </svg>
                                </a>
                                <x-ui.confirm-delete :action="route('pedidos.destroy', $pedido)"/>
                            </div>
                        </td>
                    </tr>
                @endforeach

                <x-slot name="pagination">
                    {{ $pedidos->appends(request()->only(['search', 'fecha', 'estado']))->links() }}
                </x-slot>
            </x-ui.table>
        @endif

    </div>
</div>
@endsection
