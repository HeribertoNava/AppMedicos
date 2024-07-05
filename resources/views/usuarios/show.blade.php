@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalles del Usuario</h1>

    <div class="card">
        <div class="card-header">
            {{ $usuario->nombre }} {{ $usuario->apellido }}
        </div>
        <div class="card-body">
            <p><strong>Email: </strong>{{ $usuario->email }}</p>
            <p><strong>Teléfono: </strong>{{ $usuario->telefono }}</p>
            <p><strong>Rol: </strong>{{ $usuario->rol }}</p>
            <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-warning">Editar</a>
            <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Eliminar</button>
            </form>
        </div>
    </div>
</div>
@endsection
