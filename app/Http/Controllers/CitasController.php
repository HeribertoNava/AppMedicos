<?php

namespace App\Http\Controllers;

use App\Models\Pacientes;
use App\Models\Doctores;
use App\Models\Citas;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;

class CitasController extends Controller
{
    public function index(): View
    {
        $citas = Citas::with(['paciente', 'doctor'])->get();
        return view('citas.citas', ['citas' => $citas]);

        $user = Auth::user();

        // Filtrar las citas según el rol del usuario
        if ($user->rol === 'Paciente') {
            // Si el usuario es un paciente, solo ver sus propias citas
            $citas = Cita::where('paciente_id', $user->id)->get();
        } else {
            // Si el usuario es un doctor, ver todas las citas
            $citas = Cita::all();
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
            'paciente_id' => 'required|exists:pacientes,id',
            'doctor_id' => 'required|exists:doctores,id',
            'fecha' => 'required|date|after_or_equal:today',
            'hora' => 'required|date_format:H:i',
            'estado' => 'required|in:Completada,Cancelada,En proceso',
        ]);

        // Obtener la fecha y hora ingresadas
        $fechaCita = Carbon::parse($request->fecha . ' ' . $request->hora);
        $horaActual = Carbon::now();

        // Verificar si la cita es al menos 3 horas después de la hora actual
        if ($fechaCita->lessThan($horaActual->addHours(3))) {
            return back()->withErrors(['hora' => 'La cita debe ser agendada con al menos 3 horas de anticipación.'])->withInput();
        }

        // Crear la cita
        Citas::create($request->all());

        return redirect()->route('citas.index')->with('success', 'Cita creada exitosamente.');
    }
}
 