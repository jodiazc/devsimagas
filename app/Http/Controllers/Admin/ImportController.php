<?php

namespace App\Http\Controllers\Admin;

use App\Models\PaymentLink;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\ApiPaymentLinkController;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ImportController extends Controller
{
    public function import(Request $request)
    {
        // Validar el archivo
        $request->validate([
            'file' => 'required|file|mimes:csv,txt,xlsx|max:2048', // Ajusta las reglas según tus necesidades
        ]);

        $file = $request->file('file');

        // Leer el contenido del archivo CSV
        $fileContents = file($file->getPathname());

        // Omitir el primer renglón (encabezados)
        $dataRows = array_slice($fileContents, 1);
        $paymentController = new ApiPaymentLinkController();

        $startTime = Carbon::now();

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
            $transactionId = null;

            // Ejecutar la función de pago
            $response = $paymentController->makePayment($importe, 'MXN', $pedido,$fecha_expiracion);

            if (isset($response['requestStatus']) && $response['requestStatus'] === 'SUCCESS') {
                // Acceder a elementos específicos de la respuesta
                $paymentUrl = $response['paymentUrl'];
                $transactionId = $response['transactionId'];

                // Mostrar información
                Log::info("Payment processed successfully.");
                Log::info("Payment URL: $paymentUrl");
                Log::info("Transaction ID: $transactionId");

                // Validar y evitar duplicados
                $existingLink = PaymentLink::where([
                    ['tipo_liga', $tipoLiga],
                    ['dlectura', $dlectura],
                    ['cliente', $cliente],
                    ['pedido', $pedido],
                    ['importe', $importe],
                    ['estaus', $estaus],
                    ['fecha_expiracion', $fecha_expiracion],
                    ['fecha_elaboracion', $fecha_elaboracion],
                    ['transactionId', $transactionId],
                ])->first();

                if (!$existingLink) {
                    // Crear un nuevo registro en la base de datos
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
                        'transactionId' => $transactionId
                        // Puedes dejar 'insercion_al_modulo' vacío o con un valor predeterminado si lo prefieres
                    ]);

                    // Actualizar el registro con la URL de pago y el ID de transacción
                    $paymentLink->update([
                        'insercion_al_modulo' => $paymentUrl,
                        'transactionId' => $transactionId,
                        'processed_at' => Carbon::now(), // Establece la fecha de procesamiento
                    ]);
                } else {
                    // Actualizar el registro existente con la información de pago si aún no se ha actualizado
                    $existingLink->update([
                        'insercion_al_modulo' => $paymentUrl,
                        'transaction_id' => $transactionId,
                        'processed_at' => Carbon::now(),
                    ]);
                }
            } else {
                // Manejar el caso en el que el pago no fue exitoso
                Log::error("Payment failed. Response: " . json_encode($response));
            }

            // Esperar 10 segundos antes de procesar la siguiente fila
            $elapsedTime = Carbon::now()->diffInSeconds($startTime);
            $waitTime = max(0, 10 - $elapsedTime % 10);
            if ($waitTime > 0) {
                sleep($waitTime); // Esperar el tiempo restante para completar 10 segundos
            }

            // Actualizar el tiempo de inicio para la próxima iteración
            $startTime = Carbon::now();
        }

        return redirect()->back()->with('success', 'CSV file imported successfully.');
    }
}
