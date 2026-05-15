@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        <x-ui.back-link :href="route('catalogo.productos', $producto->categoria_id)" label="Volver al catálogo"/>

        <x-ui.card>
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Editar Producto</h1>

            @if ($errors->any())
                <x-ui.alert type="error" class="mb-6">
                    Completa correctamente todos los campos obligatorios.
                </x-ui.alert>
            @endif

            <form action="{{ route('productos.update', $producto) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <x-ui.form-input name="nombre" label="Nombre" :value="$producto->nombre" :required="true"/>

                <div class="mb-5">
                    <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1.5">Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="3"
                              class="w-full border border-orange-200 rounded-xl px-4 py-2.5 text-gray-700 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition">{{ old('descripcion', $producto->descripcion) }}</textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <x-ui.form-input name="precio" label="Precio (€)" type="number" :value="$producto->precio" :required="true" step="0.01" min="0"/>
                    <x-ui.form-input name="stock" label="Stock" type="number" :value="$producto->stock" :required="true" min="0"/>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <x-ui.form-select name="estado" label="Estado" :required="true">
                        <option value="disponible" {{ old('estado', $producto->estado) == 'disponible' ? 'selected' : '' }}>Disponible</option>
                        <option value="agotado" {{ old('estado', $producto->estado) == 'agotado' ? 'selected' : '' }}>Agotado</option>
                        <option value="pre-venta" {{ old('estado', $producto->estado) == 'pre-venta' ? 'selected' : '' }}>Pre-venta</option>
                    </x-ui.form-select>

                    <x-ui.form-select name="categoria_id" label="Categoría" :required="true">
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" {{ old('categoria_id', $producto->categoria_id) == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </x-ui.form-select>
                </div>

                @if($producto->imagen)
                    <div class="mb-5">
                        <p class="text-sm font-medium text-gray-700 mb-2">Imagen actual</p>
                        <img src="{{ asset('storage/'.$producto->imagen) }}" class="w-24 h-24 object-cover rounded-xl shadow-sm">
                    </div>
                @endif

                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Cambiar imagen</label>
                    <input type="file" name="imagen" class="text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-orange-50 file:text-orange-600 hover:file:bg-orange-100 transition">
                </div>

                <div class="flex items-center gap-3 pt-4">
                    <x-ui.button type="submit">Actualizar Producto</x-ui.button>
                    <x-ui.button variant="secondary" href="{{ route('catalogo.productos', $producto->categoria_id) }}">Cancelar</x-ui.button>
                </div>
            </form>
        </x-ui.card>

    </div>
</div>
@endsection