@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Lista de Archivos</h1>
@stop

@section('content')
    <div class="container">
        <a href="{{ route('admin.upload_files.create') }}" class="btn btn-primary">Agregar archivo</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($files as $file)
                <tr>
                    <td>{{ $file->id }}</td>
                    <td>{{ $file->filename }}</td>
                    <td>
                        <a href="{{ url('/uploads/files/' . $file->filename) }}" class="btn btn-info" target="_blank">Ver Archivo</a>
                        <a href="{{ route('admin.upload_files.edit', $file->id) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('admin.upload_files.destroy', $file->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop
