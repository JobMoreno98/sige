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
                <h2>Administración de Usuarios</h2>
            </div>

            <div class="row">
                <div class="col-auto mb-1">
                    <br>
                    <form method="POST" action="{{ route('usuarios.create') }}">
                        @method('GET')
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            {{ __('Nuevo Usuario') }}
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
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Activo</th>
                            <th>Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usuarios as $usuario)
                            <tr>
                                <td>{{$usuario->name}}</td>
                                <td>{{$usuario->email}}</td>
                                @if($usuario->activo == 1)
                                    <td>Activo</td>
                                    <td>
                                        <form method="GET" action="{{ route('usuarios.edit',$usuario->id) }}">    
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Editar') }}
                                            </button>
                                        </form>
                                    </td>
                                @else
                                    <td><span class="inactivo">Inactivo</span></td>
                                    <td>
                                        <form method="POST" action="{{ route('usuarios.show',$usuario->id) }}">    
                                            @method('GET')
                                            <button type="submit" class="btn btn-success">
                                                {{ __('Activar') }}
                                            </button>
                                        </form>
                                    </td>
                                @endif
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