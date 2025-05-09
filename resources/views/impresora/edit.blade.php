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

                        <form method="POST" action="{{ route('impresoras.update', $impresora->id) }}" role="form"
                            enctype="multipart/form-data">
                            @method('PATCH')
                            @csrf

                            @include('impresora.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
