@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        {{-- Saludo --}}
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Hola, {{ Auth::user()->name }}</h1>
            <p class="text-sm text-gray-500 mt-1">Panel Comercial</p>
        </div>

        {{-- Stat cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <x-ui.stat-card
                label="Mis Clientes"
                :value="\App\Models\Cliente::where('comercial_id', Auth::id())->count()"
                color="blue"
                icon='<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>'
            />
            <x-ui.stat-card
                label="Mis Pedidos"
                :value="\App\Models\Pedido::where('comercial_id', Auth::id())->count()"
                color="orange"
                icon='<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>'
            />
            <x-ui.stat-card
                label="Pendientes"
                :value="\App\Models\Pedido::where('comercial_id', Auth::id())->where('estado', 'pendiente')->count()"
                color="red"
                icon='<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
            />
        </div>

        {{-- Accesos rápidos --}}
        <div>
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Accesos rápidos</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

                <a href="{{ route('clientes.index') }}"
                   class="group bg-white rounded-2xl shadow-sm p-5 hover:shadow-md hover:-translate-y-0.5 transition flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800 group-hover:text-orange-600 transition">Clientes</p>
                        <p class="text-xs text-gray-500">Gestionar mis clientes</p>
                    </div>
                </a>

                <a href="{{ route('pedidos.index') }}"
                   class="group bg-white rounded-2xl shadow-sm p-5 hover:shadow-md hover:-translate-y-0.5 transition flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800 group-hover:text-orange-600 transition">Pedidos</p>
                        <p class="text-xs text-gray-500">Crear y gestionar pedidos</p>
                    </div>
                </a>

                <a href="{{ route('catalogo.index') }}"
                   class="group bg-white rounded-2xl shadow-sm p-5 hover:shadow-md hover:-translate-y-0.5 transition flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-green-100 text-green-600 flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800 group-hover:text-orange-600 transition">Catálogo</p>
                        <p class="text-xs text-gray-500">Ver productos disponibles</p>
                    </div>
                </a>

            </div>
        </div>

    </div>
</div>
@endsection
