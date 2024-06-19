<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citas extends Model
{
    use HasFactory;

    protected $fillable = [
        'paciente_id',
        'doctor_id',
        'fecha',
        'hora',
        'estado',   
    ];

   // Relación con Paciente
   public function paciente()
   {
       return $this->belongsTo(Pacientes::class, 'paciente_id');
   }

   // Relación con Doctor
   public function doctor()
   {
       return $this->belongsTo(Doctores::class, 'doctor_id');
   }
}
