@extends('layouts.app')

@section('content')
<div class="py-12 bg-orange-50 min-h-screen">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Volver a categorías --}}
        <div class="mb-6">
            <a href="{{ route('catalogo.index') }}"
               class="text-orange-500 hover:text-orange-700 font-semibold">
                ← Volver a categorías
            </a>
        </div>

        {{-- Título categoría --}}
        <h2 class="text-4xl font-extrabold text-orange-600 mb-10 text-center">
            {{ $categoria->nombre }}
        </h2>

        {{-- Grid productos --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-8">

            @forelse($productos as $producto)
                <a href="{{ route('catalogo.producto', $producto) }}"
                   class="group bg-white rounded-2xl shadow hover:shadow-xl transition overflow-hidden">

                    {{-- Imagen --}}
                    @if($producto->imagen)
                        <img src="{{ asset('storage/' . $producto->imagen) }}"
                             alt="{{ $producto->nombre }}"
                             class="w-full h-44 object-cover group-hover:scale-105 transition duration-300">
                    @else
                        <div class="w-full h-44 bg-orange-100 flex items-center justify-center text-orange-500">
                            Sin imagen
                        </div>
                    @endif

                    {{-- Nombre --}}
                    <div class="p-4 text-center">
                        <p class="font-semibold text-gray-800 group-hover:text-orange-600 transition">
                            {{ $producto->nombre }}
                        </p>
                    </div>

                </a>
            @empty
                <p class="col-span-full text-center text-gray-500">
                    No hay productos en esta categoría
                </p>
            @endforelse

        </div>

        {{-- Paginación --}}
        <div class="mt-10">
            {{ $productos->links() }}
        </div>

    </div>
</div>
@endsection
