@extends('layouts.app')

@section('content')
<div class="py-12 bg-orange-50 min-h-screen">
    <div class="max-w-6xl mx-auto px-6">

        <div class="bg-white rounded-3xl shadow-xl p-10">

            <!-- BOTÓN VOLVER -->
            <div class="mb-6 flex justify-between items-center">

                <a href="{{ url()->previous() }}"
                   class="text-orange-600 font-semibold hover:underline text-lg">
                    ← Volver
                </a>

                <!-- BOTONES SOLO ADMIN -->
                @auth
                    @if(auth()->user()->rol === 'admin')
                        <div class="flex gap-3">

                            <!-- EDITAR -->
                            <a href="{{ route('productos.edit', $producto->id) }}"
                               class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg shadow transition">
                                Editar
                            </a>

                            <!-- ELIMINAR -->
                            <form action="{{ route('productos.destroy', $producto->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('¿Seguro que deseas eliminar este producto?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow transition">
                                    Eliminar
                                </button>
                            </form>

                        </div>
                    @endif
                @endauth

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">

                <!-- IMAGEN -->
                <div>
                    @if($producto->imagen)
                        <img src="{{ asset('storage/' . $producto->imagen) }}"
                             class="w-full h-[450px] object-cover rounded-2xl shadow-md"
                             alt="{{ $producto->nombre }}">
                    @else
                        <div class="w-full h-[450px] bg-orange-100 flex items-center justify-center rounded-2xl shadow-inner">
                            <span class="text-orange-600 text-xl font-semibold">
                                Sin imagen disponible
                            </span>
                        </div>
                    @endif
                </div>

                <!-- INFORMACIÓN -->
                <div class="space-y-6">

                    <h1 class="text-4xl font-extrabold text-gray-800">
                        {{ $producto->nombre }}
                    </h1>

                    <p class="text-gray-600 text-lg">
                        <strong>Categoría:</strong>
                        {{ $producto->categoria->nombre ?? 'Sin categoría' }}
                    </p>

                    <p class="text-gray-600 text-lg">
                        <strong>Referencia:</strong>
                        {{ $producto->referencia ?? 'No definida' }}
                    </p>

                    <div>
                        <h3 class="text-xl font-bold text-gray-700 mb-2">
                            Descripción
                        </h3>
                        <p class="text-gray-600 leading-relaxed">
                            {{ $producto->descripcion ?? 'Este producto no tiene descripción disponible.' }}
                        </p>
                    </div>

                    <p class="text-4xl font-extrabold text-gray-900">
                        {{ number_format($producto->precio, 2) }} €
                    </p>

                    <span class="
                        inline-block px-5 py-2 text-sm font-bold rounded-full
                        @if($producto->estado === 'disponible') bg-green-100 text-green-700
                        @elseif($producto->estado === 'agotado') bg-red-100 text-red-700
                        @else bg-yellow-100 text-yellow-700 @endif
                    ">
                        {{ ucfirst($producto->estado) }}
                    </span>

                    <p class="text-gray-700 text-lg">
                        <strong>Stock disponible:</strong> {{ $producto->stock }}
                    </p>

                </div>

            </div>

        </div>

    </div>
</div>
@endsection