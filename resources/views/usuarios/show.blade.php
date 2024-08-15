@extends('layouts.app')

@section('content')
<div class="container p-6 mx-auto">
    <div class="max-w-lg p-6 mx-auto bg-white rounded-lg shadow-lg">
        <h1 class="mb-6 text-3xl font-bold text-center text-pink-600">Detalles del Usuario</h1>

        <div class="p-4 mb-6 bg-pink-100 rounded-lg">
            <h2 class="mb-2 text-xl font-semibold text-gray-800">{{ $usuario->nombre }} {{ $usuario->apellido }}</h2>
            <p class="text-gray-700"><strong>Email: </strong>{{ $usuario->email }}</p>
            <p class="text-gray-700"><strong>Teléfono: </strong>{{ $usuario->telefono }}</p>
            <p class="text-gray-700"><strong>Rol: </strong>{{ $usuario->rol }}</p>
        </div>

        <div class="flex justify-between">
            <a href="{{ route('usuarios.edit', $usuario->id) }}" class="px-4 py-2 font-semibold text-white bg-yellow-500 rounded-lg hover:bg-yellow-600">
                Editar
            </a>

            <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar a este usuario?');" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 font-semibold text-white bg-red-500 rounded-lg hover:bg-red-600">
                    Eliminar
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
