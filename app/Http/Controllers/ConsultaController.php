<?php
namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Productos;
use App\Models\Servicios;
use App\Models\Pacientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultaController extends Controller
{
    public function index()
    {
        $consultas = Consulta::with(['productos', 'servicios'])->get();
        return view('consultas.index', compact('consultas'));
    }

    public function create($paciente_id = null)
    {
        $paciente = $paciente_id ? Pacientes::findOrFail($paciente_id) : null;
        $productos = Productos::all();
        $servicios = Servicios::all();
        return view('consultas.create', compact('paciente', 'productos', 'servicios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|max:255',
            // Aquí puedes agregar validaciones adicionales según sea necesario
        ]);

        $consulta = new Consulta($request->all());
        $consulta->user_id = Auth::id(); // Asigna el ID del usuario autenticado
        $consulta->save();

        $consulta->productos()->attach($request->productos);
        $consulta->servicios()->attach($request->servicios);

        return redirect()->route('consultas.index')->with('success', 'Consulta creada exitosamente.');
    }

    public function show(Consulta $consulta)
    {
        return view('consultas.show', compact('consulta'));
    }

    public function edit(Consulta $consulta)
    {
        $productos = Productos::all();
        $servicios = Servicios::all();
        return view('consultas.edit', compact('consulta', 'productos', 'servicios'));
    }

    public function update(Request $request, Consulta $consulta)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|max:255',
            // Aquí puedes agregar validaciones adicionales según sea necesario
        ]);

        $consulta->update($request->all());

        $consulta->productos()->sync($request->productos);
        $consulta->servicios()->sync($request->servicios);

        return redirect()->route('consultas.index')->with('success', 'Consulta actualizada exitosamente.');
    }

    public function destroy(Consulta $consulta)
    {
        $consulta->delete();
        return redirect()->route('consultas.index')->with('success', 'Consulta eliminada exitosamente.');
    }
}
