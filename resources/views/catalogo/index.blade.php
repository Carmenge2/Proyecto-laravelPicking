@extends('layouts.app')

@section('content')
<div class="py-12 bg-orange-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-6">

        <h1 class="text-5xl font-extrabold text-orange-600 text-center mb-12">
            Categorías
        </h1>

        @if($categorias->isEmpty())
            <p class="text-center text-gray-500">
                No hay categorías registradas.
            </p>
        @endif

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-10 justify-items-center">
            @foreach ($categorias as $categoria)

                <a href="{{ route('catalogo.productos', $categoria->id) }}"
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

    </div>
</div>
@endsection
