@extends('layouts.app')

@section('content')
<script src="{{ asset('assets/fullcalendar/dist/index.global.js') }}"></script>

<!-- Botón para agendar una nueva cita -->
@if(auth()->user()->rol === 'Doctor')                       
<a href="{{ route('citas.crear') }}" class="px-4 py-2 text-sm font-medium text-center text-black bg-[#FFE5EC] rounded-lg hover:bg-[#FFC2D1] focus:ring-4 focus:outline-none focus:ring-[#FFB3C6] transition duration-300">
    Agendar Cita
</a>
@endif

<div class="flex mt-6">
    <!-- Calendario -->
    <div id='calendar-wrap' class="flex-1 mr-4">
        <div id='calendar'></div>
    </div>

    <!-- Historial de citas -->
    <div class="flex-1 ml-4">
        <h2 class="text-xl font-semibold mb-4">Historial de Citas</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="px-4 py-2">Paciente</th>
                        <th class="px-4 py-2">Doctor</th>
                        <th class="px-4 py-2">Fecha</th>
                        <th class="px-4 py-2">Hora</th>
                        <th class="px-4 py-2">Estado</th>
                        <th class="px-4 py-2">Detalles</th>
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
    }

    #calendar-wrap {
      width: 100%;
      max-width: 1100px;
      margin: 0 auto;
    }

    #calendar {
      max-width: 1000px;
      margin: 0 auto;
    }
</style>

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
          alert('Evento: ' + info.event.title + '\n' +
                'Detalles: ' + info.event.extendedProps.detalles + '\n' +
                'Doctor: ' + info.event.extendedProps.doctor + '\n' +
                'Estado: ' + info.event.extendedProps.estado + '\n' +
                'Fecha: ' + info.event.start.toISOString());
        }
      });

      calendar.render();
    });
</script>
@endsection
