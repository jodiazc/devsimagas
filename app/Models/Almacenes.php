<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Almacenes extends Model
{
    use HasFactory;

    protected $fillable = [
        'inmueble',
        'almacen',
        'cliente',
        'depa',
        'estatus'
    ];
}
