@extends('layouts.app')

@section('content')
<script src="{{ asset('assets/fullcalendar/dist/index.global.js') }}"></script>

<!-- Botones para agendar una nueva cita y ver la lista de citas -->
<div class="flex justify-between mb-4">
    @if(auth()->user()->rol === 'Doctor')
    <a href="{{ route('citas.crear') }}" class="px-4 py-2 text-sm font-medium text-center text-black bg-[#FFE5EC] rounded-lg hover:bg-[#FFC2D1] focus:ring-4 focus:outline-none focus:ring-[#FFB3C6] transition duration-300">
        Agregar Cita
    </a>
    @endif
    <a href="{{ route('citas.lista') }}" class="px-4 py-2 text-sm font-medium text-center text-black bg-[#FFE5EC] rounded-lg hover:bg-[#FFC2D1] focus:ring-4 focus:outline-none focus:ring-[#FFB3C6] transition duration-300">
        Ver lista de citas
    </a>
</div>

<button id="openModalButton" class="px-4 py-2 font-medium text-white bg-blue-500 rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
    Ver Citas del Día
</button>

<div class="flex mt-6">
    <!-- Calendario -->
    <div id='calendar-wrap' class="flex-1 p-4 mr-4 bg-white rounded-lg shadow-lg">
        <div id='calendar'></div>
    </div>

    <!-- Historial de citas -->
    <div class="flex-1 p-4 ml-4 bg-white rounded-lg shadow-lg">
        <h2 class="mb-4 text-xl font-semibold">Historial de Citas</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead class="text-white bg-gray-800">
                    <tr>
                        <th class="px-4 py-2">No</th>
                        <th class="px-4 py-2">Doctor</th>
                        <th class="px-4 py-2">Paciente</th>
                        <th class="px-4 py-2">Hora</th>
                        <th class="px-4 py-2">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($citas as $cita)
                        <tr class="bg-gray-100 border-b border-gray-200">
                            <td class="px-4 py-2">{{ $cita->paciente->nombres }} {{ $cita->paciente->apellidos }}</td>
                            <td class="px-4 py-2">{{ $cita->doctor->nombres }} {{ $cita->doctor->apellidos }}</td>
                            <td class="px-4 py-2">{{ $cita->fecha }}</td>
                            <td class="px-4 py-2">{{ $cita->hora }}</td>
                            <td class="px-4 py-2">{{ $cita->estado }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<style>
    body {
        margin-top: 40px;
        font-size: 14px;
        font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
        background-color: #f8f9fa;
    }

    #calendar-wrap {
        width: 100%;
        max-width: 1100px;
        margin: 0 auto;
        padding: 10px;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    #calendar {
        max-width: 1000px;
        margin: 0 auto;
    }

    .fc-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .fc-button {
        background-color: #FFE5EC;
        border: none;
        color: black;
        border-radius: 5px;
        padding: 5px 10px;
    }

    .fc-button:hover {
        background-color: #FFC2D1;
    }

    .fc-toolbar-title {
        font-size: 1.5rem;
        font-weight: bold;
    }

    .fc-view-harness {
        border: 1px solid #DDD;
        border-radius: 5px;
        padding: 10px;
    }

    .fc-daygrid-day-number {
        color: #FF6F61;
    }

    .fc-event {
        background-color: #FFB3C6;
        border: 1px solid #FF6F61;
    }

    .fc-event:hover {
        background-color: #FF6F61;
        color: white;
    }
    #modalCita {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Fondo semi-transparente */
    align-items: center;
    justify-content: center;
    z-index: 100; /* Asegura que esté por encima de otros elementos */
}

#modalCita .modal-content {
    background-color: #ffffff;
    padding: 20px;
    border-radius: 8px;
    max-width: 600px;
    width: 100%;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

#modalCita h3 {
    font-size: 24px;
    margin-bottom: 20px;
    text-align: center;
}

#modalCita table {
    width: 100%;
    border-collapse: collapse;
}

#modalCita th, #modalCita td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

#modalCita th {
    background-color: #f9f9f9;
}

#modalCita .close {
    position: absolute;
    top: 10px;
    right: 10px;
    cursor: pointer;
}

#modalCita button {
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #ff4b5c;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

#modalCita button:hover {
    background-color: #e43d50;
}
</style>
<!-- Modal -->
<div id="modalCita" class="fixed inset-0 items-center justify-center hidden overflow-y-auto bg-gray-800 bg-opacity-75">
    <div class="relative w-full max-w-3xl mx-auto bg-white border border-gray-300 rounded-lg shadow-xl">
        <div class="flex items-center justify-between p-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Citas del día <span id="modal-date"></span></h3>
            <button class="text-gray-500 hover:text-gray-700" onclick="closeModal()">
                <ion-icon name="close-circle-outline" >x</ion-icon>
            </button>
        </div>
        <div class="p-4">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr>
                        <th class="py-2 border-b">No</th>
                        <th class="py-2 border-b">Doctor</th>
                        <th class="py-2 border-b">Paciente</th>
                        <th class="py-2 border-b">Hora</th>
                        <th class="py-2 border-b">Estado</th>
                        <th class="py-2 border-b">Acciones</th>
                    </tr>
                </thead>
                <tbody id="modal-appointment-list-body">
                    @foreach ($citas as $cita)
                        <tr class="hover:bg-gray-100">
                            <td class="px-2 py-2 border-b">{{ $cita->id }}</td>
                            <td class="px-2 py-2 border-b">{{ $cita->doctor->nombres }} {{ $cita->doctor->apellidos }}</td>
                            <td class="px-2 py-2 border-b">{{ $cita->paciente->nombres }} {{ $cita->paciente->apellidos }}</td>
                            <td class="px-2 py-2 border-b">{{ $cita->hora }}</td>
                            <td class="px-2 py-2 border-b">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $cita->estado == 'En proceso' ? 'bg-yellow-100 text-yellow-800' : ($cita->estado == 'Completada' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($cita->estado) }}
                                </span>
                            </td>
                            <td class="px-2 py-2 border-b">
                                @if ($cita->estado == 'En proceso')
                                    <a href="{{ route('citas.cambiarEstado', ['id' => $cita->id, 'estado' => 'Completada']) }}" class="text-blue-600 hover:text-blue-800">Completar</a> |
                                    <a href="{{ route('citas.cambiarEstado', ['id' => $cita->id, 'estado' => 'Cancelada']) }}" class="text-red-600 hover:text-red-800">Cancelar</a> |
                                    <a href="{{ route('consultas.create', ['pacienteId' => $cita->paciente->id, 'fecha' => $cita->fecha, 'hora' => $cita->hora, 'doctorId' => $cita->doctor->id]) }}" class="btn btn-primary">Crear Consulta</a>

                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-4 text-right border-t border-gray-200">

        </div>
    </div>
</div>

<!-- Custom Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar el calendario
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
            },
            editable: true,
            droppable: true, // Permitir arrastrar eventos al calendario
            events: {!! json_encode($citas->map(function($cita) {
                return [
                    'title' => $cita->paciente->nombres . ' ' . $cita->paciente->apellidos,
                    'start' => $cita->fecha . 'T' . $cita->hora,
                    'extendedProps' => [
                        'id' => $cita->id,
                        'detalles' => $cita->detalles,
                        'doctor' => $cita->doctor->nombres . ' ' . $cita->doctor->apellidos,
                        'estado' => $cita->estado
                    ]
                ];
            })->toArray()) !!},
            eventClick: function(info) {
                var content = `<h3>${info.event.title}</h3><p>Detalles: ${info.event.extendedProps.detalles}</p><p>Doctor: ${info.event.extendedProps.doctor}</p><p>Estado: ${info.event.extendedProps.estado}</p><p>Fecha: ${info.event.start.toISOString().slice(0, 10)}</p>`;
                openModal(content);
            }
        });

        calendar.render();
    });

    // Abrir y cerrar el modal
    function openModal(content) {
        document.getElementById('modalContent').innerHTML = content;
        document.getElementById('modalCita').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('modalCita').classList.add('hidden');
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Obtener elementos del DOM
        var modal = document.getElementById('modalCita');
        var openModalButton = document.getElementById('openModalButton');
        var closeModalButtons = document.querySelectorAll('#modalCita #closeButton');

        // Función para abrir el modal
        openModalButton.addEventListener('click', function() {
            modal.classList.remove('hidden');
        });

        // Función para cerrar el modal
        closeModalButtons.forEach(button => {
            button.addEventListener('click', function() {
                modal.classList.add('hidden');
            });
        });
    });
</script>

@endsection
