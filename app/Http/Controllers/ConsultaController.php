<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use App\Models\Consulta;
use App\Models\Doctores;
use App\Models\Pacientes;
use App\Models\Productos;
use App\Models\Servicios;
use Illuminate\Http\Request;

class ConsultaController extends Controller
{
    public function index()
    {
        // Recuperar todas las consultas sin filtrar por paciente_id
        $consultas = Consulta::all();

        // Retornar la vista con las consultas
        return view('consultas.index', compact('consultas'));
    }

    public function show($id)
    {
        $consulta = Consulta::with(['doctor', 'paciente', 'signosVitales', 'recetas', 'servicios', 'venta'])->findOrFail($id);
        return view('consultas.show', compact('consulta'));
    }

    public function create(Request $request, $pacienteId)
    {
        $doctores = Doctores::all();
        $paciente = Pacientes::findOrFail($pacienteId);
        $productos = Productos::all(); // Obtener todos los productos
        $servicios = Servicios::all(); // Obtener todos los servicios

        return view('consultas.create', compact('paciente', 'doctores', 'productos', 'servicios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'doctor_id' => 'required|exists:doctores,id',
            'correo' => 'required|email',
            'nombre' => 'required|string',
            'motivo_consulta' => 'required|string',
            'notas_padecimiento' => 'nullable|string',
            'interrogatorio_aparatos_sistemas' => 'nullable|string',
            'examen_fisico' => 'nullable|string',
            'diagnostico' => 'nullable|string',
            'plan' => 'nullable|string',
            'total_a_pagar' => 'required|numeric',
            'medicamento.*' => 'nullable|string',
            'dosis.*' => 'nullable|string',
            'frecuencia.*' => 'nullable|string',
            'duracion.*' => 'nullable|string',
        ]);

        // Crear la consulta
        $consulta = Consulta::create([
            'paciente_id' => $request->paciente_id,
            'doctor_id' => $request->doctor_id,
            'correo' => $request->correo,
            'nombre' => $request->nombre,
            'motivo_consulta' => $request->motivo_consulta,
            'notas_padecimiento' => $request->notas_padecimiento,
            'interrogatorio_aparatos_sistemas' => $request->interrogatorio_aparatos_sistemas,
            'examen_fisico' => $request->examen_fisico,
            'diagnostico' => $request->diagnostico,
            'plan' => $request->plan,
            'total_a_pagar' => $request->total_a_pagar,
        ]);

        // Crear recetas si se han proporcionado
        if ($request->medicamento) {
            foreach ($request->medicamento as $index => $medicamento) {
                Receta::create([
                    'consulta_id' => $consulta->id,
                    'correo' => $request->correo,
                    'nombre' => $request->nombre,
                    'medicamento' => $medicamento,
                    'dosis' => $request->dosis[$index],
                    'frecuencia' => $request->frecuencia[$index],
                    'duracion' => $request->duracion[$index],
                ]);
            }
        }

        return redirect()->route('consultas.index')
            ->with('success', 'Consulta creada exitosamente.');
    }
}
