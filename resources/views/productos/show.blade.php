@extends('layouts.app')

@section('content')
<div class="py-12 bg-orange-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-6">

        <!-- TÍTULO CATEGORÍA -->
        <h1 class="text-5xl font-extrabold text-orange-600 text-center mb-12">
            {{ $categoriaSeleccionada->nombre }}
        </h1>

        <!-- BOTÓN VOLVER -->
        <div class="text-center mb-12">
            <a href="{{ route('catalogo.index') }}"
               class="inline-flex items-center px-6 py-3 bg-gray-400 hover:bg-gray-500 text-white font-semibold rounded-xl shadow transition">
                ← Volver a categorías
            </a>
        </div>

        <!-- GRID PRODUCTOS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-10">

            @forelse($productos as $producto)

                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300 flex flex-col">

                    <!-- IMAGEN -->
                    @if($producto->imagen)
                        <img src="{{ asset('storage/' . $producto->imagen) }}"
                             class="h-52 w-full object-cover">
                    @else
                        <div class="h-52 w-full bg-orange-100 flex items-center justify-center">
                            <span class="text-orange-600 font-semibold">Sin imagen</span>
                        </div>
                    @endif

                    <!-- CONTENIDO -->
                    <div class="p-6 flex flex-col flex-grow">

                        <h3 class="text-xl font-bold text-gray-800 mb-2">
                            {{ $producto->nombre }}
                        </h3>

                        <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                            {{ $producto->descripcion ?? 'Sin descripción disponible.' }}
                        </p>

                        <div class="mt-auto">

                            <p class="text-2xl font-extrabold text-gray-900 mb-4">
                                {{ number_format($producto->precio, 2) }} €
                            </p>

                            <!-- ESTADO -->
                            <span class="
                                inline-block px-3 py-1 text-xs font-bold rounded-full mb-4
                                @if($producto->estado === 'disponible') bg-green-100 text-green-700
                                @elseif($producto->estado === 'agotado') bg-red-100 text-red-700
                                @else bg-yellow-100 text-yellow-700 @endif
                            ">
                                {{ ucfirst($producto->estado) }}
                            </span>

                            <!-- BOTÓN VER DETALLE -->
                            <a href="{{ route('catalogo.producto', $producto->id) }}"
                               class="block text-center bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 rounded-xl transition">
                                Ver producto
                            </a>

                        </div>

                    </div>

                </div>

            @empty

                <p class="col-span-full text-center text-gray-500 text-lg">
                    No hay productos en esta categoría.
                </p>

            @endforelse

        </div>

    </div>
</div>
@endsection
