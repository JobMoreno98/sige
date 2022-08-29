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
                    <form action="{{route('bajas.update',$baja->id)}}" method="post" enctype="multipart/form-data" class="col-12">
                        {!! csrf_field() !!}
                        {{ method_field('PUT') }}
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
                                <input type="text"  class="form-control" name="dependencia" value="{{$baja->dependencia}}" >
                            </div>
                               
                        </div>
                        <br>
                        
                        <br>
                        <div class="row align-items-center">
                            
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="fecha_revision">Fecha de creacion </label>
                                <input type="date" class="form-control" id="fecha_revision" name="fecha_de_creacion" value="{{$baja->fecha_de_creacion}}" >
                            </div>

                            <div class="col-md-3">
                                <label class="font-weight-bold" for="fecha_revision">Fecha de finalización </label>
                                <input type="date" class="form-control" id="fecha_revision" name="fecha_de_finalizacion" value="{{$baja->fecha_de_finalizacion}}" >
                            </div>
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="formato_bajas">Formato de baja</label>
                                <input type="file" class="form-control" id="documento" name="documento">
                                
                            </div>
                        </div>

                        

                    <br>

                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <a href="{{ route('home') }}" class="btn btn-danger">Cancelar</a>
                            <button name="edit_baja" type="submit" class="btn btn-success" value="edit_baja">
                                Capturar baja
                                <i class="ml-1 "></i>
                            </button>
                           
                            <a href="#agregarI" class="btn btn-info" data-toggle="modal">Agregar objeto</a>

                            
                            <!--Modal para agregar item-->
                            <div class="modal fade" id="agregarI" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel">Agrgar item al registro 
                                      registro</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <p class="text-primary">
                                         <!--Formulario -->       
                                        <form  method="post" enctype="multipart/form-data" class="col-12">
                                            {!! csrf_field() !!}
                                            
                                            <div class="row align-items-center">
                                                <div class="col-md-6">
                                                    <input type="hidden" name="id_baja" value="{{$baja->id}}">
                                                    <label class="font-weight-bold" for="motivo_baja">Motivo de la baja </label>
                                                    
                                                    <input type="text" name="motivo_baja" id="motivo_baja" class="form-control">
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="font-weight-bold" for="ano_de_adquisicion">Año de adquisicion </label>
                                                    <input type="text" class="form-control"  name="ano_adquisicion" maxlength="4" minlength="4" value="" >
                                                </div>

                                            </div>

                                            <br>

                                            <div class="row align-items-center">

                                                <div class="col-sm-6">
                                                    <label class="font-weight-bold" for="encargado_de_revision_de_mantenimiento">Encargado de revisión de mantenimiento</label>
                                                    <input type="text" class="form-control" id="encargado_revicion_mantenimiento" name="encargado_revicion_mantenimiento" value="" >
                                                </div> 
                                                
    
                                                <div class="col-sm-6">
                                                    <label class="font-weight-bold" for="encargado_de_revision">Encargado de revisión </label>
                                                    <input type="text" class="form-control" id="encargado_revicion" name="encargado_revicion" value="" >
                                                </div>
                    
                                                                           
                            
                                            </div>

                                            <div class="row align-items-center">

                                                <div class="col-md-6">
                                                    <label class="font-weight-bold" for="fecha_revision">Fecha de revisión </label>
                                                    <input type="date" class="form-control" id="fecha_revision" name="fecha_revision" value="" >
                                                </div>

                                            </div>


                                            <div class="row align-items-center mt-4">
                                                <div class="col-md-6">
                                                    <label class="font-weight-bold" for="motivo_de_no_reparacion" >Motivo de no reparacion</label>
                                                    <textarea class="form-control" id="motivo_de_no_reparacion" name="motivo_de_no_reparacion"></textarea>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="font-weight-bold" for="Descripcion">Descripcion </label>
                                                     <textarea class="form-control" id="descripcion" name="descripcion"s></textarea> 
                                                </div>
                                                
                                            </div>

                                            
                                        </form>

                                        <div >
                                            <button name="cancelar" class="btn btn-danger" value="cancelar" data-dismiss="modal" >cancelar</button>
                                            <button name="guardar" class="btn btn-success" value="guardar">guardar</button>
                                            
                                          </div>
                                        <!--Formulario -->
                                        
                                      </p>
                                    </div>

                                    
                                  </div>
                                </div>
                              </div>
                            
                        </div>
                    </div>
                    <br>  
            </div>
            <br>
                <br>
                
                <br>
                
                <br>
            </form>

            <div class="row">
                <div class="col-12" >
        
                    
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                        <tr>
                            <th>Acciones</th>
                            <th>Id Baja</th>
                            <th>descripcion</th>
                            <th>año de adquisicion</th>
                            <th>Motivo de la baja</th>
                            <th>Fecha de revision</th>
                            <th>Encargado de revicion</th>
                            <th>Encargado de revicion de mantenimiento</th>
                            <th>No reparacion</th>
  
                        </tr>
                        </thead>
                        <tbody>
        
                       
                        </tbody>
        
                    </table>
         </div>
                </div>

               

                <script type="text/javascript">
                    var data = @json($items);
                
                    $(document).ready(function() {
                        $('#example').DataTable({
                            "data": data,
                            
                            "pageLength":  100,
                            "order": [
                                [0, "desc"],
                            ],
                            "language": {
                                "sProcessing": "Procesando...",
                                "sLengthMenu": "",
                                "sZeroRecords": "No se encontraron resultados",
                                "sEmptyTable": "Ningún dato disponible en esta tabla",
                                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                                "sInfoPostFix": "",
                                "sSearch": "Buscar:",
                                "sUrl": "",
                                "sInfoThousands": ",",
                                "sLoadingRecords": "Cargando...",
                                "oPaginate": {
                                    "sFirst": "Primero",
                                    "sLast": "Último",
                                    "sNext": "Siguiente",
                                    "sPrevious": "Anterior"
                                },
                                "oAria": {
                                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                                }
                            },
                            responsive: true,
                            // dom: 'Bfrtip',
                            
                            buttons: [
                                
                
                            ]
                        })
                       loader(false);
                    });

                    </script>

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
