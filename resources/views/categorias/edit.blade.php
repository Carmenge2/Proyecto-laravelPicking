@extends('layouts.app')

@section('content')
<div class="py-12 bg-orange-50 min-h-screen">
    <div class="max-w-3xl mx-auto px-6">

        <!-- TÍTULO -->
        <h1 class="text-4xl font-extrabold text-orange-600 text-center mb-8">
            Editar Categoría
        </h1>

        <!-- TARJETA -->
        <div class="bg-white shadow-xl rounded-2xl p-8">

            <!-- ERRORES -->
            @if ($errors->any())
                <div class="mb-6 bg-red-100 border border-red-300 text-red-700 p-4 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- FORMULARIO -->
            <form action="{{ route('categorias.update', $categoria->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- NOMBRE -->
                <div class="mb-6">
                    <label class="block text-orange-700 font-semibold mb-2">
                        Nombre de la categoría
                    </label>

                    <input type="text"
                           name="nombre"
                           value="{{ old('nombre', $categoria->nombre) }}"
                           class="w-full border border-orange-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400"
                           required>
                </div>

                <!-- IMAGEN ACTUAL -->
                @if($categoria->imagen)
                    <div class="mb-6 text-center">
                        <p class="text-orange-600 mb-2 font-semibold">Imagen actual:</p>
                        <img src="{{ asset('storage/'.$categoria->imagen) }}"
                             class="w-40 h-40 object-cover rounded-full mx-auto shadow">
                    </div>
                @endif

                <!-- NUEVA IMAGEN -->
                <div class="mb-6">
                    <label class="block text-orange-700 font-semibold mb-2">
                        Cambiar imagen 
                    </label>

                    <input type="file"
                           name="imagen"
                           class="w-full border border-orange-300 rounded-lg px-4 py-2">
                </div>

                <!-- BOTONES -->
                <div class="flex justify-between items-center">

                    <!-- VOLVER -->
                        <a href="{{ route('catalogo.productos', $categoria->id) }}"
                            class="inline-flex items-center text-orange-500 hover:text-orange-700 font-semibold transition">
                                
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1" fill="none"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    
                                </svg>

                                ← Cancelar 
                        </a>
                    <!-- GUARDAR -->
                    <button type="submit"
                            class="bg-orange-500 text-white px-6 py-2 rounded-lg hover:bg-orange-600 transition">
                        Guardar cambios
                    </button>

                </div>

            </form>

        </div>

    </div>
</div>
@endsection