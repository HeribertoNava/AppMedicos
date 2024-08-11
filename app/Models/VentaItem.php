<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VentaItem extends Model
{
    protected $fillable = [
        'venta_id',
        'nombre',
        'cantidad',
        'precio',
        'subtotal',
    ];

    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }
}
