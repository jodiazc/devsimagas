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
    ];
}
