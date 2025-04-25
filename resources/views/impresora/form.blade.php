<div class="row padding-1 p-1">
    <div class="col-md-12">
        <div class="form-group mb-2 mb20">
            <label for="tipo" class="form-label">{{ __('Tipo') }}</label>
            <input type="text" name="tipo" class="form-control @error('tipo') is-invalid @enderror"
                value="{{ old('tipo', $impresora?->tipo) }}" id="tipo">
            {!! $errors->first('tipo', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="ubicacion" class="form-label">{{ __('Ubicación') }}</label>
            <input type="text" name="ubicacion" class="form-control @error('ubicacion') is-invalid @enderror"
                value="{{ old('ubicacion', $impresora?->ubicacion) }}" id="ubicacion">
            {!! $errors->first('ubicacion', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="usuario" class="form-label">{{ __('Usuario') }}</label>
            <input type="text" name="usuario" class="form-control @error('usuario') is-invalid @enderror"
                value="{{ old('usuario', $impresora?->usuario) }}" id="usuario">
            {!! $errors->first('usuario', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="ip" class="form-label">{{ __('IP') }}</label>
            <input type="text" name="ip" class="form-control @error('ip') is-invalid @enderror"
                value="{{ old('ip', $impresora?->ip) }}" id="ip">
            {!! $errors->first('ip', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="sede" class="form-label">{{ __('Sede') }}</label>
            <input type="text" name="sede" class="form-control @error('sede') is-invalid @enderror"
                value="{{ old('sede', $impresora?->sede) }}" id="sede">
            {!! $errors->first('sede', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="num_contrato" class="form-label">{{ __('Número de Contrato') }}</label>
            <input type="text" name="num_contrato" class="form-control @error('num_contrato') is-invalid @enderror"
                value="{{ old('num_contrato', $impresora?->num_contrato) }}" id="num_contrato">
            {!! $errors->first('num_contrato', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="color" class="form-label">{{ __('Color') }}</label>
            <select name="color" class="form-control @error('color') is-invalid @enderror" id="color">
                <option value="1" {{ old('color', $impresora?->color) == 1 ? 'selected' : '' }}>Sí</option>
                <option value="0" {{ old('color', $impresora?->color) == 0 ? 'selected' : '' }}>No</option>
            </select>
            {!! $errors->first('color', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="nombre_reserva_dhcp" class="form-label">{{ __('Nombre Reserva DHCP') }}</label>
            <input type="text" name="nombre_reserva_dhcp"
                class="form-control @error('nombre_reserva_dhcp') is-invalid @enderror"
                value="{{ old('nombre_reserva_dhcp', $impresora?->nombre_reserva_dhcp) }}" id="nombre_reserva_dhcp">
            {!! $errors->first(
                'nombre_reserva_dhcp',
                '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>',
            ) !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="descripcion" class="form-label">{{ __('Observaciones') }}</label>
            <textarea name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" id="descripcion">{{ old('descripcion', $impresora?->descripcion) }}</textarea>
            {!! $errors->first(
                'descripcion',
                '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>',
            ) !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="nombre_cola_hacos" class="form-label">{{ __('Nombre Cola HACOS') }}</label>
            <input type="text" name="nombre_cola_hacos"
                class="form-control @error('nombre_cola_hacos') is-invalid @enderror"
                value="{{ old('nombre_cola_hacos', $impresora?->nombre_cola_hacos) }}" id="nombre_cola_hacos">
            {!! $errors->first(
                'nombre_cola_hacos',
                '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>',
            ) !!}
        </div>
    </div>

    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Enviar') }}</button>
        <a href="{{ route('impresoras.index') }}" class="btn btn-secondary">{{ __('Atrás') }}</a>
    </div>
</div>
