<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroLecturas extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente',
        'lectura_inicial',
        'lectura_final',
        'imagen_lectura',
    ];
}
