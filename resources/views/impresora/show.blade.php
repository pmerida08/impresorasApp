@extends('layouts.app')

@section('template_title')
    {{ $impresora->name ?? __('Ver') . " " . __('Impresora') }}
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
                            <a class="btn btn-primary btn-sm" href="{{ route('impresoras.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Modelo:</strong>
                                    {{ $impresora->modelo }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Copias por día:</strong>
                                    {{ $impresora->copias_dia }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Copias por mes:</strong>
                                    {{ $impresora->copias_mes }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Copias por año:</strong>
                                    {{ $impresora->copias_anio }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
