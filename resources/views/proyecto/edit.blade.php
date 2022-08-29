@extends('layouts.app')

@section('content')
    @if (Auth::check() &&(  Auth::user()->role =='admin' || Auth::user()->role =='cta' ||  Auth::user()->role =='redes'))
        <div class="container">
            @if (session('message'))
                <div class="alert alert-success">
                    <h2>{{ session('message') }}</h2>
                </div>
            @endif

            <h2>Edición de Proyecto</h2>

            {{-- Formulario proyecto --}}
            <form action="{{ route('proyectos.update', $proyecto->id) }}" method="post" enctype="multipart/form-data">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <div class="row align-items-center">
                    <div class="col-md-6 mt-3">
                        <label class="font-weight-bold" for="titulo">Título</label>
                        <input class="form-control" type="text" id="titulo" name="titulo" value="{{ $proyecto->titulo }}">
                    </div>
                    <div class="col-md-6 mt-3">
                        <label class="font-weight-bold" for="area_interna">Área interna</label>
                        <select class="form-control" id="area_interna" name="area_interna">
                            <option disabled selected>Elegir</option>
                            <option>Soporte</option>
                            <option>Redes</option>
                            <option>Programación</option>
                            <option>Servidores</option>
                        </select>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col mt-3">
                        <label class="font-weight-bold" for="ubicacion">Ubicación</label>
                        <select class="form-control" id="ubicacion" name="ubicacion">
                            <option disabled selected>Elegir</option>
                            @foreach($areas as $area)
                                <option value="{{ $area->id }}">{{ $area->sede }} - {{ $area->division }} - {{ $area->coordinacion }} - {{ $area->area }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-md-6 mt-3">
                        <label class="font-weight-bold" for="responsable">Responsable</label>
                        <select class="form-control" id="responsable" name="responsable">
                            <option disabled selected>Elegir</option>
                            @foreach($tecnicos as $tecnico)
                                <option value="{{ $tecnico->id }}">{{ $tecnico->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mt-3">
                        <label class="font-weight-bold" for="contacto">Contacto</label>
                        <select class="form-control" id="contacto" name="contacto">
                            <option disabled selected>Elegir</option>
                            @foreach($empleados as $empleado)
                                <option value="{{ $empleado->id }}">{{ $empleado->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-md-6 mt-3">
                        <label class="font-weight-bold" for="fecha_inicio">Fecha inicio</label>
                        <input class="form-control" type="date" id="fecha_inicio" name="fecha_inicio" value="{{ $proyecto->fecha_inicio }}"> 
                    </div>
                    <div class="col-md-6 mt-3">
                        <label class="font-weight-bold" for="fecha_fin">Fecha fin</label>
                        <input class="form-control" type="date" id="fecha_fin" name="fecha_fin" value="{{ $proyecto->fecha_fin }}"> 
                    </div>
                </div>

                {{-- Botón de guardar o cancelar --}}
                <div class="row align-items-center mt-4">
                    <div class="col-md-6">
                        <a href="{{ route('proyectos.index') }}" class="btn btn-danger">Cancelar</a>
                        <button type="submit" class="btn btn-success">Guardar datos</button>
                    </div>
                </div>
            </form>

            {{-- Pie de página --}}
            <div class="d-flex justify-content-end">
                <h5>Coordinación de Tecnologías para el Aprendizaje. CUCSH</h5>    
            </div>
        </div>

        {{-- Estilos personalizados --}}
        <style type="text/css">
            span.select2-container {
                width: 100% !important;
            }
            .select2-container 
            .select2-selection--single {
                height: 38px !important;
            }
            .select2-selection__rendered {
                color: #495057 !important;
                padding-left: 16px !important;
                margin: 4px 0;
            }
            .select2-selection__arrow {
                margin-top: 6px;
            }
            .select2-container--default 
            .select2-selection--single {
                border: 1px solid #ced4da;
            }
            .select2-search input {
                display: block;
                width: 100%;
                padding: 0.375rem 0.75rem;
                color: #212529;
                background: #fff;
                border: 1px solid #ced4da;
                border-radius: 0.25rem;
            }
            .select2-search input:focus {
                color: #212529;
                background-color: #fff;
                border-color: #86b7fe;
                outline: 0;
                box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
            }
            body {
                overflow-x: hidden;
            }
        </style>

        {{-- JavaScript con JQuery --}}
        <script>
            var select2 = {    
                language: {
                    noResults: function() { return "No hay resultado"; },
                    searching: function() { return "Buscando.."; }
                }
            };

            $(document).ready(function () {
                $('#area_interna').select2(select2);
                $('#responsable').select2(select2);
                $('#ubicacion').select2(select2);
                $('#contacto').select2(select2);

                $("#area_interna").val("{{ $proyecto->area_interna }}").change();
                $("#responsable").val("{{ $proyecto->id_tecnico }}").change();
                $("#ubicacion").val("{{ $proyecto->id_area }}").change();
                $("#contacto").val("{{ $proyecto->id_empleado }}").change();
            });
            
        </script>

    @else
        Acceso No válido
    @endif 
    
@endsection