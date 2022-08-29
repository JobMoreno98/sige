@extends('layouts.app')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous">
    </script>
    @if (Auth::check() &&
        (Auth::user()->role == 'admin' ||
            Auth::user()->role == 'rh' ||
            Auth::user()->role == 'redes' ||
            Auth::user()->role == 'cta'))
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-10 order-sm-1 order-md-0">
                    <h2>Sede {{ $sede }}</h2>
                    @foreach ($areas as $clave => $valor)
                        {{-- Muestra el listado de Aulas --}}
                        <div class="mb-2 p-4 shadow w-100">
                            <h2>Edificio {{ $clave }}</h2>
                            @php
                                $pisos = collect($valor);
                            @endphp
                            <hr class="border">
                            @foreach ($pisos as $p => $item)
                                <h4>{{ strcmp('Piso 0', $p) == 0 ? 'Planta Baja' : $p }}</h4>
                                @php
                                    $areas = collect($item);
                                @endphp
                                @foreach ($areas as $key)
                                    @if (isset($key['tickets']))
                                        <a onclick="modal({{ collect($key) }})" class="btn bg-danger text-white text-wrap"
                                            data-bs-toggle="modal" data-bs-target="#exampleModal">

                                            {{ $key['area'] }}
                                            @if (str_contains($key['equipamiento'], 'PC'))
                                                <i class="fa fa-laptop "></i>
                                            @endif
                                            @if (str_contains($key['equipamiento'], 'TV') == 1)
                                                <i class="fa fa-tv "></i>
                                            @endif
                                            @if (str_contains($key['equipamiento'], 'Proyector') == 1)
                                                <i class="fa fa-video "></i>
                                            @endif

                                        </a>
                                    @else
                                        <a onclick="modal({{ collect($key) }})" class="btn bg-success text-white text-wrap"
                                            data-bs-toggle="modal" data-bs-target="#exampleModal">{{ $key['area'] }}
                                            @if (str_contains($key['equipamiento'], 'PC') == 1)
                                                <i class="fa fa-laptop "></i>
                                            @endif
                                            @if (str_contains($key['equipamiento'], 'TV') == 1)
                                                <i class="fa fa-tv "></i>
                                            @endif
                                            @if (str_contains($key['equipamiento'], 'Proyector') == 1)
                                                <i class="fa fa-video "></i>
                                            @endif
                                        </a>
                                    @endif
                                @endforeach
                            @endforeach
                        </div>
                    @endforeach

                </div>
                <div class="col-md-2 col-sm-12 order-sm-0 order-md-1">
                    <div class="d-flex flex-column align-items-center sticky-top">
                        <p class="font-weight-bold">Nomenclatura</p>

                        <div class="row">
                            <div class="col-6 d-flex flex-column align-items-center">
                                <button type="button" class="btn btn-danger mt-1" data-toggle="tooltip"
                                    data-placement="top" title="Ticket Abierto">
                                </button>
                                <button type="button" class="btn btn-primary btn-sm mt-1" data-toggle="tooltip"
                                    data-placement="left" title="Proyector">
                                    <i class="fas fa-video fa-xs"></i>
                                </button>
                                <button type="button" class="btn btn-primary btn-sm mt-1" data-toggle="tooltip"
                                    data-placement="left" title="Computadora">
                                    <i class="fa fa-laptop  fa-xs"></i>
                                </button>
                            </div>
                            <div class="col-6 d-flex flex-column align-items-center">
                                <button type="button" class="btn btn-success mt-1" data-toggle="tooltip"
                                    data-placement="bottom" title="Sin tickets">
                                </button>
                                <button type="button" class="btn btn-primary btn-sm mt-1" data-toggle="tooltip"
                                    data-placement="left" title="Videoconferencia">
                                    <i class="fas fa-chalkboard-teacher fa-xs"></i>
                                </button>
                                <button type="button" class="btn btn-primary btn-sm mt-1" data-toggle="tooltip"
                                    data-placement="left" title="Sin equipo">
                                    <i class="fas fa-ban fa-xs"></i>
                                </button>
                            </div>
                        </div>

                        <label class="font-weight-bold my-3" for="sede">Área </label>
                        @if (strcmp($sede, 'Belenes') == 0)
                            <a href="{{ route('area-ticket', 'Belenes') }}"
                                class="col-auto my-2 btn bg-secondary text-white">Belenes</a>
                            <a href="{{ route('area-ticket', 'La Normal') }}" class="col-auto my-2 btn ">La
                                Normal</a>
                        @else
                            <a href="{{ route('area-ticket', 'Belenes') }}" class="col-auto my-2 btn ">Belenes</a>
                            <a href="{{ route('area-ticket', 'La Normal') }}"
                                class="col-auto my-2 btn bg-secondary text-white">La
                                Normal</a>
                        @endif




                        <label class="font-weight-bold my-2" for="">Edificio </label>

                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                        <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">x</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12" id="slide">
                                <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="true">
                                    <div class="carousel-indicators">
                                        <button type="button" data-bs-target="#carouselExampleIndicators"
                                            data-bs-slide-to="0" class="active" aria-current="true"
                                            aria-label="Slide 1"></button>
                                        <button type="button" data-bs-target="#carouselExampleIndicators"
                                            data-bs-slide-to="1" aria-label="Slide 2"></button>
                                    </div>
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img id="img1" src="" class="d-block w-100" alt="...">
                                        </div>
                                        <div class="carousel-item">
                                            <img id="img2" src="" class="d-block w-100" alt="...">
                                        </div>
                                    </div>
                                    <button class="carousel-control-prev" type="button"
                                        data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button"
                                        data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            </div>

                        </div>
                        <div class="row" id="row_datos" style="display:none;">
                            <div class="col-sm-12">
                                <h5 class="text-center">Solicitante: <span id="solicitante"></span>Contacto: <span
                                        id="prioridad"></span></h5>
                                <hr>
                                <p>Datos reporte: <span id="datos"></span></p>
                                <p>Fecha reporte: <span id="fecha"></span></p>
                                <p>Prioridad: <span id="prioridad"></span></p>

                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm-12 col-md-3">
                                <a href="" id="historial" class="btn btn-primary">Historial</a>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <a href="" id="equipos" class="btn btn-primary">Equipos</a>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        </div>

        <script>
            function modal(params) {
                $("#exampleModalLabel").html(params['area']);
                if (params['imagen_1'] == 'Sin imagen') {
                    console.log('Sin imagen');
                    document.getElementById('slide').style.display = 'none';

                } else {
                    $('#img1').attr("src", params['imagen_1']);
                    $('#img2').attr("src", params['imagen_2']);
                    document.getElementById('slide').style.display = 'block';
                }

                if (params.hasOwnProperty('tickets')) {
                    document.getElementById('row_datos').style.display = 'block';
                    $("#datos").html(params['tickets'][0]['datos_reporte']);
                    $("#solicitante").html(params['tickets'][0]['solicitante']);
                    $("#fecha").html(params['tickets'][0]['fecha_reporte']);
                    $("#prioridad").html(params['tickets'][0]['prioridad']);
                    $("#contacto").html(params['tickets'][0]['contacto']);

                } else {
                    document.getElementById('row_datos').style.display = 'none';
                }
                var id = params['id'].toString();
                var url = "{{ route('ticket-historial', ':id') }}";
                url = url.replace(':id', id);
                document.getElementById('historial').href = url;
                var url = "{{ route('equipo-area', ':id') }}";
                url = url.replace(':id', id);
                document.getElementById('equipos').href = url;

            }
        </script>
    @else
        Acceso No válido
    @endif
@endsection
