<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dcliadm extends Model
{
    use HasFactory;

    // Definimos la tabla explícitamente porque el nombre no es plural ni sigue convención
    protected $table = 'dcliadm';

    // La clave primaria es ID
    protected $primaryKey = 'ID';

    // La clave primaria es autoincremental y es un entero
    public $incrementing = true;
    protected $keyType = 'int';

    // La tabla no tiene los campos created_at ni updated_at en formato estándar, así que desactivamos timestamps
    public $timestamps = false;

    // Definimos los campos que se pueden asignar en masa
    protected $fillable = [
        'K_CLIADM_D',
        'K_CLIADM',
        'NOMRESP',
        'CLASIFICA',
        'DEPTO',
        'TEL_CASA',
        'TEL_OFI',
        'TEL_MOVIL',
        'TEL_REC',
        'CORREO_E',
        'SERIE_MED',
        'REF_BANCO',
        'FECHA_ALT',
        'FECHA_MOD',
        'ESTATUS',
        'ESTATUS_SERVICO',
        'OBSERVACION',
        'FECHA_BAJA',
        'REFERENCIA',
        'SIN_VERIFICADOR',
        'rfc',
        'cuentahabiente',
        'usuario',
        'interbancaria',
        'centavos',
        'P_PROGRAMADO',
        'FACTURACION',
        'DEPTO_SISTEMA',
        'BURO',
        'EQUIPO',
        'RegistrationID',
        'operator',
        'cliente_click',
        'CUENTA_CLAVE',
        'id_archivo',
        'ENVIO_CEL',
    ];

    // Si quieres que Eloquent convierta automáticamente las fechas a Carbon, declara aquí los campos fecha
    protected $dates = [
        'FECHA_ALT',
        'FECHA_MOD',
        'FECHA_BAJA',
    ];    
}
