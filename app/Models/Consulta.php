<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    use HasFactory;

    protected $fillable = [
        'paciente_id',
        'doctor_id',
        'fecha',
        'correo',
        'nombre',
        'motivo_consulta',
        'notas_padecimiento',
        'interrogatorio_aparatos_sistemas',
        'examen_fisico',
        'diagnostico',
        'plan',
        'total_a_pagar'
    ];

    public function recetas()
    {
        return $this->hasMany(Receta::class);
    }

    public function paciente()
    {
        return $this->belongsTo(Pacientes::class, 'paciente_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctores::class, 'doctor_id');
    }
}
