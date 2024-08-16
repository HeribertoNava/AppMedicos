@extends('layouts.app')

@section('content')
<div class="container p-6 mx-auto" x-data="{ open: false }">
    <div class="flex items-center justify-between mb-6">
        <input type="text" class="block w-1/2 p-3 border border-pink-200 rounded-lg focus:ring-pink-100 focus:border-pink-300" placeholder="Buscar usuario">
        <button @click="open = true" class="inline-flex items-center px-4 py-2 ml-4 text-xs font-semibold text-white uppercase bg-pink-300 rounded-lg hover:bg-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-100">
            <ion-icon name="add-circle-outline" class="mr-2"></ion-icon> Agregar Usuario
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-pink-200 rounded-lg">
            <thead class="text-white bg-pink-300">
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
                    <tr class="border-b border-pink-100 bg-pink-50 hover:bg-pink-100">
                        <td class="px-4 py-2">{{ $usuario->nombre }}</td>
                        <td class="px-4 py-2">{{ $usuario->apellido }}</td>
                        <td class="px-4 py-2">{{ $usuario->email }}</td>
                        <td class="px-4 py-2">{{ $usuario->telefono }}</td>
                        <td class="px-4 py-2">{{ $usuario->rol }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('usuarios.show', $usuario->id) }}" class="inline-flex items-center px-3 py-1 text-sm font-medium text-white bg-blue-200 rounded-lg hover:bg-blue-300">
                                <ion-icon name="eye-outline" class="mr-1"></ion-icon> Ver
                            </a>
                            <a href="{{ route('usuarios.edit', $usuario->id) }}" class="inline-flex items-center px-3 py-1 text-sm font-medium text-white bg-yellow-200 rounded-lg hover:bg-yellow-300">
                                <ion-icon name="create-outline" class="mr-1"></ion-icon> Editar
                            </a>
                            <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de que deseas eliminar a este usuario?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-3 py-1 text-sm font-medium text-white bg-red-200 rounded-lg hover:bg-red-300">
                                    <ion-icon name="trash-outline" class="mr-1"></ion-icon> Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div x-show="open" class="fixed inset-0 z-10 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-50"></div>
            </div>
            <div class="overflow-hidden transition-all transform bg-white rounded-lg shadow-xl sm:max-w-lg sm:w-full">
                <div class="px-4 py-5 bg-pink-300 sm:px-6">
                    <h3 class="text-lg font-medium leading-6 text-white" id="modal-title">
                        Registrar Usuario
                    </h3>
                </div>
                <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <div class="mt-2">
                                @if($errors->any())
                                    <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg">
                                        <ul>
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form action="{{ route('usuarios.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="nombre" class="block mb-2 text-sm font-bold text-gray-700">Nombre</label>
                                        <input type="text" name="nombre" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-pink-50 focus:ring-pink-100 focus:border-pink-300" value="{{ old('nombre') }}" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="apellido" class="block mb-2 text-sm font-bold text-gray-700">Apellido</label>
                                        <input type="text" name="apellido" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-pink-50 focus:ring-pink-100 focus:border-pink-300" value="{{ old('apellido') }}" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="email" class="block mb-2 text-sm font-bold text-gray-700">Email</label>
                                        <input type="email" name="email" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-pink-50 focus:ring-pink-100 focus:border-pink-300" value="{{ old('email') }}" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="password" class="block mb-2 text-sm font-bold text-gray-700">Contraseña</label>
                                        <input type="password" name="password" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-pink-50 focus:ring-pink-100 focus:border-pink-300" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="password_confirmation" class="block mb-2 text-sm font-bold text-gray-700">Confirmar Contraseña</label>
                                        <input type="password" name="password_confirmation" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-pink-50 focus:ring-pink-100 focus:border-pink-300" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="telefono" class="block mb-2 text-sm font-bold text-gray-700">Teléfono</label>
                                        <input type="text" name="telefono" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-pink-50 focus:ring-pink-100 focus:border-pink-300" value="{{ old('telefono') }}">
                                    </div>
                                    <div class="mb-4">
                                        <label for="rol" class="block mb-2 text-sm font-bold text-gray-700">Rol</label>
                                        <select name="rol" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-pink-50 focus:ring-pink-100 focus:border-pink-300" required>
                                            <option value="" disabled selected>Seleccionar rol</option>
                                            <option value="Doctor">Doctor</option>
                                            <option value="Paciente">Paciente</option>
                                            <option value="Secretaria">Secretaria</option>
                                            <option value="Enfermera">Enfermera</option>
                                            <option value="Medico_Colaborador">Medico Colaborador</option>
                                        </select>
                                    </div>
                                    <div class="flex items-center justify-end">
                                        <button @click="open = false" type="button" class="inline-flex justify-center px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-100 sm:ml-3 sm:w-auto sm:text-sm">Cancelar</button>
                                        <button type="submit" class="inline-flex justify-center px-4 py-2 text-white bg-blue-300 border border-transparent rounded-md shadow-sm hover:bg-blue-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-200 sm:ml-3 sm:w-auto sm:text-sm">Guardar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
