@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Listado de Lecturas</h1>
@stop
@section('content')

<div class="container mx-auto py-6">
    <h1 class="text-2xl font-bold mb-4">Listado de Almacenes</h1>

    @livewire('admin.almacenes-listado') {{-- Este es el componente Livewire que creaste --}}
</div>
@stop
