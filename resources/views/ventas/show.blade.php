@extends('layouts.app')

@section('content')
<div class="container p-6 mx-auto">
    <h1 class="mb-6 text-3xl font-bold text-center text-pink-600">Detalles de la Venta</h1>

    <div class="p-6 mb-4 bg-white rounded-lg shadow-lg">
        <h2 class="text-xl font-semibold text-pink-600">Venta ID: {{ $venta->id }}</h2>
        <p><strong>Consulta ID:</strong> {{ $venta->consulta_id }}</p>
        <p><strong>Total:</strong> {{ number_format($venta->total, 2) }} MXN</p>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-lg shadow-lg">
            <thead class="bg-pink-100">
                <tr>
                    <th class="px-6 py-3 font-semibold text-left text-pink-600">Nombre</th>
                    <th class="px-6 py-3 font-semibold text-left text-pink-600">Cantidad</th>
                    <th class="px-6 py-3 font-semibold text-left text-pink-600">Precio</th>
                    <th class="px-6 py-3 font-semibold text-left text-pink-600">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($venta->items as $item)
                <tr class="hover:bg-pink-50">
                    <td class="px-6 py-4 border-b border-pink-200">{{ $item->nombre }}</td>
                    <td class="px-6 py-4 border-b border-pink-200">{{ $item->cantidad }}</td>
                    <td class="px-6 py-4 border-b border-pink-200">{{ number_format($item->precio, 2) }} MXN</td>
                    <td class="px-6 py-4 border-b border-pink-200">{{ number_format($item->subtotal, 2) }} MXN</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
