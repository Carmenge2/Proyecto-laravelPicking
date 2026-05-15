@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        <x-ui.back-link :href="route('clientes.index')" label="Volver a Clientes"/>

        <x-ui.card>
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Nuevo Cliente</h1>

            @if ($errors->any())
                <x-ui.alert type="error" class="mb-6">
                    Completa correctamente el formulario.
                </x-ui.alert>
            @endif

            <form action="{{ route('clientes.store') }}" method="POST">
                @csrf

                <x-ui.form-input name="nombre_comercial" label="Nombre Comercial" :required="true"/>
                <x-ui.form-input name="razon_social" label="Razón Social" :required="true"/>

                <x-ui.form-select name="comercial_id" label="Comercial asignado" :required="true">
                    <option value="">Selecciona un comercial</option>
                    @foreach($comerciales as $id => $nombre)
                        <option value="{{ $id }}" {{ old('comercial_id', $comercialSeleccionado) == $id ? 'selected' : '' }}>
                            {{ $nombre }}
                        </option>
                    @endforeach
                </x-ui.form-select>

                @if(count($comerciales) === 1)
                    <input type="hidden" name="comercial_id" value="{{ $comercialSeleccionado }}">
                @endif

                <x-ui.form-input name="email" label="Email" type="email"/>
                <x-ui.form-input name="telefono" label="Teléfono"/>
                <x-ui.form-input name="direccion" label="Dirección"/>
                <x-ui.form-input name="tipo_negocio" label="Tipo de Negocio"/>

                <div class="flex items-center gap-3 pt-4">
                    <x-ui.button type="submit">Guardar</x-ui.button>
                    <x-ui.button variant="secondary" href="{{ route('clientes.index') }}">Cancelar</x-ui.button>
                </div>
            </form>
        </x-ui.card>

    </div>
</div>
@endsection

