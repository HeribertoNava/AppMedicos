<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-pink-50">

    <nav class="fixed top-0 z-20 w-full bg-white shadow-lg">
        <div class="flex items-center justify-between max-w-screen-xl p-4 mx-auto">
            <a href="#" class="flex items-center space-x-3">
                <img src="{{ asset('images/logo.png') }}" class="h-10" alt="Health Plus Logo">
                <span class="text-2xl font-bold text-pink-600">Health</span>
            </a>
            <div class="flex space-x-3">
                <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-semibold text-white bg-pink-600 rounded-lg hover:bg-pink-700 focus:ring-4 focus:ring-pink-300">Log in</a>
            </div>
        </div>
    </nav>

    <header class="relative flex items-center justify-center h-screen bg-no-repeat bg-cover" style="background-image: url('{{ asset('images/doctora.jpg') }}');">
        <div class="absolute inset-0 bg-black opacity-40"></div> <!-- Sombra para mejorar la legibilidad del texto -->
        <div class="relative z-10 flex flex-col items-center text-center text-white">
            <h1 class="mb-6 text-5xl font-extrabold tracking-tight text-shadow-lg lg:text-6xl">Bienvenidos a Health</h1>
            <p class="mb-8 text-xl font-medium text-shadow-md lg:text-2xl">Cuidamos de tu salud con dedicación y experiencia.</p>


            <a href="{{ route('login') }}" class="px-6 py-3 font-semibold text-pink-600 bg-white rounded-full hover:bg-gray-100">Comienza Ahora</a>
        </div>

    </header>

</body>
</html>
