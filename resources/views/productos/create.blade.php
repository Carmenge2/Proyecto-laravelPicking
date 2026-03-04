@extends('layouts.app')

@section('content')
<div class="py-12 bg-orange-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-6">

        <div class="bg-white shadow-lg rounded-2xl p-8 border border-orange-100">

            <h2 class="text-4xl font-extrabold text-gray-800 mb-10 text-center">
                Crear Nuevo Producto
            </h2>

            <!-- FORMULARIO -->
            <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Nombre -->
                <div class="mb-5">
                    <label for="nombre" class="block text-sm font-semibold text-gray-700 mb-1">
                        Nombre del producto
                    </label>
                    <input type="text" name="nombre" id="nombre"
                           value="{{ old('nombre') }}"
                           class="w-full border border-orange-200 rounded-lg px-4 py-2
                                  focus:outline-none focus:ring-2 focus:ring-orange-400
                                  @error('nombre') border-red-500 @enderror"
                           required>
                    @error('nombre')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Descripción -->
                <div class="mb-5">
                    <label for="descripcion" class="block text-sm font-semibold text-gray-700 mb-1">
                        Descripción
                    </label>
                    <textarea name="descripcion" id="descripcion" rows="3"
                              class="w-full border border-orange-200 rounded-lg px-4 py-2
                                     focus:outline-none focus:ring-2 focus:ring-orange-400
                                     @error('descripcion') border-red-500 @enderror">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Precio -->
                <div class="mb-5">
                    <label for="precio" class="block text-sm font-semibold text-gray-700 mb-1">
                        Precio (€)
                    </label>
                    <input type="number" step="0.01" name="precio" id="precio"
                           value="{{ old('precio') }}"
                           class="w-full border border-orange-200 rounded-lg px-4 py-2
                                  focus:outline-none focus:ring-2 focus:ring-orange-400
                                  @error('precio') border-red-500 @enderror"
                           required>
                    @error('precio')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Estado -->
                <div class="mb-5">
                    <label for="estado" class="block text-sm font-semibold text-gray-700 mb-1">
                        Estado
                    </label>
                    <select name="estado" id="estado"
                            class="w-full border border-orange-200 rounded-lg px-4 py-2
                                   focus:outline-none focus:ring-2 focus:ring-orange-400
                                   @error('estado') border-red-500 @enderror">
                        <option value="disponible" {{ old('estado') == 'disponible' ? 'selected' : '' }}>Disponible</option>
                        <option value="agotado" {{ old('estado') == 'agotado' ? 'selected' : '' }}>Agotado</option>
                        <option value="pre-venta" {{ old('estado') == 'pre-venta' ? 'selected' : '' }}>Pre-venta</option>
                    </select>
                    @error('estado')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Stock -->
                <div class="mb-5">
                    <label for="stock" class="block text-sm font-semibold text-gray-700 mb-1">
                        Stock Disponible
                    </label>
                    <input type="number" name="stock" id="stock"
                           value="{{ old('stock') }}"
                           class="w-full border border-orange-200 rounded-lg px-4 py-2
                                  focus:outline-none focus:ring-2 focus:ring-orange-400
                                  @error('stock') border-red-500 @enderror"
                           required>
                    @error('stock')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Imagen -->
                <div class="mb-6">
                    <label for="imagen" class="block text-sm font-semibold text-gray-700 mb-1">
                        Imagen del Producto
                    </label>

                    <input type="file" name="imagen" id="imagen" accept="image/*"
                           class="w-full border border-orange-200 rounded-lg px-4 py-2 bg-white
                                  focus:outline-none focus:ring-2 focus:ring-orange-400
                                  @error('imagen') border-red-500 @enderror">

                    @error('imagen')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror

                    <!-- Vista previa -->
                    <div class="mt-4">
                        <img id="preview"
                             class="hidden w-40 h-40 object-cover rounded-xl shadow border border-orange-200">
                    </div>
                </div>

                <!-- Botones -->
                <div class="mt-8 flex justify-between">

                    <!-- Cancelar -->
                    <a href="{{ route('productos.index') }}"
                       class="px-6 py-3 bg-gray-400 text-white rounded-lg shadow
                              hover:bg-gray-500 transition font-semibold">
                        Cancelar
                    </a>

                    <!-- Crear Producto -->
                    <button type="submit"
                            class="px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white rounded-lg shadow
                                   transition font-semibold transform hover:scale-[1.03]">
                        Crear Producto
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- Script para vista previa imagen -->
<script>
document.getElementById('imagen').addEventListener('change', function(event) {
    let preview = document.getElementById('preview');
    preview.src = URL.createObjectURL(event.target.files[0]);
    preview.style.display = 'block';
});
</script>
@endsection
