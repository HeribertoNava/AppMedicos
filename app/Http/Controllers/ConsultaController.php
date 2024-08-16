<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Citas;
use App\Models\Venta;
use App\Models\Receta;
use App\Models\Consulta;
use App\Models\Doctores;
use App\Models\Pacientes;
use App\Models\Productos;
use App\Models\Servicios;
use App\Models\VentaItem;
use Illuminate\View\View;
use App\Models\Colaboracion;
use Illuminate\Http\Request;
use App\Models\SignosVitales;
use App\Models\ConsultaServicio;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;

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

        $fecha = $request->input('fecha'); // Obtener la fecha desde la URL
        $hora = $request->input('hora');   // Obtener la hora desde la URL
        $doctorId = $request->input('doctorId'); // Obtener el ID del doctor desde la URL

        return view('consultas.create', compact('paciente', 'doctores', 'productos', 'servicios', 'fecha', 'hora', 'doctorId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'doctor_id' => 'required|exists:doctores,id',
            'correo' => 'required|email',
            'nombre' => 'required|string',
            'motivo_consulta' => 'required|string',
            'notas_padecimiento' => 'required|string',
            'interrogatorio_aparatos_sistemas' => 'required|string',
            'examen_fisico' => 'required|string',
            'diagnostico' => 'required|string',
            'plan' => 'required|string',
            'total_a_pagar' => 'required|numeric',
            'talla' => 'required|numeric',
            'temperatura' => 'required|numeric',
            'frecuencia_cardiaca' => 'required|numeric',
            'saturacion_oxigeno' => 'required|numeric',
            'medicamento.*' => 'required|string',
            'dosis.*' => 'required|string',
            'frecuencia.*' => 'required|string',
            'duracion.*' => 'required|string',
        ]);

        // Establecer la zona horaria de Mexico City
        $fecha = Carbon::now('America/Mexico_City');

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
            'created_at' => $fecha,
            'updated_at' => $fecha,
        ]);

        // Guardar los signos vitales
        SignosVitales::create([
            'consulta_id' => $consulta->id,
            'talla' => $request->talla,
            'temperatura' => $request->temperatura,
            'frecuencia_cardiaca' => $request->frecuencia_cardiaca,
            'saturacion_oxigeno' => $request->saturacion_oxigeno,
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

        // Guardar los servicios seleccionados en la tabla consulta_servicio
        if ($request->has('servicio')) {
            foreach ($request->servicio as $index => $servicioId) {
                $servicio = Servicios::find($servicioId);
                $cantidad = $request->cantidad_servicio[$index];

                if ($servicio) {
                    ConsultaServicio::create([
                        'consulta_id' => $consulta->id,
                        'servicio_id' => $servicio->id,
                        'cantidad' => $cantidad,
                        'precio' => $servicio->precio * $cantidad,
                        'notas_servicio' => $request->notas_servicio ?? '', // Puedes guardar notas si están disponibles
                    ]);
                }
            }
        }

        // Crear una nueva venta y sus items correspondientes
        if ($request->has('productos')) {
            $venta = Venta::create([
                'consulta_id' => $consulta->id,
                'total' => $request->total_a_pagar, // Se puede ajustar según la lógica de negocio
            ]);

            foreach ($request->productos as $index => $precioProducto) {
                $productoId = $request->productos[$index];
                $cantidad = $request->cantidad_producto[$index];
                $producto = Productos::find($productoId);

                if ($producto) {
                    $subtotal = $producto->precio * $cantidad;

                    VentaItem::create([
                        'venta_id' => $venta->id,
                        'nombre' => $producto->nombre,
                        'cantidad' => $cantidad,
                        'precio' => $producto->precio,
                        'subtotal' => $producto->precio,
                    ]);
                }
            }
        }

        return redirect()->route('consultas.index')
            ->with('success', 'Consulta creada exitosamente.');
    }
    public function listaConsultas(): View
    {
        $consultas = Consulta::with(['paciente', 'doctor'])->get();
        return view('consultas.create', compact('consultas'));
    }



    public function compartir($id)
{
    $consulta = Consulta::findOrFail($id);

    // Obtener todos los médicos colaboradores, excluyendo al usuario actual
    $medicosColaboradores = Usuario::where('rol', 'medico_colaborador')
        ->where('id', '!=', Auth::id())
        ->get();

    return view('consultas.compartir', compact('consulta', 'medicosColaboradores'));
}

public function asignarColaboracion(Request $request, $id)
{
    $request->validate([
        'medico_colaborador_id' => 'required|exists:usuarios,id',
    ]);

    // Crear la colaboración
    Colaboracion::create([
        'consulta_id' => $id,
        'medico_colaborador_id' => $request->medico_colaborador_id,
    ]);

    return redirect()->route('consultas.show', $id)->with('success', 'Consulta compartida con éxito.');
}

public function verColaboracion($id)
{
    // Obtener la colaboración específica para el médico colaborador autenticado
    $colaboracion = Colaboracion::where('consulta_id', $id)
        ->where('medico_colaborador_id', Auth::id())
        ->firstOrFail();

    return view('consultas.verColaboracion', compact('colaboracion'));
}

public function enviarMensaje(Request $request, $id)
{
    // Validar y enviar el mensaje dentro de la colaboración
    $request->validate([
        'mensaje' => 'required|string',
    ]);

    // Encontrar la colaboración por ID
    $colaboracion = Colaboracion::findOrFail($id);

    // Actualizar la colaboración con el mensaje del médico colaborador
    $colaboracion->update([
        'mensaje' => $request->mensaje,
    ]);

    return redirect()->route('consultas.verColaboracion', $colaboracion->consulta_id)
        ->with('success', 'Mensaje enviado con éxito.');
}

public function listarColaboraciones()
{
    // Obtener todas las colaboraciones asignadas al médico colaborador autenticado
    $colaboraciones = Colaboracion::where('medico_colaborador_id', Auth::id())->get();

    return view('consultas.colaboracionesIndex', compact('colaboraciones'));
}

}
