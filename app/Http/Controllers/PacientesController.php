<?php

namespace App\Http\Controllers;

use App\Models\Citas;
use App\Models\Usuario;
use App\Models\Pacientes;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;

class PacientesController extends Controller
{
    // Mostrar vista cuando se de clic en crear, obtiene todos los pacientes de la bd para mostrarlos en la tabla
    public function index(): View
    {
        $pacientes = Pacientes::all();
        return view('pacientes.pacientes', ['pacientes' => $pacientes]);
    }

    // Método para mostrar el formulario de edición
    public function editar($id): View
    {
        $paciente = Pacientes::findOrFail($id);
        return view('pacientes.editar', compact('paciente'));
    }

    // Formulario de crear paciente
    public function crear(): View
    {
        return view('pacientes.crear');
    }

    // Agregar el paciente en la bd
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombres' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'correo' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:pacientes'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'telefono' => ['required', 'int'],
            'direccion' => ['required', 'string', 'max:255'],
            'edad' => ['required', 'int'],
        ]);

        // Crear el registro en la tabla de pacientes
        $paciente = Pacientes::create([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'correo' => $request->correo,
            'password' => Hash::make($request->password),
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'edad' => $request->edad,
        ]);

        // Crear el registro en la tabla de usuarios
        $usuario = Usuario::create([
            'nombre' => $request->nombres,
            'apellido' => $request->apellidos,
            'email' => $request->correo,
            'password' => Hash::make($request->password),
            'telefono' => $request->telefono,
            'rol' => 'Paciente',
        ]);

        event(new Registered($paciente));

        return redirect()->route('pacientes.index')->with('success', 'Nuevo paciente agregado.');
    }

    // Método para actualizar un paciente
    public function actualizar(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'nombres' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'correo' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:pacientes,correo,'.$id],
            'telefono' => ['required', 'int'],
            'direccion' => ['required', 'string', 'max:255'],
            'edad' => ['required', 'int'],
        ]);

        $paciente = Pacientes::findOrFail($id);
        $paciente->update($request->all()); // Actualiza todo con los nuevos datos

        // Actualizar la información en la tabla de usuarios
        $usuario = Usuario::where('email', $paciente->correo)->first();
        if ($usuario) {
            $usuario->update([
                'nombre' => $request->nombres,
                'apellido' => $request->apellidos,
                'email' => $request->correo,
                'telefono' => $request->telefono,
            ]);
        }

        return redirect()->route('pacientes.index')->with('success', 'Paciente actualizado.');
    }

    // Método para eliminar un paciente
    public function eliminar($id): RedirectResponse
    {
        $paciente = Pacientes::findOrFail($id);
        $paciente->delete();

        // Eliminar también el registro de usuario asociado
        $usuario = Usuario::where('email', $paciente->correo)->first();
        if ($usuario) {
            $usuario->delete();
        }

        return redirect()->route('pacientes.index')->with('success', 'Paciente eliminado.');
    }
    public function historial($id)
{
    $paciente = Pacientes::with(['citas.doctor', 'consultas'])->findOrFail($id);

    return view('pacientes.historial', compact('paciente'));
}

public function mostrarCitas()
{
    $user = auth()->user();

    if ($user->rol === 'Paciente') {
        $citas = Citas::where('paciente_id', $user->id)->with('doctor')->get();
    } else {
        $citas = Citas::with('doctor', 'paciente')->get();
    }

    return view('citas.lista', compact('citas'));
}
}
