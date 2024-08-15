@if (Auth::user()->hasRole('Doctor'))
@extends('layouts.app')

@section('content')
<div class="container p-6 mx-auto">
    <h1 class="mb-6 text-3xl font-bold text-center text-blue-700">Crear Consulta</h1>

    <form id="consultaForm" action="{{ route('consultas.store') }}" method="POST" class="p-6 space-y-6 bg-white rounded-lg shadow-lg">
        @csrf

        <!-- Información del Paciente -->
        <div class="space-y-4">
            <h2 class="flex items-center text-xl font-semibold text-gray-700"><ion-icon name="person-outline" class="mr-2"></ion-icon> Información del Paciente</h2>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label for="nombre" class="block text-gray-600">Nombre del Paciente</label>
                    <input type="text" id="nombre" name="nombre" class="w-full p-3 border-gray-300 rounded-lg focus:ring focus:ring-blue-200" value="{{ $paciente->nombres }}" readonly />
                </div>
                <div>
                    <label for="correo" class="block text-gray-600">Correo</label>
                    <input type="email" id="correo" name="correo" class="w-full p-3 border-gray-300 rounded-lg focus:ring focus:ring-blue-200" value="{{ $paciente->correo }}" readonly />
                </div>
            </div>
            <input type="hidden" name="paciente_id" value="{{ $paciente->id }}">
        </div>

        <!-- Selección del Doctor -->
        <div class="space-y-4">
            <label for="doctor_id" class="block text-gray-600"><ion-icon name="medkit-outline" class="mr-2"></ion-icon> Doctor</label>
            <select id="doctor_id" name="doctor_id" class="w-full p-3 border-gray-300 rounded-lg focus:ring focus:ring-blue-200">
                <option value="">Seleccione un doctor</option>
                @foreach($doctores as $doctor)
                    <option value="{{ $doctor->id }}" {{ isset($doctorId) && $doctorId == $doctor->id ? 'selected' : '' }}>
                        {{ $doctor->nombres }} {{ $doctor->apellidos }}
                    </option>
                @endforeach
            </select>
            @error('doctor_id')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>


        <!-- Fecha y Hora (solo si es a partir de una cita) -->

        <div class="space-y-4">
            @if(isset($fecha) && isset($hora))
                <label for="fecha" class="block text-gray-600"><ion-icon name="calendar-outline" class="mr-2"></ion-icon> Fecha</label>
                <input type="text" id="fecha" name="fecha" class="w-full p-3 border-gray-300 rounded-lg focus:ring focus:ring-blue-200" value="{{ $fecha }}" readonly />

                <label for="hora" class="block text-gray-600"><ion-icon name="time-outline" class="mr-2"></ion-icon> Hora</label>
                <input type="text" id="hora" name="hora" class="w-full p-3 border-gray-300 rounded-lg focus:ring focus:ring-blue-200" value="{{ $hora }}" readonly />
            @endif
        </div>


        <!-- Signos vitales -->
        <div class="space-y-4">
            <h2 class="flex items-center text-xl font-semibold text-gray-700"><ion-icon name="heart-outline" class="mr-2"></ion-icon> Signos Vitales</h2>
            <div class="grid grid-cols-2 gap-4 md:grid-cols-3">
                @foreach(['talla' => 'Talla (cm)', 'temperatura' => 'Temperatura (°C)', 'saturacion_oxigeno' => 'Saturación de Oxígeno (%)', 'frecuencia_cardiaca' => 'Frecuencia Cardíaca (bpm)', 'peso' => 'Peso (kg)', 'tension_arterial' => 'Tensión Arterial (mmHg)'] as $field => $label)
                <div>
                    <label for="{{ $field }}" class="block text-gray-600">{{ $label }}</label>
                    <input type="text" id="{{ $field }}" name="{{ $field }}" class="w-full p-3 border-gray-300 rounded-lg focus:ring focus:ring-blue-200" value="{{ old($field) }}" />
                    @error($field)
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                @endforeach
            </div>
        </div>

        <!-- Motivo de la consulta -->
        <div class="space-y-4">
            <label for="motivo_consulta" class="block text-gray-600"><ion-icon name="help-outline" class="mr-2"></ion-icon> Motivo de la Consulta</label>
            <textarea id="motivo_consulta" name="motivo_consulta" class="w-full h-32 p-3 border-gray-300 rounded-lg focus:ring focus:ring-blue-200">{{ old('motivo_consulta') }}</textarea>
            @error('motivo_consulta')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Notas de padecimiento -->
        <div class="space-y-4">
            <label for="notas_padecimiento" class="block text-gray-600"><ion-icon name="book-outline" class="mr-2"></ion-icon> Notas de Padecimiento</label>
            <textarea id="notas_padecimiento" name="notas_padecimiento" class="w-full h-32 p-3 border-gray-300 rounded-lg focus:ring focus:ring-blue-200">{{ old('notas_padecimiento') }}</textarea>
            @error('notas_padecimiento')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Interrogatorio por aparatos y sistemas -->
        <div class="space-y-4">
            <label for="interrogatorio_aparatos_sistemas" class="block text-gray-600"><ion-icon name="clipboard-outline" class="mr-2"></ion-icon> Interrogatorio por Aparatos y Sistemas</label>
            <textarea id="interrogatorio_aparatos_sistemas" name="interrogatorio_aparatos_sistemas" class="w-full h-32 p-3 border-gray-300 rounded-lg focus:ring focus:ring-blue-200">{{ old('interrogatorio_aparatos_sistemas') }}</textarea>
            @error('interrogatorio_aparatos_sistemas')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Examen físico -->
        <div class="space-y-4">
            <label for="examen_fisico" class="block text-gray-600"><ion-icon name="body-outline" class="mr-2"></ion-icon> Examen Físico</label>
            <textarea id="examen_fisico" name="examen_fisico" class="w-full h-32 p-3 border-gray-300 rounded-lg focus:ring focus:ring-blue-200">{{ old('examen_fisico') }}</textarea>
            @error('examen_fisico')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Diagnóstico -->
        <div class="space-y-4">
            <label for="diagnostico" class="block text-gray-600"><ion-icon name="checkmark-outline" class="mr-2"></ion-icon> Diagnóstico</label>
            <textarea id="diagnostico" name="diagnostico" class="w-full h-32 p-3 border-gray-300 rounded-lg focus:ring focus:ring-blue-200">{{ old('diagnostico') }}</textarea>
            @error('diagnostico')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Plan -->
        <div class="space-y-4">
            <label for="plan" class="block text-gray-600"><ion-icon name="document-outline" class="mr-2"></ion-icon> Plan</label>
            <textarea id="plan" name="plan" class="w-full h-32 p-3 border-gray-300 rounded-lg focus:ring focus:ring-blue-200">{{ old('plan') }}</textarea>
            @error('plan')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Recetas -->
        <div class="space-y-4">
            <h2 class="flex items-center text-xl font-semibold text-gray-700"><ion-icon name="medkit-outline" class="mr-2"></ion-icon> Recetas</h2>
            <div class="space-y-4 recetas-container">
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 receta-template">
                    <div>
                        <label for="medicamento" class="block text-gray-600">Medicamento</label>
                        <input type="text" id="medicamento" name="medicamento[]" class="w-full p-3 border-gray-300 rounded-lg focus:ring focus:ring-blue-200" />
                    </div>
                    <div>
                        <label for="dosis" class="block text-gray-600">Dosis</label>
                        <input type="text" id="dosis" name="dosis[]" class="w-full p-3 border-gray-300 rounded-lg focus:ring focus:ring-blue-200" />
                    </div>
                    <div>
                        <label for="frecuencia" class="block text-gray-600">Frecuencia</label>
                        <input type="text" id="frecuencia" name="frecuencia[]" class="w-full p-3 border-gray-300 rounded-lg focus:ring focus:ring-blue-200" />
                    </div>
                    <div>
                        <label for="duracion" class="block text-gray-600">Duración</label>
                        <input type="text" id="duracion" name="duracion[]" class="w-full p-3 border-gray-300 rounded-lg focus:ring focus:ring-blue-200" />
                    </div>
                </div>
            </div>
            <button type="button" id="add-receta" class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-700"><ion-icon name="add-outline"></ion-icon> Añadir Receta</button>
        </div>

        <!-- Productos -->
        <div class="space-y-4">
            <h2 class="flex items-center text-xl font-semibold text-gray-700">
                <ion-icon name="cart-outline" class="mr-2"></ion-icon> Productos
            </h2>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                @foreach($productos as $producto)
                <div class="flex items-center">
                    <input
                        type="checkbox"
                        id="producto_{{ $producto->id }}"
                        name="productos[]"
                        value="{{ $producto->id }}"
                        class="mr-2 producto-checkbox"
                        data-precio="{{ $producto->precio }}">

                    <label for="producto_{{ $producto->id }}" class="text-gray-700">
                        {{ $producto->nombre }} ({{ $producto->precio }} pesos)
                    </label>

                    <input
                        type="number"
                        id="cantidad_producto_{{ $producto->id }}"
                        name="cantidad_producto[]"
                        value="1"
                        min="1"
                        class="w-20 p-2 ml-2 border-gray-300 rounded-lg input-field focus:ring focus:ring-blue-200 producto-cantidad"
                        data-precio="{{ $producto->precio }}">

                    <input
                        type="hidden"
                        name="precio_producto[]"
                        value="{{ $producto->precio }}"
                        id="precio_producto_{{ $producto->id }}">
                </div>
                @endforeach
            </div>
        </div>

        <!-- Servicios -->
        <div id="section-servicios-content" class="section-content">
            <h2 class="flex items-center text-xl font-semibold text-gray-700"><ion-icon name="settings-outline" class="mr-2"></ion-icon> Servicios</h2>
            <div id="servicios-fields-container" class="flex flex-wrap gap-4 align-middle">
                <div class="flex w-full gap-4 servicios-field-group">
                    <div class="flex-1">
                        <label for="servicio">Servicio</label>
                        <select id="servicio" name="servicio[]" class="w-full p-3 border-gray-300 rounded-lg input-field servicio-select focus:ring focus:ring-blue-200">
                            <option value="">Seleccione un servicio</option>
                            @foreach($servicios as $servicio)
                                <option value="{{ $servicio->id }}" data-precio="{{ $servicio->precio }}" data-cantidad="{{ $servicio->cantidad }}" {{ !is_null($servicio->cantidad) && $servicio->cantidad === 0 ? 'disabled' : '' }}>
                                    {{ $servicio->nombre }} {{ !is_null($servicio->cantidad) && $servicio->cantidad === 0 ? '(No disponible)' : '' }} ({{ $servicio->precio }} pesos)
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex-1">
                        <label for="cantidad_servicio">Cantidad</label>
                        <input type="number" id="cantidad_servicio" name="cantidad_servicio[]" value="1" class="w-full p-3 border-gray-300 rounded-lg input-field focus:ring focus:ring-blue-200"/>
                    </div>
                    <div class="flex-1">
                        <label for="precio">Precio</label>
                        <input type="number" id="precio" name="precio[]" class="w-full p-3 border-gray-300 rounded-lg input-field focus:ring focus:ring-blue-200" readonly/>
                    </div>
                    <div class="flex items-center flex-1">
                        <button type="button" id="addServicioButton" class="px-4 py-2 text-white bg-green-500 rounded-lg add hover:bg-green-700"><ion-icon name="add-outline"></ion-icon></button>
                    </div>
                </div>
            </div>
            <textarea id="notas_servicio" name="notas_servicio" class="w-full p-3 mt-4 border-gray-300 rounded-lg input-field focus:ring focus:ring-blue-200" placeholder="Agregar notas..."></textarea>
        </div>

        <!-- Total a Pagar -->
        <div class="space-y-4">
            <label for="total_a_pagar" class="flex items-center block text-gray-600"><ion-icon name="cash-outline" class="mr-2"></ion-icon> Total a Pagar</label>
            <input type="text" id="total_a_pagar" name="total_a_pagar" class="w-full p-3 border-gray-300 rounded-lg focus:ring focus:ring-blue-200" value="0.00" readonly />
            @error('total_a_pagar')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end">
            <button type="submit" class="flex items-center px-6 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700"><ion-icon name="save-outline" class="mr-2"></ion-icon> Guardar</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let recetaCount = 1; // Para contar el número de recetas

    // Añadir recetas dinámicamente
    document.getElementById('add-receta').addEventListener('click', function() {
        const recetaTemplate = document.querySelector('.receta-template').cloneNode(true);
        recetaTemplate.classList.remove('receta-template', 'hidden');

        // Añadir botón de eliminar solo para las recetas adicionales
        if (recetaCount > 0) {
            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.classList.add('px-4', 'py-2', 'text-white', 'bg-red-500', 'rounded-lg', 'hover:bg-red-700', 'remove-receta');
            removeButton.innerHTML = '<ion-icon name="trash-outline"></ion-icon> Eliminar';
            removeButton.addEventListener('click', function() {
                recetaTemplate.remove();
            });
            recetaTemplate.appendChild(removeButton);
        }

        recetaCount++;
        document.querySelector('.recetas-container').appendChild(recetaTemplate);
    });

    // Función para calcular el total a pagar
    function calculateTotal() {
        let total = 0;

        // Sumar precios de los productos seleccionados
        document.querySelectorAll('.producto-checkbox:checked').forEach(function(element) {
            const cantidad = element.closest('.flex').querySelector('.producto-cantidad').value;
            total += cantidad * parseFloat(element.getAttribute('data-precio') || 0);
        });

        // Sumar precios de los servicios seleccionados
        document.querySelectorAll('.servicio-select').forEach(function(selectElement) {
            const cantidad = selectElement.closest('.servicios-field-group').querySelector('input[name="cantidad_servicio[]"]').value;
            const precio = selectElement.options[selectElement.selectedIndex].getAttribute('data-precio');
            total += cantidad * parseFloat(precio || 0);
        });

        // Actualizar el campo total_a_pagar
        document.getElementById('total_a_pagar').value = total.toFixed(2);
    }

    // Añadir evento para actualizar el precio al seleccionar un servicio
    document.getElementById('servicio').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const precio = selectedOption.getAttribute('data-precio');
        document.getElementById('precio').value = precio;

        calculateTotal(); // Recalcular el total al seleccionar un servicio
    });

    // Añadir evento para recalcular el total al cambiar la cantidad de productos
    document.querySelectorAll('.producto-cantidad').forEach(function(element) {
        element.addEventListener('input', calculateTotal);
    });

    // Añadir la funcionalidad del modal de éxito
    document.getElementById('consultaForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const pacienteId = "{{ $paciente->id }}"; // Obtén el ID del paciente

        Swal.fire({
            title: 'Consulta Creada',
            text: 'La consulta ha sido guardada exitosamente.',
            icon: 'success',
            confirmButtonText: 'Aceptar'
        }).then(() => {
            document.getElementById('consultaForm').submit(); // Enviar el formulario
        });
    });

    // Añadir funcionalidad para duplicar campos de servicio y calcular el total
    document.getElementById('addServicioButton').addEventListener('click', function() {
        const container = document.getElementById('servicios-fields-container');
        const newFieldGroup = document.querySelector('.servicios-field-group').cloneNode(true);
        newFieldGroup.querySelector('select').selectedIndex = 0;
        newFieldGroup.querySelector('input[name="cantidad_servicio[]"]').value = 1;
        newFieldGroup.querySelector('input[name="precio[]"]').value = '';
        container.appendChild(newFieldGroup);

        // Reapply event listener to the new select element
        newFieldGroup.querySelector('select').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const precio = selectedOption.getAttribute('data-precio');
            newFieldGroup.querySelector('input[name="precio[]"]').value = precio;

            calculateTotal(); // Recalcular el total al agregar un nuevo servicio
        });

        // Añadir evento para recalcular el total al cambiar la cantidad de servicios
        newFieldGroup.querySelector('input[name="cantidad_servicio[]"]').addEventListener('input', calculateTotal);

        calculateTotal(); // Recalcular el total al agregar un nuevo servicio
    });

    // Reaplicar el cálculo al cargar la página
    calculateTotal();
</script>
@endsection

@endif
