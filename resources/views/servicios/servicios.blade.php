
@if(auth()->user()->rol ==='Doctor' || auth()->user()->rol ==='Secretaria' )
    
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
                <input type="text" id="table-search-users" class="block p-2 text-sm text-gray-900 border border-gray-300 rounded-lg ps-10 w-80 bg-gray-50 focus:ring-pink-400 focus:border-pink-400 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-pink-400 dark:focus:border-pink-400" placeholder="Buscar servicios">
            </div>
            <button type="button" onclick="openModal()" class="px-4 py-2 text-sm font-medium text-center text-white bg-pink-600 rounded-lg hover:bg-pink-700 focus:ring-4 focus:outline-none focus:ring-pink-300">
                Agregar Servicio
            </button>
        </div>
    </div>
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase" style="background-color: #f8e7f2;">
            <tr>
                <th scope="col" class="px-6 py-3">Servicio</th>
                <th scope="col" class="px-6 py-3">Descripción</th>
                <th scope="col" class="px-6 py-3">Precio</th>
                <th scope="col" class="px-6 py-3">Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($servicios as $servicio)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="px-6 py-4">{{ $servicio->nombre }}</td>
                <td class="px-6 py-4">{{ $servicio->descripcion }}</td>
                <td class="px-6 py-4">{{ $servicio->precio }}</td>
                <td class="flex px-6 py-4 space-x-2">
                    @if(auth()->user()->rol === 'Doctor')                       

                    <a href="{{ route('servicios.editar', $servicio->id) }}" class="font-medium text-pink-600 dark:text-pink-500 hover:underline">Editar</a>
                    <form action="{{ route('servicios.eliminar', $servicio->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline" onclick="return confirm('¿Estás seguro de que deseas eliminar este servicio?')">Eliminar</button>
                        @endif
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal -->
<div id="servicioModal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
    <div class="p-6 bg-white rounded-lg shadow-lg dark:bg-gray-800" style="width: 500px;">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold">Registrar Servicio</h2>
            <button onclick="closeModal()" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">&times;</button>
        </div>
        <form method="POST" action="{{ route('servicios.store') }}">
            @csrf
            <!-- Servicio -->
            <div class="mb-4">
                <label for="nombre" class="block mb-2 text-sm font-medium text-gray-800 dark:text-gray-200">Servicio <span class="text-red-600">*</span></label>
                <input type="text" id="nombre" name="nombre" class="block w-full p-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Ingrese el nombre del servicio" required />
            </div>

            <!-- Descripción -->
            <div class="mb-4">
                <label for="descripcion" class="block mb-2 text-sm font-medium text-gray-800 dark:text-gray-200">Descripción <span class="text-red-600">*</span></label>
                <input type="text" id="descripcion" name="descripcion" class="block w-full p-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Ingrese la descripción" required />
            </div>

            <!-- Precio -->
            <div class="mb-4">
                <label for="precio" class="block mb-2 text-sm font-medium text-gray-800 dark:text-gray-200">Precio <span class="text-red-600">*</span></label>
                <input type="number" id="precio" name="precio" class="block w-full p-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Ingrese el precio" required />
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
        document.getElementById('servicioModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('servicioModal').classList.add('hidden');
    }
</script>
@endsection

@endif