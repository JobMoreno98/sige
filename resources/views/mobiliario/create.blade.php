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
                <h2>Captura de Mobiliario</h2>
                <hr>
                <script type="text/javascript">

                    $(document).ready(function() {
                        $('#busqueda-empleado').select2();
                        $('#js-example-basic-single').select2();

                    });

                </script>

            </div>
            <form action="{{route('mobiliarios.store')}}" method="post" enctype="multipart/form-data" class="col-12">
                <div class="row">
                    <div class="col">
                        {!!csrf_field()!!}
                        @if ($errors-> any())
                            <div class="alert alert-danger">
                                <ul>
                                    Debe de llenar los campos marcados con un asterisco (*).
                                    @foreach ($errors->all() as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <br>
                        <div class="row g-3 aling-item-center">
                            <div class="col-md-3">
                                <label for="id_udg">Id UdeG </label>
                                <input type="text" class="form-control" id="id_udg" name="id_udg" value="{{old('id_udg')}}">
                            </div>
                            <div class="col-md-3">
                                <label for="fecha_adquisicion">Fecha de Adquisición </label>
                                <input type="date" class="form-control" id="fecha_adquisicion" name="fecha_adquisicion" value="{{old('fecha_adquisicion')}}">
                            </div>
                            <div class="col-md-6">
                                <label for="ubicacion">Ubicación </label>
                                <input type="text" class="form-control" id="ubicacion" name="ubicacion" value="{{old('ubicacion')}}">
                            </div>
                        </div>
                        <br>
                        <div class="row g-3 aling-item-center">
                            <div class="col-md-12">
                                <label for="descripcion">Descripción </label>
                                <input type="text" class="form-control" id="descripcion" name="descripcion" >{{old('descripcion')}}
                            </div>
                        </div>
                        <br>
                        <div class="row g-3 aling-item-center">
                            <div class="col-md-3">
                                <label for="estatus_sici">Estatus SICI </label>
                                <select class="form-control" id="estatus_sici" name="estatus_sici">
                                    <option disabled selected>Elegir</option>
                                    <option value="Activo" >Activo</option>
                                    <option value="Inactivo">Inactivo</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="localizado_sici">Localizado en SICI </label>
                                <select class="form-control" id="localizado_sici" name="localizado_sici">
                                    <option disabled selected>Elegir</option>
                                    <option value="S" >Si</option>
                                    <option value="N">No</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="id_resguardante">Resguardante</label>
                                <select class="form-control" class="form-control" id="busqueda-empleado" name="id_resguardante">
                                    <option value="No Aplica" selected>No Aplica</option>
                                    @foreach($empleados as $empleado)
                                        <option value="{{$empleado->id}}">{{$empleado->nombre}} - {{$empleado->id}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row g-3 align-items-center">
                            <div class="col-md-12">
                                <label for="area_id">Areas</label>
                                <select class="form-control" class="form-control" id="js-example-basic-single" name="area_id">
                                    <option value="No Aplica" selected>No Aplica</option>
                                    @foreach($areas as $area)
                                        <option value="{{$area->id}}">{{$area->sede}} - {{$area->division}} - {{$area->coordinacion}} - {{$area->area}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                    </div>
                    <br>
                    <div class="row g-3 align-items-center">
                        <div class="col-md-6">
                            <a href="{{ route('home') }}" class="btn btn-danger">Cancelar</a>
                            <button type="submit" class="btn btn-success">Guardar datos</button>
                        </div>
                    </div>
                </div>
            </form>
            <br>
            <div class="row g-3 align-items-center">

                <br>
                <hr>
                <h5>Coordinación de Tecnologías para el Aprendizaje. CUCSH</h5>


            </div>
    </div>

    @else
        El periodo de Registro de Proyectos a terminado
    @endif

@endsection
