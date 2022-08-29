@extends('layouts.app')

@section('content')
    @if (Auth::check() && (  Auth::user()->role =='admin' || Auth::user()->role =='cta' ||  Auth::user()->role =='redes'))
        <div class="container">
            @if (session('message'))
                <div class="alert alert-success">
                    <h2>{{ session('message') }}</h2>
                </div>
            @endif

            <h2>Edición de Actividad</h2>

            <form action="{{ route('proyecto-actividad.update', $actividad->id) }}" method="post" enctype="multipart/form-data" id="formActividad">
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

                <div class="row align-items-start">
                    <div class="col-md-4 mt-3">
                        <label class="font-weight-bold" for="nombre">Nombre</label>
                        <input class="form-control" type="text" id="nombre" name="nombre" value="{{ $actividad->nombre }}">
                    </div>
                    <div class="col-md-8 mt-3">
                        <label class="font-weight-bold" for="descripcion">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion">{{ $actividad->descripcion }}</textarea>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-md-4 mt-3">
                        <label class="font-weight-bold" for="tiempo">Tiempo estimado en horas</label>
                        <input class="form-control" type="number" id="tiempo" name="tiempo" value="{{ $actividad->tiempo }}">
                    </div>
                    <div class="col-md-4 mt-3">
                        <label class="font-weight-bold" for="fecha_inicio">Fecha inicio</label>
                        <input class="form-control" type="date" id="fecha_inicio" name="fecha_inicio" value="{{ $actividad->fecha_inicio }}" min="{{ $proyecto->fecha_inicio }}" max="{{ $proyecto->fecha_fin }}"> 
                    </div>
                    <div class="col-md-4 mt-3">
                        <label class="font-weight-bold" for="fecha_fin">Fecha fin</label>
                        <input class="form-control" type="date" id="fecha_fin" name="fecha_fin" value="{{ $actividad->fecha_fin }}" min="{{ $proyecto->fecha_inicio }}" max="{{ $proyecto->fecha_fin }}"> 
                    </div>
                </div>
                <div class="row align-items-start">
                    <div class="col-md-4 mt-3">
                        <input type="hidden" name="tecnicos" id="tecnicos_array" value="{{ $actividad->id_tecnicos }}">
                        <label class="font-weight-bold" for="tecnicos">Técnicos</label>
                        <select class="form-control" id="tecnicos" multiple>
                            @foreach($tecnicos as $tecnico)
                                <option value="{{ $tecnico->id }}">{{ $tecnico->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mt-3">
                        <input type="hidden" name="equipos" id="equipos_array" value="{{ $actividad->id_equipos }}">
                        <label class="font-weight-bold" for="equipos">Equipos</label>
                        <select class="form-control" id="equipos" multiple>
                            @foreach ($equipos_seleccionados as $equipo)
                                <option value="{{ $equipo["id"] }}" selected>{{ $equipo["value"] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mt-3">
                        <input type="hidden" name="actividades_previas" id="actividades_previas_array" value="{{ $actividad->id_actividades_previas }}">
                        <label class="font-weight-bold" for="actividades_previas">Actividades previas</label>
                        <select class="form-control" id="actividades_previas" multiple>
                            @foreach($actividades_previas as $actividad)
                                <option value="{{ $actividad->id }}">{{ $actividad->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Botón de guardar o cancelar --}}
                <div class="row align-items-center mt-4">
                    <div class="col-md-6">
                        <a href="{{ route('proyectos.show', $proyecto->id) }}" class="btn btn-danger">Cancelar</a>
                        <button id="btnSubmit" type="button" class="btn btn-success">Guardar datos</button>
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

            .select2-selection {
                border: 1px solid #ced4da !important;
                min-height: 38px !important;
            }
            body {
                overflow-x: hidden;
            }
        </style>

        <script>
            var select2 = {    
                language: {
                    noResults: function() { return "No hay resultado"; },
                    searching: function() { return "Buscando.."; }
                }
            };

            $(document).ready(function () {
                $('#tecnicos').select2(select2);
                $('#actividades_previas').select2(select2);

                // Se utiliza ajax para obtener los equipos
                // https://select2.org/data-sources/ajax
                $('#equipos').select2({
                    ajax: {
                        url: '{{ route("select-equipo") }}',
                        dataType: 'json'
                    },
                    language: select2.language
                });

                // Evento del bóton para guardar
                $("#btnSubmit").click(function (e) { 
                    e.preventDefault();
                    selectValue("#tecnicos");
                    selectValue("#equipos");
                    selectValue("#actividades_previas");
                    $("#formActividad").submit();
                });

                // Se seleccionan las opciones guardadas
                getSelectValue("#tecnicos");
                getSelectValue("#actividades_previas");
                
            });

            function selectValue(e) {
                // Guarda en un input un array los id's
                $(e + "_array").val('[' + $(e).val() + ']');
            }

            function getSelectValue(e) {
                var data = JSON.parse($(e + "_array").val());
                data.forEach(function (id) {
                    $(e).val(id + '').change();
                });
            }
            
        </script>

    @else
        Acceso No válido
    @endif 
   
@endsection