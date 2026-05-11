@extends('layouts.app')

@section('content')
<div class="py-12 bg-orange-50 min-h-screen">

    {{-- 🔥 VOLVER FUERA DEL RECUADRO --}}
    <div class="max-w-xl mx-auto mb-4">
        <a href="{{ route('catalogo.index') }}"
           class="text-orange-600 hover:text-orange-700 font-semibold">
           ← Volver a categorías
        </a>
    </div>
        <h2 class="text-2xl font-bold mb-6 text-center text-orange-600">
            Nueva Categoría
        </h2>
    {{-- 🔲 RECUADRO --}}
    <div class="max-w-xl mx-auto bg-white p-8 rounded-xl shadow">


        <form action="{{ route('categorias.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Nombre -->
            <div class="mb-4">
                <label class="font-semibold">Nombre *</label>
                <input type="text" name="nombre"
                       class="w-full border rounded px-3 py-2 mt-1">
                @error('nombre')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Imagen -->
            <div class="mb-4">
                <label class="font-semibold">Imagen</label>
                <input type="file" name="imagen" class="mt-1">
            </div>

            <!-- Botón -->
            <div class="text-center">
                <button class="bg-orange-500 text-white px-6 py-2 rounded hover:bg-orange-600">
                    Crear categoría
                </button>
            </div>

        </form>

    </div>
</div>
@endsection