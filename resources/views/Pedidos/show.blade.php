@extends('layouts.app')

@section('content')
<div class="bg-orange-50 min-h-screen py-12">
    <div class="max-w-4xl mx-auto space-y-6 px-4 sm:px-6 lg:px-8">

        {{-- Título --}}
        <div class="bg-white p-6 rounded-xl shadow">
            <h1 class="text-2xl font-semibold text-orange-700">Detalles del Pedido {{ $pedido->id }}</h1>
        </div>

        {{-- Detalle del pedido --}}
        <div class="bg-white rounded-xl shadow p-6 space-y-4 text-gray-800">
            <div>
                <p class="font-semibold text-orange-600">Cliente:</p>
                <p>
                    {{ $pedido->cliente->nombre_comercial ?? '—' }}<br>
                    <span class="text-sm text-gray-500">{{ $pedido->cliente->razon_social ?? '' }}</span>
                </p>
            </div>

            <div>
                <p class="font-semibold text-orange-600">Productos:</p>
                <ul class="list-disc list-inside text-sm text-gray-700">
                    @foreach($pedido->productos as $producto)
                        <li>{{ $producto->nombre }} ({{ $producto->pivot->cantidad }})</li>
                    @endforeach
                </ul>
            </div>

            <div>
                <p class="font-semibold text-orange-600">Total:</p>
                <p>{{ number_format($pedido->total, 2, ',', '.') }}€</p>
            </div>

            <div>
                <p class="font-semibold text-orange-600">Comercial:</p>
                <p>{{ $pedido->comercial->name ?? 'Sin comercial asignado' }}</p>
            </div>

            <div>
                <p class="font-semibold text-orange-600">Fecha de Entrega:</p>
                <p>{{ \Carbon\Carbon::parse($pedido->fecha)->format('d/m/Y') }}</p>
            </div>

            <div>
                <p class="font-semibold text-orange-600">Estado:</p>
                <p class="capitalize">{{ $pedido->estado }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-400">
                    Creado el {{ $pedido->created_at->format('d/m/Y H:i') }}
                </p>
            </div>
        </div>

        {{-- Botones --}}
        <div class="flex space-x-2">
            <a href="{{ route('pedidos.edit', $pedido) }}" 
               class="bg-orange-400 hover:bg-orange-500 text-white font-semibold py-2 px-4 rounded-lg transition">
               Editar
            </a>
            <a href="{{ route('pedidos.index') }}" 
               class="bg-gray-400 hover:bg-gray-500 text-white font-semibold py-2 px-4 rounded-lg transition">
               Volver
            </a>
        </div>

    </div>
</div>
@endsection
