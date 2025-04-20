@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Listado de Pagos</h1>
@stop
@section('content')
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif
    <p><strong>Almacén:</strong> {{ $almacen }}</p>
    <p><strong>Cliente:</strong> {{ $cliente }}</p>
    <form action="{{ route('admin.registro.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label for="cliente">Nombre:</label>
        <input type="text" name="cliente" required><br><br>

        <label for="lectura_inicial">lectura_inicial:</label>
        <input type="text" name="lectura_inicial" required><br><br>

        <label for="lectura_final">lectura_final:</label>
        <input type="text" name="lectura_final" required><br><br>
        <input type="hidden" name="almacen" value="{{ $almacen }}"><br><br>
        <input type="hidden" name="cliente" value="{{ $cliente }}"><br><br>

        <label for="archivo">Archivo / Foto:</label>
        <input
            type="file"
            name="imagen_lectura"
            accept="image/*,application/pdf"
            capture="environment"><br><br>

        <button type="submit">Enviar</button>
    </form>
@stop
