@if(auth()->user()->rol === 'Doctor')

@extends('layouts.app')

@section('content')
<div class="container p-6 mx-auto">
    <div class="flex items-center justify-between mb-6">
        <input type="text" class="block w-1/2 p-2 border border-pink-300 rounded-lg focus:ring-pink-200 focus:border-pink-400" placeholder="Buscar usuario">
        <a href="{{ route('usuarios.create') }}" class="inline-flex items-center px-4 py-2 ml-4 text-xs font-semibold text-white uppercase bg-pink-500 rounded-md hover:bg-pink-600 focus:outline-none focus:ring-2 focus:ring-pink-200">
            <ion-icon name="add-circle-outline" class="mr-2"></ion-icon> Agregar Usuario
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
            <thead class="text-white bg-pink-500">
                <tr>
                    <th class="px-4 py-2 text-left">NOMBRES</th>
                    <th class="px-4 py-2 text-left">APELLIDOS</th>
                    <th class="px-4 py-2 text-left">CORREO</th>
                    <th class="px-4 py-2 text-left">TELÉFONO</th>
                    <th class="px-4 py-2 text-left">ROL</th>
                    <th class="px-4 py-2 text-left">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usuarios as $usuario)
                    <tr class="bg-pink-100 border-b border-pink-200 hover:bg-pink-50">
                        <td class="px-4 py-2">{{ $usuario->nombre }}</td>
                        <td class="px-4 py-2">{{ $usuario->apellido }}</td>
                        <td class="px-4 py-2">{{ $usuario->email }}</td>
                        <td class="px-4 py-2">{{ $usuario->telefono }}</td>
                        <td class="px-4 py-2">{{ $usuario->rol }}</td>
                        <td class="px-4 py-2 space-x-2">
                            <a href="{{ route('usuarios.show', $usuario->id) }}" class="inline-flex items-center px-3 py-1 text-sm font-medium text-white bg-blue-500 rounded hover:bg-blue-400">
                                <ion-icon name="eye-outline" class="mr-1"></ion-icon> Ver
                            </a>
                            <a href="{{ route('usuarios.edit', $usuario->id) }}" class="inline-flex items-center px-3 py-1 text-sm font-medium text-white bg-yellow-500 rounded hover:bg-yellow-400">
                                <ion-icon name="create-outline" class="mr-1"></ion-icon> Editar
                            </a>
                            <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de que deseas eliminar a este usuario?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-3 py-1 text-sm font-medium text-white bg-red-500 rounded hover:bg-red-400">
                                    <ion-icon name="trash-outline" class="mr-1"></ion-icon> Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@endif
