<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
//use App\Models\Dcliadm;
use App\Models\DcliadmDatosPeriodo;
use App\Models\RegistroLecturas;
use Illuminate\Support\Facades\DB;

class DcliadmGrid extends Component
{
    use WithPagination;

    public $search = '';
    public $kCliadm;
    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount($kCliadm)
    {
        $this->kCliadm = $kCliadm;
    }

    public function render()
    {
        DB::enableQueryLog();

        $query = DcliadmDatosPeriodo::query()
            ->where('K_CLIADM', $this->kCliadm);
            //->where('ESTATUS', '!=', 'P')

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('NOMRESP', 'like', '%' . $this->search . '%')
                  ->orWhere('TEL_MOVIL', 'like', '%' . $this->search . '%');
            });
        }

        $dcliadms = $query->orderBy('NOMRESP')->paginate(10);

        // Obtener los códigos de cliente de la página actual
        $referencias = $dcliadms->pluck('REFERENCIA')->toArray();

        // Buscar registros de lectura relacionados y agrupar por cliente
        $registros = RegistroLecturas::whereIn('cliente', $referencias)
            ->latest()
            ->get()
            ->groupBy('cliente');

        // Log opcional
        \Log::info(DB::getQueryLog());

        return view('livewire.admin.dcliadm-grid', [
            'dcliadms' => $dcliadms,
            'registros' => $registros,
        ]);
    }
}