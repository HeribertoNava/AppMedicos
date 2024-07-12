@extends('layouts.app')

@section('content')
<div class="container p-4 mx-auto">
    <h1 class="mb-4 text-2xl font-bold">Consultas</h1>

    <a href="{{ route('consultas.create') }}" class="px-4 py-2 mb-4 text-white bg-blue-600 rounded-lg hover:bg-blue-700">Nueva Consulta</a>

    <div class="overflow-x-auto bg-white rounded-lg shadow-md">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                        Nombre del Paciente
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                        Correo
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                        Fecha de la Consulta
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($consultas as $consulta)
                <tr>
                    <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">{{ $consulta->nombre }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">{{ $consulta->correo }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">{{ $consulta->created_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                        <a href="{{ route('consultas.show', $consulta->id) }}" class="text-blue-600 hover:text-blue-900">Ver</a>
                        <a href="{{ route('consultas.edit', $consulta->id) }}" class="ml-4 text-green-600 hover:text-green-900">Editar</a>
                        <form action="{{ route('consultas.destroy', $consulta->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="ml-4 text-red-600 hover:text-red-900" onclick="return confirm('¿Estás seguro de que deseas eliminar esta consulta?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4">
            {{ $consultas->links() }}
        </div>
    </div>
</div>
@endsection
