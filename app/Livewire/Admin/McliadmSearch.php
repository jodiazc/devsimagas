<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Mcliadm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class McliadmSearch extends Component
{
    public $search = '';
    public $clientesPorBusqueda = [];
    public $activeTab = null;
    public $queryDebug = '';
    public $sugerencias = [];
    public $mostrarResultados = false;
    public $mostrarSugerenciasDebug = false;
    public $mostrarLista = false;
    public $almacen = null;
    public $successMessage = null;

    public function updatedSearch()
    {
        if (trim($this->search) === '') {
            $this->sugerencias = [];
            return;
        }

        $this->sugerencias = $this->generarSugerencias($this->search);
    }

    public function verificarSeleccion()
    {
        $coincidencia = collect($this->sugerencias)->firstWhere('value', $this->search);

        if ($coincidencia) {
            $this->buscar();
            $this->mostrarResultados = true;
        }
    }

    private function generarSugerencias($search)
    {
        $query = Mcliadm::query()
            ->whereRaw("TRIM(UPPER(ESTATUS)) = 'A'")
            ->where(function ($q) use ($search) {
                if (ctype_digit($search)) {
                    $q->whereRaw("CAST(K_CLIADM AS UNSIGNED) LIKE ?", ["%{$search}%"]);
                } else {
                    $q->where(function ($sub) use ($search) {
                        $sub->where('NOMRESP', 'like', '%' . $search . '%')
                            ->orWhereRaw("CAST(K_CLIADM AS CHAR) LIKE ?", ["%{$search}%"]);
                    });
                }
            });

        // Log para depuración
        $sql = $this->interpolateQuery($query->toSql(), $query->getBindings());
        Log::info('[McliadmSearch] Query generarSugerencias: ' . $sql);

        // Solo las columnas necesarias para el autocompletado
        $resultados = $query->get(['K_CLIADM', 'NOMRESP']);

        return $resultados->map(function ($item) {
            return [
                'id' => $item->K_CLIADM,
                'label' => $item->NOMRESP . ' (Almacén: ' . $item->K_CLIADM . ')',
                'value' => $item->NOMRESP,
            ];
        })->toArray();
    }

    public function buscar()
    {
        $search = trim($this->search);
        if ($search === '') return;

        $query = Mcliadm::query()
            ->whereRaw("TRIM(UPPER(ESTATUS)) = 'A'")
            ->where(function ($q) use ($search) {
                if (ctype_digit($search)) {
                    $q->whereRaw("CAST(K_CLIADM AS UNSIGNED) = ?", [$search]);
                } else {
                    $q->where(function ($sub) use ($search) {
                        $sub->where('NOMRESP', 'like', "%{$search}%")
                            ->orWhereRaw("CAST(K_CLIADM AS CHAR) LIKE ?", ["%{$search}%"]);
                    });
                }
            });

        // Log para depuración
        $this->queryDebug = $this->interpolateQuery($query->toSql(), $query->getBindings());
        Log::info('[McliadmSearch] Query buscar: ' . $this->queryDebug);

        // Limpiar resultados previos para evitar acumulación
        $this->clientesPorBusqueda = [];

        // Ahora trae TODAS las columnas de la tabla
        $resultados = $query->get();

        if ($resultados->isNotEmpty()) {
            $coincidencia = collect($this->sugerencias)->firstWhere('value', $this->search);

            $key = $coincidencia['label']
                ?? (ctype_digit($search) ? "Código: {$search}" : "Resultados para '{$search}'");

            $this->clientesPorBusqueda = [$key => $resultados->values()];
            $this->activeTab = $key;
            $this->mostrarResultados = true;
        } else {
            $this->clientesPorBusqueda = [];
            $this->mostrarResultados = false;
            $this->activeTab = null;
        }
    }

    public function seleccionar($value)
    {
        $this->search = $value;
        $this->mostrarLista = false;
        $this->buscar();
        $this->mostrarResultados = true;
    }

    public function mount(Request $request)
    {
        if ($request->filled('almacen')) {
            $this->search = $request->almacen;
            $this->buscar();
            $this->mostrarResultados = true;
        }
        if (session()->has('success')) {
            $this->successMessage = session('success');
        }
    }

    public function render()
    {
        return view('livewire.admin.mcliadm-search', [
            'almacen' => $this->almacen,
        ]);
    }

    public function clearSuccessMessage()
    {
        $this->successMessage = null;
    }

    private function interpolateQuery($sql, $bindings)
    {
        foreach ($bindings as $binding) {
            $binding = is_numeric($binding) ? $binding : "'" . addslashes($binding) . "'";
            $sql = preg_replace('/\?/', $binding, $sql, 1);
        }
        return $sql;
    }
}