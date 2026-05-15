@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-lg mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        <x-ui.back-link :href="route('admin.trabajadores.index')" label="Volver a Comerciales"/>

        <x-ui.card>
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Nuevo Comercial</h1>

            @if ($errors->any())
                <x-ui.alert type="error" class="mb-6">
                    Completa correctamente el formulario.
                </x-ui.alert>
            @endif

            <form action="{{ route('admin.trabajadores.store') }}" method="POST">
                @csrf

                <x-ui.form-input name="name" label="Nombre completo" :required="true"/>
                <x-ui.form-input name="email" label="Email" type="email" :required="true"/>

                <div class="flex items-center gap-3 pt-4">
                    <x-ui.button type="submit">Guardar</x-ui.button>
                    <x-ui.button variant="secondary" href="{{ route('admin.trabajadores.index') }}">Cancelar</x-ui.button>
                </div>
            </form>
        </x-ui.card>

    </div>
</div>
@endsection
