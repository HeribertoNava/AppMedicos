@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8">
    <div class="p-6 bg-pink-50 rounded-lg shadow-lg">
        <!-- Header del Perfil -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-pink-700">Perfil del Paciente</h1>
            <div class="flex space-x-4">
                <div class="p-4 bg-pink-100 rounded-lg shadow">
                    <p class="text-pink-600">Citas</p>
                    <p class="text-2xl font-semibold">{{ $paciente->citas->count() }}</p>
                </div>
                <div class="p-4 bg-pink-100 rounded-lg shadow">
                    <p class="text-pink-600">Consultas</p>
                    <p class="text-2xl font-semibold">{{ $paciente->consultas->count() }}</p>
                </div>
            </div>
        </div>

        <!-- Información Personal del Paciente -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold text-pink-700 mb-4">Información Personal</h2>
                <p><strong>Teléfono:</strong> {{ $paciente->telefono }}</p>
                <p><strong>Correo:</strong> {{ $paciente->correo }}</p>
                <p><strong>Edad:</strong> {{ $paciente->edad }}</p>
                <p><strong>Género:</strong> {{ ucfirst($paciente->genero) }}</p>
            </div>
            <div class="col-span-2">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-semibold text-pink-700 mb-4">Resumen del Paciente</h2>
                    <div class="flex space-x-4">
                        <div class="w-1/2">
                            <h3 class="text-pink-600">Última Cita</h3>
                            <p>{{ $paciente->citas->last() ? $paciente->citas->last()->fecha . ' a las ' . $paciente->citas->last()->hora : 'No hay citas' }}</p>
                        </div>
                        <div class="w-1/2">
                            <h3 class="text-pink-600">Última Consulta</h3>
                            <p>{{ $paciente->consultas->last() ? $paciente->consultas->last()->created_at->format('Y-m-d') : 'No hay consultas' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="mt-8">
            <div class="flex border-b border-pink-300">
                <button class="px-4 py-2 text-pink-700 font-semibold focus:outline-none" onclick="showTab('citas')">Citas</button>
                <button class="ml-2 px-4 py-2 text-pink-700 font-semibold focus:outline-none" onclick="showTab('consultas')">Consultas</button>
            </div>
        </div>

        <!-- Contenido de Citas -->
        <div id="citas" class="mt-6">
            <h2 class="text-xl font-semibold text-pink-700">Lista de Citas</h2>
            <table class="w-full mt-4 bg-white border border-pink-200 rounded-lg">
                <thead>
                    <tr class="bg-pink-100">
                        <th class="px-4 py-2 text-left">Fecha</th>
                        <th class="px-4 py-2 text-left">Hora</th>
                        <th class="px-4 py-2 text-left">Doctor</th>
                        <th class="px-4 py-2 text-left">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paciente->citas as $cita)
                        <tr class="hover:bg-pink-50">
                            <td class="px-4 py-2 border">{{ $cita->fecha }}</td>
                            <td class="px-4 py-2 border">{{ $cita->hora }}</td>
                            <td class="px-4 py-2 border">{{ $cita->doctor->nombres }} {{ $cita->doctor->apellidos }}</td>
                            <td class="px-4 py-2 border">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{
                                    $cita->estado == 'En proceso' ? 'bg-yellow-100 text-yellow-800' :
                                    ($cita->estado == 'Completada' ? 'bg-green-100 text-green-800' :
                                    'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($cita->estado) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Contenido de Consultas -->
        <div id="consultas" class="mt-6 hidden">
            <h2 class="text-xl font-semibold text-pink-700">Lista de Consultas</h2>
            <table class="w-full mt-4 bg-white border border-pink-200 rounded-lg">
                <thead>
                    <tr class="bg-pink-100">
                        <th class="px-4 py-2 text-left">Fecha</th>
                        <th class="px-4 py-2 text-left">Doctor</th>
                        <th class="px-4 py-2 text-left">Motivo</th>
                        <th class="px-4 py-2 text-left">Diagnóstico</th>
                        <th class="px-4 py-2 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paciente->consultas as $consulta)
                        <tr class="hover:bg-pink-50">
                            <td class="px-4 py-2 border">{{ $consulta->created_at->format('Y-m-d') }}</td>
                            <td class="px-4 py-2 border">{{ $consulta->doctor->nombres }} {{ $consulta->doctor->apellidos }}</td>
                            <td class="px-4 py-2 border">{{ $consulta->motivo_consulta }}</td>
                            <td class="px-4 py-2 border">{{ $consulta->diagnostico }}</td>
                            <td class="px-4 py-2 border">
                                <a href="{{ route('consultas.show', $consulta->id) }}" class="text-pink-600 hover:text-pink-800">Ver</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function showTab(tabName) {
        document.getElementById('citas').classList.add('hidden');
        document.getElementById('consultas').classList.add('hidden');

        document.getElementById(tabName).classList.remove('hidden');
    }

    // Por defecto mostrar la pestaña de citas
    showTab('citas');
</script>
@endsection
