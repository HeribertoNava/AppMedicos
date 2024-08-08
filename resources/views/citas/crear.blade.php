@extends('layouts.app')

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<div class="flex items-center justify-center min-h-screen p-6 bg-gray-100">
    <div class="container max-w-screen-lg mx-auto">
        <div class="p-4 px-4 mb-6 bg-white rounded shadow-lg md:p-8">
            <form action="{{ route('citas.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 gap-4 text-sm gap-y-2 lg:grid-cols-3">
                    <!-- Selección de Paciente -->
                    <div class="md:col-span-5">
                        <label for="paciente_id">Paciente</label>
                        <select name="paciente_id" id="paciente_id" class="w-full h-10 px-4 mt-1 border rounded bg-gray-50">
                            @foreach($pacientes as $paciente)
                                <option value="{{ $paciente->id }}">{{ $paciente->nombres }} {{ $paciente->apellidos }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="paciente_id_hidden" id="paciente_id_hidden">
                    </div>

                    <!-- Selección de Doctor -->
                    <div class="md:col-span-5">
                        <label for="doctor_id">Doctor</label>
                        <select name="doctor_id" id="doctor_id" class="w-full h-10 px-4 mt-1 border rounded bg-gray-50">
                            @foreach($doctores as $doctor)
                                <option value="{{ $doctor->id }}">{{ $doctor->nombres }} {{ $doctor->apellidos }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="doctor_id_hidden" id="doctor_id_hidden">
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
                            <option value="09:00-11:00">09:00 am - 11:00 am</option>
                            <option value="12:00-15:00">12:00 pm - 3:00 pm</option>
                            <option value="15:00-17:00">03:00 pm - 5:00 pm</option>
                        </select>
                    </div>

                    <!-- Selección de Horas Disponibles -->
                    <div class="md:col-span-5">
                        <label for="hora">Hora</label>
                        <div id="horas_disponibles" class="grid grid-cols-2 gap-2">
                            <!-- Horas disponibles se insertarán aquí -->
                        </div>
                    </div>

                    <!-- Selección de Estado -->
                    <div class="md:col-span-5">
                        <label for="estado">Estado</label>
                        <select name="estado" id="estado" class="w-full h-10 px-4 mt-1 border rounded bg-gray-50">
                            <option value="En curso">En curso</option>
                        </select>
                    </div>

                    <!-- Botón de enviar -->
                    <div class="text-right md:col-span-5">
                        <button type="submit" class="px-4 py-2 font-bold text-black rounded" style="background-color: #daffef; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#247b7b'" onmouseout="this.style.backgroundColor='#daffef'">Agendar</button>
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
                        radio.name = 'hora';
                        radio.value = hora + ':00'; // Añadir segundos
                        radio.id = `hora_${hora.replace(':', '')}`;

                        var label = document.createElement('label');
                        label.htmlFor = radio.id;
                        label.textContent = hora;

                        var div = document.createElement('div');
                        div.appendChild(radio);
                        div.appendChild(label);

                        horasDisponiblesDiv.appendChild(div);
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
