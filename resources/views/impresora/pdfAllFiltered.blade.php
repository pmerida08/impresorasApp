<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Impresoras</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .filters { margin-bottom: 20px; font-size: 12px; }
        .filter-item { margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f5f5f5; }
        .title { text-align: center; margin-bottom: 20px; }
        .date-range { text-align: center; margin-bottom: 15px; font-style: italic; }
        .pages-total { 
            font-weight: bold; 
            text-align: right; 
            margin-top: 10px;
            padding: 10px;
            border-top: 2px solid #000;
        }
    </style>
</head>
<body>
    <div class="title">
        <h2>Reporte de Impresoras</h2>
    </div>

    @if($start_date || $end_date)
        <div class="date-range">
            Período: {{ $start_date ?? 'Inicio' }} al {{ $end_date ?? 'Fin' }}
        </div>
    @endif

    <div class="filters">
        <h3>Filtros Aplicados:</h3>
        @foreach($filters as $field => $value)
            @if($value)
                <div class="filter-item">
                    {{ ucfirst($field) }}: 
                    @if($field === 'color')
                        Sí
                    @else
                        {{ $value }}
                    @endif
                </div>
            @endif
        @endforeach
    </div>

    <table>
        <thead>
            <tr>
                <th>Tipo</th>
                <th>Ubicación</th>
                <th>IP</th>
                <th>Usuario</th>
                <th>Sede RCJA</th>
                <th>Organismo</th>
                <th>Contrato</th>
                <th>Nº Serie</th>
                <th>Color</th>
                @if($start_date && $end_date)
                    <th>Páginas Totales</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @php
                $totalPaginas = 0;
            @endphp
            @foreach($impresoras as $impresora)
                <tr>
                    <td>{{ $impresora->tipo }}</td>
                    <td>{{ $impresora->ubicacion }}</td>
                    <td>{{ $impresora->ip }}</td>
                    <td>{{ $impresora->usuario }}</td>
                    <td>{{ $impresora->sede_rcja }}</td>
                    <td>{{ $impresora->organismo }}</td>
                    <td>{{ $impresora->contrato }}</td>
                    <td>{{ $impresora->num_serie }}</td>
                    <td>{{ $impresora->color ? 'Sí' : 'No' }}</td>
                    @if($start_date && $end_date)
                        <td style="text-align: right;">{{ number_format($impresora->total_paginas, 0, ',', '.') }}</td>
                        @php
                            $totalPaginas += $impresora->total_paginas;
                        @endphp
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>

    @if($start_date && $end_date)
        <div class="pages-total">
            Total de páginas en el período: {{ number_format($totalPaginas, 0, ',', '.') }}
        </div>
    @endif
</body>
</html>
