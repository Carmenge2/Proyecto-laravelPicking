<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                @if ($error === 'These credentials do not match our records.')
                    <div class="mb-4 text-sm text-red-600 bg-red-50 px-3 py-2 rounded-lg">
                        Correo o contraseña incorrectos.
                    </div>
                @endif
            @endforeach
        @endif

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                   class="w-full border border-orange-200 rounded-xl px-4 py-2.5 text-gray-700 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition">
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Contraseña</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                   class="w-full border border-orange-200 rounded-xl px-4 py-2.5 text-gray-700 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition">
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <div class="flex items-center justify-between mt-5">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-orange-300 text-orange-500 shadow-sm focus:ring-orange-400" name="remember">
                <span class="ms-2 text-sm text-gray-600">Recuérdame</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-orange-600 hover:text-orange-700" href="{{ route('password.request') }}">
                    ¿Olvidaste tu contraseña?
                </a>
            @endif
        </div>

        <div class="mt-6">
            <button type="submit"
                    class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2.5 px-4 rounded-xl shadow-sm transition">
                Iniciar Sesión
            </button>
        </div>
    </form>
</x-guest-layout>
