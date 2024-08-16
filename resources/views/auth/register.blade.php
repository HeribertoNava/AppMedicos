<x-guest-layout>
    <div class="flex flex-col items-center justify-center min-h-screen py-2 bg-gray-100">
        <div class="w-full max-w-sm p-6 bg-white rounded-lg shadow-md">
            <!-- Imagen en la parte superior -->
            <div class="flex justify-center mb-4">
                <img src="images/logo.png" alt="Descripción de la imagen" class="object-cover w-32 h-32 rounded-full shadow-md">
            </div>
            <h2 class="text-3xl font-bold text-center">REGISTRO</h2>
            <form method="POST" action="{{ route('register') }}" class="mt-4">
                @csrf

                <!-- Nombre -->
                <div class="mt-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input id="name" class="block w-full px-3 py-2 mt-1 border rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-indigo-200" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Apellido -->
                <div class="mt-4">
                    <label for="apellido" class="block text-sm font-medium text-gray-700">Apellido</label>
                    <input id="apellido" class="block w-full px-3 py-2 mt-1 border rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-indigo-200" type="text" name="apellido" :value="old('apellido')" required autocomplete="apellido" />
                    <x-input-error :messages="$errors->get('apellido')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Correo</label>
                    <input id="email" class="block w-full px-3 py-2 mt-1 border rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-indigo-200" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Teléfono -->
                <div class="mt-4">
                    <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
                    <input id="telefono" class="block w-full px-3 py-2 mt-1 border rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-indigo-200" type="tel" name="telefono" :value="old('telefono')" required autocomplete="telefono" />
                    <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
                </div>

                <!-- Rol -->
                <div class="mt-4">
                    <label for="rol" class="block text-sm font-medium text-gray-700">Rol</label>
                    <select id="rol" name="rol" class="block w-full px-3 py-2 mt-1 border rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-indigo-200" required>
                        <option value="Doctor">Doctor</option>
                        <option value="Secretaria">Secretaria</option>
                        <option value="Paciente">Paciente</option>
                        <option value="medico_colaborador">Medico Colaborador</option>
                    </select>
                    <x-input-error :messages="$errors->get('rol')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                    <input id="password" class="block w-full px-3 py-2 mt-1 border rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-indigo-200" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Contraseña</label>
                    <input id="password_confirmation" class="block w-full px-3 py-2 mt-1 border rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-indigo-200" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-center mt-4">
                    <a class="text-sm text-blue-600 underline hover:text-blue-800" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>
                </div>

                <div class="flex items-center justify-center mt-4">
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300" style="background-color: #daffef; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#247b7b'" onmouseout="this.style.backgroundColor='#daffef'">
                        {{ __('Register') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
