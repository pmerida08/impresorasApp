@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{-- {{ __('Has iniciado sesión') }}  --}}
                    <div class="btn">
                        <a href="{{ route('impresoras.index') }}" class="btn btn-primary ml-2">Ver Impresoras</a>
                    </div>
                    
                    <div class="btn">
                        <a href="{{ route('estadisticas.totales-por-mes') }}" class="btn btn-primary">
                            <i class="fas fa-chart-bar"></i> Ver Estadísticas Mensuales
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
