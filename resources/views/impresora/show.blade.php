@extends('layouts.app')

@section('template_title')
    {{ $impresora->name ?? __('Ver') . ' ' . __('Impresora') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Ver') }} Impresora</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('impresoras.index') }}">
                                {{ __('Ir atrás') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white"
                        style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="card-body bg-white">
                            <div class="form-group mb-2 mb20">
                                <strong>Modelo:</strong>
                                {{ $impresora->modelo }}
                            </div>

                            <div class="form-group mb-2 mb20">
                                <strong>Páginas impresas en total:</strong>
                                {{ $impresora->paginastotal }}
                            </div>
                            <div class="form-group mb-2 mb20">
                                <strong>Páginas impresas en blanco y negro:</strong>
                                {{ $impresora->paginasbw }}
                            </div>

                            @if ($impresora->color == 1)
                                <div class="form-group mb-2 mb20">
                                    <strong>Páginas impresas en color:</strong>
                                    {{ $impresora->paginascolor }}
                                </div>
                            @endif

                            <div class="form-group mb-2 mb20">
                                <strong>Número de serie:</strong>
                                {{ $impresora->num_serie }}
                            </div>
                            <div class="form-group mb-2 mb20">
                                <strong>IP:</strong>
                                {{ $impresora->ip }}
                            </div>
                            <div class="form-group mb-2 mb20">
                                <strong>Dirección MAC:</strong>
                                @if (strpos($impresora->mac, '-') !== false)
                                    {{ explode('-', $impresora->mac)[1] }}
                                @else
                                    {{ $impresora->mac }}
                                @endif
                            </div>
                            <div class="form-group mb-2 mb20">
                                <strong>Nivel de Tóner:</strong>
                                <div class="toner-levels">
                                    @if ($impresora->color == 1)
                                        <div class="toner-pill" style="background-color: rgba(0, 0, 0, 0.8);">
                                            Negro: {{ $impresora->black_toner ?? 0 }}%
                                            <span
                                                style="font-weight: bold;">{{ $impresora->showAlert($impresora->black_toner) }}</span>
                                        </div>
                                        <div class="toner-pill" style="background-color: rgba(0, 123, 255, 0.8);">
                                            Cian: {{ $impresora->cyan_toner ?? 0 }}%
                                            <span
                                                style="font-weight: bold;">{{ $impresora->showAlert($impresora->cyan_toner) }}</span>
                                        </div>
                                        <div class="toner-pill" style="background-color: rgba(255, 0, 255, 0.8);">
                                            Magenta: {{ $impresora->magenta_toner ?? 0 }}%
                                            <span
                                                style="font-weight: bold;">{{ $impresora->showAlert($impresora->magenta_toner) }}</span>
                                        </div>
                                        <div class="toner-pill" style="background-color: rgba(187, 187, 0, 0.8);">
                                            Amarillo: {{ $impresora->yellow_toner ?? 0 }}%
                                            <span
                                                style="font-weight: bold;">{{ $impresora->showAlert($impresora->yellow_toner) }}</span>
                                        </div>
                                    @else
                                        <div class="toner-pill"
                                            style="background-color: rgba(0, 0, 0, 0.8); width: {{ $impresora->black_toner ?? 0 }}%;">
                                            Negro: {{ $impresora->max_capacity ?? 0 }}%
                                            <span
                                                style="font-weight: bold;">{{ $impresora->showAlert($impresora->max_capacity) }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="float-right">
                                <a class="btn btn-primary btn-sm"
                                    href="{{ route('impresoras.historico', ['id' => $impresora->id]) }}">
                                    {{ __('Ver histórico') }}</a>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

<style>
    .toner-levels {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .toner-pill {
        color: white;
        padding: 5px;
        border-radius: 5px;
        text-align: center;
        max-width: 300px;
        /* Set a maximum width for the pills */
    }
</style>
