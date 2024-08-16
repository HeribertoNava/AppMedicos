<link rel="stylesheet">
<nav x-data="{ open: false }" class="fixed top-0 left-0 z-50 w-64 h-screen text-black shadow-lg bg-gradient-to-br from-pink-200 via-pink-300 to-pink-400">
    <!-- Logo -->
    <div class="flex items-center justify-center h-20 border-b border-pink-300">
        <a href="{{ route('dashboard') }}" class="logo">
            <x-application-logo class="w-16 h-16 text-white" />
        </a>
    </div>

    <!-- Navigation Links -->
    <div class="flex flex-col flex-grow mt-8 space-y-2">
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="px-4 py-2 text-black transition-colors rounded-md hover:text-white hover:bg-pink-600">
            {{ __('Dashboard') }}
        </x-nav-link>

        @if (Auth::user()->hasRole('medico_colaborador'))
            <x-nav-link :href="route('colaboraciones.index')" :active="request()->routeIs('colaboraciones.index')" class="px-4 py-2 text-black transition-colors rounded-md hover:text-white hover:bg-pink-600">
                {{ __('Consultas') }}
            </x-nav-link>
        @endif

        @if (Auth::user()->hasRole('Doctor'))
            <x-nav-link :href="route('doctores.index')" :active="request()->routeIs('doctores.index')" class="px-4 py-2 text-black transition-colors rounded-md hover:text-white hover:bg-pink-600">
                {{ __('Doctores') }}
            </x-nav-link>
            <x-nav-link :href="route('secretarias.index')" :active="request()->routeIs('secretarias.index')" class="px-4 py-2 text-black transition-colors rounded-md hover:text-white hover:bg-pink-600">
                {{ __('Secretarias') }}
            </x-nav-link>
            <x-nav-link :href="route('pacientes.index')" :active="request()->routeIs('pacientes.index')" class="px-4 py-2 text-black transition-colors rounded-md hover:text-white hover:bg-pink-600">
                {{ __('Pacientes') }}
            </x-nav-link>
            <x-nav-link :href="route('consultas.index')" :active="request()->routeIs('consultas.index')" class="px-4 py-2 text-black transition-colors rounded-md hover:text-white hover:bg-pink-600">
                {{ __('Consultas') }}
            </x-nav-link>
            <x-nav-link :href="route('servicios.index')" :active="request()->routeIs('servicios.index')" class="px-4 py-2 text-black transition-colors rounded-md hover:text-white hover:bg-pink-600">
                {{ __('Servicios') }}
            </x-nav-link>
            <x-nav-link :href="route('productos.index')" :active="request()->routeIs('productos.index')" class="px-4 py-2 text-black transition-colors rounded-md hover:text-white hover:bg-pink-600">
                {{ __('Productos') }}
            </x-nav-link>
            <x-nav-link :href="route('ventas.index')" :active="request()->routeIs('ventas.index')" class="px-4 py-2 text-black transition-colors rounded-md hover:text-white hover:bg-pink-600">
                {{ __('Ventas') }}
            </x-nav-link>
            <x-nav-link :href="route('citas.index')" :active="request()->routeIs('citas.index')" class="px-4 py-2 text-black transition-colors rounded-md hover:text-white hover:bg-pink-600">
                {{ __('Citas') }}
            </x-nav-link>
            <x-nav-link :href="route('usuarios.index')" :active="request()->routeIs('usuarios.index')" class="px-4 py-2 text-black transition-colors rounded-md hover:text-white hover:bg-pink-600">
                {{ __('Usuarios') }}
            </x-nav-link>
        @elseif (Auth::user()->hasRole('Secretaria'))
            <x-nav-link :href="route('pacientes.index')" :active="request()->routeIs('pacientes.index')" class="px-4 py-2 text-black transition-colors rounded-md hover:text-white hover:bg-pink-600">
                {{ __('Pacientes') }}
            </x-nav-link>
            <x-nav-link :href="route('servicios.index')" :active="request()->routeIs('servicios.index')" class="px-4 py-2 text-black transition-colors rounded-md hover:text-white hover:bg-pink-600">
                {{ __('Servicios') }}
            </x-nav-link>
            <x-nav-link :href="route('productos.index')" :active="request()->routeIs('productos.index')" class="px-4 py-2 text-black transition-colors rounded-md hover:text-white hover:bg-pink-600">
                {{ __('Productos') }}
            </x-nav-link>
            <x-nav-link :href="route('citas.index')" :active="request()->routeIs('citas.index')" class="px-4 py-2 text-black transition-colors rounded-md hover:text-white hover:bg-pink-600">
                {{ __('Citas') }}
            </x-nav-link>
        @elseif (Auth::user()->hasRole('Paciente'))
            <x-nav-link :href="route('citas.index')" :active="request()->routeIs('citas.index')" class="px-4 py-2 text-black transition-colors rounded-md hover:text-white hover:bg-pink-600">
                {{ __('Citas') }}
            </x-nav-link>
        @endif
    </div>

    <!-- Settings Dropdown -->
    <div class="px-4 mb-4">
        <x-dropdown width="48">
            <x-slot name="trigger">
                <button class="flex items-center justify-center w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-black transition duration-150 ease-in-out bg-pink-500 rounded-lg hover:bg-pink-600 focus:outline-none">
                    <span>{{ Auth::user()->showName() }}</span>
                    <svg class="w-5 h-5 ml-auto" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </x-slot>

            <x-slot name="content">
                <x-dropdown-link :href="route('profile.edit')" class="text-black rounded-md hover:bg-pink-200">
                    {{ __('Profile') }}
                </x-dropdown-link>
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')" class="text-black rounded-md hover:bg-pink-200" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
</nav>

<!-- Responsive Navigation Menu -->
<div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
    <div class="pt-2 pb-3 space-y-1">
        <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-black transition-colors rounded-md hover:bg-pink-600">
            {{ __('Dashboard') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('doctores.index')" :active="request()->routeIs('doctores.index')" class="text-black transition-colors rounded-md hover:bg-pink-600">
            {{ __('Doctores') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('doctores.crear')" :active="request()->routeIs('doctores.crear')" class="text-black transition-colors rounded-md hover:bg-pink-600">
            {{ __('Agregar Doctor') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('secretarias.index')" :active="request()->routeIs('secretarias.index')" class="text-black transition-colors rounded-md hover:bg-pink-600">
            {{ __('Secretarias') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('pacientes.index')" :active="request()->routeIs('pacientes.index')" class="text-black transition-colors rounded-md hover:bg-pink-600">
            {{ __('Pacientes') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('servicios.index')" :active="request()->routeIs('servicios.index')" class="text-black transition-colors rounded-md hover:bg-pink-600">
            {{ __('Servicios') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('productos.index')" :active="request()->routeIs('productos.index')" class="text-black transition-colors rounded-md hover:bg-pink-600">
            {{ __('Productos') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('citas.index')" :active="request()->routeIs('citas.index')" class="text-black transition-colors rounded-md hover:bg-pink-600">
            {{ __('Citas') }}
        </x-responsive-nav-link>
    </div>

    <!-- Responsive Settings Options -->
    <div class="pt-4 pb-1 border-t border-pink-300">
        <div class="px-4">
            <div class="text-base font-medium text-black">{{ Auth::user()->showName() }}</div>
            <div class="text-sm font-medium text-pink-600">{{ Auth::user()->showRol() }}</div>
        </div>
        <div class="mt-3 space-y-1">
            <x-responsive-nav-link :href="route('profile.edit')" class="text-black transition-colors rounded-md hover:bg-pink-600">
                {{ __('Profile') }}
            </x-responsive-nav-link>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-responsive-nav-link :href="route('logout')" class="text-black transition-colors rounded-md hover:bg-pink-600" onclick="event.preventDefault(); this.closest('form').submit();">
                    {{ __('Log Out') }}
                </x-responsive-nav-link>
            </form>
        </div>
    </div>
</div>

<!-- Content Wrapper -->
<div class="flex-1 p-6 ml-64 bg-pink-50 main-content md:ml-72">
    <div class="main-content">
        @yield('content')
    </div>
</div>
