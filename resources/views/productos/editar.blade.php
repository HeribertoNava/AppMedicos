@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <form class="max-w-lg mx-auto bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" method="POST" action="{{ route('productos.actualizar', $producto->id) }}">
        @csrf
        @method('PUT')
        <div class="mb-5">
            <label for="nombre" class="block mb-2 text-sm font-medium text-gray-900">Nombre del Productos</label>
            <input type="text" id="nombre" name="nombre" value="{{ $producto->nombre }}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required />
        </div>
        <div class="mb-5">
            <label for="descripcion" class="block mb-2 text-sm font-medium text-gray-900">Descripción</label>
            <input type="text" id="descripcion" name="descripcion" value="{{ $producto->descripcion }}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required />
        </div>
        <div class="mb-5">
            <label for="cantidad" class="block mb-2 text-sm font-medium text-gray-900">Cantidad</label>
            <input type="number" id="cantidad" name="cantidad" value="{{ $producto->cantidad }}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required />
        </div>
        <div class="mb-5">
            <label for="precio" class="block mb-2 text-sm font-medium text-gray-900">Precio</label>
            <input type="number" id="precio" name="precio" value="{{ $producto->precio }}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required />
        </div>
        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Actualizar Producto</button>
    </form>
</div>
@endsection
