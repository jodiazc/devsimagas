<div style="position: relative; width: 100%; max-width: 90%;">
    <div
        class="d-flex mb-3 align-items-center"
        style="gap: 0.5rem; width: 100%; position: relative;"
    >
        <input
            type="text"
            id="busquedaInput"
            class="form-control"
            placeholder="Buscar seleccionar uno..."
            autocomplete="off"
            wire:model="search"
            wire:input="verificarSeleccion"
            wire:focus="$set('mostrarLista', true)"
            wire:keydown.escape="$set('mostrarLista', false)"
            wire:keydown.tab="$set('mostrarLista', false)"
            wire:keydown.enter.prevent="buscar"
            style="padding-right: 2.5rem;"
        />

        <button
            type="button"
            wire:click="buscar"
            title="Buscar"
            style="
                position: absolute;
                right: 10px;
                top: 50%;
                transform: translateY(-50%);
                border: none;
                background: transparent;
                cursor: pointer;
                padding: 0;
                margin: 0;
                color: #6c757d;
                font-size: 1.25rem;
                line-height: 1;
            "
            aria-label="Buscar"
        >
            🔍
        </button>
    </div>

    @if (!empty($sugerencias) && $mostrarLista)
        <div
            style="
                position: relative;
                top: 100%;
                left: 0;
                right: 0;
                background-color: white;
                z-index: 1050;
                border: 1px solid #ced4da;
                border-top: none;
                border-radius: 0 0 0.25rem 0.25rem;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                max-height: 200px;
                overflow-y: auto;
                margin-top: 0;
            "
        >
            @foreach ($sugerencias as $sugerencia)
                <div
                    style="padding: 8px 12px; cursor: pointer; border-bottom: 1px solid #eee;"
                    wire:click="seleccionar('{{ $sugerencia['value'] }}')"
                    tabindex="0"
                >
                    {{ $sugerencia['label'] }}
                </div>
            @endforeach
        </div>
    @endif

    @if (!empty($clientesPorBusqueda) && $mostrarResultados)
        <ul class="nav nav-tabs mt-3 flex-wrap">
            @foreach ($clientesPorBusqueda as $key => $resultados)
                <li class="nav-item">
                    <a
                        href="#"
                        class="nav-link @if ($activeTab == $key) active @endif"
                        wire:click.prevent="$set('activeTab', '{{ $key }}')"
                    >
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
                            <div class="col-md-4 col-12">
                                @foreach ($clientes as $cliente)
                                    <div class="card mb-2 p-2">
                                        <div class="card-body p-2">
                                            <div class="row">
                                                <div class="col-6">
                                                    <p class="mb-1">
                                                        <strong>Nº Almacén:</strong>
                                                        {{ $cliente->K_CLIADM ?? '-' }}
                                                    </p>
                                                    <p class="mb-1">
                                                        <strong>Nombre:</strong>
                                                        {{ $cliente->NOMRESP ?? '-' }}
                                                    </p>
                                                    <p class="mb-1">
                                                        <strong>Dirección:</strong>
                                                        {{ $cliente->DIRECCION1 ?? '-' }}
                                                    </p>
                                                    <p class="mb-1">
                                                        <strong>Contacto:</strong>
                                                        {{ $cliente->TEL_MOVIL ?? '-' }}
                                                    </p>
                                                    <p class="mb-1">
                                                        <strong>Correo:</strong>
                                                        {{ $cliente->CORREO_E ?? '-' }}
                                                    </p>
                                                    <p class="mb-1">
                                                        <strong>Capacidad:</strong>
                                                        {{ $cliente->K_TANQUE ?? '-' }}
                                                    </p>
                                                </div>
                                                <div class="col-6">
                                                    <p class="mb-1">
                                                        <strong>Google Maps:</strong>
                                                        {{ $cliente->DIRECCION_GOOGLE ?? '-' }}
                                                    </p>
                                                    <p class="mb-1">
                                                        <strong>Grupo:</strong>
                                                        {{ $cliente->ID_GRUPO_RUTA ?? '-' }}
                                                    </p>
                                                    <p class="mb-1">
                                                        <strong>Ruta:</strong>
                                                        {{ $cliente->RUTA ?? '-' }}
                                                    </p>
                                                    <p class="mb-1">
                                                        <strong>Unidad:</strong>
                                                        {{ $cliente->UNIDAD ?? '-' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="col-md-8 col-12">
                                @php
                                    $primerCliente = $clientes[0] ?? null;
                                @endphp

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

@push('styles')
<style>
    .rounded-bottom-0 {
        border-bottom-left-radius: 0 !important;
        border-bottom-right-radius: 0 !important;
    }

    .autocomplete-list {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background-color: white;
        z-index: 1050;
        border: 1px solid #ced4da;
        border-top: none;
        border-radius: 0 0 0.25rem 0.25rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        max-height: 200px;
        overflow-y: auto;
        margin-top: 0;
    }

    .autocomplete-item {
        padding: 8px 12px;
        cursor: pointer;
        border-bottom: 1px solid #eee;
    }

    .autocomplete-item:last-child {
        border-bottom: none;
    }

    .autocomplete-item:hover,
    .autocomplete-item:focus {
        background-color: #f8f9fa;
        color: #212529;
    }

    #busquedaInput {
        width: 100%;
    }
</style>
@endpush