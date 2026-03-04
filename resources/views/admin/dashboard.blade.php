{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="relative py-12 bg-cover bg-center" 
     style="background-image: url('{{ asset('storage/productos/cabecera.jpg') }}')">



    {{-- Contenido del dashboard --}}
    <div class="relative z-10">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <h2 class="text-5xl lg:text-6xl font-extrabold text-gray-900 text-center mb-24 tracking-wide drop-shadow-md">
      Panel de Administrador
    </h2>


    <div class="space-y-6">

      {{-- TARJETA PRODUCTOS --}}
      <a href="{{ route('catalogo.index') }}"
         class="block bg-white rounded-2xl shadow hover:shadow-lg transition p-6">
        <div class="flex items-center justify-between">
          <div class="flex items-center space-x-3">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-gray-700">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4 4h6v6H4zM14 4h6v6h-6zM4 14h6v6H4zM14 14h6v6h-6z" />
            </svg>


            <h3 class="text-xl font-semibold text-gray-800">Gestión de Productos</h3>
          </div>
          <svg xmlns="http://www.w3.org/2000/svg"
               class="h-6 w-6 text-green-600"
               fill="none" viewBox="0 0 24 24"
               stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 5l7 7-7 7" />
          </svg>
        </div>
      </a>

        {{-- TARJETA PEDIDOS --}}
        <a href="{{ route('pedidos.index') }}"
          class="block bg-white rounded-2xl shadow hover:shadow-lg transition p-6">
          <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
              {{-- Icono de cesta --}}
              <svg xmlns="http://www.w3.org/2000/svg"
                  class="h-6 w-6 text-orange-400"
                  fill="none" viewBox="0 0 24 24"
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
        </a>


                {{-- TARJETA CLIENTES --}}
        <a href="{{ route('clientes.index') }}"
          class="block bg-white rounded-2xl shadow hover:shadow-lg transition p-6">
          <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
              {{-- Icono de una sola persona --}}
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
        </a>



      {{-- TARJETA VALORACIONES --}}
      <a href="{{ route('valoraciones.index') }}"
         class="block bg-white rounded-2xl shadow hover:shadow-lg transition p-6">
        <div class="flex items-center justify-between">
          <div class="flex items-center space-x-3">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-6 w-6 text-yellow-500"
                 fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 4.5l2.09 6.26L21 12l-5.45 3.96L17.64 22 12 18.27 6.36 22l1.09-6.04L3 12l6.91-1.24L12 4.5z" />
            </svg>
            <h3 class="text-xl font-semibold text-gray-800">Gestión de Valoraciones</h3>
          </div>
          <svg xmlns="http://www.w3.org/2000/svg"
               class="h-5 w-5 text-yellow-500"
               fill="none" viewBox="0 0 24 24"
               stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 5l7 7-7 7" />
          </svg>
        </div>
      </a>

      {{-- TARJETA EMPLEADOS  --}}
      <a href="{{ route('admin.trabajadores.index') }}"
         class="block bg-white rounded-2xl shadow hover:shadow-lg transition p-6">
        <div class="flex items-center justify-between">
          <div class="flex items-center space-x-3">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-6 w-6 text-red-500"
                 fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 
                       014-4h1m4-4a4 4 0 11-8 0 4 4 0 018 0zm6 0a4 4 0 
                       11-8 0 4 4 0 018 0z" />
            </svg>
            <h3 class="text-xl font-semibold text-gray-800">Gestión de Comerciales</h3>
          </div>
          <svg xmlns="http://www.w3.org/2000/svg"
               class="h-5 w-5 text-red-500"
               fill="none" viewBox="0 0 24 24"
               stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 5l7 7-7 7" />
          </svg>
        </div>
      </a>

    </div>
  </div>
</div>
@endsection
