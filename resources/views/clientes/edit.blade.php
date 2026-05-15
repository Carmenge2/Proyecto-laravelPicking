@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        <x-ui.back-link :href="route('clientes.index')" label="Volver a Clientes"/>

        <x-ui.card>
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Editar Cliente</h1>

            @if ($errors->any())
                <x-ui.alert type="error" class="mb-6">
                    Completa correctamente el formulario.
                </x-ui.alert>
            @endif

            <form action="{{ route('clientes.update', $cliente) }}" method="POST">
                @csrf
                @method('PUT')

                <x-ui.form-input name="nombre_comercial" label="Nombre Comercial" :value="$cliente->nombre_comercial" :required="true"/>
                <x-ui.form-input name="razon_social" label="Razón Social" :value="$cliente->razon_social" :required="true"/>
                <x-ui.form-input name="email" label="Email" type="email" :value="$cliente->email"/>
                <x-ui.form-input name="telefono" label="Teléfono" :value="$cliente->telefono"/>
                <x-ui.form-input name="direccion" label="Dirección" :value="$cliente->direccion"/>
                <x-ui.form-input name="tipo_negocio" label="Tipo de Negocio" :value="$cliente->tipo_negocio"/>

                <div class="flex items-center gap-3 pt-4">
                    <x-ui.button type="submit">Actualizar</x-ui.button>
                    <x-ui.button variant="secondary" href="{{ route('clientes.index') }}">Cancelar</x-ui.button>
                </div>
            </form>
        </x-ui.card>

    </div>
</div>
@endsection
