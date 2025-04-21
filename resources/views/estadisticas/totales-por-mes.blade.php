@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h2>Estadísticas Mensuales de Impresiones</h2>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Año</th>
                                        <th>Mes</th>
                                        <th>Total Impresiones</th>
                                        <th>Impresoras Activas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($totales as $anio => $meses)
                                        @foreach ($meses as $mes => $datos)
                                            <tr>
                                                <td>{{ $anio }}</td>
                                                <td>{{ mb_strtoupper(\Carbon\Carbon::create()->locale('es')->month($mes)->translatedFormat('F')) }}
                                                </td>
                                                <td>{{ number_format($datos['total_paginas']) }}</td>
                                                <td>{{ $datos['total_impresoras'] }}</td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
