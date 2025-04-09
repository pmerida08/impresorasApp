<div class="row padding-1 p-1">
    <div class="col-md-12">

        <div class="form-group mb-2 mb20">
            <label for="tipo" class="form-label">{{ __('Tipo') }}</label>
            <input type="text" name="tipo" class="form-control @error('tipo') is-invalid @enderror" value="{{ old('tipo', $impresora?->tipo) }}" id="tipo">
            {!! $errors->first('tipo', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="ubicacion" class="form-label">{{ __('Ubicación') }}</label>
            <input type="text" name="ubicacion" class="form-control @error('ubicacion') is-invalid @enderror" value="{{ old('ubicacion', $impresora?->ubicacion) }}" id="ubicacion">
            {!! $errors->first('ubicacion', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="usuario" class="form-label">{{ __('Usuario') }}</label>
            <input type="text" name="usuario" class="form-control @error('usuario') is-invalid @enderror" value="{{ old('usuario', $impresora?->usuario) }}" id="usuario">
            {!! $errors->first('usuario', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="ip" class="form-label">{{ __('IP') }}</label>
            <input type="text" name="ip" class="form-control @error('ip') is-invalid @enderror" value="{{ old('ip', $impresora?->ip) }}" id="ip">
            {!! $errors->first('ip', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="nombre_reserva_dhcp" class="form-label">{{ __('Nombre Reserva DHCP') }}</label>
            <input type="text" name="nombre_reserva_dhcp" class="form-control @error('nombre_reserva_dhcp') is-invalid @enderror" value="{{ old('nombre_reserva_dhcp', $impresora?->nombre_reserva_dhcp) }}" id="nombre_reserva_dhcp">
            {!! $errors->first('nombre_reserva_dhcp', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="observaciones" class="form-label">{{ __('Observaciones') }}</label>
            <textarea name="observaciones" class="form-control @error('observaciones') is-invalid @enderror" id="observaciones">{{ old('observaciones', $impresora?->observaciones) }}</textarea>
            {!! $errors->first('observaciones', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="nombre_cola_hacos" class="form-label">{{ __('Nombre Cola HACOS') }}</label>
            <input type="text" name="nombre_cola_hacos" class="form-control @error('nombre_cola_hacos') is-invalid @enderror" value="{{ old('nombre_cola_hacos', $impresora?->nombre_cola_hacos) }}" id="nombre_cola_hacos">
            {!! $errors->first('nombre_cola_hacos', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>

    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Enviar') }}</button>
    </div>
</div>
