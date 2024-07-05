@extends('layouts.app')

@section('content')
<script src="{{ asset('assets/fullcalendar/dist/index.global.js') }}"></script>

<!-- Botón para agendar una nueva cita -->
<a href="{{ route('citas.crear') }}" class="px-4 py-2 text-sm font-medium text-center text-black bg-[#FFE5EC] rounded-lg hover:bg-[#FFC2D1] focus:ring-4 focus:outline-none focus:ring-[#FFB3C6] transition duration-300">
    Agendar Cita
</a>

<div id='wrap'>
    <div id='external-events'>
      <h4>Draggable Events</h4>

      <div id='external-events-list'>
        <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event'>
          <div class='fc-event-main'>My Event 1</div>
        </div>
        <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event'>
          <div class='fc-event-main'>My Event 2</div>
        </div>
        <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event'>
          <div class='fc-event-main'>My Event 3</div>
        </div>
        <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event'>
          <div class='fc-event-main'>My Event 4</div>
        </div>
        <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event'>
          <div class='fc-event-main'>My Event 5</div>
        </div>
      </div>

      <p>
        <input type='checkbox' id='drop-remove' />
        <label for='drop-remove'>remove after drop</label>
      </p>
    </div>

    <div id='calendar-wrap'>
      <div id='calendar'></div>
    </div>
</div>

<style>
    body {
      margin-top: 40px;
      font-size: 14px;
      font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
    }

    #external-events {
      position: fixed;
      left: 20px;
      top: 20px;
      width: 150px;
      padding: 0 10px;
      border: 1px solid #ccc;
      background: #eee;
      text-align: left;
    }

    #external-events h4 {
      font-size: 16px;
      margin-top: 0;
      padding-top: 1em;
    }

    #external-events .fc-event {
      margin: 3px 0;
      cursor: move;
    }

    #external-events p {
      margin: 1.5em 0;
      font-size: 11px;
      color: #666;
    }

    #external-events p input {
      margin: 0;
      vertical-align: middle;
    }

    #calendar-wrap {
      margin-left: 200px;
    }

    #calendar {
      max-width: 1100px;
      margin: 0 auto;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
      // Inicializar eventos arrastrables
      var containerEl = document.getElementById('external-events-list');
      new FullCalendar.Draggable(containerEl, {
        itemSelector: '.fc-event',
        eventData: function(eventEl) {
          return {
            title: eventEl.innerText.trim()
          }
        }
      });

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
