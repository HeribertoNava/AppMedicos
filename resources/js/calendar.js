import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        editable: true,
        events: citas.map(cita => ({
            title: cita.paciente.nombres + ' ' + cita.paciente.apellidos,
            start: cita.fecha + 'T' + cita.hora,
            extendedProps: {
                id: cita.id,
                detalles: cita.detalles
            }
        })),
        eventClick: function(info) {
            showModal(info.event.title, info.event.extendedProps.detalles, info.event.start);
        }
    });

    calendar.render();
});

function showModal(title, details, dateObject) {
    const modal = document.getElementById('myModal');
    const modalDateElement = document.getElementById('modalDate');
    const modalDetailsElement = document.getElementById('modalDetails');

    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
    const formattedDate = dateObject.toLocaleDateString(undefined, options);

    modalDateElement.innerText = formattedDate;
    modalDetailsElement.innerHTML = `<p><strong>Paciente:</strong> ${title}</p><p><strong>Detalles:</strong> ${details}</p>`;

    modal.classList.remove('hidden');
}

function hideModal() {
    const modal = document.getElementById('myModal');
    modal.classList.add('hidden');
}

document.getElementById('closeModal').addEventListener('click', hideModal);
