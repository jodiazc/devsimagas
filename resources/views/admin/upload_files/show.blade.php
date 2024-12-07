@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="container">
        <h1>Detalles del Archivo</h1>
        <p><strong>ID:</strong> {{ $file->id }}</p>
        <p><strong>Nombre:</strong> {{ $file->filename }}</p>
        <p><strong>Ruta:</strong> {{ $file->path }}</p>
        <a href="{{ route('admin.upload_files.index') }}" class="btn btn-primary">Volver a la lista</a>
    </div>
@stop

