@extends('layouts.app')

@section('content')
    @if (Auth::check() && (Auth::user()->role =='admin' ||  Auth::user()->role =='cta' || Auth::user()->role =='aulas' || Auth::user()->role =='redes' || Auth::user()->role =='auxiliar' || Auth::user()->role =='general'))

        <div class="container-fluid">
            <div class="row g-3 align-items-center">
                <div class="col-md-12">
                    @if (session('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
                    <h2>Cursos </h2>
                    <p align="right">
			@if (Auth::check() && Auth::user()->role == 'admin')
                        	<a href="{{ route('cursos.create') }}" class="btn btn-success">
                            		<i class="fa fa-plus"></i> Capturar Curso
                        	</a>
			@endif
                        <a href="{{ route('home') }}" class="btn btn-primary">
                            <i class="fa fa-arrow-left"></i> Regresar
                        </a>
                    </p>
                </div>
            </div>
            <br>
            <form action="{{ route('filtroCursos') }}" method="post" enctype="multipart/form-data" class="col-12">
                <div class="row g-3 align-items-center">
                    <div class="col">
                        {!! csrf_field() !!}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <br>
                </div>
                <div class="row align-items-end">
                    <div class="col-md-4 pl-0">
                       {{-- <label for="id_area">Área </label>
                        <select class="form-control" id="id_area" name="id_area">
                            @if (isset($areaElegida->id) && !is_null($areaElegida->id))
                                <option value="{{ $areaElegida->id }}" selected>
                                    {{ $areaElegida->sede }}
                                    {{ $areaElegida->edificio }}
                                    {{ $areaElegida->piso }}
                                    {{ $areaElegida->division }}
                                    {{ $areaElegida->coordinacion }}
                                    {{ $areaElegida->area }}
                                </option>
                                <option disabled>Elegir</option>
                            @else
                                <option disabled selected>Elegir</option>
                            @endif

                            @foreach ($areas as $area)
                                <option value="{{ $area->id }}">
                                    {{ $area->sede }},
                                    {{ $area->edificio }},
                                    {{ $area->piso }},
                                    {{ $area->division }},
                                    {{ $area->coordinacion }},
                                    {{ $area->area }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-auto mt-3 pl-0">
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="fa fa-search"></i> Filtrar
                        </button>
                        <a href="{{ route('cursos.index') }}" class="btn btn-outline-success">
                        <i class="fa fa-search-minus"></i> Quitar Filtro
                        </a>
                    </div>
--}}
                </div>
                <br>
            </form>
        </div>
        <form action="{{route('busqueda-curso')}}" method="POST" enctype="multipart/form-data" class="col-12">
            {!! csrf_field() !!}
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        Debe de escribir un criterio de búsqueda
                    </ul>
                </div>
            @endif
            <br>
            <div class="row align-items-center">
                <div class="col-md-2 offset-md-1">
                    <h3 class="card-title"> <span class="text-success"><i class="fa fa-search"></span></i> Búsqueda</3>
                </div>
                <div class="col-md-5">
                    <input type="text" class="form-control" id="busqueda" name="busqueda" >
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success">Filtrar</button>
                </div>

            </div>
        </form>

        <div class="row g-3 align-items-center">
            <form action="{{route('filtro-curso')}}" method="POST" enctype="multipart/form-data" class="col-12">
                {!! csrf_field() !!}
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            Debe de escribir un criterio de búsqueda
                        </ul>
                    </div>
                @endif
                <br>
                <div class="row g-3 align-items-center">





                    <div class="col-md-1 offset-md-1">
                        <h6 class="card-title"> <span class="text-success"><i class="fa fa-search"></span></i> Días</6>
                        <select class="form-control" id="filtrodia" name="filtrodia">
                            <option disabled selected >Elegir</option>
                            <option value="Lunes" >Lunes</option>
                            <option value="Martes" >Martes</option>
                            <option value="Miercoles">Miercoles</option>
                            <option value="Jueves">Jueves</option>
                            <option value="Viernes">Viernes</option>
                            <option value="Sabado">Sábado</option>
                        </select>


                    </div>

                    <div class="col-md-2 offset-md-1">
                        <h6 class="card-title"> <span class="text-success"><i class="fa fa-search"></span></i> Tipo</6>
                    </div>
                    <div class="col-md-1">
                        <select class="form-control" id="filtrotipo" name="filtrotipo">
                            <option  disabled selected>Elegir</option>
                            <option value="Aula" >Aula</option>
                            <option value="Laboratorio" >Laboratorio</option>

                        </select>
                    </div>

                    <div class="col-md-2 offset-md-1">
                        <h6 class="card-title"> <span class="text-success"><i class="fa fa-search"></span></i> Departamento</6>
                    </div>
                    <div class="col-md-2">
                        <select class="form-control" id="filtrodepartamento" name="filtrodepartamento">
                            <option  disabled selected>Elegir</option>
                            <option value="DEPTO. DE DERECHO SOCIAL Y DISCIPLINAS SOBRE EL DE" >DEPTO. DE DERECHO SOCIAL Y DISCIPLINAS SOBRE EL DE</option>
                            <option value="DEPTO. DE DERECHO PUBLICO" >DEPTO. DE DERECHO PUBLICO</option>
                            <option value="LICENCIATURA EN SOCIOLOGÍA" >LICENCIATURA EN SOCIOLOGÍA</option>
                            <option value="LICENCIATURA EN ESTUDIOS INTERNACIONALES">LICENCIATURA EN ESTUDIOS INTERNACIONALES</option>
                            <option value="DEPTO. DE DESARROLLO SOCIAL">DEPTO. DE DESARROLLO SOCIAL</option>
                            <option value="DEPTO. DE LENGUAS MODERNAS">DEPTO. DE LENGUAS MODERNAS</option>
                            <option value="DEPTO. DE FILOSOFIA">DEPTO. DE FILOSOFIA</option>
                            <option value="DEPTO. DE DERECHO PRIVADO">DEPTO. DE DERECHO PRIVADO</option>
                            <option value="DEPTO. DE HISTORIA ">DEPTO. DE HISTORIA</option>
                            <option value="DEPTO. DE GEOGRAFIA Y ORDENACION TERRITORIAL">DEPTO. DE GEOGRAFIA Y ORDENACION TERRITORIAL</option>
                            <option value="DEPTO. DE LETRAS ">DEPTO. DE LETRAS </option>
                            <option value="DEPTO. DE ESTUDIOS DE LENGUAS INDIGENAS ">DEPTO. DE ESTUDIOS DE LENGUAS INDIGENAS </option>
                            <option value="DEPTO. DE ESTUDIOS POLITICOS ">DEPTO. DE ESTUDIOS POLITICOS </option>
                            <option value="DEPTO. DE ESTUDIOS DEL PACIFICO">DEPTO. DE ESTUDIOS DEL PACIFICO</option>
                            <option value="DEPTO. DE ESTUDIOS INTERNACIONALES">DEPTO. DE ESTUDIOS INTERNACIONALES</option>
                            <option value="DEPTO. DE TRABAJO SOCIAL">DEPTO. DE TRABAJO SOCIAL</option>
                            <option value="LICENCIATURA EN ESCRITURA CREATIVA">LICENCIATURA EN ESCRITURA CREATIVA</option>
                            <option value="DEPTO. DE ESTUDIOS LITERARIOS ">DEPTO. DE ESTUDIOS LITERARIOS </option>
                            <option value="DEPTO. DE ESTUDIOS DE LA COMUNICACION SOCIAL  ">DEPTO. DE ESTUDIOS DE LA COMUNICACION SOCIAL  </option>
                            <option value="DEPTO. DE ESTUDIOS SOCIO URBANOS ">DEPTO. DE ESTUDIOS SOCIO URBANOS </option>
                            <option value="DEPTO. DE SOCIOLOGIA">DEPTO. DE SOCIOLOGIA</option>
                            <option value="DEPTO. DE ESTUDIOS INTERDISCIPLINARES EN CIENCIAS">DEPTO. DE ESTUDIOS INTERDISCIPLINARES EN CIENCIAS</option>
                            <option value="DEPTO. DE ESTUDIOS EN EDUCACION">DEPTO. DE ESTUDIOS EN EDUCACION</option>

                        </select>
                    </div>



                    <div class="col-md-1">
                        <button type="submit" class="btn btn-success">Filtrar</button>
                    </div>
                </div>
            </form>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <table id="example" class="table table-striped table-bordered" cellspacing="2" width="100%">
                        <thead>
                            <tr>
                                @if(Auth::user()->role != 'general')
                                <th>Acción</th>
                                @endif
                                <th>Tipo</th>
                                <th>Curso</th>
                                <th>Departamento</th>
                                <th>Días</th>
                                <th>Horario</th>
                                <th>Detalle Aula</th>
                                <th>Profesor</th>
                                <th>Cupo</th>
                                <th>Alumnos</th>
                                <th>Crn</th>
                                <th>Observaciones</th>
                                <th>Id</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <p>
                        <a href="{{ route('home') }}" class="btn btn-primary">
                            < Regresar</a>
                    </p>
                </div>
            </div>
        </div>

        @extends('layouts.loader')

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/v/bs4-4.1.1/jszip-2.5.0/dt-1.10.24/b-1.7.0/b-html5-1.7.0/b-print-1.7.0/r-2.2.7/datatables.min.js"></script>

        <script type="text/javascript">
            var data = @json($cursos);

            $(document).ready(function() {
                $('#example').DataTable({
                    "data": data,
                    "pageLength": 100,
                    "order": [
                        [0, "desc"]
                    ],
                    "language": {
                        "sProcessing": "Procesando...",
                        "sLengthMenu": "Mostrar _MENU_ registros",
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
                    dom: '<"col-xs-3"l><"col-xs-5"B><"col-xs-4"f>rtip',
                    buttons: [
                        'copy', 'excel',
                        {
                            extend: 'pdfHtml5',
                            orientation: 'landscape',
                            pageSize: 'LETTER',
                        }

                    ]
                })
               loader(false);
            });


            jQuery.extend( jQuery.fn.dataTableExt.oSort, {
            "portugues-pre": function ( data ) {
                var a = 'a';
                    var e = 'e';
                    var i = 'i';
                    var o = 'o';
                    var u = 'u';
                    var c = 'c';
                    var special_letters = {
                        "Á": a, "á": a, "Ã": a, "ã": a, "À": a, "à": a,
                        "É": e, "é": e, "Ê": e, "ê": e,
                        "Í": i, "í": i, "Î": i, "î": i,
                        "Ó": o, "ó": o, "Õ": o, "õ": o, "Ô": o, "ô": o,
                        "Ú": u, "ú": u, "Ü": u, "ü": u,
                        "ç": c, "Ç": c
                    };
                    for (var val in special_letters)
                        data = data.split(val).join(special_letters[val]).toLowerCase();
                    return data;
                },
                "portugues-asc": function ( a, b ) {
                    return ((a < b) ? -1 : ((a > b) ? 1 : 0));
                },
                "portugues-desc": function ( a, b ) {
                    return ((a < b) ? 1 : ((a > b) ? -1 : 0));
                }
            } );
            //"columnDefs": [{ type: 'portugues', targets: "_all" }],            

        </script>
    @else
        Acceso No válido
    @endif
@endsection
