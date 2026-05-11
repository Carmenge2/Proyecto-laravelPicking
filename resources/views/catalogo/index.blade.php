@extends('layouts.app')

@section('content')
<div class="py-12 bg-orange-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-6">

            {{--  Volver al panel --}}
        <div >
            <a href="{{ route('admin.dashboard') }}"
               class="text-orange-600 hover:text-orange-700 font-semibold">
               ← Volver al Panel
            </a>
        </div>
        <!-- TÍTULO -->
        <h1 class="text-5xl font-extrabold text-orange-600 text-center mb-6">
            Categorías
        </h1>

        

        <!-- BOTÓN NUEVA CATEGORÍA (SOLO ADMIN) -->
        @auth
            @if(auth()->user()->rol === 'admin')
                <div class="flex justify-center mb-10">
                    <a href="{{ route('categorias.create') }}"
                       class="inline-flex items-center px-6 py-3 bg-orange-500 hover:bg-orange-600 
                              text-white font-bold rounded-xl shadow-lg transition transform hover:scale-105">
                        
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 4v16m8-8H4" />
                        </svg>

                        Nueva categoría
                    </a>

                    
                </div>
            @endif
        @endauth

        

        <!-- MENSAJE SI NO HAY CATEGORÍAS -->
        @if($categorias->isEmpty())
            <p class="text-center text-gray-500">
                No hay categorías registradas.
            </p>
        @endif

        <!-- GRID DE CATEGORÍAS -->
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