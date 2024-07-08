<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="flex flex-col items-center justify-center min-h-screen py-2 bg-gray-100">
        <div class="w-full max-w-sm p-6 bg-white rounded-lg shadow-md">
            <!-- Imagen en la parte superior -->
            <div class="flex justify-center mb-4">
                <img src="images/logo.png" alt="Descripción de la imagen" class="w-32 h-32 object-cover rounded-full shadow-md">
            </div>

            <h2 class="text-3xl font-bold text-center">LOGIN</h2>
            <form method="POST" action="{{ route('login') }}" class="mt-4">
                @csrf

                <!-- Email Address -->
                <div class="mt-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" class="block mt-1 w-full px-3 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-indigo-200" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" class="block mt-1 w-full px-3 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-indigo-200" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-center mt-4">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-blue-600 hover:text-blue-800" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>

                <div class="flex items-center justify-center mt-4">
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center" style="background-color: #daffef; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#247b7b'" onmouseout="this.style.backgroundColor='#daffef'">
                        {{ __('Log in') }}
                    </button>
                </div>

                <div class="flex items-center justify-center mt-4">
                    <p class="text-sm text-gray-600">¿No tienes cuenta? <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800">Regístrate ahora</a></p>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
