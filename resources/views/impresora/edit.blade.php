@extends('layouts.app')

@section('template_title')
    {{ __('Actualizar') }} Impresora
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Actualizar') }} Impresora</span>
                    </div>
                    <div class="card-body bg-white">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('impresoras.update', $impresora->id) }}" role="form"
                            enctype="multipart/form-data">
                            @method('PATCH')
                            @csrf

                            <!-- Formulario de edición -->
                            <div class="form-group">
                                <label for="tipo">{{ __('Tipo') }}</label>
                                <input type="text" name="tipo" id="tipo" class="form-control"
                                    value="{{ old('tipo', $impresora->tipo) }}">
                            </div>

                            <div class="form-group">
                                <label for="ubicacion">{{ __('Ubicación') }}</label>
                                <input type="text" name="ubicacion" id="ubicacion" class="form-control"
                                    value="{{ old('ubicacion', $impresora->ubicacion) }}">
                            </div>

                            <div class="form-group">
                                <label for="usuario">{{ __('Usuario') }}</label>
                                <input type="text" name="usuario" id="usuario" class="form-control"
                                    value="{{ old('usuario', $impresora->usuario) }}">
                            </div>

                            <div class="form-group">
                                <label for="ip">{{ __('IP') }}</label>
                                <input type="text" name="ip" id="ip" class="form-control"
                                    value="{{ old('ip', $impresora->ip) }}">
                            </div>

                            <div class="form-group">
                                <label for="nombre_reserva_dhcp">{{ __('Nombre Reserva DHCP') }}</label>
                                <input type="text" name="nombre_reserva_dhcp" id="nombre_reserva_dhcp" class="form-control"
                                    value="{{ old('nombre_reserva_dhcp', $impresora->nombre_reserva_dhcp) }}">
                            </div>

                            <div class="form-group">
                                <label for="observaciones">{{ __('Observaciones') }}</label>
                                <textarea name="observaciones" id="observaciones"
                                    class="form-control">{{ old('observaciones', $impresora->observaciones) }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="nombre_cola_hacos">{{ __('Nombre Cola HACOS') }}</label>
                                <input type="text" name="nombre_cola_hacos" id="nombre_cola_hacos" class="form-control"
                                    value="{{ old('nombre_cola_hacos', $impresora->nombre_cola_hacos) }}">
                            </div>

                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary">{{ __('Actualizar') }}</button>
                                <a href="{{ route('impresoras.index') }}" class="btn btn-secondary">{{ __('Cancelar') }}</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection