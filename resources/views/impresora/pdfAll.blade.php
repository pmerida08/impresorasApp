<?php
use Carbon\Carbon;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Impresoras</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 4px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h2>Listado de Impresoras - {{ Carbon::today()->format('d-m-Y') }}</h2>
    <table>
        <thead>
            <tr>
                <th>IP</th>
                <th>Modelo</th>
                <th>Ubicación</th>
                <th>Usuario</th>
                <th>Páginas Total</th>
                <th>Páginas BW</th>
                <th>Páginas Color</th>
                <th>MAC</th>
                <th>Nº Serie</th>
            </tr>
        </thead>
        <tbody>
            // TODO: Concretar que es lo que se quiere ver:
            @foreach ($impresoras as $impresora)
                <tr>
                    <td>{{ $impresora->ip }}</td>
                    <td>{{ $impresora->modelo }}</td>
                    <td>{{ $impresora->ubicacion }}</td>
                    <td>{{ $impresora->usuario }}</td>
                    <td>{{ $impresora->paginas_total }}</td>
                    <td>{{ $impresora->paginas_bw }}</td>
                    <td>{{ $impresora->paginas_color }}</td>
                    <td>{{ $impresora->mac }}</td>
                    <td>{{ $impresora->num_serie }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    //TODO: Grafico
    {{-- Gráfico --}}
    {{-- <canvas id="graficoPaginas"></canvas> --}}

    <!-- Chart.js CDN -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('graficoPaginas').getContext('2d');
        const grafico = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [{
                    label: 'Páginas impresas por mes',
                    data: {!! json_encode($valores) !!},
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 50
                        }
                    }
                }
            }
        });
    </script> --}}
</body>

</html>
