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
                        <div class="form-group mb-2 mb20">
                            <strong>Páginas impresas en color:</strong>
                            {{ $impresora->paginascolor }}
                        </div>

                        <div class="form-group mb-2 mb20">
                            <strong>Número de serie:</strong>
                            {{ $impresora->numserie }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>IP:</strong>
                            {{ $impresora->ip }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Dirección MAC:</strong>
                            {{ $impresora->mac }}
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm"
                                href="{{ route('impresoras.historico', ['id' => $impresora->id]) }}">
                                {{ __('Ver histórico') }}</a>
                        </div>



                        {{-- <div class="form-group mb-2 mb20">
                                    <strong>Tóner:</strong>
                                    {{ $impresora->toner }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Unidad de imagen:</strong>
                                    {{ $impresora->unidadimg }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Páginas restantes del tóner:</strong>
                                    {{ $impresora->paginasrestantestoner }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Páginas restantes de la unidad de imagen:</strong>
                                    {{ $impresora->paginasrestantesunidadimg }}
                                </div> --}}

                        {{-- <div class="form-group mb-2 mb20">
                                    <strong>Mensaje de alerta:</strong>
                                    {{ $impresora->alert }}
                                </div>
                                
                                <div class="form-group mb-2 mb20">
                                    <strong>Número de serie:</strong>
                                    {{ $impresora->numserie }}
                                </div> --}}

                        {{-- TODO: Toner, Unidad Imagen,.... MIBs --}}

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
