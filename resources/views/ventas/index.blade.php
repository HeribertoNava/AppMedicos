@extends('layouts.app')

@section('content')
<div class="container p-6 mx-auto">
    <h1 class="mb-6 text-3xl font-bold text-center text-pink-600">Lista de Ventas</h1>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-lg shadow-lg">
            <thead class="bg-pink-100">
                <tr>
                    <th class="px-6 py-3 font-semibold text-left text-pink-600">ID Venta</th>
                    <th class="px-6 py-3 font-semibold text-left text-pink-600">Consulta ID</th>
                    <th class="px-6 py-3 font-semibold text-left text-pink-600">Total</th>
                    <th class="px-6 py-3 font-semibold text-left text-pink-600">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ventas as $venta)
                <tr class="hover:bg-pink-50">
                    <td class="px-6 py-4 border-b border-pink-200">{{ $venta->id }}</td>
                    <td class="px-6 py-4 border-b border-pink-200">{{ $venta->consulta_id }}</td>
                    <td class="px-6 py-4 border-b border-pink-200">{{ number_format($venta->total, 2) }} MXN</td>
                    <td class="px-6 py-4 border-b border-pink-200">
                        <a href="{{ route('ventas.show', $venta->id) }}" class="text-pink-600 hover:underline">Ver Detalles</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
