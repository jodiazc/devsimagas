<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroLecturas extends Model
{
    use HasFactory;

    protected $fillable = [
        'almacen',
        'cliente',
        'lectura_inicial',
        'lectura_final',
        'imagen_lectura',
        'observaciones',
        'estatus_registro'
    ];

    public function getImagenLecturaAttribute($value)
    {
        if (!$value) {
            return null;
        }

        return url('storage/' . $value);
    }    

    public function getEstatusRegistroNombreAttribute(): string
    {
        return match ($this->estatus_registro) {
            0 => 'Pendiente',
            1 => 'Completado',
            2 => 'Rechazado',
            default => 'Desconocido',
        };
    }    
}
