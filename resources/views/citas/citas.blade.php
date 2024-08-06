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
    <a href="{{ route('citas.index') }}" class="px-4 py-2 text-sm font-medium text-center text-black bg-[#FFE5EC] rounded-lg hover:bg-[#FFC2D1] focus:ring-4 focus:outline-none focus:ring-[#FFB3C6] transition duration-300">
        Ver lista de citas
    </a>
</div>

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
                            <td class="px-4 py-2">{{ $cita->detalles }}</td>
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
</style>

<div id="modalCita" class="fixed inset-0 hidden overflow-y-auto bg-gray-600 bg-opacity-50" onclick="if(event.target.id === 'modalCita') { closeModal(); }">
    <div class="relative p-5 mx-auto bg-white border rounded-md shadow-lg top-20 w-96">
        <div class="mt-3 text-center">
            <div id="modalContent" class="p-4 text-left">
                <!-- Contenido del modal será insertado aquí -->
            </div>
            <div class="items-center px-4 py-3">
                <button id="closeButton" class="w-full px-4 py-2 text-base font-medium text-white bg-red-500 rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500" onclick="closeModal()">
                    Cerrar
                </button>
                <button id="closeButton" class="w-full px-4 py-2 text-base font-medium text-white bg-red-500 rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500" onclick="closeModal()">
                    Completar
                </button>
                <button id="closeButton" class="w-full px-4 py-2 text-base font-medium text-white bg-red-500 rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500" onclick="closeModal()">
                    Cancelar
                </button>
                <button id="closeButton" class="w-full px-4 py-2 text-base font-medium text-white bg-red-500 rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500" onclick="closeModal()">
                    Editar
                </button>
            </div>
        </div>
    </div>
</div>

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

    function openModal(content) {
        document.getElementById('modalContent').innerHTML = content;
        document.getElementById('modalCita').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('modalCita').classList.add('hidden');
    }
</script>
@endsection
