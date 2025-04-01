<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="modelo" class="form-label">{{ __('Modelo') }}</label>
            <input type="text" name="modelo" class="form-control @error('modelo') is-invalid @enderror" value="{{ old('modelo', $impresora?->modelo) }}" id="modelo" placeholder="Modelo">
            {!! $errors->first('modelo', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="fotocopias" class="form-label">{{ __('Fotocopias') }}</label>
            <input type="text" name="fotocopias" class="form-control @error('fotocopias') is-invalid @enderror" value="{{ old('fotocopias', $impresora?->fotocopias) }}" id="fotocopias" placeholder="Fotocopias">
            {!! $errors->first('fotocopias', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>