@extends('layouts.app')

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<div class="flex items-center justify-center min-h-screen bg-pink-50">
    <div class="container max-w-screen-lg mx-auto">
        <div class="p-8 bg-white rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold text-center text-pink-600">Agendar Nueva Cita</h2>

            <form action="{{ route('citas.store') }}" method="POST" class="mt-8">
                @csrf

                <!-- Mostrar errores de validación -->
                @if ($errors->any())
                    <div class="mb-4">
                        <ul class="text-red-600 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-1 gap-6 text-sm lg:grid-cols-2">
                    <!-- Selección de Paciente -->
                    <div>
                        <label for="paciente_id" class="block font-semibold text-pink-600">Paciente</label>
                        <select name="paciente_id" id="paciente_id" class="w-full h-10 px-4 mt-1 border rounded-lg bg-pink-50 focus:ring focus:ring-pink-200">
                            @foreach($pacientes as $paciente)
                                <option value="{{ $paciente->id }}" {{ old('paciente_id') == $paciente->id ? 'selected' : '' }}>{{ $paciente->nombres }} {{ $paciente->apellidos }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="paciente_id_hidden" id="paciente_id_hidden" value="{{ old('paciente_id_hidden') }}">
                        @error('paciente_id_hidden')
                            <p class="text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Selección de Doctor -->
                    <div>
                        <label for="doctor_id" class="block font-semibold text-pink-600">Doctor</label>
                        <select name="doctor_id" id="doctor_id" class="w-full h-10 px-4 mt-1 border rounded-lg bg-pink-50 focus:ring focus:ring-pink-200">
                            @foreach($doctores as $doctor)
                                <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>{{ $doctor->nombres }} {{ $doctor->apellidos }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="doctor_id_hidden" id="doctor_id_hidden" value="{{ old('doctor_id_hidden') }}">
                        @error('doctor_id_hidden')
                            <p class="text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Selección de Fecha -->
                    <div>
                        <label for="fecha" class="block font-semibold text-pink-600">Fecha</label>
                        <input type="date" name="fecha" id="fecha" class="w-full h-10 px-4 mt-1 border rounded-lg bg-pink-50 focus:ring focus:ring-pink-200" min="{{ date('Y-m-d') }}" value="{{ old('fecha') }}" required />
                        @error('fecha')
                            <p class="text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Selección de Rango de Horas -->
                    <div>
                        <label for="rango_horas" class="block font-semibold text-pink-600">Rango de Horas</label>
                        <select name="rango_horas" id="rango_horas" class="w-full h-10 px-4 mt-1 border rounded-lg bg-pink-50 focus:ring focus:ring-pink-200" required>
                            <option value="09:00-11:00" {{ old('rango_horas') == '09:00-11:00' ? 'selected' : '' }}>09:00 am - 11:00 am</option>
                            <option value="12:00-15:00" {{ old('rango_horas') == '12:00-15:00' ? 'selected' : '' }}>12:00 pm - 3:00 pm</option>
                            <option value="15:00-17:00" {{ old('rango_horas') == '15:00-17:00' ? 'selected' : '' }}>03:00 pm - 5:00 pm</option>
                        </select>
                    </div>

                    <!-- Selección de Horas Disponibles -->
                    <div class="lg:col-span-2">
                        <label for="hora" class="block font-semibold text-pink-600">Hora</label>
                        <div id="horas_disponibles" class="grid grid-cols-2 gap-2 mt-2">
                            <!-- Horas disponibles se insertarán aquí -->
                        </div>
                        @error('hora')
                            <p class="text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Campo oculto para la hora seleccionada -->
                    <input type="hidden" name="hora" id="hora_hidden">

                    <!-- Selección de Estado -->
                    <div>
                        <label for="estado" class="block font-semibold text-pink-600">Estado</label>
                        <select name="estado" id="estado" class="w-full h-10 px-4 mt-1 border rounded-lg bg-pink-50 focus:ring focus:ring-pink-200">
                            <option value="En proceso" {{ old('estado') == 'En proceso' ? 'selected' : '' }}>En proceso</option>
                        </select>
                    </div>

                    <!-- Botón de enviar -->
                    <div class="text-right lg:col-span-2">
                        <button type="submit" class="px-6 py-2 font-bold text-white bg-pink-600 rounded-lg hover:bg-pink-700">Agendar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var fechaInput = document.getElementById('fecha');
    var doctorInput = document.getElementById('doctor_id');
    var rangoHorasSelect = document.getElementById('rango_horas');
    var horasDisponiblesDiv = document.getElementById('horas_disponibles');
    var pacienteInput = document.getElementById('paciente_id');
    var doctorHiddenInput = document.getElementById('doctor_id_hidden');
    var pacienteHiddenInput = document.getElementById('paciente_id_hidden');
    var horaHiddenInput = document.getElementById('hora_hidden');

    function actualizarHorasDisponibles() {
        var fecha = fechaInput.value;
        var doctorId = doctorInput.value;
        var rangoHoras = rangoHorasSelect.value.split('-');
        var inicio = rangoHoras[0].trim();
        var fin = rangoHoras[1].trim();

        if (fecha && doctorId && inicio && fin) {
            fetch(`/citas/horas-ocupadas?fecha=${fecha}&doctor_id=${doctorId}&horaInicio=${inicio}&horaFin=${fin}`)
                .then(response => response.json())
                .then(horasOcupadas => {
                    const todasLasHoras = generarRangoHoras(inicio, fin, 30);
                    const horasDisponibles = todasLasHoras.filter(h => !horasOcupadas.includes(h));

                    horasDisponiblesDiv.innerHTML = '';
                    horasDisponibles.forEach(hora => {
                        var radio = document.createElement('input');
                        radio.type = 'radio';
                        radio.name = 'hora_radio';
                        radio.value = hora; // Asegurar el formato H:i:s
                        radio.id = `hora_${hora.replace(':', '')}`;

                        var label = document.createElement('label');
                        label.htmlFor = radio.id;
                        label.textContent = hora;

                        var div = document.createElement('div');
                        div.classList.add('flex', 'items-center', 'space-x-2');
                        div.appendChild(radio);
                        div.appendChild(label);

                        horasDisponiblesDiv.appendChild(div);

                        // Asignar evento para actualizar el campo oculto
                        radio.addEventListener('change', function() {
                            horaHiddenInput.value = this.value;
                        });
                    });
                })
                .catch(error => {
                    console.error('Error fetching available hours:', error);
                    horasDisponiblesDiv.innerHTML = '<p>Error al buscar horas disponibles. Intente de nuevo más tarde.</p>';
                });
        }
    }

    fechaInput.addEventListener('change', actualizarHorasDisponibles);
    doctorInput.addEventListener('change', actualizarHorasDisponibles);
    rangoHorasSelect.addEventListener('change', actualizarHorasDisponibles);

    // Capturar el valor seleccionado de paciente y doctor en campos ocultos
    pacienteInput.addEventListener('change', function() {
        pacienteHiddenInput.value = pacienteInput.value;
    });

    doctorInput.addEventListener('change', function() {
        doctorHiddenInput.value = doctorInput.value;
    });

    function generarRangoHoras(inicio, fin, intervalo) {
        const start = moment(inicio, 'HH:mm:ss');
        const end = moment(fin, 'HH:mm:ss');
        let times = [];

        while(start < end) {
            times.push(start.format('HH:mm:ss'));
            start.add(intervalo, 'minutes');
        }

        return times;
    }
});
</script>
@endsection
