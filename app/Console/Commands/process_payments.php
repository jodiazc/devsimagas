<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\PaymentLink;
use App\Http\Controllers\Admin\ApiPaymentLinkController;
use Carbon\Carbon;

class Process_Payments extends Command
{
    // Nombre del comando
    protected $signature = 'ProcessPayments';

    // Descripción del comando
    protected $description = 'Process payment links and update their status';

    /**
     * Ejecuta el comando
     *
     * @return void
     */
    public function handle()
    {
        Log::info("Procesando Pagos a ver si funciona para ser ejecutado desde un cron");

        //$paymentLinks = PaymentLink::all();
        $paymentLinks = PaymentLink::where('estaus', '1')->get();

        $paymentController = new ApiPaymentLinkController();
        // Procesar cada enlace de pago
        foreach ($paymentLinks as $paymentLink) {
            $tipoLiga = $paymentLink->tipo_liga;
            $dlectura = $paymentLink->dlectura;
            $cliente = $paymentLink->cliente;
            $pedido = $paymentLink->pedido;
            $importe = $paymentLink->importe;
            $fecha_expiracion = $paymentLink->fecha_expiracion;

            // Llamar a la API de pagos
            $response = $paymentController->makePayment($importe, 'MXN', $pedido, $fecha_expiracion);

            if (isset($response['requestStatus']) && $response['requestStatus'] === 'SUCCESS') {
                $paymentUrl = $response['paymentUrl'];
                $transactionId = $response['transactionId'];

                // Actualizar el registro con la URL de pago y el ID de transacción
                $paymentLink->update([
                    'insercion_al_modulo' => $paymentUrl,
                    'transactionId' => $transactionId,
                    'processed_at' => Carbon::now(),
                    'estaus' => 2,
                ]);

                Log::info("Payment processed successfully for PaymentLink ID: {$paymentLink->id}");
                Log::info("Payment URL: $paymentUrl");
                Log::info("Transaction ID: $transactionId");
            } else {
                Log::error("Payment failed for PaymentLink ID: {$paymentLink->id}. Response: " . json_encode($response));
            }

        }
    }
}
