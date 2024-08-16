@extends('layouts.app')

@section('content')
<div class="container p-6 mx-auto">
    <h1 class="mb-6 text-3xl font-bold text-center text-pink-700">Compartir Consulta</h1>

    <form action="{{ route('consultas.asignarColaboracion', $consulta->id) }}" method="POST" class="p-6 space-y-6 bg-white rounded-lg shadow-lg">
        @csrf
        <div class="space-y-4">
            <label for="medico_colaborador_id" class="block text-lg font-semibold text-pink-600">Seleccione un Médico Colaborador</label>
            <select id="medico_colaborador_id" name="medico_colaborador_id" class="w-full p-3 border border-pink-300 rounded-lg bg-pink-50 focus:ring focus:ring-pink-200">
                <option value="" disabled selected>Seleccione un médico</option>
                @foreach($medicosColaboradores as $medico)
                    <option value="{{ $medico->id }}">{{ $medico->name }} {{ $medico->apellido }}</option>
                @endforeach
            </select>
            @error('medico_colaborador_id')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end mt-4">
            <button type="submit" class="flex items-center px-6 py-2 text-white transition duration-300 bg-pink-600 rounded-lg hover:bg-pink-700">
                <ion-icon name="share-outline" class="mr-2"></ion-icon> Compartir Consulta
            </button>
        </div>
    </form>
</div>
@endsection
