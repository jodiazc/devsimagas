<?php

use App\Models\PaymentLink;
use App\Http\Controllers\Admin\ApiPaymentLinkController;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

require __DIR__ . '/../../../vendor/autoload.php'; // Ajusta la ruta si es necesario

// Configuración para iniciar Laravel
$app = require_once __DIR__ . '/../../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

// Obtener los enlaces de pago que necesitan ser procesados
$paymentLinks = PaymentLink::whereNull('transactionId')
    ->whereNull('insercion_al_modulo')
    ->get();

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
        ]);

        Log::info("Payment processed successfully for PaymentLink ID: {$paymentLink->id}");
        Log::info("Payment URL: $paymentUrl");
        Log::info("Transaction ID: $transactionId");
    } else {
        Log::error("Payment failed for PaymentLink ID: {$paymentLink->id}. Response: " . json_encode($response));
    }
}
