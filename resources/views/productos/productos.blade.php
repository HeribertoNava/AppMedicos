@if(auth()->user()->rol === 'Doctor' || auth()->user()->rol === 'Secretaria')

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
                <input type="text" id="table-search-users" class="block p-2 text-sm text-gray-900 border border-gray-300 rounded-lg ps-10 w-80 bg-gray-50 focus:ring-pink-400 focus:border-pink-400 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-pink-400 dark:focus:border-pink-400" placeholder="Buscar productos">
            </div>
            <button type="button" onclick="openModal()" class="px-4 py-2 text-sm font-medium text-center text-white bg-pink-600 rounded-lg hover:bg-pink-700 focus:ring-4 focus:outline-none focus:ring-pink-300">
                Agregar Producto
            </button>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"> <!-- Ajuste de gap para espacio entre recuadros -->
        @foreach ($productos as $producto)
        <div class="flex items-center p-4 mb-4 bg-white rounded-lg shadow-md dark:bg-gray-800"> <!-- Eliminado mx-5 -->
            <div class="flex-shrink-0">
                <x-application-producto class="block text-white fill-current w-12 h-12" />
            </div>
            <div class="ml-4">
                <div class="text-lg font-medium text-gray-900 dark:text-white">{{ $producto->nombre }}</div>
                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $producto->descripcion }}</div>
                <div class="text-sm text-gray-500 dark:text-gray-400">Cantidad: {{ $producto->cantidad }}</div>
                <div class="text-sm text-gray-500 dark:text-gray-400">Precio: ${{ $producto->precio }}</div>
                <div class="flex mt-2 space-x-2">
                    <a href="{{ route('productos.editar', $producto->id) }}" class="text-pink-600 dark:text-pink-500 hover:underline">Editar</a>
                    <form action="{{ route('productos.eliminar', $producto->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 dark:text-red-500 hover:underline" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?')">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Modal -->
<div id="productoModal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
    <div class="p-6 bg-white rounded-lg shadow-lg dark:bg-gray-800" style="width: 500px;">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold">Registrar Producto</h2>
            <button onclick="closeModal()" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">&times;</button>
        </div>
        <form method="POST" action="{{ route('productos.store') }}">
            @csrf
            <!-- Producto -->
            <div class="mb-4">
                <label for="nombre" class="block mb-2 text-sm font-medium text-gray-800 dark:text-gray-200">Producto <span class="text-red-600">*</span></label>
                <input type="text" id="nombre" name="nombre" class="block w-full p-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Ingrese el nombre del producto" required />
            </div>

            <!-- Descripción -->
            <div class="mb-4">
                <label for="descripcion" class="block mb-2 text-sm font-medium text-gray-800 dark:text-gray-200">Descripción <span class="text-red-600">*</span></label>
                <input type="text" id="descripcion" name="descripcion" class="block w-full p-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Ingrese la descripción" required />
            </div>

            <!-- Cantidad -->
            <div class="mb-4">
                <label for="cantidad" class="block mb-2 text-sm font-medium text-gray-800 dark:text-gray-200">Cantidad <span class="text-red-600">*</span></label>
                <input type="number" id="cantidad" name="cantidad" class="block w-full p-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Ingrese la cantidad" required />
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
        document.getElementById('productoModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('productoModal').classList.add('hidden');
    }
</script>
@endsection
@endif
