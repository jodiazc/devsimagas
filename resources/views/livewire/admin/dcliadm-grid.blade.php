<div>
    <!--div class="mb-3 d-flex">
        <input wire:model.debounce.500ms="search" type="text" class="form-control" placeholder="Buscar por nombre o contacto...">
    </div-->

    @if ($dcliadms->count())
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-primary">
                    <tr>
                        <th>Almacen</th>
                        <th>Cliente</th>
                        <th>Depa</th>
                        <th>Estatus</th>
                        <th>Procesar</th>
                        <th>Lectura</th>
                        <th>Foto</th>
                        <th>Observacion</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dcliadms as $dcliadm)
                        @php
                            $lecturasCliente = $registros[$dcliadm->REFERENCIA] ?? collect();
                            $ultimaLectura = $lecturasCliente->first();
                        @endphp
                        <tr>
                            <td>{{ $dcliadm->K_CLIADM ?? '-' }}</td>
                            <td>{{ $dcliadm->REFERENCIA ?? '-' }}</td>
                            <td>{{ $dcliadm->DEPTO ?? '-' }}</td>
                            <td>{{ $dcliadm->ESTATUS ?? '-' }}</td>
                            <td>
                                <a href="{{ route('admin.registro.create', ['almacen' => $dcliadm->K_CLIADM, 'cliente' => $dcliadm->REFERENCIA]) }}" class="btn btn-sm btn-info">Procesar</a>
                            </td>
                            <td>
                                {{ $ultimaLectura?->lectura_final ?? 'Sin lectura' }}
                            </td>
                            <td>
                                @if ($ultimaLectura?->imagen_lectura)
                                    <a href="{{ asset('public/storage/' . $ultimaLectura->imagen_lectura) }}" target="_blank">Ver foto</a>
                                @else
                                    <span class="text-muted">Sin foto</span>
                                @endif
                            </td>
                            <td>
                                {{ $ultimaLectura?->observaciones ?? 'Sin observación' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $dcliadms->links() }}
        </div>
    @else
        <div class="alert alert-warning">
            No se encontraron resultados.
        </div>
    @endif
</div>