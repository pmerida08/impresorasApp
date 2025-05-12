<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Impresoras</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .filters {
            margin-bottom: 20px;
            font-size: 12px;
        }

        .filter-item {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 4px;
            text-align: left;
            font-size: 10px;
            word-break: break-word;
            overflow: hidden;
        }

        th {
            background-color: #f2f2f2;
        }

        .title {
            text-align: center;
            margin-bottom: 20px;
        }

        .date-range {
            text-align: center;
            margin-bottom: 15px;
            font-style: italic;
        }

        .pages-total {
            font-weight: bold;
            text-align: right;
            margin-top: 10px;
            padding: 10px;
            border-top: 2px solid #000;
        }

        .text-right {
            text-align: right;
        }

        /* Ajustar anchos de columnas específicas */
        th:nth-child(1), td:nth-child(1) { width: 6%; } /* Tipo */
        th:nth-child(2), td:nth-child(2) { width: 12%; } /* Ubicación */
        th:nth-child(3), td:nth-child(3) { width: 8%; } /* IP */
        th:nth-child(4), td:nth-child(4) { width: 10%; } /* Usuario */
        th:nth-child(5), td:nth-child(5) { width: 10%; } /* Sede RCJA */
        th:nth-child(6), td:nth-child(6) { width: 10%; } /* Organismo */
        th:nth-child(7), td:nth-child(7) { width: 8%; } /* Contrato */
        th:nth-child(8), td:nth-child(8) { width: 10%; } /* Nº Serie */
        th:nth-child(9), td:nth-child(9) { width: 6%; } /* Color */
    </style>
</head>

<body>
    <div class="title">
        <h2>Reporte de Impresoras</h2>
    </div>

    @if ($start_date || $end_date)
        <div class="date-range">
            Período: {{ $start_date ?? 'Inicio' }} al {{ $end_date ?? 'Fin' }}
        </div>
    @endif

    <div class="filters">
        <h3>Filtros Aplicados:</h3>
        @foreach ($filters as $field => $value)
            @if ($value)
                <div class="filter-item">
                    {{ ucfirst($field) }}:
                    @if ($field === 'color')
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
                @if ($start_date && $end_date)
                    <th>Páginas Totales</th>
                    <th>Páginas B/N</th>
                    <th>Páginas Color</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @php
                $totalPaginas = 0;
                $totalPaginasBW = 0;
                $totalPaginasColor = 0;
            @endphp
            @foreach ($impresoras as $impresora)
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
                    @if ($start_date && $end_date)
                        <td class="text-right">{{ number_format($impresora->total_paginas, 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($impresora->total_paginas_bw, 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($impresora->total_paginas_color, 0, ',', '.') }}</td>
                        @php
                            $totalPaginas += $impresora->total_paginas;
                            $totalPaginasBW += $impresora->total_paginas_bw;
                            $totalPaginasColor += $impresora->total_paginas_color;
                        @endphp
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>

    @if ($start_date && $end_date)
        <div class="pages-total">
            <p>Total de páginas en el período: {{ number_format($totalPaginas, 0, ',', '.') }}</p>
            <p>Total de páginas B/N en el período: {{ number_format($totalPaginasBW, 0, ',', '.') }}</p>
            <p>Total de páginas Color en el período: {{ number_format($totalPaginasColor, 0, ',', '.') }}</p>
        </div>
    @endif
</body>

</html>