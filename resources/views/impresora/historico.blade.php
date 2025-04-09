@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Histórico mensual de {{ $impresora->ip }}</h2>

    <canvas id="graficoPaginas" height="100"></canvas>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('graficoPaginas').getContext('2d');
    const grafico = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [{
                label: 'Páginas impresas por mes',
                data: {!! json_encode($valores) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderRadius: 5,
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Páginas'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Mes/Año'
                    }
                }
            }
        }
    });
</script>
@endsection