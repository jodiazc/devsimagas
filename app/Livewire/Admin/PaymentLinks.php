<?php

namespace App\Livewire\Admin;

use App\Models\PaymentLink;
use Livewire\Component;
use Livewire\WithPagination;

class PaymentLinks extends Component
{
    public $search = '';
    public $startDate;
    public $endDate;

    public function render()
    {
        $query = PaymentLink::query();

        // Filtro de búsqueda
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('dlectura', 'like', '%' . $this->search . '%')
                    ->orWhere('cliente', 'like', '%' . $this->search . '%');
            });
        }

        // Verifica que ambas fechas estén establecidas y sean válidas
        if ($this->startDate && $this->endDate) {
            $startDate = \DateTime::createFromFormat('d/m/Y', $this->startDate);
            $endDate = \DateTime::createFromFormat('d/m/Y', $this->endDate);

            if ($startDate && $endDate) {
                $query->whereBetween('fecha_elaboracion', [
                    $startDate->format('d-m-Y 00:00:00'),
                    $endDate->format('d-m-Y 23:59:59')
                ]);
            }
        }

        // Muestra el SQL generado y los parámetros vinculados
        //$sql = $query->toSql();
        //$bindings = $query->getBindings();

        // Usa dd() para detener la ejecución y mostrar ambos
        //dd(compact('sql', 'bindings'));

        $paymentLinks = $query->paginate();

        return view('livewire.admin.payment-links', compact('paymentLinks'));
    }

    public function applyFilter()
    {
        // Solo necesitamos actualizar los resultados en el método render
        $this->render(); // Esto no es necesario, se hará automáticamente en Livewire
    }
}
