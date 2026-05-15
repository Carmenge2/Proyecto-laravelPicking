@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        <x-ui.back-link :href="route('pedidos.index')" label="Volver a Pedidos"/>

        <x-ui.card>
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Pedido #{{ $pedido->id }}</h1>
                <x-ui.badge type="{{ $pedido->estado }}">{{ ucfirst($pedido->estado) }}</x-ui.badge>
            </div>

            {{-- Info grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                <div class="bg-orange-50 rounded-xl p-4">
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Comercial</p>
                    <p class="mt-1 text-sm font-semibold text-gray-900">{{ $pedido->comercial->name ?? 'Sin asignar' }}</p>
                </div>
                <div class="bg-orange-50 rounded-xl p-4">
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Entrega</p>
                    <p class="mt-1 text-sm font-semibold text-gray-900">{{ \Carbon\Carbon::parse($pedido->fecha)->format('d/m/Y') }}</p>
                </div>
                <div class="bg-orange-50 rounded-xl p-4">
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Total</p>
                    <p class="mt-1 text-lg font-bold text-orange-600">{{ number_format($pedido->total, 2, ',', '.') }} €</p>
                </div>
            </div>

            {{-- Cliente --}}
            <div class="mb-6">
                <h2 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Cliente</h2>
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="font-semibold text-gray-900">{{ $pedido->cliente->nombre_comercial ?? '—' }}</p>
                    <p class="text-sm text-gray-500">{{ $pedido->cliente->razon_social ?? '' }}</p>
                </div>
            </div>

            {{-- Productos --}}
            <div class="mb-6">
                <h2 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Productos</h2>
                <div class="space-y-2">
                    @foreach($pedido->productos as $producto)
                        <div class="flex justify-between items-center bg-gray-50 rounded-xl px-4 py-3">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $producto->nombre }}</p>
                                <p class="text-xs text-gray-500">{{ number_format($producto->precio, 2) }} €/ud</p>
                            </div>
                            <span class="text-sm font-bold text-orange-600">x{{ $producto->pivot->cantidad }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <p class="text-xs text-gray-400">Creado el {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
        </x-ui.card>

        <div class="flex items-center gap-3">
            <x-ui.button href="{{ route('pedidos.edit', $pedido) }}">Editar Pedido</x-ui.button>
            <x-ui.button variant="secondary" href="{{ route('pedidos.index') }}">Volver</x-ui.button>
        </div>

    </div>
</div>
@endsection