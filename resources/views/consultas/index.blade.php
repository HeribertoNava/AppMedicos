@extends('layouts.app')

@section('content')
<div class="container p-6 mx-auto">
    <h1 class="mb-6 text-3xl font-bold text-center text-blue-700">Lista de Consultas</h1>

    <table class="min-w-full bg-white rounded-lg shadow-md">
        <thead>
            <tr>
                <th class="px-6 py-3 text-left text-gray-600">ID</th>
                <th class="px-6 py-3 text-left text-gray-600">Paciente</th>
                <th class="px-6 py-3 text-left text-gray-600">Doctor</th>
                <th class="px-6 py-3 text-left text-gray-600">Fecha</th>
                <th class="px-6 py-3 text-left text-gray-600">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($consultas as $consulta)
            <tr>
                <td class="px-6 py-4 border-b">{{ $consulta->id }}</td>
                <td class="px-6 py-4 border-b">{{ $consulta->paciente->nombres }} {{ $consulta->paciente->apellidos }}</td>
                <td class="px-6 py-4 border-b">{{ $consulta->doctor->nombres }} {{ $consulta->doctor->apellidos }}</td>
                <td class="px-6 py-4 border-b">{{ $consulta->created_at->format('d/m/Y') }}</td>
                <td class="px-6 py-4 border-b">
                    <!-- Puedes añadir botones para ver más detalles o editar la consulta -->
                    <a href="{{ route('consultas.show', $consulta->id) }}" class="text-blue-600 hover:underline">Ver</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
