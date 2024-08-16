<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="flex flex-col items-center justify-center min-h-screen bg-center bg-cover" style="background-image: url('https://www.example.com/path-to-your-image.jpg');">
        <div class="w-full max-w-md p-10 bg-white rounded-lg shadow-xl bg-opacity-95">
            <!-- Imagen en la parte superior -->
            <div class="flex justify-center mb-6">
                <img src="images/logo.png" alt="Descripción de la imagen" class="object-cover rounded-full shadow-lg w-36 h-36">
            </div>

            <h2 class="text-4xl font-extrabold text-center text-pink-600">LOGIN</h2>
            <form method="POST" action="{{ route('login') }}" class="mt-8">
                @csrf

                <!-- Email Address -->
                <div class="mt-6">
                    <label for="email" class="block text-lg font-medium text-gray-700">Email</label>
                    <input id="email" class="block w-full px-5 py-3 mt-2 text-lg border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-pink-400" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
                </div>

                <!-- Password -->
                <div class="mt-6">
                    <label for="password" class="block text-lg font-medium text-gray-700">Password</label>
                    <input id="password" class="block w-full px-5 py-3 mt-2 text-lg border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-pink-400" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between mt-6">
                    @if (Route::has('password.request'))
                        <a class="text-sm font-medium text-pink-600 underline hover:text-pink-800" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>

                <div class="flex items-center justify-center mt-8">
                    <button type="submit" class="px-8 py-3 text-lg font-semibold text-white bg-pink-600 rounded-lg hover:bg-pink-700 focus:ring-4 focus:outline-none focus:ring-pink-300">
                        {{ __('Log in') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
