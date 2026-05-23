@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        <x-ui.back-link :href="route('clientes.index')" label="Volver a Clientes"/>

        <x-ui.card>
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-900">{{ $cliente->nombre_comercial }}</h1>
                <span class="text-sm text-gray-400">{{ $cliente->id }}</span>
            </div>

            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Razón Social</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $cliente->razon_social }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Email</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $cliente->email ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Teléfono</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $cliente->telefono ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Dirección</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $cliente->direccion ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo de Negocio</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $cliente->tipo_negocio ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Comercial asignado</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ optional($cliente->comercial)->name ?? '—' }}</dd>
                </div>
            </dl>

            <p class="text-xs text-gray-400 mt-6">Creado el {{ $cliente->created_at->format('d/m/Y H:i') }}</p>
        </x-ui.card>

        <div class="flex items-center gap-3">
            <x-ui.button href="{{ route('clientes.edit', $cliente) }}">Editar</x-ui.button>
            <x-ui.button variant="secondary" href="{{ route('clientes.index') }}">Volver</x-ui.button>
        </div>

    </div>
</div>
@endsection
