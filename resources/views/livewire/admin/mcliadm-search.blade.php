<div>
    <div class="d-flex mb-2">
        <input
            type="text"
            id="busquedaInput"
            class="form-control me-2"
            placeholder="Buscar por nombre o contacto..."
            autocomplete="off"
            list="sugerencias"
            wire:model.defer="search"
            wire:input="verificarSeleccion"
        />

        <button class="btn btn-primary" wire:click="buscar" type="button">
            Buscar
        </button>
    </div>

    <datalist id="sugerencias">
        @foreach ($sugerencias as $sugerencia)
            <option value="{{ $sugerencia['value'] }}">{{ $sugerencia['label'] }}</option>
        @endforeach
    </datalist>

    @if (!empty($clientesPorBusqueda) && $mostrarResultados)
        <ul class="nav nav-tabs mt-3">
            @foreach ($clientesPorBusqueda as $key => $resultados)
                <li class="nav-item">
                    <a href="#"
                       class="nav-link @if($activeTab == $key) active @endif"
                       wire:click.prevent="$set('activeTab', '{{ $key }}')">
                        {{ $key }}
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="tab-content mt-3">
            @foreach ($clientesPorBusqueda as $key => $clientes)
                @if ($activeTab == $key)
                    <div class="tab-pane fade show active">
                        <div class="row">
                            <div class="col-md-4">
                                @foreach ($clientes as $cliente)
                                    <div class="card mb-2 p-2">
                                        <div class="card-body p-2">
                                            <div class="row">
                                                <div class="col-6">
                                                    <p class="mb-1"><strong>Nº Almacén:</strong> {{ $cliente->K_CLIADM ?? '-' }}</p>
                                                    <p class="mb-1"><strong>Nombre:</strong> {{ $cliente->NOMRESP ?? '-' }}</p>
                                                    <p class="mb-1"><strong>Dirección:</strong> {{ $cliente->DIRECCION1 ?? '-' }}</p>
                                                    <p class="mb-1"><strong>Contacto:</strong> {{ $cliente->TEL_MOVIL ?? '-' }}</p>
                                                    <p class="mb-1"><strong>Correo:</strong> {{ $cliente->CORREO_E ?? '-' }}</p>
                                                    <p class="mb-1"><strong>Capacidad:</strong> {{ $cliente->K_TANQUE ?? '-' }}</p>
                                                </div>
                                                <div class="col-6">
                                                    <p class="mb-1"><strong>Google Maps:</strong> {{ $cliente->DIRECCION_GOOGLE ?? '-' }}</p>
                                                    <p class="mb-1"><strong>Grupo:</strong> {{ $cliente->ID_GRUPO_RUTA ?? '-' }}</p>
                                                    <p class="mb-1"><strong>Ruta:</strong> {{ $cliente->RUTA ?? '-' }}</p>
                                                    <p class="mb-1"><strong>Unidad:</strong> {{ $cliente->UNIDAD ?? '-' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="col-md-8">
                                @php $primerCliente = $clientes[0] ?? null; @endphp

                                @if ($primerCliente)
                                    <div class="card h-100">
                                        <div class="card-body">
                                            @livewire('admin.dcliadm-grid', ['kCliadm' => $primerCliente->K_CLIADM], key($primerCliente->K_CLIADM))
                                        </div>
                                    </div>
                                @else
                                    <p class="text-muted">No hay cliente seleccionado para mostrar el grid.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endif
</div>