<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Productos extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nombre',
        'descripcion',
        'cantidad',
        'precio',   
    ];
}
