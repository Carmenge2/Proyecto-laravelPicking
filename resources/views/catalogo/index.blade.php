@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        @if(Auth::user()->rol === 'admin')
            <x-ui.page-header title="Catálogo" actionLabel="Nueva Categoría" :actionRoute="route('categorias.create')"/>
        @else
            <x-ui.page-header title="Catálogo"/>
        @endif

        @if($categorias->isEmpty())
            <x-ui.card>
                <x-ui.empty-state message="No hay categorías de productos." actionLabel="Crear Categoría" :actionRoute="route('categorias.create')"/>
            </x-ui.card>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                @foreach($categorias as $categoria)
                    <a href="{{ route('catalogo.productos', $categoria->id) }}"
                       class="group flex flex-col items-center p-4 bg-white rounded-2xl shadow-sm hover:shadow-md hover:-translate-y-0.5 transition">

                        <div class="w-20 h-20 rounded-full overflow-hidden border-2 border-orange-100 group-hover:border-orange-300 transition mb-3">
                            @if($categoria->imagen)
                                <img src="{{ asset('storage/'.$categoria->imagen) }}"
                                     alt="{{ $categoria->nombre }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-orange-50 flex items-center justify-center text-orange-400 text-xl font-bold">
                                    {{ strtoupper(substr($categoria->nombre, 0, 1)) }}
                                </div>
                            @endif
                        </div>

                        <p class="text-sm font-medium text-gray-800 group-hover:text-orange-600 transition text-center">
                            {{ $categoria->nombre }}
                        </p>
                    </a>
                @endforeach
            </div>
        @endif

    </div>
</div>
@endsection