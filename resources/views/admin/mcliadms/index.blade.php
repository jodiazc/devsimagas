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

@section('js')
    <script>
    /*document.addEventListener('DOMContentLoaded', function () {
        const message = document.querySelector('.alert-success');

        if (message) {
            setTimeout(() => {
                message.remove(); // Elimina completamente el div del DOM
            }, 5000); // Espera 5 segundos
        }
    });*/
    document.addEventListener('DOMContentLoaded', function () {
        const messages = document.querySelectorAll('.alert-success');
        messages.forEach((msg) => {
            setTimeout(() => {
                msg.style.transition = "opacity 0.5s ease";
                msg.style.opacity = "0";
                setTimeout(() => {
                    msg.style.display = "none";
                }, 500);
            }, 5000);
        });
    });         
    </script>    
@stop