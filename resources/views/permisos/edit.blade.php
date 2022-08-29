@extends('layouts.app')
@section('content')
    <div class="container">
        @if(Auth::check())
            @if (session('message'))
                <div class="alert alert-success">
                    <h2>{{ session('message') }}</h2>
                </div>
            @endif
            <div class="row">
                <h2>Eliminar Permisos</h2>
            </div>
            <br>
            <hr>
            <div>
                <h5>¿Estás seguro de eliminar el siguiente permiso?</h5>
            </div>
            <form method="POST" action="{{ route('permisos.destroy', $permiso->id) }}">
                @csrf
                @method('DELETE')
                <div class="row">
                    <div class="col-mb-4">
                        <label for="permiso" class="col-form-label text-md-right">{{ __('Permiso') }}</label>
                    </div>
                    <div class="col-mb-4">
                        <input id="permiso" type="text" class="form-control" name="permiso" value="{{ $permiso->name}}" readonly>
                    </div>
                    <div class="col-mb-4">
                        <button type="submit" class="btn btn-danger">{{ __('Eliminar Permiso') }}</button>
                    </div>
                </div>
            </form>

        @else
            El periodo de Registro de Proyectos a terminado
        @endif
    </div>
    <script
        type="text/javascript"
        src="{{ asset('js/usuarios/main.js') }}"
    >
    </script>
@endsection

