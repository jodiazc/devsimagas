@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Listado de Pagos</h1>
@stop
@section('content')
    @livewire('admin.payment-links')
@stop

