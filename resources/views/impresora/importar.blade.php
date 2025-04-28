@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Importar Impresoras</h1>

    <div class="alert alert-info">
        <h5>Instrucciones:</h5>
        <p>Por favor, asegúrese de que su archivo CSV contiene las siguientes columnas:</p>
        <ul>
            <li>ip</li>
            <li>sede_rcja</li>
            <li>tipo</li>
            <li>num_contrato</li>
            <li>organismo</li>
            <li>descripcion</li>
        </ul>
    </div>

    <div id="alertMessages" style="display: none;" class="alert" role="alert"></div>

    <div class="card">
        <div class="card-body">
            <form id="importForm" action="{{ route('impresoras.importar') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-3">
                    <label for="csv_file">Seleccionar archivo CSV</label>
                    <input type="file" class="form-control" id="csv_file" name="csv_file" accept=".csv" required>
                </div>
                <button type="submit" class="btn btn-primary">Importar</button>
                <a href="{{ route('impresoras.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#importForm').on('submit', function(e) {
            e.preventDefault();
            
            let formData = new FormData(this);
            
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#alertMessages')
                        .removeClass('alert-danger')
                        .addClass('alert-success')
                        .html(response.message)
                        .show();
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessage = '<ul class="mb-0">';
                    
                    if (typeof errors === 'object') {
                        $.each(errors, function(key, value) {
                            errorMessage += '<li>' + value + '</li>';
                        });
                    } else {
                        errorMessage += '<li>' + xhr.responseJSON.message + '</li>';
                    }
                    
                    errorMessage += '</ul>';
                    
                    $('#alertMessages')
                        .removeClass('alert-success')
                        .addClass('alert-danger')
                        .html(errorMessage)
                        .show();
                }
            });
        });
    });
</script>
@endpush
@endsection
