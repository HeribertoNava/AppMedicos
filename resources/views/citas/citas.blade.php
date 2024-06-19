@extends('layouts.app')

@section('content')
<!-- Botón para agendar una nueva cita -->
<a href="{{ route('citas.crear') }}" class="text-black bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" style="background-color: #daffef; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#247b7b'" onmouseout="this.style.backgroundColor='#daffef'">
    Agendar Cita
</a>

<!-- Componente del calendario -->
<div class="bg-gray-100 flex items-center justify-center min-h-screen py-8">
    <div class="lg:w-10/12 md:w-11/12 sm:w-full mx-auto p-4">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <!-- Encabezado del calendario con controles para cambiar de mes -->
            <div class="flex items-center justify-between px-6 py-3 bg-gray-700 text-white">
                <button id="prevMonth" class="focus:outline-none">Anterior</button>
                <h2 id="currentMonth" class="text-xl font-bold"></h2>
                <button id="nextMonth" class="focus:outline-none">Siguiente</button>
            </div>
            <!-- Contenedor del calendario -->
            <div class="grid grid-cols-7 gap-1 p-4" id="calendar">
                <!-- Aquí se generarán los días del calendario -->
            </div>
        </div>
    </div>
</div>

<!-- Modal para mostrar detalles de la cita seleccionada -->
<div id="myModal" class="modal hidden fixed inset-0 flex items-center justify-center z-50">
    <div class="modal-overlay absolute inset-0 bg-black opacity-50"></div>
    <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
        <div class="modal-content py-4 text-left px-6">
            <div class="flex justify-between items-center pb-3">
                <p class="text-2xl font-bold">Día seleccionado</p>
                <button id="closeModal" class="modal-close px-3 py-1 rounded-full bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring">✕</button>
            </div>
            <div id="modalDate" class="text-xl font-semibold"></div>
            <div id="modalDetails" class="text-md mt-2"></div>
        </div>
    </div>
</div>

<script>
    // Convertir la variable PHP $citas a una variable JavaScript
    const citas = @json($citas);

    /**
     * Genera el calendario para un año y mes específicos
     * @param {number} year - El año para el calendario
     * @param {number} month - El mes para el calendario (0-11)
     */
    function generateCalendar(year, month) {
        const calendarElement = document.getElementById('calendar');
        const currentMonthElement = document.getElementById('currentMonth');
        
        // Crear un objeto de fecha para el primer día del mes especificado
        const firstDayOfMonth = new Date(year, month, 1);
        // Obtener el número de días en el mes especificado
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        
        // Limpiar el contenido del calendario
        calendarElement.innerHTML = '';

        // Array con los nombres de los meses
        const monthNames = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        // Mostrar el mes y año actuales en el encabezado
        currentMonthElement.innerText = `${monthNames[month]} ${year}`;
        
        // Obtener el día de la semana del primer día del mes (0-6, donde 0 es domingo y 6 es sábado)
        const firstDayOfWeek = firstDayOfMonth.getDay();

        // Array con los nombres de los días de la semana
        const daysOfWeek = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];
        // Crear encabezados para los días de la semana
        daysOfWeek.forEach(day => {
            const dayElement = document.createElement('div');
            dayElement.className = 'text-center font-semibold';
            dayElement.innerText = day;
            calendarElement.appendChild(dayElement);
        });

        // Crear espacios vacíos para los días anteriores al primer día del mes
        for (let i = 0; i < firstDayOfWeek; i++) {
            const emptyDayElement = document.createElement('div');
            calendarElement.appendChild(emptyDayElement);
        }

        // Crear elementos para cada día del mes
        for (let day = 1; day <= daysInMonth; day++) {
            const dayElement = document.createElement('div');
            dayElement.className = 'text-center py-2 border cursor-pointer';
            dayElement.innerText = day;

            // Obtener la fecha actual
            const currentDate = new Date();
            const currentDateString = `${currentDate.getFullYear()}-${currentDate.getMonth()}-${currentDate.getDate()}`;
            // Fecha del día a verificar en el calendario
            const dateToCheck = new Date(year, month, day);
            const dateToCheckString = `${dateToCheck.getFullYear()}-${dateToCheck.getMonth()}-${dateToCheck.getDate()}`;
            // Resaltar el día actual en el calendario
            if (currentDateString === dateToCheckString) {
                dayElement.classList.add('bg-blue-500', 'text-white');
            }

            // Agregar evento click para mostrar el modal con detalles de la cita
            dayElement.addEventListener('click', () => {
                const selectedDate = new Date(year, month, day);
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                const formattedDate = selectedDate.toLocaleDateString(undefined, options);
                showModal(formattedDate, selectedDate);
            });

            calendarElement.appendChild(dayElement);
        }
    }

    // Obtener la fecha actual
    const currentDate = new Date();
    let currentYear = currentDate.getFullYear();
    let currentMonth = currentDate.getMonth();
    // Generar el calendario para el mes y año actuales
    generateCalendar(currentYear, currentMonth);

    // Evento para cambiar al mes anterior
    document.getElementById('prevMonth').addEventListener('click', () => {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        generateCalendar(currentYear, currentMonth);
    });

    // Evento para cambiar al mes siguiente
    document.getElementById('nextMonth').addEventListener('click', () => {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        generateCalendar(currentYear, currentMonth);
    });

    /**
     * Muestra el modal con los detalles de las citas para una fecha seleccionada
     * @param {string} selectedDate - Fecha seleccionada en formato legible
     * @param {Date} dateObject - Objeto de fecha para la fecha seleccionada
     */
    function showModal(selectedDate, dateObject) {
        const modal = document.getElementById('myModal');
        const modalDateElement = document.getElementById('modalDate');
        const modalDetailsElement = document.getElementById('modalDetails');
        modalDateElement.innerText = selectedDate;

        // Filtrar las citas para la fecha seleccionada
        const citasForSelectedDate = citas.filter(cita => {
            const citaDate = new Date(cita.fecha);
            return citaDate.getFullYear() === dateObject.getFullYear() &&
                   citaDate.getMonth() === dateObject.getMonth() &&
                   citaDate.getDate() === dateObject.getDate();
        });

        // Generar contenido para los detalles de las citas
        let detailsContent = '';
        if (citasForSelectedDate.length > 0) {
            citasForSelectedDate.forEach(cita => {
                detailsContent += `<p><strong>Paciente:</strong> ${cita.paciente.nombres} ${cita.paciente.apellidos}</p>`;
                detailsContent += `<p><strong>Hora:</strong> ${cita.hora}</p>`;
                detailsContent += `<hr>`;
            });
        } else {
            detailsContent = '<p>No hay citas para esta fecha.</p>';
        }
        modalDetailsElement.innerHTML = detailsContent;

        // Mostrar el modal
        modal.classList.remove('hidden');
    }

    // Función para ocultar el modal
    function hideModal() {
        const modal = document.getElementById('myModal');
        modal.classList.add('hidden');
    }

    // Evento para cerrar el modal
    document.getElementById('closeModal').addEventListener('click', hideModal);
</script>
@endsection
