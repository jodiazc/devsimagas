@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="container">
        <h1>Editar Archivo</h1>
        <form action="{{ route('admin.upload_files.update', $file->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="file" class="form-label">Selecciona un nuevo archivo (opcional)</label>
                <input type="file" name="file" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
    </div>
@stop

