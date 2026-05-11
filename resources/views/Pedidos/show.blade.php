@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-orange-50 py-12">

    {{-- VOLVER --}}
    <div class="max-w-5xl mx-auto px-4 mb-6">
        <a href="{{ route('pedidos.index') }}"
           class="text-orange-600 hover:text-orange-700 font-semibold">
            ← Volver a Pedidos
        </a>
    </div>

    <div class="max-w-6xl mx-auto px-4">

        {{-- TÍTULO --}}
        <h1 class="text-4xl font-extrabold text-orange-600 text-center mb-8">
            Detalles del Pedido {{ $pedido->id }}
        </h1>

        {{-- TARJETA --}}
        <div class="bg-white shadow-xl rounded-2xl p-12">

            {{-- CLIENTE --}}
            <div class="mb-6">
                <h2 class="text-orange-700 font-bold text-lg mb-2">
                    Cliente
                </h2>

                <div class="bg-orange-50 border border-orange-100 rounded-xl p-2">
                    <p class="font-semibold text-gray-800">
                        {{ $pedido->cliente->nombre_comercial ?? '—' }}
                    </p>

                    <p class="text-sm text-gray-500">
                        {{ $pedido->cliente->razon_social ?? '' }}
                    </p>
                </div>
            </div>

            {{-- PRODUCTOS --}}
            <div class="mb-6">
                <h2 class="text-orange-700 font-bold text-lg mb-2">
                    Productos
                </h2>

                <div class="space-y-2">

                    @foreach($pedido->productos as $producto)

                        <div class="flex justify-between items-center bg-orange-50 border border-orange-100 rounded-xl p-2">

                            <div>
                                <p class="font-semibold text-gray-800">
                                    {{ $producto->nombre }}
                                </p>

                                <p class="text-sm text-gray-500">
                                    {{ number_format($producto->precio, 2) }}€
                                </p>
                            </div>

                            <div class="text-orange-700 font-bold">
                                x{{ $producto->pivot->cantidad }}
                            </div>

                        </div>

                    @endforeach

                </div>
            </div>

            {{-- TOTAL --}}
            <div class="mb-6">
                <h2 class="text-orange-700 font-bold text-lg mb-2">
                    Total
                </h2>

                <div class="bg-orange-50 border border-orange-100 rounded-xl p-2">
                    <p class="text-2xl font-extrabold text-orange-600">
                        {{ number_format($pedido->total, 2, ',', '.') }}€
                    </p>
                </div>
            </div>

            {{-- INFORMACIÓN --}}
            <div class="grid md:grid-cols-3 gap-4 mb-6">

                {{-- COMERCIAL --}}
                <div class="bg-orange-50 border border-orange-100 rounded-xl p-2">
                    <p class="text-sm text-orange-600 font-semibold mb-1">
                        Comercial
                    </p>

                    <p class="font-semibold text-gray-800">
                        {{ $pedido->comercial->name ?? 'Sin asignar' }}
                    </p>
                </div>

                {{-- FECHA --}}
                <div class="bg-orange-50 border border-orange-100 rounded-xl p-2">
                    <p class="text-sm text-orange-600 font-semibold mb-1">
                        Fecha de Entrega
                    </p>

                    <p class="font-semibold text-gray-800">
                        {{ \Carbon\Carbon::parse($pedido->fecha)->format('d/m/Y') }}
                    </p>
                </div>

                {{-- ESTADO --}}
                <div class="bg-orange-50 border border-orange-100 rounded-xl p-2">
                    <p class="text-sm text-orange-600 font-semibold mb-1">
                        Estado
                    </p>

                    <p class="font-semibold text-gray-800 capitalize">
                        {{ $pedido->estado }}
                    </p>
                </div>

            </div>

            {{-- FECHA CREACIÓN --}}
            <div class="mb-8">
                <p class="text-sm text-gray-400">
                    Creado el {{ $pedido->created_at->format('d/m/Y H:i') }}
                </p>
            </div>

            {{-- BOTONES --}}
            <div class="flex justify-between items-center">

                <a href="{{ route('pedidos.index') }}"
                class="text-orange-600 hover:text-orange-700 font-semibold">
                    ← Volver 
                </a>

                <a href="{{ route('pedidos.edit', $pedido) }}"
                   class="px-8 py-3 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-xl shadow-lg">
                    Editar Pedido
                </a>

            </div>

        </div>

    </div>
</div>
@endsection