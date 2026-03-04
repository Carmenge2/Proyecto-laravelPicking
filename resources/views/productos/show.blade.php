@extends('layouts.app')

@section('content')
<div class="py-12 bg-orange-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-6">

        <!-- CONTENEDOR PRINCIPAL -->
        <div class="bg-white rounded-2xl shadow-lg p-8">

            <!-- TÍTULO -->
            <h2 class="text-4xl font-extrabold text-orange-600 mb-10 text-center tracking-wide">
                Detalle del Producto
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

                <!-- IMAGEN DEL PRODUCTO -->
                <div>
                    @if($producto->imagen)
                        <img src="{{ asset('storage/' . $producto->imagen) }}"
                             class="rounded-xl shadow-md w-full object-cover h-80"
                             alt="Imagen del producto">
                    @else
                        <div class="w-full h-80 bg-orange-100 flex items-center justify-center rounded-xl shadow-inner">
                            <span class="text-orange-600 font-medium">Sin imagen</span>
                        </div>
                    @endif
                </div>

                <!-- INFORMACIÓN -->
                <div class="space-y-6">

                    <h3 class="text-3xl font-bold text-gray-800">
                        {{ $producto->nombre }}
                    </h3>

                    <p class="text-gray-700 leading-relaxed">
                        {{ $producto->descripcion ?? 'Este producto no tiene descripción.' }}
                    </p>

                    <p class="text-2xl font-extrabold text-gray-900">
                        {{ number_format($producto->precio, 2) }} €
                    </p>

                    <span class="
                        inline-block px-4 py-2 text-sm font-bold rounded-full
                        @if($producto->estado === 'disponible') bg-green-100 text-green-700
                        @elseif($producto->estado === 'agotado') bg-red-100 text-red-700
                        @else bg-yellow-100 text-yellow-700 @endif
                    ">
                        Estado: {{ ucfirst($producto->estado) }}
                    </span>

                    <p class="text-gray-700">
                        <strong class="font-semibold">Stock disponible:</strong> {{ $producto->stock }}
                    </p>

                </div>
            </div>

            <!-- BOTONES -->
            <div class="mt-12 flex justify-between items-center">

                <!-- VOLVER -->
                <a href="{{ route('productos.index') }}"
                   class="flex items-center px-5 py-3 bg-gray-400 hover:bg-gray-500 text-white font-semibold rounded-xl shadow transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2" fill="none"
                         viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" 
                              d="M15 19l-7-7 7-7" />
                    </svg>
                    Volver
                </a>

                <div class="flex space-x-3">

                    <!-- EDITAR -->
                    <a href="{{ route('productos.edit', $producto) }}"
                       class="flex items-center px-5 py-3 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-xl shadow transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2" fill="none"
                             viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M16.862 3.487a2.25 2.25 0 113.182 3.182L7.125 19.587l-4.2.933.933-4.2 12.004-12.003z" />
                        </svg>
                        
                    </a>

                    <!-- ELIMINAR -->
                    <form action="{{ route('productos.destroy', $producto) }}" method="POST"
                        class="inline"
                        onsubmit="return confirm('¿Seguro que deseas eliminar este producto?')">
                        @csrf @method('DELETE')
                        <button class="flex items-center px-5 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl shadow transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2" fill="none"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            
                        </button>
                    </form>

                </div>

            </div>

        </div>

    </div>
</div>
@endsection
