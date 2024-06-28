@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-lg p-10 bg-white rounded-lg shadow-lg">
        <h2 class="mb-8 text-3xl font-bold text-center text-gray-800">Registrar Doctor</h2>
        <form method="POST" action="{{ route('doctores.store') }}">
            @csrf
            <!-- Nombres -->
            <div class="mb-6">
                <label for="nombres" class="block mb-2 text-sm font-medium text-gray-800">Nombres <span class="text-red-600">*</span></label>
                <input type="text" id="nombres" name="nombres" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-pink-500 focus:border-pink-500 block w-full p-2.5" placeholder="Ingrese los nombres" required />
            </div>

            <!-- Apellidos -->
            <div class="mb-6">
                <label for="apellidos" class="block mb-2 text-sm font-medium text-gray-800">Apellidos <span class="text-red-600">*</span></label>
                <input type="text" id="apellidos" name="apellidos" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-pink-500 focus:border-pink-500 block w-full p-2.5" placeholder="Ingrese los apellidos" required />
            </div>

            <!-- Correo -->
            <div class="mb-6">
                <label for="correo" class="block mb-2 text-sm font-medium text-gray-800">Correo <span class="text-red-600">*</span></label>
                <input type="email" id="correo" name="correo" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-pink-500 focus:border-pink-500 block w-full p-2.5" placeholder="Ingrese el correo" required />
            </div>

            <!-- Contraseña -->
            <div class="mb-6">
                <label for="password" class="block mb-2 text-sm font-medium text-gray-800">Contraseña <span class="text-red-600">*</span></label>
                <input type="password" id="password" name="password" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-pink-500 focus:border-pink-500 block w-full p-2.5" placeholder="Ingrese la contraseña" required />
            </div>

            <!-- Confirmar Contraseña -->
            <div class="mb-6">
                <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-800">Confirmar Contraseña <span class="text-red-600">*</span></label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-pink-500 focus:border-pink-500 block w-full p-2.5" placeholder="Confirme la contraseña" required />
            </div>

            <!-- Teléfono -->
            <div class="mb-6">
                <label for="telefono" class="block mb-2 text-sm font-medium text-gray-800">Teléfono <span class="text-red-600">*</span></label>
                <input type="tel" id="telefono" name="telefono" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-pink-500 focus:border-pink-500 block w-full p-2.5" placeholder="Ingrese el teléfono" required />
            </div>

            <!-- Especialidad -->
            <div class="mb-6">
                <label for="especialidad" class="block mb-2 text-sm font-medium text-gray-800">Especialidad <span class="text-red-600">*</span></label>
                <input type="text" id="especialidad" name="especialidad" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-pink-500 focus:border-pink-500 block w-full p-2.5" placeholder="Ingrese la especialidad" required />
            </div>

            <!-- Consultorio -->
            <div class="mb-6">
                <label for="consultorio" class="block mb-2 text-sm font-medium text-gray-800">Consultorio <span class="text-red-600">*</span></label>
                <input type="text" id="consultorio" name="consultorio" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-pink-500 focus:border-pink-500 block w-full p-2.5" placeholder="Ingrese el consultorio" required />
            </div>

            <button type="submit" class="w-full text-white bg-pink-600 hover:bg-pink-700 focus:ring-4 focus:outline-none focus:ring-pink-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Registrar</button>
        </form>
    </div>
</div>
@endsection
