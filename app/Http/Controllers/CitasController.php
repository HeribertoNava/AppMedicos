<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Citas;
use App\Models\Doctores;
use App\Models\Pacientes;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CitasController extends Controller
{
    public function index(): View
    {
        $citas = Citas::with(['paciente', 'doctor'])->get();

        $user = Auth::user();

        // Filtrar las citas según el rol del usuario
        if ($user->rol === 'Paciente') {
            // Si el usuario es un paciente, solo ver sus propias citas
            $citas = Citas::where('paciente_id', $user->id)->get();
        } else {
            // Si el usuario es un doctor, ver todas las citas
            $citas = Citas::all();
        }

        return view('citas.citas', compact('citas'));
    }

    public function crear()
    {
        $pacientes = Pacientes::all();
        $doctores = Doctores::all();
        return view('citas.crear', compact('pacientes', 'doctores'));
    }

    public function store(Request $request)
    {
        // Validar datos de entrada
        $request->validate([
            'paciente_id_hidden' => 'required|exists:pacientes,id',
            'doctor_id_hidden' => 'required|exists:doctores,id',
            'fecha' => 'required|date|after_or_equal:today',
            'hora' => 'required|date_format:H:i:s', // Asegurar el formato correcto
            'estado' => 'required|in:Completada,Cancelada,En curso',
        ]);

        // Obtener la fecha y hora ingresadas
        $fechaCita = Carbon::parse($request->fecha . ' ' . $request->hora);
        $horaActual = Carbon::now();

        // Verificar si la cita es al menos 3 horas después de la hora actual
        if ($fechaCita->lessThan($horaActual->addHours(3))) {
            return back()->withErrors(['hora' => 'La cita debe ser agendada con al menos 3 horas de anticipación.'])->withInput();
        }

        // Crear la cita con el estado "En curso" por defecto
        Citas::create([
            'paciente_id' => $request->paciente_id_hidden,
            'doctor_id' => $request->doctor_id_hidden,
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'estado' => 'En curso',
        ]);

        return redirect()->route('citas.index')->with('success', 'Cita creada exitosamente.');
    }

    public function getHorasDisponibles(Request $request)
    {
        $fecha = $request->input('fecha');
        $doctorId = $request->input('doctor_id');
        $inicio = $request->input('horaInicio');
        $fin = $request->input('horaFin');

        $horasOcupadas = Citas::where('doctor_id', $doctorId)
                              ->whereDate('fecha', $fecha)
                              ->pluck('hora')
                              ->toArray();

        // Suponiendo que las citas son de 30 minutos y que trabajan en horas de oficina
        $todasLasHoras = $this->generarHoras($inicio, $fin);
        $horasDisponibles = array_diff($todasLasHoras, $horasOcupadas);

        return response()->json($horasDisponibles);
    }

    private function generarHoras($inicio, $fin) {
        $horas = [];
        $start = Carbon::createFromFormat('H:i', $inicio);
        $end = Carbon::createFromFormat('H:i', $fin);

        while ($start < $end) {
            $horas[] = $start->format('H:i:s'); // Asegurar el formato correcto
            $start->addMinutes(30); // incremento cada 30 minutos
        }

        return $horas;
    }

    public function getHorasOcupadas(Request $request)
    {
        $fecha = $request->input('fecha');
        $doctorId = $request->input('doctor_id');

        $horasOcupadas = Citas::where('doctor_id', $doctorId)
                              ->whereDate('fecha', $fecha)
                              ->pluck('hora')
                              ->all();

        return response()->json($horasOcupadas);
    }
}
