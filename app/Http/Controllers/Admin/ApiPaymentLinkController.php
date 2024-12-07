<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ApiPaymentLinkController extends Controller
{
    public function makePayment($amount,$currency,$orderId,$fechaExpiracion)
    {
        // Recuperar valores del archivo .env
        $apiUrl = env('URL_FIRSTDATA');
        $apiKey = env('API_KEY');
        $apiSecret = env('API_SECRET');

        // Registrar la API Key y el API Secret usando Log::info
        Log::info('API Key and Secret', [
            'API_KEY' => $apiKey,
            'API_SECRET' => $apiSecret
        ]);

        $clientRequestId = Str::uuid()->toString(); // Generar un UUIDv4
        $timestamp = (int) (microtime(true) * 1000); // Timestamp en milisegundos

        // Definir el payload
        $payload = [
            "transactionAmount" => [
                "total" => $amount, //"5.00",
                "currency" => $currency //"MXN"
            ],
            "transactionType" => "SALE",
            "transactionNotificationURL" => "https://www.firstdata.com/es_mx/home.html",
            "clientLocale" => [
                "language" => "es_MX",
                "country" => "MX"
            ],
            "orderId" => $orderId,
            "expiration" => $fechaExpiracion
        ];

        // Convertir el payload a JSON
        $payloadJson = json_encode($payload);

        // Generar la firma
        $messageSignature = $this->generateMessageSignature($apiKey, $clientRequestId, $timestamp, $payloadJson, $apiSecret);

        // Definir los headers
        $headers = [
            'Content-Type' => 'application/json',
            'Api-Key' => $apiKey,
            'Client-Request-Id' => $clientRequestId,
            'Timestamp' => $timestamp,
            'Message-Signature' => $messageSignature
        ];

        // Enviar la solicitud HTTP con headers y payload
        $response = Http::withHeaders($headers)
            ->post($apiUrl, $payload);


            Log::info('RespuestaGeneral', [
                'REQUEST' => [
                    'headers' => $headers,
                    'RequestBody', json_decode($payloadJson)
                ],
                'RESPONSE' => $response
            ]);

            // Procesar la respuesta
        return $response->json();
    }

    function generateMessageSignature($apiKey, $clientRequestId, $timestamp, $payload, $apiSecret)
    {
        // Generar la cadena para firmar
        $msgSignatureString = $apiKey . $clientRequestId . $timestamp . $payload;

        // Crear la firma usando HMAC SHA256 y codificar en Base64
        $signature = base64_encode(hash_hmac('sha256', $msgSignatureString, $apiSecret, true));

        return $signature;
    }
}
