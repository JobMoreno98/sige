@extends('layouts.app')

@section('content')
@if(Auth::check() && (Auth::user()->role =='admin' || Auth::user()->role =='cta' || Auth::user()->role =='auxiliar' || Auth::user()->role =='redes'))


<div class="container-fluid">
    <div class="row g-3 align-items-center">
        <div class="col-md-12">
            @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
            @endif
            <h2>Artículos en requisición </h2>
            <p align="right">
                <a href="{{route('requisicion-articulos-create',$id)}}" class="btn btn-success">Agregar artículo</a>
                <a href="{{route('requisicion.index')}}" class="btn btn-primary">Regresar</a>
            </p>
        </div>
    </div>

    <br>

    <div class="row g-3 align-items-center">
        <div class="col">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Observación</th>
                        <th>Estatus</th>
                        <th>Acciones</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($articulos as $articulo)
                    <tr>
                        <td>{{ $articulo->codigo }}</td>
                        <td>{{ $articulo->descripcion }}</td>
                        <td>{{ $articulo->cantidad }}</td>
                        <td>{{ $articulo->observacion }}</td>
                        <td>{{ $articulo->status}}</td>
                        <td>
                            <div class="btn-circle">
                                <form action="{{ route ('articulos.destroy', $articulo->id)}}" method="POST">
                                    <a class="btn btn-success" href="{{route('articulos.edit',$articulo->id)}}">Editar</a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Borrar" class="btn btn-danger"> <i class="far fa-trash-alt"></i></button>
                                </form>
                            </div>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div><br>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>

@else
Acceso No válido
@endif
@endsection