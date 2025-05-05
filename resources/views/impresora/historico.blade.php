@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Histórico de impresora: {{ $impresora->modelo }}</h2>

        {{-- Formulario de selección de fechas --}}
        <form method="GET" action="{{ route('impresoras.paginas.rango', ['id' => $impresora->id]) }}" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <label for="fecha_inicio" class="form-label">Fecha de inicio</label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label for="fecha_fin" class="form-label">Fecha de fin</label>
                    <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" required>
                </div>
                <div class="col-md-4 align-self-end">
                    <button type="submit" class="btn btn-primary">Calcular páginas</button>
                </div>
            </div>
        </form>

        {{-- Resultado --}}
        @if (session('resultado'))
            <div class="alert alert-info">
                {!! session('resultado') !!}
            </div>
        @endif

        {{-- Gráfico --}}
        <canvas id="graficoPaginas"></canvas>
    </div>

    <!-- Chart.js CDN -->
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
    </script>
@endsection
