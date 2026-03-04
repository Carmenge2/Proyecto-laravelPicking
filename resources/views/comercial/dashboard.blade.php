{{-- resources/views/comercial/dashboard.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="relative py-12 bg-cover bg-center" 
     style="background-image: url('{{ asset('storage/productos/cabecera.jpg') }}')">



    {{-- Contenido del dashboard --}}
    <div class="relative z-10">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <h2 class="text-5xl lg:text-6xl font-extrabold text-black text-center mb-24 tracking-wide drop-shadow-2xl">
          Panel Comercial
        </h2>

        <div class="space-y-6">

          {{-- TARJETA CLIENTES --}}
          <a href="{{ route('clientes.index') }}"
            class="block bg-white rounded-2xl shadow hover:shadow-lg transition p-6">
            <div class="flex items-center justify-between">
              <div class="flex items-center space-x-3">

                {{-- Icono persona --}}
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6 text-indigo-600"
                    fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5.121 17.804A4 4 0 018 14h8a4 4 0 012.879 3.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>

                <h3 class="text-xl font-semibold text-gray-800">Gestión de Clientes</h3>
              </div>
              <svg xmlns="http://www.w3.org/2000/svg"
                  class="h-5 w-5 text-indigo-600"
                  fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 5l7 7-7 7" />
              </svg>
            </div>
            <p class="mt-4 text-gray-600">
              Agrega, modifica, elimina y consulta todos los clientes registrados.
            </p>
          </a>

          {{-- TARJETA PEDIDOS --}}
          <a href="{{ route('pedidos.index') }}"
            class="block bg-white rounded-2xl shadow hover:shadow-lg transition p-6">
            <div class="flex items-center justify-between">
              <div class="flex items-center space-x-3">

                {{-- Icono pedidos --}}
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6 text-orange-400"
                    fill="none" style="margin-right: 4px;" viewBox="0 0 24 24"
                    stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 6h13L17 13M10 21a1 1 0 100-2 1 1 0 000 2zm7 1a1 1 0 100-2 1 1 0 000 2z" />
                </svg>

                <h3 class="text-xl font-semibold text-gray-800">Gestión de Pedidos</h3>
              </div>
              <svg xmlns="http://www.w3.org/2000/svg"
                  class="h-5 w-5 text-orange-400"
                  fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 5l7 7-7 7" />
              </svg>
            </div>
            <p class="mt-4 text-gray-600">
              Crea y elimina pedidos, actualiza estados y consulta detalles de Pedidos.
            </p>
          </a>

        </div>
      </div>
    </div>
</div>
@endsection
