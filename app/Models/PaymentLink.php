<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentLink extends Model
{
    use HasFactory;

    // Definir los campos que se pueden asignar masivamente
    protected $fillable = [
        'tipo_liga',
        'dlectura',
        'cliente',
        'pedido',
        'importe',
        'estaus',
        'fecha_expiracion',
        'fecha_elaboracion',
        'insercion_al_modulo',
        'insercion_al_modulo',
        'transactionId',
    ];

    // Opcional: Si usas fechas personalizadas
    protected $dates = [
        'fecha_expiracion',
        'fecha_elaboracion',
    ];
    
}
