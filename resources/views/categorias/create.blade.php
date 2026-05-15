@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-lg mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        <x-ui.back-link :href="route('catalogo.index')" label="Volver a categorías"/>

        <x-ui.card>
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Nueva Categoría</h1>

            <form action="{{ route('categorias.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <x-ui.form-input name="nombre" label="Nombre" :required="true"/>

                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Imagen</label>
                    <input type="file" name="imagen" class="text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-orange-50 file:text-orange-600 hover:file:bg-orange-100 transition">
                </div>

                <div class="flex items-center gap-3 pt-4">
                    <x-ui.button type="submit">Crear Categoría</x-ui.button>
                    <x-ui.button variant="secondary" href="{{ route('catalogo.index') }}">Cancelar</x-ui.button>
                </div>
            </form>
        </x-ui.card>

    </div>
</div>
@endsection