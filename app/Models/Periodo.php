<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'codigo_periodo', 'inicio', 'fin'];

    public function datos()
    {
        return $this->hasMany(DcliadmDatosPeriodo::class);
    }    
}
