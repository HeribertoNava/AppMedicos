@extends('layouts.app')

@section('content')
<div class="container px-4 mx-auto">
    <div class="flex justify-between mb-6">
        <input type="text" class="block w-1/2 mt-1 form-input" placeholder="Buscar usuario">
        <a href="{{ route('usuarios.create') }}" class="inline-flex items-center px-4 py-2 ml-4 text-xs font-semibold tracking-widest text-white uppercase transition bg-pink-600 border border-transparent rounded-md hover:bg-pink-500 focus:outline-none focus:border-pink-700 focus:ring focus:ring-pink-200 active:bg-pink-600 disabled:opacity-25">Agregar Usuario</a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="text-white bg-gray-800">
                <tr>
                    <th class="w-1/6 px-4 py-2">NOMBRES</th>
                    <th class="w-1/6 px-4 py-2">APELLIDOS</th>
                    <th class="w-1/6 px-4 py-2">CORREO</th>
                    <th class="w-1/6 px-4 py-2">TELÉFONO</th>
                    <th class="w-1/6 px-4 py-2">ROL</th>
                    <th class="w-1/6 px-4 py-2">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usuarios as $usuario)
                    <tr class="bg-gray-100 border-b border-gray-200">
                        <td class="px-4 py-2">{{ $usuario->nombre }}</td>
                        <td class="px-4 py-2">{{ $usuario->apellido }}</td>
                        <td class="px-4 py-2">{{ $usuario->email }}</td>
                        <td class="px-4 py-2">{{ $usuario->telefono }}</td>
                        <td class="px-4 py-2">{{ $usuario->rol }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('usuarios.show', $usuario->id) }}" class="inline-flex items-center px-3 py-1 text-sm font-medium text-white bg-blue-500 rounded hover:bg-blue-400">Ver</a>
                            <a href="{{ route('usuarios.edit', $usuario->id) }}" class="inline-flex items-center px-3 py-1 text-sm font-medium text-white bg-yellow-500 rounded hover:bg-yellow-400">Editar</a>
                            <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-3 py-1 text-sm font-medium text-white bg-red-500 rounded hover:bg-red-400">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
