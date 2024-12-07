<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    <div class="card">
        <div class="card-header">
            <input class="form-control" type="text" wire:model.live="search" placeholder="Buscar usuarios..." />
        </div>
        @if($users->count())
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td width="10px">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">editar</a>
                            </td>
                        </tr>                        
                    @endforeach
                </tbody>
            </table>    
        </div>
        <div class="card-footer">
            {{ $users->links() }}            
        </div>
        @else
            <div class="card-body">
                <strong>No hay registros.</strong>
            </div>
        @endif
    </div>
</div>
