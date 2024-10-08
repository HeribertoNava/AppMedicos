<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pacientes extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nombres',
        'apellidos',
        'correo',
        'password',
        'telefono',
        'direccion',
        'edad',

    ];

    // Relación con Citas
    public function citas()
    {
        return $this->hasMany(Citas::class, 'paciente_id');
    }
    public function consultas()
    {
        return $this->hasMany(Consulta::class, 'paciente_id');
    }
}

