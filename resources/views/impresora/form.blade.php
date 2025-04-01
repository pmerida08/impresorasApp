<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="modelo" class="form-label">{{ __('Modelo') }}</label>
            <input type="text" name="modelo" class="form-control @error('modelo') is-invalid @enderror" value="{{ old('modelo', $impresora?->modelo) }}" id="modelo" placeholder="Modelo">
            {!! $errors->first('modelo', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="copias_dia" class="form-label">{{ __('Copias por día') }}</label>
            <input type="number" name="copias_dia" class="form-control @error('copias_dia') is-invalid @enderror" value="{{ old('copias_dia', $impresora?->copias_dia) }}" id="copias_dia" placeholder="Copias por día">
            {!! $errors->first('copias_dia', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="copias_mes" class="form-label">{{ __('Copias por mes') }}</label>
            <input type="number" name="copias_mes" class="form-control @error('copias_mes') is-invalid @enderror" value="{{ old('copias_mes', $impresora?->copias_mes) }}" id="copias_mes" placeholder="Copias por mes">
            {!! $errors->first('copias_mes', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="copias_anio" class="form-label">{{ __('Copias por año') }}</label>
            <input type="number" name="copias_anio" class="form-control @error('copias_anio') is-invalid @enderror" value="{{ old('copias_anio', $impresora?->copias_anio) }}" id="copias_anio" placeholder="Copias por año">
            {!! $errors->first('copias_anio', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Enviar') }}</button>
    </div>
</div>