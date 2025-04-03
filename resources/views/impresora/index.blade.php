@extends('layouts.app')

@section('template_title')
    Impresoras
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="mb-3">
                        @include('layouts.search') {{-- Incluye el formulario de búsqueda --}}
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">
                            {{ __('Impresoras') }}
                        </span>
                    </div>
                </div>

                {{-- Mensaje de éxito --}}
                @if ($message = Session::get('success'))
                    <div class="alert alert-success m-4">
                        <p>{{ $message }}</p>
                    </div>
                @endif

                <div class="card-body bg-white">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead">
                                <tr>
                                    <th>No</th>
                                    <th>Modelo</th>
                                    <th>Copias por día</th>
                                    <th>Copias por mes</th>
                                    <th>Copias por año</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($impresoras as $index => $impresora)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $impresora->modelo }}</td>
                                        <td>{{ $impresora->copias_dia }}</td>
                                        <td>{{ $impresora->copias_mes }}</td>
                                        <td>{{ $impresora->copias_anio }}</td>
                                        <td>
                                            <form action="{{ route('impresoras.destroy', $impresora->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('¿Estás seguro que quieres eliminar esta impresora?');">
                                                    <i class="fa fa-fw fa-trash"></i> {{ __('Eliminar') }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Paginación --}}
                    <div class="d-flex justify-content-center mt-3">
                        {!! $impresoras->withQueryString()->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
