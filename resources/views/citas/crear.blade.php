@extends('layouts.app')

@section('content')
<!-- Contenedor principal -->
<div class="flex items-center justify-center min-h-screen p-6 bg-gray-100">
  <div class="container max-w-screen-lg mx-auto">
    <div>
      <!-- Tarjeta para el formulario -->
      <div class="p-4 px-4 mb-6 bg-white rounded shadow-lg md:p-8">
        <!-- Formulario para agendar cita -->
        <form action="{{ route('citas.store') }}" method="POST">
          @csrf
          <div class="grid grid-cols-1 gap-4 text-sm gap-y-2 lg:grid-cols-3">
            <!-- Sección de instrucciones -->
            <div class="text-gray-600">
              <p class="text-lg font-medium">Agendar Cita</p>
              <p>Ingrese todos los campos</p>
            </div>

            <div class="lg:col-span-2">
              <div class="grid grid-cols-1 gap-4 text-sm gap-y-2 md:grid-cols-5">
                <!-- Selección de Paciente -->
                <div class="md:col-span-5">
                  <label for="paciente_id">Paciente</label>
                  <select name="paciente_id" id="paciente_id" class="w-full h-10 px-4 mt-1 border rounded bg-gray-50">
                    @foreach($pacientes as $paciente)
                      <option value="{{ $paciente->id }}">{{ $paciente->nombres }} {{ $paciente->apellidos }}</option>
                    @endforeach
                  </select>
                </div>

                <!-- Selección de Doctor -->
                <div class="md:col-span-5">
                  <label for="doctor_id">Doctor</label>
                  <select name="doctor_id" id="doctor_id" class="w-full h-10 px-4 mt-1 border rounded bg-gray-50">
                    @foreach($doctores as $doctor)
                      <option value="{{ $doctor->id }}">{{ $doctor->nombres }} {{ $doctor->apellidos }}</option>
                    @endforeach
                  </select>
                </div>

                <!-- Selección de Fecha -->
                <div class="md:col-span-3">
                  <label for="fecha">Fecha</label>
                  <input type="date" name="fecha" id="fecha" class="w-full h-10 px-4 mt-1 border rounded bg-gray-50" required />
                </div>

                <!-- Selección de Hora -->
                <div class="md:col-span-2">
                  <label for="hora">Hora</label>
                  <input type="time" name="hora" id="hora" class="w-full h-10 px-4 mt-1 border rounded bg-gray-50" required />
                </div>

                <!-- Selección de Estado -->
                <div class="md:col-span-5">
                  <label for="estado">Estado</label>
                  <select name="estado" id="estado" class="w-full h-10 px-4 mt-1 border rounded bg-gray-50">
                    <option value="En proceso">En proceso</option>
                    <option value="Cancelada">Cancelada</option>
                    <option value="Completada">Completada</option>
                  </select>
                </div>

                <!-- Botón de enviar -->
                <div class="text-right md:col-span-5">
                  <div class="inline-flex items-end">
                    <button class="px-4 py-2 font-bold text-black rounded" style="background-color: #daffef; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#247b7b'"  onmouseout="this.style.backgroundColor='#daffef'">Agendar</button>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
