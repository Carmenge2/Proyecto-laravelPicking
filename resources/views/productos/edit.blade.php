@extends('layouts.app')

@section('content')
<div class="py-12 bg-orange-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-6">

        <!-- Contenedor principal -->
        <div class="bg-white rounded-2xl shadow-lg p-8 border border-orange-100">

            {{-- Volver --}}
            <div class="mb-6">
                <a href="{{ route('productos.index') }}"
                   class="inline-flex items-center text-orange-500 hover:text-orange-700 font-semibold transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1" fill="none"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15 19l-7-7 7-7" />
                    </svg>
                    Volver a Productos
                </a>
            </div>

            <h2 class="text-4xl font-extrabold text-gray-800 mb-10 text-center">
                Editar Producto
            </h2>

            <form action="{{ route('productos.update', $producto) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Nombre -->
                <div class="mb-5">
                    <label class="font-semibold text-gray-700">Nombre del producto</label>
                    <input type="text"
                           name="nombre"
                           value="{{ old('nombre', $producto->nombre) }}"
                           class="w-full mt-1 border border-orange-200 rounded-lg px-4 py-2 focus:outline-none 
                                  focus:ring-2 focus:ring-orange-400">
                    @error('nombre')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Descripción -->
                <div class="mb-5">
                    <label class="font-semibold text-gray-700">Descripción</label>
                    <textarea name="descripcion" rows="4"
                        class="w-full mt-1 border border-orange-200 rounded-lg px-4 py-2 focus:outline-none 
                               focus:ring-2 focus:ring-orange-400">{{ old('descripcion', $producto->descripcion) }}</textarea>
                    @error('descripcion')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Precio -->
                <div class="mb-5">
                    <label class="font-semibold text-gray-700">Precio (€)</label>
                    <input type="number" step="0.01" name="precio"
                           value="{{ old('precio', $producto->precio) }}"
                           class="w-full mt-1 border border-orange-200 rounded-lg px-4 py-2 focus:outline-none 
                                  focus:ring-2 focus:ring-orange-400">
                    @error('precio')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Stock -->
                <div class="mb-5">
                    <label class="font-semibold text-gray-700">Stock disponible</label>
                    <input type="number"
                           name="stock"
                           value="{{ old('stock', $producto->stock) }}"
                           class="w-full mt-1 border border-orange-200 rounded-lg px-4 py-2 focus:outline-none 
                                  focus:ring-2 focus:ring-orange-400">
                    @error('stock')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Estado -->
                <div class="mb-6">
                    <label class="font-semibold text-gray-700">Estado</label>
                    <select name="estado"
                        class="w-full mt-1 border border-orange-200 rounded-lg px-4 py-2 focus:outline-none 
                               focus:ring-2 focus:ring-orange-400">
                        <option value="disponible" {{ old('estado', $producto->estado) === 'disponible' ? 'selected' : '' }}>Disponible</option>
                        <option value="agotado" {{ old('estado', $producto->estado) === 'agotado' ? 'selected' : '' }}>Agotado</option>
                        <option value="pre-venta" {{ old('estado', $producto->estado) === 'pre-venta' ? 'selected' : '' }}>Pre-venta</option>
                    </select>
                    @error('estado')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Imagen actual -->
                <div class="mb-6">
                    <label class="font-semibold text-gray-700">Imagen actual</label>

                    @if($producto->imagen)
                        <img src="{{ asset('storage/' . $producto->imagen) }}"
                             class="w-48 h-48 object-cover rounded-xl shadow mt-2 border border-orange-100">
                    @else
                        <p class="text-gray-500 mt-2">Este producto no tiene imagen.</p>
                    @endif
                </div>

                <!-- Nueva imagen -->
                <div class="mb-8">
                    <label class="font-semibold text-gray-700">Subir nueva imagen</label>
                    <input type="file" name="imagen"
                           class="mt-2 block w-full text-gray-700">
                    @error('imagen')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
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

                        <!-- Botón actualizar -->
                        <div class="flex justify-center">
                            <button class="px-8 py-3 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-xl shadow-lg 
                                        transition transform hover:scale-105">
                                Actualizar Producto
                            </button>
                        </div>
            </div>
        

        </div>

    </div>
</div>
@endsection
