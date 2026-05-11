@extends('layouts.app')

@section('content')
<div class="py-12 bg-orange-50 min-h-screen">
    <div class="max-w-3xl mx-auto px-6">

        <!-- VOLVER -->
        <div class="mb-6">
            <a href="{{ route('catalogo.productos', $categoriaSeleccionada) }}"
               class="inline-flex items-center text-orange-500 hover:text-orange-700 font-semibold transition">
                ← Volver al catálogo
            </a>
        </div>

        <!-- TÍTULO -->
        <h1 class="text-4xl font-extrabold text-orange-600 text-center mb-8">
            Nuevo Producto
        </h1>

        <!-- TARJETA -->
        <div class="bg-white shadow-xl rounded-2xl p-8">

            <!-- ERROR GLOBAL LIMPIO -->
            @if ($errors->any())
                <div class="mb-6 bg-red-100 border border-red-300 text-red-700 p-4 rounded-lg text-center font-semibold">
                    @php
                        $error = $errors->first();

                        if (str_contains($error, 'validation.')) {
                            $error = 'Completa correctamente todos los campos obligatorios.';
                        }
                    @endphp

                    {{ $error }}
                </div>
            @endif

            <!-- FORMULARIO -->
            <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- NOMBRE -->
                <div class="mb-4">
                    <label class="block font-semibold mb-1">Nombre *</label>
                    <input type="text" name="nombre"
                           value="{{ old('nombre') }}"
                           class="w-full border rounded px-3 py-2">
                </div>

                <!-- DESCRIPCIÓN -->
                <div class="mb-4">
                    <label class="block font-semibold mb-1">Descripción</label>
                    <textarea name="descripcion"
                              class="w-full border rounded px-3 py-2">{{ old('descripcion') }}</textarea>
                </div>

                <!-- PRECIO -->
                <div class="mb-4">
                    <label class="block font-semibold mb-1">Precio (€) *</label>
                    <input type="number" step="0.01" min="0" name="precio"
                           value="{{ old('precio') }}"
                           class="w-full border rounded px-3 py-2">
                </div>

                <!-- STOCK -->
                <div class="mb-4">
                    <label class="block font-semibold mb-1">Stock *</label>
                    <input type="number" min="0" name="stock"
                           value="{{ old('stock') }}"
                           class="w-full border rounded px-3 py-2">
                </div>

                <!-- ESTADO -->
                <div class="mb-4">
                    <label class="block font-semibold mb-1">Estado *</label>
                    <select name="estado" class="w-full border rounded px-3 py-2">
                        <option value="disponible" {{ old('estado') == 'disponible' ? 'selected' : '' }}>Disponible</option>
                        <option value="agotado" {{ old('estado') == 'agotado' ? 'selected' : '' }}>Agotado</option>
                        <option value="pre-venta" {{ old('estado') == 'pre-venta' ? 'selected' : '' }}>Pre-venta</option>
                    </select>
                </div>

                <!-- CATEGORÍA -->
                <div class="mb-4">
                    <label class="block font-semibold mb-1">Categoría *</label>
                    <select name="categoria_id" class="w-full border rounded px-3 py-2">
                        <option value="">-- Seleccionar --</option>

                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}"
                                {{ old('categoria_id', $categoriaSeleccionada) == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- IMAGEN -->
                <div class="mb-6">
                    <label class="block font-semibold mb-1">Imagen</label>
                    <input type="file" name="imagen">
                </div>

                <!-- BOTONES -->
                <div class="flex justify-between items-center">

                    <a href="{{ route('catalogo.productos', $categoriaSeleccionada) }}"
                       class="text-orange-600 hover:underline">
                        ← Cancelar
                    </a>

                    <button type="submit"
                            class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg">
                        Crear producto
                    </button>

                </div>

            </form>
        </div>
    </div>
</div>
@endsection