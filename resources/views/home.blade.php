@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">{{ __('Dashboard') }}</h5>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="text-center py-4">
                        <h3 class="text-primary mb-4">Bienvenido al Sistema de Gestión de Impresoras</h3>
                        <div class="border-top border-bottom py-4 my-3">
                            <p class="lead mb-0">
                                Utiliza la barra de navegación superior para acceder a las diferentes funciones del sistema.
                            </p>
                        </div>
                        <div class="mt-4 text-muted">
                            <small>Selecciona "Ver Impresoras" para gestionar el inventario o "Ver Estadísticas Mensuales" para consultar los reportes.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
