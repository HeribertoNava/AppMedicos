@extends('layouts.app')

@section('content')
<div class="container p-4 mx-auto">
    <h1 class="mb-4 text-2xl font-bold">Lista de Consultas</h1>

    @if (session('success'))
        <div class="p-4 mb-4 text-green-800 bg-green-100 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Correo</th>
                <th class="px-4 py-2">Nombre</th>
                <th class="px-4 py-2">Motivo de Consulta</th>
                <th class="px-4 py-2">Total a Pagar</th>
                <th class="px-4 py-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($consultas as $consulta)
                <tr>
                    <td class="px-4 py-2">{{ $consulta->id }}</td>
                    <td class="px-4 py-2">{{ $consulta->correo }}</td>
                    <td class="px-4 py-2">{{ $consulta->nombre }}</td>
                    <td class="px-4 py-2">{{ $consulta->motivo_consulta }}</td>
                    <td class="px-4 py-2">{{ $consulta->total_a_pagar }}</td>
                    <td class="px-4 py-2">
                        <!-- Agrega aquí los botones de acciones si es necesario -->
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
