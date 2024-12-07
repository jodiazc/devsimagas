@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Importar Pagos</h1>
@stop
@section('content')

<div class="card">
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.payments.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="file">Selecciona un archivo CSV:</label>
                <input type="file" name="file" id="file" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Importar</button>
        </form>
    </div>
</div>
@stop

