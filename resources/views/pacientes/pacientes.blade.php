@extends('layouts.app')

@section('content')
<div class="relative p-4 overflow-x-auto bg-white shadow-md sm:rounded-lg dark:bg-gray-900">
    <div class="flex flex-wrap items-center justify-between mb-4 space-y-4 md:flex-nowrap md:space-y-0">
        <div class="flex items-center space-x-4">
            <label for="table-search" class="sr-only">Buscar</label>
            <div class="relative">
                <div class="absolute inset-y-0 flex items-center pointer-events-none rtl:inset-r-0 start-0 ps-3">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input type="text" id="table-search-users" class="block p-2 text-sm text-gray-900 border border-gray-300 rounded-lg ps-10 w-80 bg-gray-50 focus:ring-pink-400 focus:border-pink-400 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-pink-400 dark:focus:border-pink-400" placeholder="Buscar paciente">
            </div>
            <button type="button" onclick="openModal()" class="px-4 py-2 text-sm font-medium text-center text-white bg-pink-600 rounded-lg hover:bg-pink-700 focus:ring-4 focus:outline-none focus:ring-pink-300">
                Agregar Paciente
            </button>
        </div>
    </div>
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase" style="background-color: #f8e7f2;">
            <tr>
                <th scope="col" class="px-6 py-3">Nombres</th>
                <th scope="col" class="px-6 py-3">Apellidos</th>
                <th scope="col" class="px-6 py-3">Correo</th>
                <th scope="col" class="px-6 py-3">Teléfono</th>
                <th scope="col" class="px-6 py-3">Dirección</th>
                <th scope="col" class="px-6 py-3">Edad</th>
                <th scope="col" class="px-6 py-3">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pacientes as $paciente)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="px-6 py-4">{{ $paciente->nombres }}</td>
                <td class="px-6 py-4">{{ $paciente->apellidos }}</td>
                <td class="px-6 py-4">{{ $paciente->correo }}</td>
                <td class="px-6 py-4">{{ $paciente->telefono }}</td>
                <td class="px-6 py-4">{{ $paciente->direccion }}</td>
                <td class="px-6 py-4">{{ $paciente->edad }}</td>
                <td class="flex px-6 py-4 space-x-2">
                    <a href="{{ route('pacientes.editar', $paciente->id) }}" class="font-medium text-pink-600 dark:text-pink-500 hover:underline">Editar</a>
                    <form action="{{ route('pacientes.eliminar', $paciente->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline" onclick="return confirm('¿Estás seguro de que deseas eliminar a este paciente?')">Eliminar</button>
                    </form>
                    @if(auth()->user()->rol === 'Doctor')
                    <a href="{{ route('consultas.create', $paciente->id) }}" class="font-medium text-green-600 dark:text-green-500 hover:underline">{{ __('Consultas') }}</a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal -->
<div id="pacienteModal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
    <div class="p-6 bg-white rounded-lg shadow-lg dark:bg-gray-800" style="width: 500px;">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold">Registrar Paciente</h2>
            <button onclick="closeModal()" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">&times;</button>
        </div>
        <form method="POST" action="{{ route('pacientes.store') }}">
            @csrf
            <!-- Nombres -->
            <div class="mb-4">
                <label for="nombres" class="block mb-2 text-sm font-medium text-gray-800 dark:text-gray-200">Nombres <span class="text-red-600">*</span></label>
                <input type="text" id="nombres" name="nombres" class="block w-full p-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Ingrese los nombres" required />
            </div>

            <!-- Apellidos -->
            <div class="mb-4">
                <label for="apellidos" class="block mb-2 text-sm font-medium text-gray-800 dark:text-gray-200">Apellidos <span class="text-red-600">*</span></label>
                <input type="text" id="apellidos" name="apellidos" class="block w-full p-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Ingrese los apellidos" required />
            </div>

            <!-- Correo -->
            <div class="mb-4">
                <label for="correo" class="block mb-2 text-sm font-medium text-gray-800 dark:text-gray-200">Correo <span class="text-red-600">*</span></label>
                <input type="email" id="correo" name="correo" class="block w-full p-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Ingrese el correo" required />
            </div>

            <!-- Teléfono -->
            <div class="mb-4">
                <label for="telefono" class="block mb-2 text-sm font-medium text-gray-800 dark:text-gray-200">Teléfono <span class="text-red-600">*</span></label>
                <input type="tel" id="telefono" name="telefono" class="block w-full p-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Ingrese el teléfono" required />
            </div>

            <!-- Dirección -->
            <div class="mb-4">
                <label for="direccion" class="block mb-2 text-sm font-medium text-gray-800 dark:text-gray-200">Dirección <span class="text-red-600">*</span></label>
                <input type="text" id="direccion" name="direccion" class="block w-full p-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Ingrese la dirección" required />
            </div>

            <!-- Edad -->
            <div class="mb-4">
                <label for="edad" class="block mb-2 text-sm font-medium text-gray-800 dark:text-gray-200">Edad <span class="text-red-600">*</span></label>
                <input type="number" id="edad" name="edad" class="block w-full p-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Ingrese la edad" required />
            </div>

            <!-- Contraseña -->
            <div class="mb-4">
                <label for="password" class="block mb-2 text-sm font-medium text-gray-800 dark:text-gray-200">Contraseña <span class="text-red-600">*</span></label>
                <input type="password" id="password" name="password" class="block w-full p-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Ingrese la contraseña" required />
            </div>

            <!-- Confirmar Contraseña -->
            <div class="mb-4">
                <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-800 dark:text-gray-200">Confirmar Contraseña <span class="text-red-600">*</span></label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="block w-full p-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Confirme la contraseña" required />
            </div>

            <div class="flex justify-end">
                <button type="button" onclick="closeModal()" class="px-4 py-2 mr-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-100">Cancelar</button>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300">Guardar</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('pacienteModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('pacienteModal').classList.add('hidden');
    }
</script>
@endsection
