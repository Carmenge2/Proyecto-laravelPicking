@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        {{-- Cabecera --}}
        <x-ui.page-header title="Comerciales" actionLabel="Nuevo Comercial" :actionRoute="route('admin.trabajadores.create')"/>

        {{-- Filtro --}}
        <x-ui.card>
            <form action="{{ route('admin.trabajadores.index') }}" method="GET" class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-[250px]">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1.5">Buscar</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                           placeholder="Nombre o email"
                           class="w-full border border-orange-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition">
                </div>
                <div class="flex gap-2">
                    <x-ui.button type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 100-15 7.5 7.5 0 000 15z"/>
                        </svg>
                        Buscar
                    </x-ui.button>
                    <x-ui.button variant="secondary" href="{{ route('admin.trabajadores.index') }}">Limpiar</x-ui.button>
                </div>
            </form>
        </x-ui.card>

        {{-- Tabla --}}
        @if($trabajadores->isEmpty())
            <x-ui.card>
                <x-ui.empty-state message="No hay comerciales registrados." actionLabel="Crear Comercial" :actionRoute="route('admin.trabajadores.create')"/>
            </x-ui.card>
        @else
            <x-ui.table :headers="['ID', 'Nombre', 'Email', 'Rol', 'Acciones']">
                @foreach($trabajadores as $t)
                    <tr class="hover:bg-orange-50/50 transition">
                        <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $t->id }}</td>
                        <td class="px-4 py-3 text-sm font-semibold text-gray-800">{{ $t->name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $t->email }}</td>
                        <td class="px-4 py-3">
                            <x-ui.badge type="{{ $t->rol }}">{{ ucfirst($t->rol) }}</x-ui.badge>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.trabajadores.edit', $t) }}" class="text-blue-500 hover:text-blue-700 transition" title="Editar" aria-label="Editar comercial">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"/>
                                    </svg>
                                </a>
                                <x-ui.confirm-delete :action="route('admin.trabajadores.destroy', $t)"/>
                            </div>
                        </td>
                    </tr>
                @endforeach

                <x-slot name="pagination">
                    {{ $trabajadores->appends(request()->only('search'))->links() }}
                </x-slot>
            </x-ui.table>
        @endif

    </div>
</div>
@endsection

