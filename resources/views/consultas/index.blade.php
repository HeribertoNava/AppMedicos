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
                <input type="text" id="table-search-consultas" class="block p-2 text-sm text-gray-900 border border-gray-300 rounded-lg ps-10 w-80 bg-gray-50 focus:ring-pink-400 focus:border-pink-400 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-pink-400 dark:focus:border-pink-400" placeholder="Buscar consulta">
            </div>
            <a href="{{ route('consultas.create', ['paciente_id' => $paciente->id]) }}" class="px-4 py-2 text-sm font-medium text-center text-white bg-pink-600 rounded-lg hover:bg-pink-700 focus:ring-4 focus:outline-none focus:ring-pink-300">
                Agregar Consulta
            </a>
        </div>
    </div>
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase" style="background-color: #f8e7f2;">
            <tr>
                <th scope="col" class="px-6 py-3">Fecha</th>
                <th scope="col" class="px-6 py-3">Doctor</th>
                <th scope="col" class="px-6 py-3">Motivo Consulta</th>
                <th scope="col" class="px-6 py-3">Diagnóstico</th>
                <th scope="col" class="px-6 py-3">Plan</th>
                <th scope="col" class="px-6 py-3">Total a Pagar</th>
                <th scope="col" class="px-6 py-3">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($consultas as $consulta)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="px-6 py-4">{{ $consulta->fecha }}</td>
                <td class="px-6 py-4">{{ $consulta->doctor->nombres }} {{ $consulta->doctor->apellidos }}</td>
                <td class="px-6 py-4">{{ $consulta->motivo_consulta }}</td>
                <td class="px-6 py-4">{{ $consulta->diagnostico }}</td>
                <td class="px-6 py-4">{{ $consulta->plan }}</td>
                <td class="px-6 py-4">{{ $consulta->total_a_pagar }}</td>
                <td class="flex px-6 py-4 space-x-2">
                    <a href="{{ route('consultas.editar', $consulta->id) }}" class="font-medium text-pink-600 dark:text-pink-500 hover:underline">Editar</a>
                    <form action="{{ route('consultas.eliminar', $consulta->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline" onclick="return confirm('¿Estás seguro de que deseas eliminar esta consulta?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
