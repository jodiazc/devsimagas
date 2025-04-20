@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Listado de Lecturas</h1>
@stop
@section('content')

    @if($registros->isEmpty())
        <p>No hay registros aún.</p>
    @else
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Ciente</th>
                <th>lectura_inicial</th>
                <th>lectura_final</th>
                <th>Archivo</th>
                <th>Fecha</th>
            </tr>
            </thead>
            <tbody>
            @foreach($registros as $registro)
                <tr>
                    <td>{{ $registro->cliente }}</td>
                    <td>{{ $registro->lectura_inicial }}</td>
                    <td>{{ $registro->lectura_final }}</td>
                    <td>
                        @php
                            $extension = pathinfo($registro->imagen_lectura, PATHINFO_EXTENSION);
                        @endphp

                        @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png']))
                            <img src="{{ asset('storage/app/public/' . $registro->imagen_lectura) }}" alt="Imagen" width="250" height="250">
                        @elseif($extension === 'pdf')
                            <a href="{{ asset('storage/' . $registro->imagen_lectura) }}" target="_blank">📄 Ver PDF</a>
                        @else
                            <a href="{{ asset('storage/' . $registro->imagen_lectura) }}" target="_blank">📎 Descargar archivo</a>
                        @endif
                    </td>
                    <td>{{ $registro->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@stop
