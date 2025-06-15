<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mcliadm extends Model
{
    use HasFactory;

    protected $table = 'mcliadm';
    protected $primaryKey = 'K_CLIADM';
    public $timestamps = false;

    protected $fillable = [
        'NOMRESP',
        'CONTACTO',
        'DIRECCION1',
        'DIRECCION_GOOGLE',
        'COLONIA',
        'CP',
        'K_DELMUN',
        'ESTADO',
        'TEL_MOVIL',
        'TEL_REC',
        'CORREO_E',
        'K_TIPCLI',
        'K_TANQUE',
        'K_RUTA',
        'K_EJECAR',
        'SERIE_MED',
        'REF_BANCO',
        'FECHA_ALT',
        'FECHA_MOD',
        'ESTATUS',
        'TIEMPO_RECARGA',
        'DIA_CORTE',
        'DIA_LIMITE_PAGO',
        'PRECIOADM',
        'ADM_TIPO_PRECIO',
        'TIPO_SERVICIO',
        'ID_EJECUTIVO',
        'RECIBO',
        'ID_CUENTA1',
        'ID_CUENTA2',
        'ID_CUENTA3',
        'ID_CUENTA4',
        'ID_CUENTA5',
        'FACTOR_CONV',
        'CORTE_PROPUESTA',
        'n_imagen',
        'ID_EMPRESA',
        'TIPO_LIMITE_PAGO',
        'PROCESO_PERIODO',
        'id_cuenta_banco',
        'ID_CLIENTE',
        'ID_GRUPO_RUTA',
        'PROCESO_ESPECIAL',
        'FACTURA',
        'CLICK_BALANCE',
        'CLICK_BALANCE_ALTERNA',
        'DESCUENTO',
        'CONTABLE',
        'TIPO_CONTRATO',
        'id_recibo',
        'porc_carga',
        'mas_100',
        'FORMA_PAGO',
        'id_franquicia',
        'COBRANZA',
        'CLICK_ALMACEN',
        'CLICK_EMPRESA',
        'trabajo',
        'ref_inteligente',
        'dispositivo',
    ];    
}
