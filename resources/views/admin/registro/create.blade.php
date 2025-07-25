@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Registro de Lecturas</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <p><strong>Almacén:</strong> {{ $almacen }}</p>
            <p><strong>Cliente:</strong> {{ $cliente }}</p>

            <div class="row">
                <!-- Columna izquierda: formulario -->
                <div class="col-md-4">
                    <form id="formRegistro" action="{{ route('admin.registro.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="lectura_final">Lectura final:</label>
                            <input type="text" name="lectura_final" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="observaciones">Observaciones:</label>
                            <input type="text" name="observaciones" class="form-control" required>
                        </div>                        

                        <input type="hidden" name="almacen" value="{{ $almacen }}">
                        <input type="hidden" name="cliente" value="{{ $cliente }}">

                        <div class="form-group">
                            <label for="imagen_lectura">Archivo / Foto:</label>
                            <input
                                type="file"
                                name="imagen_lectura"
                                id="imagen_lectura"
                                class="form-control-file"
                                accept="image/*,application/pdf"
                                capture="environment">
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Enviar</button>
                    </form>
                </div>

                <!-- Columna derecha: preview -->
                <div class="col-md-8">
                    <h5>Vista previa</h5>
                    <div id="previewContainer" class="border p-2 rounded" style="min-height: 100px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación Bootstrap -->
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="confirmModalLabel">Confirmar envío</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que los datos ingresados son correctos y deseas enviarlos?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="confirmSubmit" class="btn btn-primary">Sí, enviar</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('imagen_lectura');
        const previewContainer = document.getElementById('previewContainer');
        const form = document.getElementById('formRegistro');
        const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
        let allowSubmit = false;

        // Vista previa
        if (input && previewContainer) {
            input.addEventListener('change', function(event) {
                const file = event.target.files[0];
                previewContainer.innerHTML = '';

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        if (file.type.startsWith('image/')) {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.classList.add('img-fluid', 'rounded', 'shadow');
                            img.style.maxWidth = '100%';
                            previewContainer.appendChild(img);
                        } else if (file.type === 'application/pdf') {
                            const embed = document.createElement('embed');
                            embed.src = e.target.result;
                            embed.type = 'application/pdf';
                            embed.width = '100%';
                            embed.height = '400px';
                            embed.classList.add('border');
                            previewContainer.appendChild(embed);
                        } else {
                            previewContainer.innerHTML = '<p class="text-danger">Tipo de archivo no compatible para vista previa.</p>';
                        }
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        // Interceptar el envío y mostrar modal
        if (form) {
            form.addEventListener('submit', function(e) {
                if (!allowSubmit) {
                    e.preventDefault();
                    confirmModal.show();
                }
            });
        }

        // Confirmar desde el modal
        document.getElementById('confirmSubmit').addEventListener('click', function () {
            allowSubmit = true;
            confirmModal.hide();
            form.submit();
        });
    });
</script>
@stop