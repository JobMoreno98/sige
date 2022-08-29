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
                <h2>Administración de Roles</h2>
            </div>

            @if( isset($success))
                <div class="alert alert-success">
                    {{ $success }}
                </div>
            @endif

            <div class="row">
                <div class="col-auto mb-1">
                    <br>
                    <form method="POST" action="{{ route('roles.create') }}">
                        @method('GET')
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            {{ __('Nuevo Rol') }}
                        </button>
                    </form>
                </div>
            </div>

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
                            <th>Rol</th>
                            <th>Descripción</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                            <tr>
                                <td>{{$role->name}}</td>
                                <td>{{$role->description}}</td>
                                <td>
                                    <form method="GET" action="{{ route('roles.edit',$role->id) }}">    
                                        <button type="submit" class="btn btn-info">
                                            {{ __('Editar') }}
                                        </button>
                                        <a href="{{ route('asignar_permisos',$role->id) }}"><button type="button" class="btn btn-success">Relacionar Permisos</button> </a>
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