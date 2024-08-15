@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/ver.css') }}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

@section('content')
<br>
<div class="container p-6 mx-auto">
    <div class="flex justify-between mb-4">
        <a href="{{ route('consultas.index') }}" class="px-4 py-2 text-white bg-blue-400 rounded-lg hover:bg-blue-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="inline-block w-5 h-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.707a1 1 0 00-1.414 0L9 11.586V6a1 1 0 10-2 0v5.586l-3.293-3.293a1 1 0 00-1.414 1.414l5 5a1 1 0 001.414 0l5-5a1 1 0 000-1.414z" clip-rule="evenodd" />
            </svg>
            Regresar a Consultas
        </a>
        <button id="download-pdf" class="px-4 py-2 text-white bg-pink-400 rounded-lg hover:bg-pink-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="inline-block w-5 h-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path d="M8.5 3a.5.5 0 01.5-.5h2a.5.5 0 010 1h-2a.5.5 0 01-.5-.5zM5 2a2 2 0 00-2 2v10a2 2 0 002 2h1v1.5a.5.5 0 001 0V16h6v1.5a.5.5 0 001 0V16h1a2 2 0 002-2V4a2 2 0 00-2-2H5zM4 4a1 1 0 011-1h10a1 1 0 011 1v10a1 1 0 01-1 1H5a1 1 0 01-1-1V4zm8 4.5a.5.5 0 00-1 0V11H9.5a.5.5 0 000 1H11v2.5a.5.5 0 001 0V12h1.5a.5.5 0 000-1H12V8.5z"/>
            </svg>
            Descargar PDF
        </button>
    </div>

    <div class="p-6 space-y-6 bg-white rounded-lg shadow-lg" id="content-to-print">
        <h1 class="mb-6 text-3xl font-bold text-center text-blue-700">Detalles de la Consulta</h1>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div>
                <h2 class="text-xl font-semibold text-gray-700">Doctor</h2>
                <p>{{ $consulta->doctor->nombres }} {{ $consulta->doctor->apellidos }}</p>
                <p><ion-icon name="call-outline"></ion-icon> {{ $consulta->doctor->telefono }}</p>
                <p><ion-icon name="mail-outline"></ion-icon> {{ $consulta->doctor->correo }}</p>
            </div>
            <div>
                <h2 class="text-xl font-semibold text-gray-700">Paciente</h2>
                <p>{{ $consulta->paciente->nombres }} {{ $consulta->paciente->apellidos }}</p>
                <p><ion-icon name="call-outline"></ion-icon> {{ $consulta->paciente->telefono }}</p>
                <p><ion-icon name="mail-outline"></ion-icon> {{ $consulta->paciente->correo }}</p>
            </div>
        </div>

        <div class="space-y-4">
            <h2 class="text-xl font-semibold text-gray-700">Consulta</h2>
            <p><strong>Fecha y Hora de la Consulta:</strong> {{ $consulta->created_at->format('Y-m-d H:i') }}</p>
            <!-- Mostrar Fecha y Hora de la Cita si está registrada -->
            <p><strong>Fecha y Hora de la Cita:</strong>
                {{ $consulta->cita ? $consulta->cita->fecha . ' ' . $consulta->cita->hora : 'No hay cita programada' }}
            </p>
        </div>

        <div class="space-y-4">
            <h2 class="text-xl font-semibold text-gray-700">Motivo de la Consulta</h2>
            <p class="p-3 border border-gray-300 rounded-lg bg-gray-50">{{ $consulta->motivo_consulta }}</p>
        </div>

        <div class="space-y-4">
            <h2 class="text-xl font-semibold text-gray-700">Notas de Padecimiento</h2>
            <p class="p-3 border border-gray-300 rounded-lg bg-gray-50">{{ $consulta->notas_padecimiento }}</p>
        </div>

        <div class="space-y-4">
            <h2 class="text-xl font-semibold text-gray-700">Signos Vitales</h2>
            @if($consulta->signosVitales)
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <p><strong>Talla:</strong> {{ $consulta->signosVitales->talla }} cm</p>
                </div>
                <div>
                    <p><strong>Temperatura:</strong> {{ $consulta->signosVitales->temperatura }} °C</p>
                </div>
                <div>
                    <p><strong>Frecuencia Cardíaca:</strong> {{ $consulta->signosVitales->frecuencia_cardiaca }} bpm</p>
                </div>
                <div>
                    <p><strong>Saturación de Oxígeno:</strong> {{ $consulta->signosVitales->saturacion_oxigeno }} %</p>
                </div>
            </div>
            @else
                <p>No hay signos vitales registrados.</p>
            @endif
        </div>

        <div class="space-y-4">
            <h2 class="text-xl font-semibold text-gray-700">Receta</h2>
            <table class="w-full text-left table-auto">
                <thead>
                    <tr>
                        <th class="px-4 py-2">No.</th>
                        <th class="px-4 py-2">Medicamento</th>
                        <th class="px-4 py-2">Cantidad</th>
                        <th class="px-4 py-2">Frecuencia</th>
                        <th class="px-4 py-2">Duración</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($consulta->recetas as $index => $receta)
                    <tr class="bg-gray-50">
                        <td class="px-4 py-2">{{ $index + 1 }}</td>
                        <td class="px-4 py-2">{{ $receta->medicamento }}</td>
                        <td class="px-4 py-2">{{ $receta->cantidad }}</td>
                        <td class="px-4 py-2">{{ $receta->frecuencia }}</td>
                        <td class="px-4 py-2">{{ $receta->duracion }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="space-y-4">
            <h2 class="text-xl font-semibold text-gray-700">Servicios</h2>
            <table class="w-full text-left table-auto">
                <thead>
                    <tr>
                        <th class="px-4 py-2">No.</th>
                        <th class="px-4 py-2">Nombre</th>
                        <th class="px-4 py-2">Cantidad</th>
                        <th class="px-4 py-2">Precio</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($consulta->servicios as $index => $servicio)
                    <tr class="bg-gray-50">
                        <td class="px-4 py-2">{{ $index + 1 }}</td>
                        <td class="px-4 py-2">{{ $servicio->nombre }}</td>
                        <td class="px-4 py-2">{{ $servicio->pivot->cantidad }}</td>
                        <td class="px-4 py-2">{{ $servicio->pivot->precio }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="space-y-4">
            <h2 class="text-xl font-semibold text-gray-700">Venta</h2>
            @if($consulta->venta)
            <table class="w-full text-left table-auto">
                <thead>
                    <tr>
                        <th class="px-4 py-2">Servicio/Producto</th>
                        <th class="px-4 py-2">Cantidad</th>
                        <th class="px-4 py-2">Precio</th>
                        <th class="px-4 py-2">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($consulta->venta->items as $item)
                    <tr class="bg-gray-50">
                        <td class="px-4 py-2">{{ $item->nombre }}</td>
                        <td class="px-4 py-2">{{ $item->cantidad }}</td>
                        <td class="px-4 py-2">{{ $item->precio }}</td>
                        <td class="px-4 py-2">{{ $item->subtotal }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="px-4 py-2"><strong>Total:</strong></td>
                        <td class="px-4 py-2"><strong>{{ $consulta->venta->total }}</strong></td>
                    </tr>
                </tfoot>
            </table>
            @else
            <p>No hay venta registrada para esta consulta.</p>
            @endif
        </div>
    </div>
</div>

<script>
    document.getElementById('download-pdf').addEventListener('click', function() {
        document.querySelectorAll('.right-links a').forEach(function(link) {
            link.style.display = 'none';
        });

        var element = document.getElementById('content-to-print');
        var opt = {
            margin:       0.3,
            filename:     'Consulta_Detalles.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 12 },
            jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
        };
        html2pdf().from(element).set(opt).save().then(function() {
            document.querySelectorAll('.right-links a').forEach(function(link) {
                link.style.display = 'inline';
            });
        });
    });
</script>

@endsection
