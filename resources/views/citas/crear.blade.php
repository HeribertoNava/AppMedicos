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
                                <div id="horas_disponibles" class="grid grid-cols-2 gap-2">
                                    <!-- Aquí se generarán dinámicamente las horas disponibles -->
                                </div>
                            </div>

                            <!-- Selección de Estado -->
                            <div class="md:col-span-5">
                                <label for="estado">Estado</label>
                                <select name="estado" id="estado" class="w-full h-10 px-4 mt-1 border rounded bg-gray-50">
                                    <option value="En proceso">En proceso</option>
                                </select
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
        var rangoHorasSelect = document.getElementById('rango_horas');
        var fechaInput = document.getElementById('fecha');
        var doctorInput = document.getElementById('doctor_id');
        var horasDisponiblesDiv = document.getElementById('horas_disponibles');

        // Función para generar dinámicamente las horas disponibles
        function generarHorasDisponibles() {
            var rango = rangoHorasSelect.value.split('-').map(h => h.trim());
            var inicio = rango[0];
            var fin = rango[1];
            var fecha = fechaInput.value;
            var doctorId = doctorInput.value;

            if (fecha && doctorId) {
                fetch(`/citas/horas-disponibles?fecha=${fecha}&doctor_id=${doctorId}&horaInicio=${inicio}&horaFin=${fin}`)
                .then(response => response.json())
                .then(horasDisponibles => {
                    horasDisponiblesDiv.innerHTML = '';
                    if (horasDisponibles.length > 0) {
                        horasDisponibles.forEach(function(hora) {
                            var checkbox = document.createElement('input');
                            checkbox.type = 'checkbox';
                            checkbox.name = 'hora';
                            checkbox.value = hora;
                            checkbox.id = `hora_${hora.replace(':', '')}`;

                            var label = document.createElement('label');
                            label.htmlFor = `hora_${hora.replace(':', '')}`;
                            label.textContent = hora;

                            var div = document.createElement('div');
                            div.appendChild(checkbox);
                            div.appendChild(label);

                            horasDisponiblesDiv.appendChild(div);
                        });
                    } else {
                        horasDisponiblesDiv.innerHTML = '<p>No hay horas disponibles para este rango y fecha.</p>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching available hours:', error);
                    horasDisponiblesDiv.innerHTML = '<p>Error al buscar horas disponibles. Intente de nuevo más tarde.</p>';
                });
            } else {
                horasDisponiblesDiv.innerHTML = '<p>Seleccione una fecha y un doctor para ver las horas disponibles.</p>';
            }
        }

        fechaInput.addEventListener('change', generarHorasDisponibles);
        rangoHorasSelect.addEventListener('change', generarHorasDisponibles);
        doctorInput.addEventListener('change', generarHorasDisponibles);
    });
</script>
@endsection
