<?php

namespace App\Http\Controllers\Admin;

use App\Models\PaymentLink;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ImportController extends Controller
{
    public function import(Request $request)
    {
        ini_set('max_execution_time', 3600);

        // Validar el archivo
        $request->validate([
            'file' => 'required|file|mimes:csv,txt,xlsx|max:2048', // Ajusta las reglas según tus necesidades
        ]);

        $file = $request->file('file');

        // Leer el contenido del archivo CSV
        $fileContents = file($file->getPathname());

        // Omitir el primer renglón (encabezados)
        $dataRows = array_slice($fileContents, 1);

        foreach ($dataRows as $line) {
            $data = str_getcsv($line);

            // Asegúrate de que los índices del array correspondan a las columnas esperadas
            $tipoLiga = $data[1] ?? null;
            $dlectura = $data[2] ?? null;
            $cliente = $data[3] ?? null;
            $pedido = $data[4] ?? null;
            $importe = $data[5] ?? null;
            $estaus = $data[6] ?? null;
            $fecha_expiracion = $data[7] ?? null;
            $fecha_elaboracion = $data[8] ?? null;
            $insercion_al_modulo = $data[9] ?? null;

            // Insertar los datos sin procesar el pago
            $paymentLink = PaymentLink::create([
                'tipo_liga' => $tipoLiga,
                'dlectura' => $dlectura,
                'cliente' => $cliente,
                'pedido' => $pedido,
                'importe' => $importe,
                'estaus' => $estaus,
                'fecha_expiracion' => $fecha_expiracion,
                'fecha_elaboracion' => $fecha_elaboracion,
                'insercion_al_modulo' => $insercion_al_modulo,
                'transactionId' => 0
            ]);
        }

        return redirect()->back()->with('success', 'CSV file imported and data saved successfully.');
    }
}
