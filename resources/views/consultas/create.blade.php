@if (Auth::user()->hasRole('Doctor'))


@extends('layouts.app')

@section('content')
<div class="container p-4 mx-auto">
    <h1 class="mb-4 text-2xl font-bold">Crear Consulta</h1>

    <form action="{{ route('consultas.store') }}" method="POST">
        @csrf

        <!-- Información del Paciente -->
        <div class="p-4 mb-4 bg-white rounded-lg shadow-md">
            <h2 class="mb-2 text-xl font-semibold">Información del Paciente</h2>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label for="nombre" class="block text-gray-700">Nombre</label>
                    <input type="text" id="nombre" name="nombre" class="w-full border-gray-300 rounded-lg" value="{{ $paciente->nombres }}" readonly />
                </div>
                <div>
                    <label for="correo" class="block text-gray-700">Correo</label>
                    <input type="email" id="correo" name="correo" class="w-full border-gray-300 rounded-lg" value="{{ $paciente->correo }}" readonly />
                </div>
            </div>
        </div>

        <!-- Signos vitales -->
        <div class="p-4 mb-4 bg-white rounded-lg shadow-md">
            <h2 class="mb-2 text-xl font-semibold">Signos vitales</h2>
            <div class="grid grid-cols-2 gap-4 md:grid-cols-3">
                @foreach(['talla' => 'Talla', 'temperatura' => 'Temperatura', 'saturacion_oxigeno' => 'Saturación de oxígeno', 'frecuencia_cardiaca' => 'Frecuencia cardiaca', 'peso' => 'Peso', 'tension_arterial' => 'Tensión arterial'] as $field => $label)
                <div>
                    <label for="{{ $field }}" class="block text-gray-700">{{ $label }}</label>
                    <input type="text" id="{{ $field }}" name="{{ $field }}" class="w-full border-gray-300 rounded-lg" value="{{ old($field) }}" />
                    @error($field)
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                @endforeach
            </div>
        </div>

        <!-- Motivo de la consulta -->
        <div class="p-4 mb-4 bg-white rounded-lg shadow-md">
            <label for="motivo_consulta" class="block text-gray-700">Motivo de la consulta</label>
            <textarea id="motivo_consulta" name="motivo_consulta" class="w-full border-gray-300 rounded-lg">{{ old('motivo_consulta') }}</textarea>
            @error('motivo_consulta')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Notas de padecimiento -->
        <div class="p-4 mb-4 bg-white rounded-lg shadow-md">
            <label for="notas_padecimiento" class="block text-gray-700">Notas de padecimiento</label>
            <textarea id="notas_padecimiento" name="notas_padecimiento" class="w-full border-gray-300 rounded-lg">{{ old('notas_padecimiento') }}</textarea>
            @error('notas_padecimiento')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Interrogatorio por aparatos y sistemas -->
        <div class="p-4 mb-4 bg-white rounded-lg shadow-md">
            <label for="interrogatorio_aparatos_sistemas" class="block text-gray-700">Interrogatorio por aparatos y sistemas</label>
            <textarea id="interrogatorio_aparatos_sistemas" name="interrogatorio_aparatos_sistemas" class="w-full border-gray-300 rounded-lg">{{ old('interrogatorio_aparatos_sistemas') }}</textarea>
            @error('interrogatorio_aparatos_sistemas')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Examen físico -->
        <div class="p-4 mb-4 bg-white rounded-lg shadow-md">
            <label for="examen_fisico" class="block text-gray-700">Examen físico</label>
            <textarea id="examen_fisico" name="examen_fisico" class="w-full border-gray-300 rounded-lg">{{ old('examen_fisico') }}</textarea>
            @error('examen_fisico')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Diagnóstico -->
        <div class="p-4 mb-4 bg-white rounded-lg shadow-md">
            <label for="diagnostico" class="block text-gray-700">Diagnóstico</label>
            <textarea id="diagnostico" name="diagnostico" class="w-full border-gray-300 rounded-lg">{{ old('diagnostico') }}</textarea>
            @error('diagnostico')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Plan -->
        <div class="p-4 mb-4 bg-white rounded-lg shadow-md">
            <label for="plan" class="block text-gray-700">Plan</label>
            <textarea id="plan" name="plan" class="w-full border-gray-300 rounded-lg">{{ old('plan') }}</textarea>
            @error('plan')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Recetas -->
        <div class="p-4 mb-4 bg-white rounded-lg shadow-md">
            <h2 class="mb-2 text-xl font-semibold">Recetas</h2>
            <div class="recetas-container">
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-2 receta-template">
                    <div>
                        <label for="medicamento" class="block text-gray-700">Medicamento</label>
                        <input type="text" id="medicamento" name="medicamento[]" class="w-full border-gray-300 rounded-lg" />
                    </div>
                    <div>
                        <label for="dosis" class="block text-gray-700">Dosis</label>
                        <input type="text" id="dosis" name="dosis[]" class="w-full border-gray-300 rounded-lg" />
                    </div>
                    <div>
                        <label for="frecuencia" class="block text-gray-700">Frecuencia</label>
                        <input type="text" id="frecuencia" name="frecuencia[]" class="w-full border-gray-300 rounded-lg" />
                    </div>
                    <div>
                        <label for="duracion" class="block text-gray-700">Duración</label>
                        <input type="text" id="duracion" name="duracion[]" class="w-full border-gray-300 rounded-lg" />
                    </div>
                </div>
            </div>
            <button type="button" id="add-receta" class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-700">Añadir Receta</button>
        </div>

        <!-- Productos -->
        <div class="p-4 mb-4 bg-white rounded-lg shadow-md">
            <h2 class="mb-2 text-xl font-semibold">Productos</h2>
            @foreach($productos as $producto)
            <div class="flex items-center mb-2">
                <input type="checkbox" id="producto_{{ $producto->id }}" name="productos[]" value="{{ $producto->precio }}" class="mr-2 producto-checkbox">
                <label for="producto_{{ $producto->id }}" class="text-gray-700">{{ $producto->nombre }} ({{ $producto->precio }} pesos)</label>
            </div>
            @endforeach
        </div>

        <!-- Servicios -->
        <div class="p-4 mb-4 bg-white rounded-lg shadow-md">
            <h2 class="mb-2 text-xl font-semibold">Servicios</h2>
            @foreach($servicios as $servicio)
            <div class="flex items-center mb-2">
                <input type="checkbox" id="servicio_{{ $servicio->id }}" name="servicios[]" value="{{ $servicio->precio }}" class="mr-2 servicio-checkbox">
                <label for="servicio_{{ $servicio->id }}" class="text-gray-700">{{ $servicio->nombre }} ({{ $servicio->precio }} pesos)</label>
            </div>
            @endforeach
        </div>

        <!-- Total a Pagar -->
        <div class="p-4 mb-4 bg-white rounded-lg shadow-md">
            <label for="total_a_pagar" class="block text-gray-700">Total a Pagar</label>
            <input type="text" id="total_a_pagar" name="total_a_pagar" class="w-full border-gray-300 rounded-lg" value="0.00" readonly />
            @error('total_a_pagar')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700">Guardar</button>
        </div>
    </form>
</div>

<script>
    document.getElementById('add-receta').addEventListener('click', function() {
        const recetaTemplate = document.querySelector('.receta-template').cloneNode(true);
        recetaTemplate.classList.remove('receta-template', 'hidden');
        document.querySelector('.recetas-container').appendChild(recetaTemplate);
    });

    // Función para calcular el total a pagar
    function calculateTotal() {
        let total = 0;

        // Sumar precios de los productos seleccionados
        document.querySelectorAll('.producto-checkbox:checked').forEach(function(element) {
            total += parseFloat(element.value);
        });

        // Sumar precios de los servicios seleccionados
        document.querySelectorAll('.servicio-checkbox:checked').forEach(function(element) {
            total += parseFloat(element.value);
        });

        // Actualizar el campo total_a_pagar
        document.getElementById('total_a_pagar').value = total.toFixed(2);
    }

    // Añadir evento a los checkboxes de productos y servicios
    document.querySelectorAll('.producto-checkbox, .servicio-checkbox').forEach(function(element) {
        element.addEventListener('change', calculateTotal);
    });
</script>
@endsection
@endif