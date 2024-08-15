<link rel="stylesheet" href="{{ asset('css/nav.css') }}">
<nav x-data="{ open: false }" class="navbar">
    <!-- Logo -->
    <div class="flex items-center justify-center h-16 border-b border-gray-200">
        <a href="{{ route('dashboard') }}" class="logo">
            <x-application-logo class="block text-white fill-current w-128 h-128" />
        </a>
    </div>


    <div class="flex flex-col flex-grow mt-8 space-y-2">
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="px-4 py-2 text-white hover:text-gray-200 hover:bg-pink-600">
            {{ __('Dashboard') }}
        </x-nav-link>

    <!-- Navigation Links -->
@if (Auth::user()->hasRole('Doctor'))
        <x-nav-link :href="route('doctores.index')" :active="request()->routeIs('doctores.index')" class="px-4 py-2 text-white hover:text-gray-200 hover:bg-pink-600">
            {{ __('Doctores') }}
        </x-nav-link>
        <x-nav-link :href="route('secretarias.index')" :active="request()->routeIs('secretarias.index')" class="px-4 py-2 text-white hover:text-gray-200 hover:bg-pink-600">
            {{ __('Secretarias') }}
        </x-nav-link>
        <x-nav-link :href="route('pacientes.index')" :active="request()->routeIs('pacientes.index')" class="px-4 py-2 text-white hover:text-gray-200 hover:bg-pink-600">
            {{ __('Pacientes') }}
        </x-nav-link>
        <x-nav-link :href="route('consultas.index')" :active="request()->routeIs('consultas.index')" class="px-4 py-2 text-white hover:text-gray-200 hover:bg-pink-600">
            {{ __('Consultas') }}
        </x-nav-link>
        <x-nav-link :href="route('servicios.index')" :active="request()->routeIs('servicios.index')" class="px-4 py-2 text-white hover:text-gray-200 hover:bg-pink-600">
            {{ __('Servicios') }}
        </x-nav-link>
        <x-nav-link :href="route('productos.index')" :active="request()->routeIs('productos.index')" class="px-4 py-2 text-white hover:text-gray-200 hover:bg-pink-600">
            {{ __('Productos') }}
        </x-nav-link>
        <x-nav-link :href="route('ventas.index')" :active="request()->routeIs('ventas.index')" class="px-4 py-2 text-white hover:text-gray-200 hover:bg-pink-600">
            {{ __('Ventas') }}
        </x-nav-link>
        <x-nav-link :href="route('citas.index')" :active="request()->routeIs('citas.index')" class="px-4 py-2 text-white hover:text-gray-200 hover:bg-pink-600">
            {{ __('Citas') }}
        </x-nav-link>
        <x-nav-link :href="route('usuarios.index')" :active="request()->routeIs('usuarios.index')" class="px-4 py-2 text-white hover:text-gray-200 hover:bg-pink-600">
            {{ __('Usuarios') }}
        </x-nav-link>

@elseif (Auth::user()->hasRole('Secretaria'))
        <x-nav-link :href="route('pacientes.index')" :active="request()->routeIs('pacientes.index')" class="px-4 py-2 text-white hover:text-gray-200 hover:bg-pink-600">
            {{ __('Pacientes') }}
        </x-nav-link>

        <x-nav-link :href="route('servicios.index')" :active="request()->routeIs('servicios.index')" class="px-4 py-2 text-white hover:text-gray-200 hover:bg-pink-600">
            {{ __('Servicios') }}
        </x-nav-link>
        <x-nav-link :href="route('productos.index')" :active="request()->routeIs('productos.index')" class="px-4 py-2 text-white hover:text-gray-200 hover:bg-pink-600">
            {{ __('Productos') }}
        </x-nav-link>

        <x-nav-link :href="route('citas.index')" :active="request()->routeIs('citas.index')" class="px-4 py-2 text-white hover:text-gray-200 hover:bg-pink-600">
            {{ __('Citas') }}
        </x-nav-link>

@elseif (Auth::user()->hasRole('Paciente'))

        <x-nav-link :href="route('citas.index')" :active="request()->routeIs('citas.index')" class="px-4 py-2 text-white hover:text-gray-200 hover:bg-pink-600">
            {{ __('Citas') }}
        </x-nav-link>

@endif
    <!-- Settings Dropdown -->
    <div class="mb-4">
        <x-dropdown width="48" >
            <x-slot name="trigger">
                <button class="flex items-center justify-center w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-black transition duration-150 ease-in-out bg-[#FF8FAB] border border-transparent rounded-lg hover:bg-[#FB6F92] focus:outline-none">
                    <span>{{Auth::user()->showName()}}</span>
                    <svg class="w-5 h-5 ml-auto" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </x-slot>

            <x-slot name="content">
                <x-dropdown-link :href="route('profile.edit')" class="text-black hover:bg-gray-100">
                    {{ __('Profile') }}
                </x-dropdown-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')" class="text-black hover:bg-gray-100" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
</div>
</nav>

<!-- Responsive Navigation Menu -->
<div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
    <div class="pt-2 pb-3 space-y-1">
        <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:bg-pink-600">
            {{ __('Dashboard') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('doctores.index')" :active="request()->routeIs('doctores.index')" class="text-white hover:bg-pink-600">
            {{ __('Doctores') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('doctores.crear')" :active="request()->routeIs('doctores.crear')" class="text-white hover:bg-pink-600">
            {{ __('Agregar Doctor') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('secretarias.index')" :active="request()->routeIs('secretarias.index')" class="text-white hover:bg-pink-600">
            {{ __('Secretarias') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('pacientes.index')" :active="request()->routeIs('pacientes.index')" class="text-white hover:bg-pink-600">
            {{ __('Pacientes') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('servicios.index')" :active="request()->routeIs('servicios.index')" class="text-white hover:bg-pink-600">
            {{ __('Servicios') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('productos.index')" :active="request()->routeIs('productos.index')" class="text-white hover:bg-pink-600">
            {{ __('Productos') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('citas.index')" :active="request()->routeIs('citas.index')" class="text-white hover:bg-pink-600">
            {{ __('Citas') }}
        </x-responsive-nav-link>
    </div>

    <!-- Responsive Settings Options -->
    <div class="pt-4 pb-1 border-t border-gray-200">
        <div class="px-4">
            <div class="text-base font-medium text-black">{{ Auth::user()->showName()}}</div>
            <div class="text-sm font-medium text-black-200">{{ Auth::user()->showRol() }}</div>
        </div>
        <div class="mt-3 space-y-1">
            <x-responsive-nav-link :href="route('profile.edit')" class="text-white hover:bg-pink-600">
                {{ __('Profile') }}
            </x-responsive-nav-link>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-responsive-nav-link :href="route('logout')" class="text-white hover:bg-pink-600" onclick="event.preventDefault(); this.closest('form').submit();">
                    {{ __('Log Out') }}
                </x-responsive-nav-link>
            </form>
        </div>
    </div>
</div>

<!-- Content Wrapper -->

<div class="flex-1 p-6 ml-64 main-content md:ml-200">
    <div class="main-content">
        @yield('content')
    </div>
</div>
