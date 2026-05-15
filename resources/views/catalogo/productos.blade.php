@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        <x-ui.back-link :href="route('catalogo.index')" label="Volver a categorías"/>

        {{-- Header --}}
        <div class="flex flex-wrap items-center justify-between gap-4">
            <h1 class="text-2xl font-bold text-gray-900">{{ $categoriaSeleccionada->nombre }}</h1>

            @if(Auth::user()->rol === 'admin')
                <div class="flex flex-wrap items-center gap-2">
                    <x-ui.button href="{{ route('productos.create', ['categoria_id' => $categoriaSeleccionada->id]) }}">
                        + Agregar Producto
                    </x-ui.button>
                    <x-ui.button variant="secondary" href="{{ route('categorias.edit', $categoriaSeleccionada->id) }}">
                        Editar Categoría
                    </x-ui.button>
                    <x-ui.confirm-delete :action="route('categorias.destroy', $categoriaSeleccionada->id)" label="Eliminar Categoría"/>
                </div>
            @endif
        </div>

        {{-- Product Grid --}}
        @if($productos->isEmpty())
            <x-ui.card>
                <x-ui.empty-state message="No hay productos en esta categoría."
                    actionLabel="Agregar Producto"
                    :actionRoute="route('productos.create', ['categoria_id' => $categoriaSeleccionada->id])"/>
            </x-ui.card>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($productos as $producto)
                    <div class="bg-white rounded-2xl shadow-sm overflow-hidden flex flex-col hover:shadow-md hover:-translate-y-0.5 transition">

                        <a href="{{ route('catalogo.producto', $producto->id) }}" class="block">
                            @if($producto->imagen)
                                <img src="{{ asset('storage/'.$producto->imagen) }}"
                                     alt="{{ $producto->nombre }}"
                                     class="w-full h-44 object-cover">
                            @else
                                <div class="w-full h-44 bg-orange-50 flex items-center justify-center">
                                    <span class="text-orange-400 text-sm font-medium">Sin imagen</span>
                                </div>
                            @endif

                            <div class="p-4">
                                <h3 class="font-semibold text-gray-900 mb-1">{{ $producto->nombre }}</h3>
                                <p class="text-lg font-bold text-gray-900">{{ number_format($producto->precio, 2) }} €</p>
                                <div class="mt-2">
                                    <x-ui.badge type="{{ $producto->estado }}">{{ ucfirst($producto->estado) }}</x-ui.badge>
                                </div>
                            </div>
                        </a>

                        @if(Auth::user()->rol === 'admin')
                            <div class="px-4 pb-4 pt-0 flex gap-2 mt-auto">
                                <a href="{{ route('productos.edit', $producto->id) }}"
                                   class="flex-1 text-center text-sm font-medium px-3 py-1.5 rounded-lg bg-orange-50 text-orange-600 hover:bg-orange-100 transition">
                                    Editar
                                </a>
                                <x-ui.confirm-delete :action="route('productos.destroy', $producto->id)"/>
                            </div>
                        @endif

                    </div>
                @endforeach
            </div>
        @endif

    </div>
</div>
@endsection