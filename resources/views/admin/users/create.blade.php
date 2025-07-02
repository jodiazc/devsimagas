@extends('adminlte::page')

@section('title', 'Crear Usuario')

@section('content_header')
    <h1>Crear Usuario</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif            
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Nombre</label>
                    <input name="name" class="form-control" value="{{ old('name') }}">
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input name="email" class="form-control" value="{{ old('email') }}">
                </div>

                <div class="form-group">
                    <label>Contraseña</label>
                    <input type="password" name="password" class="form-control">
                </div>

                <div class="form-group">
                    <label>Confirmar Contraseña</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>

                <div class="form-group">
                    <label>Roles</label><br>
                    @foreach ($roles as $role)
                        <label>
                            <input type="checkbox" name="roles[]" value="{{ $role->id }}">
                            {{ $role->name }}
                        </label><br>
                    @endforeach
                </div>

                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@stop