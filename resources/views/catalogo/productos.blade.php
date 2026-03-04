@extends('layouts.app')

@section('content')
<div class="py-12 bg-orange-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-6">

        <h1 class="text-5xl font-extrabold text-orange-600 text-center mb-4">
            {{ $categoriaSeleccionada->nombre }}
        </h1>

        <div class="text-center mb-10">
            <a href="{{ route('catalogo.index') }}"
               class="text-orange-600 font-semibold hover:underline">
                ← Volver a categorías
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            
            @forelse($productos as $producto)

                <div class="bg-white shadow-lg rounded-xl p-4 hover:shadow-xl transition">

                    @if($producto->imagen)
                        <img src="{{ asset('storage/'.$producto->imagen) }}"
                             class="w-full h-48 object-cover rounded-lg mb-4">
                    @endif

                    <h3 class="text-xl font-semibold text-gray-800">
                        {{ $producto->nombre }}
                    </h3>

                    <p class="text-orange-600 font-bold text-lg mt-2">
                        {{ $producto->precio }} €
                    </p>

                </div>

            @empty
                <p class="col-span-full text-center text-gray-500">
                    No hay productos en esta categoría.
                </p>
            @endforelse

        </div>

    </div>
</div>
@endsection
