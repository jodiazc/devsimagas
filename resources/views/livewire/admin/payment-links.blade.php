<div>
    {{-- Success is as dangerous as failure. --}}
    <div class="card">
        <div class="card-header">
            <table class="table table-borderless mb-0">
                <tr>
                    <td>
                        <input class="form-control me-3" type="text" wire:model="startDate" placeholder="Fecha inicial dd/mm/YYYY..." />
                    </td>
                    <td>
                        <input class="form-control me-3" type="text" wire:model="endDate" placeholder="Fecha final dd/mm/YYYY ... " />
                    </td>
                    <td>
                        <button class="btn btn-primary me-3" wire:click="applyFilter">Aplicar Filtro</button>
                    </td>
                </tr>
                <tr>
                    <td>
                        @can('admin.payments.export')
                            <a href="{{ route('admin.payments.export') }}" class="btn btn-success">Exportar a CSV</a>
                        @endcan
                    </td>
                </tr>
            </table>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>tipo_link</th>
                    <th>dlectura</th>
                    <td>cliente</td>
                    <td>pedido</td>
                    <td>importe</td>
                    <td>estatus</td>
                    <td>fecha_expiracion</td>
                    <td>fecha_elaboracion</td>
                    <td>insercion_al_modulo</td>
                    <th colspan="2"></th>
                </tr>
                </thead>
                <tbody>

                @foreach ($paymentLinks as $paymentLink)
                    <tr>
                        <td>{{ $paymentLink->id }}</td>
                        <td>{{ $paymentLink->tipo_liga }}</td>
                        <td>{{ $paymentLink->dlectura }}</td>
                        <td>{{ $paymentLink->cliente }}</td>
                        <td>{{ $paymentLink->pedido }}</td>
                        <td>{{ $paymentLink->importe }}</td>
                        <td>{{ $paymentLink->estaus }}</td>
                        <td>{{ $paymentLink->fecha_expiracion }}</td>
                        <td>{{ $paymentLink->fecha_elaboracion }}</td>
                        <td>{{ $paymentLink->insercion_al_modulo }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $paymentLinks->links() }}
        </div>

    </div>
</div>
