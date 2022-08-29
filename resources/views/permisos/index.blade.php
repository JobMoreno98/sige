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
                <h2>Administración de Permisos</h2>
            </div>
            <br>
            <hr>
            <form method="POST" action="{{ route('permisos.store') }}">
                @csrf
                <div class="row">
                    <div class="col-mb-4">
                        <label for="permiso" class="col-form-label text-md-right">{{ __('Nuevo Permiso') }}</label>
                    </div>
                    <div class="col-mb-4">
                        <input id="permiso" type="text" class="form-control" name="permiso" placeholder="NOMBRE_DEL_MODULO#accion" required>
                    </div>
                    <div class="col-mb-4">
                        <button type="submit" class="btn btn-primary">{{ __('Nuevo Permiso') }}</button>
                    </div>
                </div>
            </form>
            <hr>

            @if(isset($retorno))
                @if(count($retorno['Error']) > 0)
                    <div class="alert alert-danger" id="alert" role="alert">
                        {{ implode("\n",$retorno['Error']) }}
                    </div>
                @else
                    <div class="alert alert-info" id="alert" role="alert">
                        {{ implode("\n",$retorno['Success']) }}
                    </div>
                @endif

            @endif

            <div class="row align-items-center">
                <table id="usersTable" class="display table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Modulo</th>
                            <th>Permiso</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($permisos as $permiso)
                            <tr>
                                <td>{{$permiso['modulo']}}</td>
                                <td>{{$permiso['permiso']}}</td>
                                <td>
                                    <form method="GET" action="{{ route('permisos.edit', $permiso['id']) }}">
                                        <button type="submit" class="btn btn-danger">
                                            {{ __('Eliminar') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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
