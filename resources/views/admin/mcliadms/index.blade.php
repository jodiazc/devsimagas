@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Listado de Clientes Administrativos</h1>
@stop
@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @livewireStyles
    @livewire('admin.mcliadm-search')
    @livewireScripts
@stop

