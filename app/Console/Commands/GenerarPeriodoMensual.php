<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Periodo;
use App\Models\Dcliadm;
use App\Models\DcliadmDatosPeriodo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class GenerarPeriodoMensual extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'periodo:generar';

    /**
     * The console command description.
     */
    protected $description = 'Genera un nuevo periodo mensual y copia los datos de dcliadm';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $inicio = Carbon::now()->startOfMonth();
        $fin = Carbon::now()->endOfMonth();
        $nombre = $inicio->translatedFormat('F Y'); // Ej: "Julio 2025"
        $codigo = $inicio->format('Ym');            // Ej: "202507"

        // Validar si ya existe ese periodo
        /*
        if (Periodo::where('codigo_periodo', $codigo)->exists()) {
            $this->error("El periodo {$codigo} ya existe.");
            return;
        }
        */

        // Crear el nuevo periodo
        $periodo = Periodo::create([
            'nombre' => $nombre,
            'codigo_periodo' => $codigo,
            'inicio' => $inicio,
            'fin' => $fin,
        ]);

        $this->info("Periodo creado: {$nombre} ({$codigo})");

        // Obtener todos los datos de dcliadm
        $datos = Dcliadm::all();
        $this->info("Total de registros encontrados en dcliadm: " . $datos->count());

        if ($datos->isEmpty()) {
            $this->warn("No hay registros para copiar.");
            return;
        }

        $copiados = 0;
        $fallidos = 0;

        foreach ($datos as $dato) {
            try {
                DcliadmDatosPeriodo::create([
                    'periodo_id'        => $periodo->id,
                    'K_CLIADM_D'        => substr($dato->K_CLIADM_D ?? '', 0, 255),
                    'K_CLIADM'        => substr($dato->K_CLIADM ?? '', 0, 255),
                    'NOMRESP'           => substr($dato->NOMRESP ?? '', 0, 255),
                    'CLASIFICA'         => substr($dato->CLASIFICA ?? '', 0, 255),
                    'DEPTO'             => substr($dato->DEPTO ?? '', 0, 255),
                    'TEL_CASA'          => substr($dato->TEL_CASA ?? '', 0, 255),
                    'TEL_OFI'           => substr($dato->TEL_OFI ?? '', 0, 255),
                    'TEL_MOVIL'         => substr($dato->TEL_MOVIL ?? '', 0, 255),
                    'TEL_REC'           => substr($dato->TEL_REC ?? '', 0, 255),
                    'CORREO_E'          => substr($dato->CORREO_E ?? '', 0, 255),
                    'REF_BANCO'         => substr($dato->REF_BANCO ?? '', 0, 255),
                    'FECHA_ALT'         => $this->validDateOrNull($dato->FECHA_ALT),
                    'FECHA_MOD'         => $this->validDateOrNull($dato->FECHA_MOD),
                    'ESTATUS'           => substr($dato->ESTATUS ?? '', 0, 255),
                    'ESTATUS_SERVICO'   => substr($dato->ESTATUS_SERVICO ?? '', 0, 255),
                    'OBSERVACION'       => substr($dato->OBSERVACION ?? '', 0, 255),
                    'FECHA_BAJA'        => $this->validDateOrNull($dato->FECHA_BAJA),
                    'REFERENCIA'        => substr($dato->REFERENCIA ?? '', 0, 255),
                    'SIN_VERIFICADOR'   => $this->validTinyInt($dato->SIN_VERIFICADOR),
                    'rfc'               => substr($dato->rfc ?? '', 0, 255),
                    'cuentahabiente'    => substr($dato->cuentahabiente ?? '', 0, 255),
                    'usuario'           => substr($dato->usuario ?? '', 0, 255),
                    'interbancaria'     => substr($dato->interbancaria ?? '', 0, 255),
                    'centavos'          => substr($dato->centavos ?? '', 0, 255),
                    'P_PROGRAMADO'      => substr($dato->P_PROGRAMADO ?? '', 0, 255),
                    'FACTURACION'       => substr($dato->FACTURACION ?? '', 0, 255),
                    'DEPTO_SISTEMA'     => substr($dato->DEPTO_SISTEMA ?? '', 0, 255),
                    'BURO'              => substr($dato->BURO ?? '', 0, 255),
                    'EQUIPO'            => substr($dato->EQUIPO ?? '', 0, 255),
                    'RegistrationID'    => substr($dato->RegistrationID ?? '', 0, 255),
                    'operator'          => substr($dato->operator ?? '', 0, 255),
                    'cliente_click'     => substr($dato->cliente_click ?? '', 0, 255),
                    'CUENTA_CLAVE'      => substr($dato->CUENTA_CLAVE ?? '', 0, 255),
                    'id_archivo'        => substr($dato->id_archivo ?? '', 0, 255),
                    'ENVIO_CEL'         => substr($dato->ENVIO_CEL ?? '', 0, 255),
                ]);
                $copiados++;
            } catch (\Throwable $e) {
                $fallidos++;
                Log::error('Error insertando DcliadmDatosPeriodo', [
                    'registro_id' => $dato->ID ?? 'sin ID',
                    'error' => $e->getMessage(),
                    'datos' => $dato->toArray(),
                ]);
                $this->warn("⚠️  Error en registro ID {$dato->ID}: " . $e->getMessage());
            }
        }

        $this->info("✅ Registros copiados exitosamente: {$copiados}");
        $this->warn("⚠️  Registros que fallaron: {$fallidos}");
    }

    /**
     * Valida una fecha, devuelve null si no es válida o está vacía
     */
    private function validDateOrNull($value)
    {
        if (empty($value) || trim($value) === '') {
            return null;
        }

        try {
            return Carbon::parse($value);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Valida y limita valores numéricos para campos tipo TINYINT
     */
    private function validTinyInt($value, $unsigned = true)
    {
        $max = $unsigned ? 255 : 127;

        if (is_numeric($value)) {
            $int = intval($value);
            return max(0, min($int, $max));
        }

        return 0;
    }
}