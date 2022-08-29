@extends('layouts.app')
@section('content')
    <div class="container">
        @if (Auth::check())
            @if (session('message'))
                <div class="alert alert-success">
                    <h2>{{ session('message') }}</h2>

                </div>
            @endif

            <div class="row">
                <div class="col-md-auto ml-3">
                    <h2>Captura de Bajas</h2>
                </div>
                <hr>
  		<script type="text/javascript">

                    $(document).ready(function() {
                        $('#js-example-basic-single').select2();

                    });
                    n =  new Date();
                    //Año
                    y = n.getFullYear();
                    //Mes
                    m = n.getMonth() + 1;
                    //Día
                    d = n.getDate();

                    //Lo ordenas a gusto.
                    document.getElementById("date").innerHTML = d + "/" + m + "/" + y;
                </script>

            </div>

            <div class="row">
                <div class="col-12">
                    <form action="{{ route('bajas.store') }}" method="post" enctype="multipart/form-data" class="col-12">
                        {!! csrf_field() !!}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    Debe de llenar los campos marcados con un asterisco (*).
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <br>
                        <div class="row align-items-center">
                            <div class="col-md-9">
                                <label class="font-weight-bold" for="Dependencia">Dependencia </label>
                                <input type="text"  class="form-control" name="dependencia">
                            </div>
                            
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="ano_de_adquisicion">Año de adquisicion </label>
                                <input type="text" class="form-control"  name="ano_adquisicion" maxlength="4" minlength="4" >
                            </div>
                            
                        </div>
                        <br>
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="motivo_baja">Motivo de la baja </label>
                                
                                <input type="text" name="motivo_baja"  id="motivo_baja"  class="form-control">
                                
                            </div>

                            <div class="col-md-5">
                                <label class="font-weight-bold" for="encargado_de_revision">Encargado de revisión </label>
                                <input type="text" class="form-control" id="encargado_revicion" name="encargado_revicion" >
                            </div>

                            <div class="col-md-4">
                                <label class="font-weight-bold" for="encargado_de_revision_de_mantenimiento">Encargado de revisión de mantenimiento</label>
                                <input type="text" class="form-control" id="encargado_revicion_mantenimiento" name="encargado_revicion_mantenimiento" >
                            </div>

   
                        </div>
                        <br>
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="fecha_revision">Fecha de revisión </label>
                                <input type="date" class="form-control" id="fecha_revision" name="fecha_revision" value="" >
                            </div>

                            <div class="col-md-3">
                                <label class="font-weight-bold" for="fecha_revision">Fecha de creacion </label>
                                <input type="date" class="form-control" id="fecha_revision" name="fecha_de_creacion" value="" >
                            </div>

                            <div class="col-md-3">
                                <label class="font-weight-bold" for="fecha_revision">Fecha de finalización </label>
                                <input type="date" class="form-control" id="fecha_revision" name="fecha_de_finalizacion" value="">
                            </div>

                            <div class="col-md-3">
                                <label class="font-weight-bold" for="formato_bajas">Formato de baja </label>
                                <input type="file" class="form-control" id="documento" name="documento">
                            </div>
                        </div>

                        <div class="row align-items-center mt-4">
                            
                            <div class="col-md-6">
                                <label class="font-weight-bold" for="motivo_de_no_reparacion">Motivo de no reparacion</label>
                                <textarea class="form-control" id="motivo_de_no_reparacion" name="motivo_de_no_reparacion" ></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="font-weight-bold" for="Descripcion">Descripcion </label>
                                 <textarea class="form-control" id="descripcion" name="descripcion" ></textarea> 
                            </div>
                        </div>

                        
                    </div>
                    
                        <br>
                        
                        <br>
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <a href="{{ route('home') }}" class="btn btn-danger">Cancelar</a>
                                <button type="submit" class="btn btn-success">
                                    Capturar baja
                                    <i class="ml-1 "></i>
                                </button>
                            </div>
                        </div>
                        <br>
                    </form>
                </div>
            </div>
            <br>
            <div class="row align-items-center">

                <br>
                <hr>
                <h5>Coordinación de Tecnologías para el Aprendizaje. CUCSH</h5>


            </div>
    </div>

@else
    El periodo de Registro de Proyectos a terminado
    @endif

@endsection
