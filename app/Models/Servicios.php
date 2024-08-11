<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Servicios extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
    ];

    public function consultas()
    {
        return $this->belongsToMany(Consulta::class, 'consulta_servicio', 'servicio_id', 'consulta_id')
                    ->withPivot('cantidad', 'precio', 'notas_servicio');
    }
}
