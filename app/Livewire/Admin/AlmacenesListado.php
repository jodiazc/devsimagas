<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Almacenes;
use Livewire\WithPagination;

class AlmacenesListado extends Component
{
    use WithPagination;

    public $searchAlmacenInput = '';
    public $searchClienteInput = '';

    public $searchAlmacen = '';
    public $searchCliente = '';

    public function buscar()
    {
        $this->searchAlmacen = $this->searchAlmacenInput;
        $this->searchCliente = $this->searchClienteInput;
    }

    public function limpiar()
    {
        $this->reset([
            'searchAlmacenInput',
            'searchClienteInput',
            'searchAlmacen',
            'searchCliente',
        ]);
    }

    public function render()
    {
        $almacenes = Almacenes::query()
            ->when($this->searchAlmacen, fn($q) => $q->where('almacen', 'like', "%{$this->searchAlmacen}%"))
            ->when($this->searchCliente, fn($q) => $q->where('cliente', 'like', "%{$this->searchCliente}%"))
            ->orderBy('id', 'desc')
            ->get();

        return view('livewire.admin.almacenes-listado', compact('almacenes'));
    }   
}
