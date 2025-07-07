<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DcliadmDatosPeriodo extends Model
{
    use HasFactory;

    protected $table = 'dcliadm_datos_periodo';

    protected $fillable = [
                    'periodo_id',
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
                    'ENVIO_CEL'
    ];

    public function periodo()
    {
        return $this->belongsTo(Periodo::class);
    }    
}
