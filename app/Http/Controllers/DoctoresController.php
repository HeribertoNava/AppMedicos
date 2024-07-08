<?php
namespace App\Http\Controllers;

use App\Models\Doctores;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse; 

class DoctoresController extends Controller
{
    //Mostrar vista register cuando se de clic en crear, se obtienen todos los registros de la tabla doctores para mostrarlos en la vista
    public function index(): View
    {
        $doctores = Doctores::all();
        return view('doctores.doctores', ['doctores' => $doctores]);
    }

    // Método para mostrar el formulario para editarar a los doctores
    public function editar(Doctores $doctor): View
    {
        return view('doctores.editar', ['doctor' => $doctor]); //en la vista se pasan los datos del doctor que se va a editar
    }
    
    // formulario de crear un doctor
    public function crear(): View
    {
        return view('doctores.crear');
    }

    //Metodo para validar y crear el doctor
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombres' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'correo' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:doctores'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'telefono' => ['required', 'int'],
            'especialidad' => ['required', 'string', 'max:255'],
            'consultorio' => ['required', 'int'],
        ]);

        // Crear el registro en la tabla de doctores
        $doctor = Doctores::create([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'correo' => $request->correo,
            'password' => Hash::make($request->password),
            'telefono' => $request->telefono, 
            'especialidad' => $request->especialidad,
            'consultorio' => $request->consultorio,
        ]);

        // Crear el registro en la tabla de usuarios
        $usuario = Usuario::create([
            'nombre' => $request->nombres,
            'apellido' => $request->apellidos,
            'email' => $request->correo,
            'password' => Hash::make($request->password),
            'telefono' => $request->telefono,
            'rol' => 'Doctor',
        ]);

        event(new Registered($doctor));

        return redirect()->route('doctores.index')->with('success', 'Nuevo doctor agregado.');
    }

    // Método para actualizar los datos del doctor
    public function actualizar(Request $request, Doctores $doctor): RedirectResponse
    {
        $request->validate([
            'nombres' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'correo' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:doctores,correo,' . $doctor->id],
            'telefono' => ['required', 'int'],
            'especialidad' => ['required', 'string', 'max:255'],
            'consultorio' => ['required', 'int'],
        ]);

        //actualiza unicamente los datos validados
        $doctor->update([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'correo' => $request->correo,
            'telefono' => $request->telefono,
            'especialidad' => $request->especialidad,
            'consultorio' => $request->consultorio,
        ]);

        // Actualizar la información en la tabla de usuarios
        $usuario = Usuario::where('email', $doctor->correo)->first();
        if ($usuario) {
            $usuario->update([
                'nombre' => $request->nombres,
                'apellido' => $request->apellidos,
                'email' => $request->correo,
                'telefono' => $request->telefono,
            ]);
        }

        return redirect()->route('doctores.index')->with('success', 'Datos del doctor actualizados.');
    }

    //metodo eliminar un doctor, lo busca por su id 
    public function eliminar($id): RedirectResponse
    {
        $doctor = Doctores::findOrFail($id);
        $doctor->delete();

        // Eliminar también el registro de usuario asociado
        $usuario = Usuario::where('email', $doctor->correo)->first();
        if ($usuario) {
            $usuario->delete();
        }

        return redirect()->route('doctores.index')->with('success', 'Doctor eliminado.');
    }
}
