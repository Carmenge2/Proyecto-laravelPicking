<nav x-data="{ open: false }" class="bg-white border-b border-orange-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Logo + Nav Links --}}
            <div class="flex items-center gap-8">
                <a href="{{ route('dashboard') }}" class="shrink-0">
                    <img class="h-8 w-auto" src="{{ asset('logo_picking.png') }}" alt="Picking">
                </a>

                @auth
                    <div class="hidden md:flex items-center gap-1">
                        @if(Auth::user()->rol === 'admin')
                            <a href="{{ route('admin.dashboard') }}"
                               class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-orange-50 text-orange-700' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-700' }} transition">
                                Dashboard
                            </a>
                            <a href="{{ route('catalogo.index') }}"
                               class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('catalogo.*') ? 'bg-orange-50 text-orange-700' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-700' }} transition">
                                Catálogo
                            </a>
                            <a href="{{ route('pedidos.index') }}"
                               class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('pedidos.*') ? 'bg-orange-50 text-orange-700' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-700' }} transition">
                                Pedidos
                            </a>
                            <a href="{{ route('clientes.index') }}"
                               class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('clientes.*') ? 'bg-orange-50 text-orange-700' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-700' }} transition">
                                Clientes
                            </a>
                            <a href="{{ route('admin.trabajadores.index') }}"
                               class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('admin.trabajadores.*') ? 'bg-orange-50 text-orange-700' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-700' }} transition">
                                Comerciales
                            </a>
                        @else
                            <a href="{{ route('comercial.dashboard') }}"
                               class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('comercial.dashboard') ? 'bg-orange-50 text-orange-700' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-700' }} transition">
                                Dashboard
                            </a>
                            <a href="{{ route('catalogo.index') }}"
                               class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('catalogo.*') ? 'bg-orange-50 text-orange-700' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-700' }} transition">
                                Catálogo
                            </a>
                            <a href="{{ route('pedidos.index') }}"
                               class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('pedidos.*') ? 'bg-orange-50 text-orange-700' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-700' }} transition">
                                Pedidos
                            </a>
                            <a href="{{ route('clientes.index') }}"
                               class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('clientes.*') ? 'bg-orange-50 text-orange-700' : 'text-gray-600 hover:bg-orange-50 hover:text-orange-700' }} transition">
                                Clientes
                            </a>
                        @endif
                    </div>
                @endauth
            </div>

            {{-- Right: User dropdown --}}
            @auth
                <div class="hidden md:flex items-center gap-3">
                    <x-ui.badge type="{{ Auth::user()->rol }}">{{ ucfirst(Auth::user()->rol) }}</x-ui.badge>

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    Cerrar Sesión
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            @endauth

            {{-- Hamburger (mobile) --}}
            <button @click="open = !open" class="md:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100 transition">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                    <path x-show="open" x-cloak stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div x-show="open" x-cloak x-transition class="md:hidden border-t border-orange-100 bg-white">
        @auth
            <div class="px-4 py-3 space-y-1">
                @if(Auth::user()->rol === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-orange-50">Dashboard</a>
                    <a href="{{ route('catalogo.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-orange-50">Catálogo</a>
                    <a href="{{ route('pedidos.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-orange-50">Pedidos</a>
                    <a href="{{ route('clientes.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-orange-50">Clientes</a>
                    <a href="{{ route('admin.trabajadores.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-orange-50">Comerciales</a>
                @else
                    <a href="{{ route('comercial.dashboard') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-orange-50">Dashboard</a>
                    <a href="{{ route('catalogo.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-orange-50">Catálogo</a>
                    <a href="{{ route('pedidos.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-orange-50">Pedidos</a>
                    <a href="{{ route('clientes.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-orange-50">Clientes</a>
                @endif
            </div>

            <div class="border-t border-gray-100 px-4 py-3">
                <p class="text-sm font-medium text-gray-800">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit" class="text-sm text-red-600 hover:underline">Cerrar Sesión</button>
                </form>
            </div>
        @endauth
    </div>
</nav>
