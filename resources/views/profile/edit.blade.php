<!-- resources/views/profile/edit.blade.php -->

@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Editar Perfil</h1>

    @if (session('status') === 'profile-updated')
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            Perfil actualizado correctamente.
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PATCH')

        <div class="mb-4">
            <label for="name" class="block font-medium">Nombre</label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                   class="w-full border rounded p-2 mt-1 @error('name') border-red-500 @enderror">
            @error('name')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="block font-medium">Correo Electrónico</label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                   class="w-full border rounded p-2 mt-1 @error('email') border-red-500 @enderror">
            @error('email')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex justify-between">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Guardar</button>

            <a href="{{ route('dashboard') }}" class="text-gray-600 underline">Cancelar</a>
        </div>
    </form>

    <form method="POST" action="{{ route('profile.destroy') }}" class="mt-6">
        @csrf
        @method('DELETE')

        <div class="border-t pt-4 mt-4">
            <h2 class="text-lg font-semibold text-red-600">Eliminar cuenta</h2>
            <p class="text-sm text-gray-600 mb-2">Esta acción no se puede deshacer.</p>

            <input type="password" name="password" placeholder="Contraseña actual"
                   class="w-full border rounded p-2 mb-2 @error('password') border-red-500 @enderror">
            @error('password')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @
