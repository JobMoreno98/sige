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
                <h2>Asignar Permisos a Roles</h2>
            </div>
            <hr>
                <h4>{{$rol->name }}</h4>
            <hr>
            <div class="row align-items-center">
                <form method="POST" id="formPermisos" action="{{ route('guardar_relacion_permisos') }}">
                    @method('POST')
                    @csrf
                    <input type="hidden" id="role_id" name="role_id" value="{{ $rol->id }}" />
                    <input type="hidden" id="permisos_seleccionados" name="permisos_seleccionados" value="" />
                    <table id="relatedTable" class="display table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Modulo</th>
                                <th>Permiso</th>
                                <th>Asignado</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <button class="btn btn-success" type="button" onclick="sendData()">Guardar</button>
                </form>
            </div>
        @else
            El periodo de Registro de Proyectos a terminado
        @endif
    </div>
    <script
        type="text/javascript"
        src="{{ asset('js/usuarios/relatedPermission.js') }}"
    >
    </script>
    <script type="text/javascript">
    var data = @json($permisos);
</script>
@endsection
