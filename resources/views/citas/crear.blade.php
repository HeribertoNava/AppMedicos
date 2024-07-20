@extends('layouts.app')

@section('content')
<!-- Contenedor principal -->
<div class="flex items-center justify-center min-h-screen p-6 bg-gray-100">
    <div class="container max-w-screen-lg mx-auto">
        <div class="p-4 px-4 mb-6 bg-white rounded shadow-lg md:p-8">
            <!-- Formulario para agendar cita -->
            <form action="{{ route('citas.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 gap-4 text-sm gap-y-2 lg:grid-cols-3">
                    <!-- Sección de instrucciones -->
                    <div class="text-gray-600">
                        <p class="text-lg font-medium">Agendar Cita</p>
                        <p>Ingrese todos los campos</p>
                    </div>

                    <div class="lg:col-span-2">
                        <div class="grid grid-cols-1 gap-4 text-sm gap-y-2 md:grid-cols-5">
                            <!-- Selección de Paciente -->
                            <div class="md:col-span-5">
                                <label for="paciente_id">Paciente</label>
                                <select name="paciente_id" id="paciente_id" class="w-full h-10 px-4 mt-1 border rounded bg-gray-50">
                                    @foreach($pacientes as $paciente)
                                        <option value="{{ $paciente->id }}">{{ $paciente->nombres }} {{ $paciente->apellidos }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Selección de Doctor -->
                            <div class="md:col-span-5">
                                <label for="doctor_id">Doctor</label>
                                <select name="doctor_id" id="doctor_id" class="w-full h-10 px-4 mt-1 border rounded bg-gray-50">
                                    @foreach($doctores as $doctor)
                                        <option value="{{ $doctor->id }}">{{ $doctor->nombres }} {{ $doctor->apellidos }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Selección de Fecha -->
                            <div class="md:col-span-3">
                                <label for="fecha">Fecha</label>
                                <input type="date" name="fecha" id="fecha" class="w-full h-10 px-4 mt-1 border rounded bg-gray-50" min="{{ date('Y-m-d') }}" required />
                            </div>

                            <!-- Selección de Rango de Horas -->
                            <div class="md:col-span-2">
                                <label for="rango_horas">Rango de Horas</label>
                                <select name="rango_horas" id="rango_horas" class="w-full h-10 px-4 mt-1 border rounded bg-gray-50" required>
                                    <option value="9:00-11:00">9:00 am - 11:00 am</option>
                                    <option value="12:00-15:00">12:00 pm - 3:00 pm</option>
                                </select>
                            </div>

                            <!-- Selección de Horas Disponibles -->
                            <div class="md:col-span-5">
                                <label for="hora">Hora</label>
                                <select name="hora" id="hora" class="w-full h-10 px-4 mt-1 border rounded bg-gray-50" required>
                                    <option value="9:00" selected>9:00</option> <!-- Valor predeterminado -->
                                </select>
                            </div>

                            <!-- Selección de Estado -->
                            <div class="md:col-span-5">
                                <label for="estado">Estado</label>
                                <select name="estado" id="estado" class="w-full h-10 px-4 mt-1 border rounded bg-gray-50">
                                    <option value="En proceso">En proceso</option>
                                    <option value="Cancelada">Cancelada</option>
                                    <option value="Completada">Completada</option>
                                </select>
                            </div>

                            <!-- Botón de enviar -->
                            <div class="text-right md:col-span-5">
                                <div class="inline-flex items-end">
                                    <button type="submit" class="px-4 py-2 font-bold text-black rounded" style="background-color: #daffef; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#247b7b'" onmouseout="this.style.backgroundColor='#daffef'">Agendar</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Obtener el select de rango de horas y el select de horas
        var rangoHorasSelect = document.getElementById('rango_horas');
        var horaSelect = document.getElementById('hora');
        var fechaInput = document.getElementById('fecha');

        // Función para llenar el select de horas según el rango seleccionado y las horas ocupadas
        function llenarHoras() {
            var rango = rangoHorasSelect.value;
            var horas = [];

            if (rango === '9:00-11:00') {
                horas = ['9:00', '9:30', '10:00', '10:30', '11:00'];
            } else if (rango === '12:00-15:00') {
                horas = ['12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00'];
            }

            // Obtener las horas ocupadas para la fecha seleccionada
            var fecha = fechaInput.value;
            if (fecha) {
                fetch(`/citas/horas-ocupadas?fecha=${fecha}`)
                    .then(response => response.json())
                    .then(horasOcupadas => {
                        // Filtrar las horas ocupadas
                        horas = horas.filter(hora => !horasOcupadas.includes(hora));

                        // Limpiar el select de horas
                        horaSelect.innerHTML = '';

                        // Llenar el select con las nuevas horas
                        horas.forEach(function(hora) {
                            var option = document.createElement('option');
                            option.value = hora;
                            option.textContent = hora;
                            horaSelect.appendChild(option);
                        });

                        // Establecer la primera opción como predeterminada si hay opciones disponibles
                        if (horas.length > 0) {
                            horaSelect.value = horas[0];
                        }
                    });
            } else {
                // Limpiar el select de horas si no hay fecha seleccionada
                horaSelect.innerHTML = '';
            }
        }

        // Llenar el select de horas al cambiar la fecha y cuando se cambie el rango
        fechaInput.addEventListener('change', llenarHoras);
        rangoHorasSelect.addEventListener('change', llenarHoras);
    });
</script>
@endsection
