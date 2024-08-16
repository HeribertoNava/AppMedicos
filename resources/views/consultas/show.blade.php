@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/ver.css') }}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

@section('content')
<br>
<div class="container p-6 mx-auto">
    <div class="flex justify-between mb-4">
        <a href="{{ route('consultas.index') }}" class="px-4 py-2 text-white bg-pink-400 rounded-lg hover:bg-pink-500">
            <ion-icon name="arrow-back-outline" class="w-5 h-5 mr-2"></ion-icon>
            Regresar a Consultas
        </a>
        <div class="flex space-x-2">
            <a href="{{ route('consultas.compartir', $consulta->id) }}" class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-700">
                <ion-icon name="share-outline"></ion-icon> Compartir con Médico Colaborador
            </a>
            <button id="download-pdf" class="px-4 py-2 text-white bg-blue-400 rounded-lg hover:bg-blue-500">
                <ion-icon name="cloud-download-outline" class="w-5 h-5 mr-2"></ion-icon>
                Descargar PDF
            </button>
        </div>
    </div>

    <div class="p-6 space-y-6 bg-white rounded-lg shadow-lg" id="content-to-print">
        <h1 class="mb-6 text-3xl font-bold text-center text-pink-700">Detalles de la Consulta</h1>

        <!-- Información del Doctor y Paciente -->
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div>
                <h2 class="text-xl font-semibold text-pink-600">Doctor</h2>
                <p>{{ $consulta->doctor->nombres }} {{ $consulta->doctor->apellidos }}</p>
                <p><ion-icon name="call-outline"></ion-icon> {{ $consulta->doctor->telefono }}</p>
                <p><ion-icon name="mail-outline"></ion-icon> {{ $consulta->doctor->correo }}</p>
            </div>
            <div>
                <h2 class="text-xl font-semibold text-pink-600">Paciente</h2>
                <p>{{ $consulta->paciente->nombres }} {{ $consulta->paciente->apellidos }}</p>
                <p><ion-icon name="call-outline"></ion-icon> {{ $consulta->paciente->telefono }}</p>
                <p><ion-icon name="mail-outline"></ion-icon> {{ $consulta->paciente->correo }}</p>
            </div>
        </div>

        <!-- Otros Detalles de la Consulta -->
        <div class="space-y-4">
            <h2 class="text-xl font-semibold text-pink-600">Consulta</h2>
            <p><strong>Fecha y Hora de la Consulta:</strong> {{ $consulta->created_at->format('Y-m-d H:i') }}</p>
            <!-- Mostrar Fecha y Hora de la Cita si está registrada -->
            <p><strong>Fecha y Hora de la Cita:</strong>
                {{ $consulta->cita ? $consulta->cita->fecha . ' ' . $consulta->cita->hora : 'No hay cita programada' }}
            </p>
        </div>

        <div class="space-y-4">
            <h2 class="text-xl font-semibold text-pink-600">Motivo de la Consulta</h2>
            <p class="p-3 border border-gray-300 rounded-lg bg-pink-50">{{ $consulta->motivo_consulta }}</p>
        </div>

        <div class="space-y-4">
            <h2 class="text-xl font-semibold text-pink-600">Notas de Padecimiento</h2>
            <p class="p-3 border border-gray-300 rounded-lg bg-pink-50">{{ $consulta->notas_padecimiento }}</p>
        </div>

        <div class="space-y-4">
            <h2 class="text-xl font-semibold text-pink-600">Signos Vitales</h2>
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
            <h2 class="text-xl font-semibold text-pink-600">Receta</h2>
            <table class="w-full text-left table-auto">
                <thead class="text-pink-600 bg-pink-100">
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
                    <tr class="bg-pink-50">
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

        <!-- Servicios -->
        <div class="space-y-4">
            <h2 class="text-xl font-semibold text-pink-600">Servicios</h2>
            <table class="w-full text-left table-auto">
                <thead class="text-pink-600 bg-pink-100">
                    <tr>
                        <th class="px-4 py-2">No.</th>
                        <th class="px-4 py-2">Nombre</th>
                        <th class="px-4 py-2">Cantidad</th>
                        <th class="px-4 py-2">Precio</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($consulta->servicios as $index => $servicio)
                    <tr class="bg-pink-50">
                        <td class="px-4 py-2">{{ $index + 1 }}</td>
                        <td class="px-4 py-2">{{ $servicio->nombre }}</td>
                        <td class="px-4 py-2">{{ $servicio->pivot->cantidad }}</td>
                        <td class="px-4 py-2">{{ $servicio->pivot->precio }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Impuestos y Total -->
        <div class="space-y-4">
            <h2 class="text-xl font-semibold text-pink-600">Total a Pagar</h2>
            <div class="flex justify-end space-x-4">
                <div>
                    <p><strong>Subtotal:</strong></p>
                    <p><strong>IVA (16%):</strong></p>
                    <p><strong>Total:</strong></p>
                </div>
                <div class="text-right">
                    <p>{{ number_format($consulta->venta->total, 2) }} MXN</p>
                    <p>{{ number_format($consulta->venta->total * 0.16, 2) }} MXN</p>
                    <p><strong>{{ number_format($consulta->venta->total * 1.16, 2) }} MXN</strong></p>
                </div>
            </div>
        </div>

        <!-- Mensajes del Médico Colaborador -->
        <!-- Mensajes del Médico Colaborador -->
        <div class="space-y-4">
            <h2 class="text-xl font-semibold text-pink-600">Mensajes del Médico Colaborador</h2>
            @forelse($consulta->colaboraciones as $colaboracion)
                @if($colaboracion->mensaje)
                    <div class="p-4 bg-pink-100 border border-pink-200 rounded-lg">
                        <p><strong>{{ $colaboracion->medicoColaborador->name }} {{ $colaboracion->medicoColaborador->apellido }}:</strong> {{ $colaboracion->mensaje }}</p>
                        <p class="text-sm text-right text-gray-500">Enviado el {{ $colaboracion->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                @endif
            @empty
                <p>No hay mensajes del médico colaborador.</p>
            @endforelse
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

    document.getElementById('share-button').addEventListener('click', async () => {
        const shareData = {
            title: 'Detalles de la Consulta',
            text: 'Revisa los detalles de esta consulta médica',
            url: window.location.href
        }

        try {
            await navigator.share(shareData)
            console.log('Consulta compartida con éxito');
        } catch (err) {
            console.error('Error al intentar compartir:', err);
            alert('No se pudo compartir el enlace. Intenta copiarlo manualmente.');
        }
    });
</script>

@endsection
