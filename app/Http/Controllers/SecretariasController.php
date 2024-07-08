<?php

namespace App\Http\Controllers;

use App\Models\Secretarias;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class SecretariasController extends Controller
{
    // Mostrar vista de secretarias y obtener todos los registros
    public function index(): View
    {
        $secretarias = Secretarias::all();
        return view('secretarias.secretarias', ['secretarias' => $secretarias]);
    }

    // Mostrar el formulario para editar una secretaria
    public function editar(Secretarias $secretaria): View
    {
        return view('secretarias.editar', ['secretaria' => $secretaria]);
    }

    // Mostrar el formulario para crear una secretaria
    public function crear(): View
    {
        return view('secretarias.crear');
    }

    // Validar y crear la secretaria
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombres' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'correo' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:secretarias'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'telefono' => ['required', 'int'],
        ]);

        // Crear el registro en la tabla de secretarias
        $secretaria = Secretarias::create([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'correo' => $request->correo,
            'password' => Hash::make($request->password),
            'telefono' => $request->telefono,
        ]);

        // Crear el registro en la tabla de usuarios
        $usuario = Usuario::create([
            'nombre' => $request->nombres,
            'apellido' => $request->apellidos,
            'email' => $request->correo,
            'password' => Hash::make($request->password),
            'telefono' => $request->telefono,
            'rol' => 'Secretaria',
        ]);

        event(new Registered($secretaria));

        return redirect()->route('secretarias.index')->with('success', 'Nueva secretaria agregada.');
    }

    // Método para actualizar los datos de la secretaria
    public function actualizar(Request $request, Secretarias $secretaria): RedirectResponse
    {
        $request->validate([
            'nombres' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'correo' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:secretarias,correo,' . $secretaria->id],
            'telefono' => ['required', 'int'],
        ]);

        // Actualiza únicamente los datos validados
        $secretaria->update([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'correo' => $request->correo,
            'telefono' => $request->telefono,
        ]);

        // Actualizar la información en la tabla de usuarios
        $usuario = Usuario::where('email', $secretaria->correo)->first();
        if ($usuario) {
            $usuario->update([
                'nombre' => $request->nombres,
                'apellido' => $request->apellidos,
                'email' => $request->correo,
                'telefono' => $request->telefono,
            ]);
        }

        return redirect()->route('secretarias.index')->with('success', 'Datos de la secretaria actualizados.');
    }

    // Método para eliminar una secretaria, busca por su id
    public function eliminar($id): RedirectResponse
    {
        $secretaria = Secretarias::findOrFail($id);
        $secretaria->delete();

        // Eliminar también el registro de usuario asociado
        $usuario = Usuario::where('email', $secretaria->correo)->first();
        if ($usuario) {
            $usuario->delete();
        }

        return redirect()->route('secretarias.index')->with('success', 'Secretaria eliminada.');
    }
}

