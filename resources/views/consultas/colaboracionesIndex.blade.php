@extends('layouts.app')

@section('content')
<div class="container p-6 mx-auto">
    <h1 class="mb-6 text-3xl font-bold text-center text-pink-700">Mis Consultas Colaboradas</h1>

    @if ($colaboraciones->isEmpty())
        <p class="text-center">No tienes consultas asignadas.</p>
    @else
        <table class="min-w-full bg-white rounded-lg shadow-lg">
            <thead class="bg-pink-100">
                <tr>
                    <th class="px-6 py-3 font-semibold text-left text-pink-600">Consulta ID</th>
                    <th class="px-6 py-3 font-semibold text-left text-pink-600">Paciente</th>
                    <th class="px-6 py-3 font-semibold text-left text-pink-600">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($colaboraciones as $colaboracion)
                    <tr class="hover:bg-pink-50">
                        <td class="px-6 py-4 border-b border-pink-200">{{ $colaboracion->consulta_id }}</td>
                        <td class="px-6 py-4 border-b border-pink-200">{{ $colaboracion->consulta->paciente->nombres }} {{ $colaboracion->consulta->paciente->apellidos }}</td>
                        <td class="px-6 py-4 border-b border-pink-200">
                            <a href="{{ route('consultas.verColaboracion', $colaboracion->consulta_id) }}" class="text-pink-600 hover:underline">Ver Consulta</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
