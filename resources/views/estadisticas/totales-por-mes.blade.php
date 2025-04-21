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
                        <canvas id="monthlyStats"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const totalesData = @json($totales);
            const labels = [];
            const impresionesData = [];

            // Get current year
            const currentYear = new Date().getFullYear();
            
            // Create array for all months
            const months = Array.from({length: 12}, (_, i) => {
                const date = new Date(currentYear, i);
                return new Intl.DateTimeFormat('es', { month: 'long' }).format(date).toUpperCase();
            });

            // Initialize data arrays with zeros for all months
            const fullYearLabels = months.map(month => `${currentYear} ${month}`);
            const fullYearImpresiones = new Array(12).fill(0);

            // Process and sort the data
            Object.entries(totalesData).forEach(([anio, meses]) => {
                Object.entries(meses).forEach(([mes, datos]) => {
                    const monthIndex = parseInt(mes) - 1;
                    if (anio == currentYear) {
                        fullYearImpresiones[monthIndex] = datos.total_paginas;
                    }
                });
            });

            const ctx = document.getElementById('monthlyStats').getContext('2d');
            const chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: fullYearLabels,
                    datasets: [
                        {
                            label: 'Total Impresiones',
                            data: fullYearImpresiones,
                            backgroundColor: 'rgba(54, 235, 105, 0.5)',
                            borderColor: 'rgba(54, 235, 105, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return value.toLocaleString('es-ES');
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const impresiones = context.parsed.y.toLocaleString('es-ES');
                                    return `Total Impresiones: ${impresiones}`;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
