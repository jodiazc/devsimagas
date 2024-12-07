@extends('adminlte::page')

@section('title', 'Usuarios')

@can('admin.users.index')
@section('content_header')
    <h1>Lista de Usuarios</h1>
@stop
@else 
<div>
    <strong>NO tienes Permisos para ver el listado</strong>
</div>
@endcan
@section('content')
    @can('admin.users.index')
        @livewire('admin.users-index')    
    @else 
        <div>
            <strong>NO tienes Permisos para ver el listado</strong>
        </div>
    @endcan
    
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
