@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8">
    <!-- Botones para agregar cita y ver agenda de citas -->
    <div class="flex justify-between mb-4">
        <a href="{{ route('citas.crear') }}" class="px-4 py-2 text-sm font-medium text-white transition duration-300 bg-pink-500 rounded-lg hover:bg-pink-700">
            <ion-icon name="add-circle-outline"></ion-icon> Agregar Cita
        </a>
        <a href="{{ route('citas.index') }}" class="px-4 py-2 text-sm font-medium text-white transition duration-300 bg-pink-500 rounded-lg hover:bg-pink-700">
            <ion-icon name="list-outline"></ion-icon> Ver agenda de citas
        </a>
    </div>

    <!-- Tabs para filtrar las citas -->
    <ul class="flex border-b">
        <li class="mr-1">
            <a class="bg-white inline-block py-2 px-4 text-pink-600 font-semibold {{ $filtro == 'hoy' ? 'border-b-2 border-pink-600' : '' }}" href="{{ route('citas.lista', ['filtro' => 'hoy']) }}">Hoy</a>
        </li>
        <li class="mr-1">
            <a class="bg-white inline-block py-2 px-4 text-pink-600 font-semibold {{ $filtro == 'en_proceso' ? 'border-b-2 border-pink-600' : '' }}" href="{{ route('citas.lista', ['filtro' => 'en_proceso']) }}">En Proceso</a>
        </li>
        <li class="mr-1">
            <a class="bg-white inline-block py-2 px-4 text-pink-600 font-semibold {{ $filtro == 'completadas' ? 'border-b-2 border-pink-600' : '' }}" href="{{ route('citas.lista', ['filtro' => 'completadas']) }}">Completadas</a>
        </li>
        <li class="mr-1">
            <a class="bg-white inline-block py-2 px-4 text-pink-600 font-semibold {{ $filtro == 'canceladas' ? 'border-b-2 border-pink-600' : '' }}" href="{{ route('citas.lista', ['filtro' => 'canceladas']) }}">Canceladas</a>
        </li>
    </ul>

    <!-- Tabla de citas -->
    <div class="mt-6 overflow-x-auto">
        <table class="min-w-full bg-white border">
            <thead class="text-pink-700 bg-pink-100">
                <tr>
                    <th class="px-4 py-2 border-b-2 border-pink-300">No</th>
                    <th class="px-4 py-2 border-b-2 border-pink-300">Doctor</th>
                    <th class="px-4 py-2 border-b-2 border-pink-300">Paciente</th>
                    <th class="px-4 py-2 border-b-2 border-pink-300">Teléfono del Paciente</th>
                    <th class="px-4 py-2 border-b-2 border-pink-300">Correo del Paciente</th>
                    <th class="px-4 py-2 border-b-2 border-pink-300">Día</th>
                    <th class="px-4 py-2 border-b-2 border-pink-300">Hora</th>
                    @if ($filtro == 'en_proceso')
                        <th class="px-4 py-2 border-b-2 border-pink-300">Acción</th>
                    @else
                        <th class="px-4 py-2 border-b-2 border-pink-300">Estado</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($citas as $cita)
                <tr class="hover:bg-pink-50">
                    <td class="px-4 py-2 border-b">{{ $cita->id }}</td>
                    <td class="px-4 py-2 border-b">{{ $cita->doctor->nombres }}</td>
                    <td class="px-4 py-2 border-b">{{ $cita->paciente->nombres }}</td>
                    <td class="px-4 py-2 border-b">{{ $cita->paciente->telefono }}</td>
                    <td class="px-4 py-2 border-b">{{ $cita->paciente->correo }}</td>
                    <td class="px-4 py-2 border-b">{{ $cita->fecha }}</td>
                    <td class="px-4 py-2 border-b">{{ $cita->hora }}</td>
                    @if ($filtro == 'en_proceso')
                        <td class="px-4 py-2 border-b">
                            <a href="{{ route('citas.cambiarEstado', ['id' => $cita->id, 'estado' => 'completada']) }}" class="text-green-600 hover:text-green-800">Completar</a> |
                            <a href="{{ route('citas.cambiarEstado', ['id' => $cita->id, 'estado' => 'cancelada']) }}" class="text-red-600 hover:text-red-800">Cancelar</a> |
                            <a href="{{ route('consultas.create', ['pacienteId' => $cita->paciente->id, 'fecha' => $cita->fecha, 'hora' => $cita->hora, 'doctorId' => $cita->doctor->id]) }}" class="btn btn-primary">Crear Consulta</a>
                        </td>
                    @else
                        <td class="px-4 py-2 border-b">{{ ucfirst($cita->estado) }}</td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="mt-4">
        {{ $citas->links() }}
    </div>
</div>

<!-- Mensaje de éxito -->
@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: '{{ session('success') }}',
            confirmButtonText: 'Aceptar'
        });
    });
</script>
@endif

@endsection
