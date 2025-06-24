<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Mcliadm;
use Illuminate\Http\Request;

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
        // No ocultar resultados aquí, solo limpiar sugerencias si está vacío
        if (trim($this->search) === '') {
            $this->sugerencias = [];
            // No cambiar $mostrarResultados para que se mantengan tabs visibles
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
        // No ocultar resultados si no hay coincidencia, solo no mostrar sugerencias nuevas
    }

    private function generarSugerencias($search)
    {
        $query = Mcliadm::query();

        if (ctype_digit($search)) {
            $query->whereRaw("CAST(K_CLIADM AS UNSIGNED) LIKE ?", ["%{$search}%"]);
        } else {
            $query->where('NOMRESP', 'like', '%' . $search . '%')
                  ->orWhereRaw("CAST(K_CLIADM AS CHAR) LIKE ?", ["%{$search}%"]);
        }

        $resultados = $query->limit(5)->get(['K_CLIADM', 'NOMRESP']);

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

        if ($search === '') {
            return; // No limpiar búsquedas previas ni ocultar tabs
        }

        if (ctype_digit($search)) {
            $query = Mcliadm::whereRaw("CAST(K_CLIADM AS UNSIGNED) = ?", [$search]);
        } else {
            $query = Mcliadm::where('NOMRESP', 'like', "%{$search}%");
        }

        $this->queryDebug = $this->interpolateQuery($query->toSql(), $query->getBindings());

        $resultados = $query->get();

        if ($resultados->isNotEmpty()) {
            $coincidencia = collect($this->sugerencias)->firstWhere('value', $this->search);

            if ($coincidencia) {
                $key = $coincidencia['label'];
            } elseif (ctype_digit($search)) {
                $key = "Código: {$search}";
            } else {
                $key = "Resultados para '{$search}'";
            }

            // Reemplazar todo el contenido para evitar acumulación de tabs
            $this->clientesPorBusqueda = [
                $key => $resultados->values(),
            ];

            $this->activeTab = $key;
            $this->mostrarResultados = true;
        } else {
            // Opcional: limpiar resultados si no hay coincidencias
            $this->clientesPorBusqueda = [];
            $this->mostrarResultados = false;
            $this->activeTab = null;
        }
    }

    public function seleccionar($value)
    {
        // Asignar valor seleccionado al input
        $this->search = $value;

        // Ocultar la lista de sugerencias
        $this->mostrarLista = false;

        // Llamar buscar para mostrar resultados correspondientes
        $this->buscar();
        $this->mostrarResultados = true;
    }

    public function mount(Request $request)
    {
        if ($request->filled('almacen')) {
            $this->search = $request->almacen;
            $this->buscar(); // Ejecuta la búsqueda usando el valor inicial
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