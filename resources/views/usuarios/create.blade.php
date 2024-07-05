@extends('layouts.app')

@section('content')
<div class="container px-4 mx-auto" x-data="{ open: false }">
    <div class="flex justify-between mb-6">
        <input type="text" class="block w-1/2 mt-1 form-input" placeholder="Buscar usuario">
        <button @click="open = true" class="inline-flex items-center px-4 py-2 ml-4 text-xs font-semibold tracking-widest text-white uppercase transition bg-pink-600 border border-transparent rounded-md hover:bg-pink-500 focus:outline-none focus:border-pink-700 focus:ring focus:ring-pink-200 active:bg-pink-600 disabled:opacity-25">
            Agregar Usuario
        </button>
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

    <!-- Modal -->
    <div x-show="open" class="fixed inset-0 z-10 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <div class="overflow-hidden transition-all transform bg-white rounded-lg shadow-xl sm:max-w-lg sm:w-full">
                <div class="px-4 py-5 bg-gray-800 sm:px-6">
                    <h3 class="text-lg font-medium leading-6 text-white" id="modal-title">
                        Registrar Usuario
                    </h3>
                </div>
                <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <div class="mt-2">
                                @if($errors->any())
                                    <div class="alert alert-danger">
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
                                        <input type="text" name="nombre" class="w-full px-3 py-2 border rounded form-control bg-gray-50" value="{{ old('nombre') }}" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="apellido" class="block mb-2 text-sm font-bold text-gray-700">Apellido</label>
                                        <input type="text" name="apellido" class="w-full px-3 py-2 border rounded form-control bg-gray-50" value="{{ old('apellido') }}" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="email" class="block mb-2 text-sm font-bold text-gray-700">Email</label>
                                        <input type="email" name="email" class="w-full px-3 py-2 border rounded form-control bg-gray-50" value="{{ old('email') }}" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="password" class="block mb-2 text-sm font-bold text-gray-700">Contraseña</label>
                                        <input type="password" name="password" class="w-full px-3 py-2 border rounded form-control bg-gray-50" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="password_confirmation" class="block mb-2 text-sm font-bold text-gray-700">Confirmar Contraseña</label>
                                        <input type="password" name="password_confirmation" class="w-full px-3 py-2 border rounded form-control bg-gray-50" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="telefono" class="block mb-2 text-sm font-bold text-gray-700">Teléfono</label>
                                        <input type="text" name="telefono" class="w-full px-3 py-2 border rounded form-control bg-gray-50" value="{{ old('telefono') }}">
                                    </div>
                                    <div class="mb-4">
                                        <label for="rol" class="block mb-2 text-sm font-bold text-gray-700">Rol</label>
                                        <select name="rol" class="w-full px-3 py-2 border rounded form-control bg-gray-50" required>
                                            <option value="" disabled selected>Seleccionar rol</option>
                                            <option value="Doctor">Doctor</option>
                                            <option value="Paciente">Paciente</option>
                                            <option value="Secretaria">Secretaria</option>
                                            <option value="Enfermera">Enfermera</option>
                                        </select>
                                    </div>
                                    <div class="flex items-center justify-end">
                                        <button @click="open = false" type="button" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:w-auto sm:text-sm">Cancelar</button>
                                        <button type="submit" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-blue-500 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">Guardar</button>
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
