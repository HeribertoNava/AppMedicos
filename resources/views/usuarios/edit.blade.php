@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="mb-6 text-3xl font-bold text-center text-pink-600">Editar Usuario</h1>

    @if($errors->any())
        <div class="p-4 mb-6 text-white bg-red-500 rounded-lg">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST" class="p-6 bg-white rounded-lg shadow-lg space-y-6">
        @csrf
        @method('PUT')

        <!-- Nombre -->
        <div>
            <label for="nombre" class="block text-gray-700">Nombre</label>
            <input type="text" name="nombre" class="w-full p-3 mt-1 border border-gray-300 rounded-lg focus:ring-pink-300 focus:border-pink-500" value="{{ old('nombre', $usuario->nombre) }}" required>
        </div>

        <!-- Apellido -->
        <div>
            <label for="apellido" class="block text-gray-700">Apellido</label>
            <input type="text" name="apellido" class="w-full p-3 mt-1 border border-gray-300 rounded-lg focus:ring-pink-300 focus:border-pink-500" value="{{ old('apellido', $usuario->apellido) }}" required>
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-gray-700">Email</label>
            <input type="email" name="email" class="w-full p-3 mt-1 border border-gray-300 rounded-lg focus:ring-pink-300 focus:border-pink-500" value="{{ old('email', $usuario->email) }}" required>
        </div>

        <!-- Contraseña -->
        <div>
            <label for="password" class="block text-gray-700">Contraseña</label>
            <input type="password" name="password" class="w-full p-3 mt-1 border border-gray-300 rounded-lg focus:ring-pink-300 focus:border-pink-500">
        </div>

        <!-- Confirmar Contraseña -->
        <div>
            <label for="password_confirmation" class="block text-gray-700">Confirmar Contraseña</label>
            <input type="password" name="password_confirmation" class="w-full p-3 mt-1 border border-gray-300 rounded-lg focus:ring-pink-300 focus:border-pink-500">
        </div>

        <!-- Teléfono -->
        <div>
            <label for="telefono" class="block text-gray-700">Teléfono</label>
            <input type="text" name="telefono" class="w-full p-3 mt-1 border border-gray-300 rounded-lg focus:ring-pink-300 focus:border-pink-500" value="{{ old('telefono', $usuario->telefono) }}">
        </div>

        <!-- Rol -->
        <div>
            <label for="rol" class="block text-gray-700">Rol</label>
            <select name="rol" class="w-full p-3 mt-1 border border-gray-300 rounded-lg focus:ring-pink-300 focus:border-pink-500" required>
                <option value="Doctor" {{ $usuario->rol == 'Doctor' ? 'selected' : '' }}>Doctor</option>
                <option value="Paciente" {{ $usuario->rol == 'Paciente' ? 'selected' : '' }}>Paciente</option>
                <option value="Secretaria" {{ $usuario->rol == 'Secretaria' ? 'selected' : '' }}>Secretaria</option>
                <option value="Enfermera" {{ $usuario->rol == 'Enfermera' ? 'selected' : '' }}>Enfermera</option>
            </select>
        </div>

        <!-- Botón de Actualizar -->
        <div class="text-center">
            <button type="submit" class="px-4 py-2 font-semibold text-white bg-pink-500 rounded-lg hover:bg-pink-600 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:ring-opacity-75">
                Actualizar
            </button>
        </div>
    </form>
</div>
@endsection
