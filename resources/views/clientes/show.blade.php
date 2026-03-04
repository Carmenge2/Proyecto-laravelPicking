@extends('layouts.app')

@section('content')
<div class="bg-orange-50 min-h-screen py-12">
    <div class="max-w-4xl mx-auto space-y-6 px-4 sm:px-6 lg:px-8">

        {{-- Título --}}
        <div class="bg-white p-6 rounded-xl shadow">
            <h1 class="text-2xl font-semibold text-orange-700">Cliente {{ $cliente->id }}</h1>
        </div>

        {{-- Detalle del cliente --}}
        <div class="bg-white rounded-xl shadow p-6 space-y-4 text-gray-800">
            <div>
                <p class="font-semibold text-gray-600">Nombre Comercial:</p>
                <p>{{ $cliente->nombre_comercial }}</p>
            </div>
            <div>
                <p class="font-semibold text-gray-600">Razón Social:</p>
                <p>{{ $cliente->razon_social }}</p>
            </div>
            <div>
                <p class="font-semibold text-gray-600">Email:</p>
                <p>{{ $cliente->email ?? '—' }}</p>
            </div>
            <div>
                <p class="font-semibold text-gray-600">Teléfono:</p>
                <p>{{ $cliente->telefono ?? '—' }}</p>
            </div>
            <div>
                <p class="font-semibold text-gray-600">Dirección:</p>
                <p>{{ $cliente->direccion ?? '—' }}</p>
            </div>
            <div>
                <p class="font-semibold text-gray-600">Tipo de Negocio:</p>
                <p>{{ $cliente->tipo_negocio ?? '—' }}</p>
            </div>
            <div>
                <p class="font-semibold text-gray-600">Comercial asignado:</p>
                <p>{{ optional($cliente->comercial)->name ?? '—' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-400">
                    Creado el {{ $cliente->created_at->format('d/m/Y H:i') }}
                </p>
            </div>
        </div>

        {{-- Botones --}}
        <div class="flex space-x-2">
            <a href="{{ route('clientes.edit', $cliente) }}" 
               class="bg-orange-400 hover:bg-orange-500 text-white font-semibold py-2 px-4 rounded-lg transition">
               Editar
            </a>
            <a href="{{ route('clientes.index') }}" 
               class="bg-gray-400 hover:bg-gray-500 text-white font-semibold py-2 px-4 rounded-lg transition">
               Volver
            </a>
        </div>

    </div>
</div>
@endsection
