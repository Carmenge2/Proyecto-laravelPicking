@extends('layouts.app')

@section('content')
<div class="py-10 bg-orange-50 min-h-screen">

    {{-- VOLVER --}}
    <div class="max-w-7xl mx-auto mb-6 px-6">
        <a href="{{ route('catalogo.index') }}"
           class="text-orange-600 hover:text-orange-700 font-semibold">
            ← Volver a categorías
        </a>
    </div>

    {{-- TÍTULO --}}
    <h1 class="text-5xl font-extrabold text-orange-600 text-center mb-6">
        {{ $categoriaSeleccionada->nombre }}
    </h1>

    {{-- BOTONES (ADMIN) --}}
    @auth
        @if(auth()->user()->rol === 'admin')
            <div class="max-w-7xl mx-auto px-6 mb-6 flex justify-between items-center">

                {{-- IZQUIERDA --}}
                <div class="flex gap-4">
                    <a href="{{ route('categorias.edit', $categoriaSeleccionada->id) }}"
                       class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg shadow">
                        Editar Categoría
                    </a>

                    <form action="{{ route('categorias.destroy', $categoriaSeleccionada->id) }}"
                          method="POST"
                          onsubmit="return confirm('¿Seguro que deseas eliminar esta categoría?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow">
                            Eliminar Categoría
                        </button>
                    </form>
                </div>

                {{-- DERECHA (AÑADIR PRODUCTO) --}}
                <a href="{{ route('productos.create', ['categoria_id' => $categoriaSeleccionada->id]) }}"
                   class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg shadow">
                    + Agregar Producto al catálogo
                </a>

            </div>
        @endif
    @endauth

    {{-- GRID --}}
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">

            @forelse($productos as $producto)

                <div class="bg-white shadow-lg rounded-2xl overflow-hidden flex flex-col justify-between">

                    {{-- ZONA CLICABLE --}}
                    <a href="{{ route('catalogo.producto', $producto->id) }}"
                       class="block hover:shadow-2xl hover:-translate-y-1 transition duration-300">

                        {{-- IMAGEN --}}
                        @if($producto->imagen)
                            <img src="{{ asset('storage/'.$producto->imagen) }}"
                                 class="w-full h-52 object-cover">
                        @else
                            <div class="w-full h-52 bg-orange-100 flex items-center justify-center">
                                <span class="text-orange-600 font-semibold">
                                    Sin imagen
                                </span>
                            </div>
                        @endif

                        {{-- CONTENIDO --}}
                        <div class="p-5">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">
                                {{ $producto->nombre }}
                            </h3>

                            <p class="text-2xl font-extrabold text-gray-900">
                                {{ number_format($producto->precio, 2) }} €
                            </p>

                            {{-- ESTADO --}}
                            <span class="
                                inline-block mt-3 px-3 py-1 text-xs font-bold rounded-full
                                @if($producto->estado === 'disponible') bg-green-100 text-green-700
                                @elseif($producto->estado === 'agotado') bg-red-100 text-red-700
                                @else bg-yellow-100 text-yellow-700 @endif
                            ">
                                {{ ucfirst($producto->estado) }}
                            </span>
                        </div>

                    </a>

                    {{-- BOTONES ADMIN --}}
                    @auth
                        @if(auth()->user()->rol === 'admin')
                            <div class="p-4 flex gap-2">

                                <a href="{{ route('productos.edit', $producto->id) }}"
                                   class="w-full text-center bg-orange-500 hover:bg-orange-600 text-white py-2 rounded-lg text-sm">
                                    Editar
                                </a>

                                <form action="{{ route('productos.destroy', $producto->id) }}"
                                      method="POST" class="w-full">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            onclick="return confirm('¿Eliminar producto?')"
                                            class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded-lg text-sm">
                                        Eliminar
                                    </button>
                                </form>

                            </div>
                        @endif
                    @endauth

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