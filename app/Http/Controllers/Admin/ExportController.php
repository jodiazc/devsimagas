<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentLink;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Log;

class ExportController extends Controller
{


    public function exportCsv()
    {
        Log::info('ExportCsv method called.');
        $filename = 'payment_links.csv';

        $response = new StreamedResponse(function() {
            $handle = fopen('php://output', 'w');

            // Escribir encabezados del CSV
            fputcsv($handle, [
                'Id',
                'Tipo Link',
                'Dlectura',
                'Cliente',
                'Pedido',
                'Importe',
                'Estatus',
                'Fecha Expiracion',
                'Fecha Elaboracion',
                'Insercion al Modulo',
            ]);

            // Obtener los datos del modelo
            $paymentLinks = PaymentLink::all();

            // Escribir datos en el CSV
            foreach ($paymentLinks as $paymentLink) {
                fputcsv($handle, [
                    $paymentLink->id,
                    $paymentLink->tipo_link,
                    $paymentLink->dlectura,
                    $paymentLink->cliente,
                    $paymentLink->pedido,
                    $paymentLink->importe,
                    $paymentLink->estatus,
                    $paymentLink->fecha_expiracion,
                    $paymentLink->fecha_elaboracion,
                    $paymentLink->insercion_al_modulo,
                ]);
            }

            fclose($handle);
        });

        // Configurar encabezados de respuesta
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', "attachment; filename=\"$filename\"");

        return $response;
    }
}
