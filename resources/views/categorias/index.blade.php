@extends('layouts.app')

@section('content')
<div class="py-12 bg-orange-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-6">

        <h1 class="text-5xl font-extrabold text-orange-600 text-center mb-12">
            Categorías
        </h1>

        </div>
        {{-- MENSAJE SI NO HAY CATEGORÍAS --}}
        @if($categorias->isEmpty())
            <p class="text-center text-gray-500">
                No hay categorías registradas.
            </p>
        @endif

        {{-- GRID DE CATEGORÍAS --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-10 justify-items-center">
            @foreach ($categorias as $categoria)

                <a href="{{ route('catalogo.index', ['categoria' => $categoria->id]) }}"
                   class="group flex flex-col items-center">

                    <div class="w-36 h-36 rounded-full overflow-hidden shadow-lg
                                border-4 border-orange-200
                                group-hover:scale-105 transition duration-300">

                        @if($categoria->imagen)
                            <img src="{{ asset('storage/'.$categoria->imagen) }}"
                                 alt="{{ $categoria->nombre }}"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center
                                        bg-orange-100 text-orange-600 font-bold text-lg">
                                {{ strtoupper(substr($categoria->nombre, 0, 1)) }}
                            </div>
                        @endif
                    </div>

                    <p class="mt-4 text-lg font-semibold text-gray-800
                              group-hover:text-orange-600 transition">
                        {{ $categoria->nombre }}
                    </p>

                </a>

            @endforeach
        </div>


        {{-- PRODUCTOS DE LA CATEGORÍA SELECCIONADA --}}
        @if($productos)

            <div class="mt-16">
                <h2 class="text-4xl font-bold text-orange-600 text-center mb-10">
                    Productos
                </h2>

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

        @endif

    </div>
</div>
@endsection
