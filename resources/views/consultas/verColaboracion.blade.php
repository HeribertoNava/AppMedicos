@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/ver.css') }}">

@section('content')
<br>
<div class="container p-6 mx-auto">
    <div class="flex justify-between mb-4">
        <a href="{{ route('colaboraciones.index') }}" class="px-4 py-2 text-white bg-pink-400 rounded-lg hover:bg-pink-500">
            <ion-icon name="arrow-back-outline" class="w-5 h-5 mr-2"></ion-icon>
            Regresar a Mis Consultas
        </a>
        <button id="download-pdf" class="px-4 py-2 text-white bg-blue-400 rounded-lg hover:bg-blue-500">
            <ion-icon name="cloud-download-outline" class="w-5 h-5 mr-2"></ion-icon>
            Descargar PDF
        </button>
    </div>

    <div class="p-6 space-y-6 bg-white rounded-lg shadow-lg" id="content-to-print">
        <h1 class="mb-6 text-3xl font-bold text-center text-pink-700">Detalles de la Consulta</h1>

        <!-- Información del Doctor y Paciente -->
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div>
                <h2 class="text-xl font-semibold text-pink-600">Doctor</h2>
                <p>{{ $colaboracion->consulta->doctor->nombres }} {{ $colaboracion->consulta->doctor->apellidos }}</p>
                <p><ion-icon name="call-outline"></ion-icon> {{ $colaboracion->consulta->doctor->telefono }}</p>
                <p><ion-icon name="mail-outline"></ion-icon> {{ $colaboracion->consulta->doctor->correo }}</p>
            </div>
            <div>
                <h2 class="text-xl font-semibold text-pink-600">Paciente</h2>
                <p>{{ $colaboracion->consulta->paciente->nombres }} {{ $colaboracion->consulta->paciente->apellidos }}</p>
                <p><ion-icon name="call-outline"></ion-icon> {{ $colaboracion->consulta->paciente->telefono }}</p>
                <p><ion-icon name="mail-outline"></ion-icon> {{ $colaboracion->consulta->paciente->correo }}</p>
            </div>
        </div>

        <!-- Otros Detalles de la Consulta -->
        <div class="space-y-4">
            <h2 class="text-xl font-semibold text-pink-600">Consulta</h2>
            <p><strong>Fecha y Hora de la Consulta:</strong> {{ $colaboracion->consulta->created_at->format('Y-m-d H:i') }}</p>
            <p><strong>Fecha y Hora de la Cita:</strong>
                {{ $colaboracion->consulta->cita ? $colaboracion->consulta->cita->fecha . ' ' . $colaboracion->consulta->cita->hora : 'No hay cita programada' }}
            </p>
        </div>

        <div class="space-y-4">
            <h2 class="text-xl font-semibold text-pink-600">Motivo de la Consulta</h2>
            <p class="p-3 border border-gray-300 rounded-lg bg-pink-50">{{ $colaboracion->consulta->motivo_consulta }}</p>
        </div>

        <div class="space-y-4">
            <h2 class="text-xl font-semibold text-pink-600">Notas de Padecimiento</h2>
            <p class="p-3 border border-gray-300 rounded-lg bg-pink-50">{{ $colaboracion->consulta->notas_padecimiento }}</p>
        </div>

        <div class="space-y-4">
            <h2 class="text-xl font-semibold text-pink-600">Signos Vitales</h2>
            @if($colaboracion->consulta->signosVitales)
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <p><strong>Talla:</strong> {{ $colaboracion->consulta->signosVitales->talla }} cm</p>
                </div>
                <div>
                    <p><strong>Temperatura:</strong> {{ $colaboracion->consulta->signosVitales->temperatura }} °C</p>
                </div>
                <div>
                    <p><strong>Frecuencia Cardíaca:</strong> {{ $colaboracion->consulta->signosVitales->frecuencia_cardiaca }} bpm</p>
                </div>
                <div>
                    <p><strong>Saturación de Oxígeno:</strong> {{ $colaboracion->consulta->signosVitales->saturacion_oxigeno }} %</p>
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
                    @foreach($colaboracion->consulta->recetas as $index => $receta)
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
    </div>

    <!-- Formulario para Enviar Mensaje -->
    <div class="p-6 mt-6 bg-white rounded-lg shadow-lg">
        <h2 class="text-xl font-semibold text-pink-600">Añadir un Mensaje</h2>
        <form action="{{ route('consultas.enviarMensaje', $colaboracion->id) }}" method="POST">
            @csrf
            <div class="space-y-4">
                <label for="mensaje" class="block text-pink-600">Mensaje:</label>
                <textarea id="mensaje" name="mensaje" rows="4" class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-pink-200">{{ old('mensaje') }}</textarea>
                @error('mensaje')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div
            <div class="flex justify-end mt-4">
                <button type="submit" class="px-4 py-2 text-white bg-pink-600 rounded-lg hover:bg-pink-700">Enviar Mensaje</button>
            </div>
        </form>
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
