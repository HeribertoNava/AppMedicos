@extends('layouts.app')

@section('content')
<div class="container p-6 mx-auto">
    <h1 class="mb-6 text-3xl font-bold text-center text-pink-600">Lista de Consultas</h1>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-lg shadow-lg">
            <thead class="bg-pink-100">
                <tr>
                    <th class="px-6 py-3 font-semibold text-left text-pink-600">ID</th>
                    <th class="px-6 py-3 font-semibold text-left text-pink-600">Paciente</th>
                    <th class="px-6 py-3 font-semibold text-left text-pink-600">Doctor</th>
                    <th class="px-6 py-3 font-semibold text-left text-pink-600">Fecha</th>
                    <th class="px-6 py-3 font-semibold text-left text-pink-600">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($consultas as $consulta)
                <tr class="hover:bg-pink-50">
                    <td class="px-6 py-4 border-b border-pink-200">{{ $consulta->id }}</td>
                    <td class="px-6 py-4 border-b border-pink-200">{{ $consulta->paciente->nombres }} {{ $consulta->paciente->apellidos }}</td>
                    <td class="px-6 py-4 border-b border-pink-200">{{ $consulta->doctor->nombres }} {{ $consulta->doctor->apellidos }}</td>
                    <td class="px-6 py-4 border-b border-pink-200">{{ $consulta->created_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 border-b border-pink-200">
                        <a href="{{ route('consultas.show', $consulta->id) }}" class="text-pink-600 hover:underline">Ver</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
