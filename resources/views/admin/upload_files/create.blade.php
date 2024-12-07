@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Alta de archivos</h1>
@stop

@section('content')
    <div class="container">
        <form action="{{ route('admin.upload_files.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="file" class="form-label">Selecciona un archivo</label>
                <input type="file" name="file" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Subir</button>
        </form>
    </div>
@stop

