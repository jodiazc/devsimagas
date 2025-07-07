<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dcliadm_datos_periodo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periodo_id')->constrained('periodos')->onDelete('cascade');

            $table->string('K_CLIADM_D')->nullable();
            $table->string('K_CLIADM')->nullable();
            $table->string('NOMRESP')->nullable();
            $table->string('CLASIFICA')->nullable();
            $table->string('DEPTO')->nullable();
            $table->string('TEL_CASA')->nullable();
            $table->string('TEL_OFI')->nullable();
            $table->string('TEL_MOVIL')->nullable();
            $table->string('TEL_REC')->nullable();
            $table->string('CORREO_E')->nullable();
            $table->string('SERIE_MED')->nullable();
            $table->string('REF_BANCO')->nullable();
            $table->string('FECHA_ALT')->nullable();
            $table->string('FECHA_MOD')->nullable();
            $table->string('ESTATUS')->nullable();
            $table->string('ESTATUS_SERVICO')->nullable();
            $table->text('OBSERVACION')->nullable();
            $table->string('FECHA_BAJA')->nullable();
            $table->string('REFERENCIA')->nullable();
            $table->string('SIN_VERIFICADOR')->nullable();
            $table->string('rfc')->nullable();
            $table->string('cuentahabiente')->nullable();
            $table->string('usuario')->nullable();
            $table->string('interbancaria')->nullable();
            $table->string('centavos', 10, 2)->nullable();
            $table->string('P_PROGRAMADO')->nullable();
            $table->string('FACTURACION', 15, 2)->nullable();
            $table->string('DEPTO_SISTEMA')->nullable();
            $table->string('BURO')->nullable();
            $table->string('EQUIPO')->nullable();
            $table->string('RegistrationID')->nullable();
            $table->string('operator')->nullable();
            $table->string('cliente_click')->nullable();
            $table->string('CUENTA_CLAVE')->nullable();
            $table->string('id_archivo')->nullable();
            $table->string('ENVIO_CEL')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dcliadm_datos_periodo');
    }
};
