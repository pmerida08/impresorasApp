@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Filtrar PDF de Impresoras</div>

                <div class="card-body">
                    <form method="GET" action="{{ route('impresoras.pdf.filtered') }}">
                        <div class="row mb-3">
                            <span class="row-md-6 fst-italic text-muted">Introduce el rango de fechas para saber las páginas impresas</span>
                            <div class="col-md-6">
                                <label for="start_date" class="form-label">Fecha Inicio</label>
                                <input type="date" class="form-control" id="start_date" name="start_date">
                            </div>
                            <div class="col-md-6">
                                <label for="end_date" class="form-label">Fecha Fin</label>
                                <input type="date" class="form-control" id="end_date" name="end_date">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="range_paginas" class="form-label">Mínimo de páginas impresas</label>
                                <input type="number" class="form-control" id="range_paginas" name="range_paginas" value="0" min="0" placeholder="Ej: 1000">
                                <small class="form-text text-muted">Mostrar impresoras con al menos este número de páginas en el período</small>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="tipo" class="form-label">Tipo</label>
                                <input type="text" class="form-control" id="tipo" name="tipo">
                            </div>
                            <div class="col-md-6">
                                <label for="ubicacion" class="form-label">Ubicación</label>
                                <input type="text" class="form-control" id="ubicacion" name="ubicacion">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="ip" class="form-label">IP</label>
                                <input type="text" class="form-control" id="ip" name="ip">
                            </div>
                            <div class="col-md-6">
                                <label for="usuario" class="form-label">Usuario</label>
                                <input type="text" class="form-control" id="usuario" name="usuario">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="sede_rcja" class="form-label">Sede RCJA</label>
                                <input type="text" class="form-control" id="sede_rcja" name="sede_rcja">
                            </div>
                            <div class="col-md-6">
                                <label for="organismo" class="form-label">Organismo</label>
                                <input type="text" class="form-control" id="organismo" name="organismo">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="contrato" class="form-label">Contrato</label>
                                <input type="text" class="form-control" id="contrato" name="contrato">
                            </div>
                            <div class="col-md-6">
                                <label for="numero_serie" class="form-label">Nº de serie</label>
                                <input type="text" class="form-control" id="numero_serie" name="numero_serie">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="color" name="color" value="1">
                                    <label class="form-check-label" for="color">Color</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Generar PDF</button>
                                <a href="{{ route('impresoras.index') }}" class="btn btn-secondary">Volver</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
