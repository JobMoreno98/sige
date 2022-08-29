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
                <h2>Edición de Información de Equipo</h2>
                <hr>
                <script type="text/javascript">

                    $(document).ready(function() {
                        $('#js-example-basic-single').select2();

                    });

                    $(document).ready(function() {
                        $('#js-example-basic-single2').select2();

                    });

                </script>

            </div>
            <form action="{{route('equipos.update',$equipo->id)}}" method="post" enctype="multipart/form-data" class="col-12">
                @method('PUT')
                <div class="row">
                    <div class="col">
                        {!! csrf_field() !!}
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <br>
		   </div>

		</div>
                        <div class="row align-items-center">
                            <div class="col-3">
                                <label for="id">Id SIGE</label>
                                <input type="text" class="form-control" id="id" name="id" value="{{$equipo->id}}" readonly>
                            </div>
                            <div class="col-md-3">
                                <label for="udg_id">Id UdeG</label>
                                <input type="text" class="form-control" id="udg_id" name="udg_id" value="{{$equipo->udg_id}}" >
                            </div>
                              <div class="col-md-6">
                                  <label for="id_resguardante">Resguardante</label>
                                  <select class="form-control" class="form-control" id="js-example-basic-single" name="id_resguardante">
                                      <option value="{{$resguardante->id}}" selected>{{$resguardante->nombre}} {{$resguardante->codigo}}</option>
                                      <option value="No Aplica">Elegir otro resguardante</option>
                                      @foreach($empleados as $empleado)
                                          <option value="{{$empleado->id}}">{{$empleado->nombre}} - {{$empleado->codigo}}</option>
                                      @endforeach
                                  </select>
                              </div>
                        </div>
                        <br>
                        <div class="row g-3 align-items-center">
                            <div class="col-md-3">
                                <label for="tipo_equipo">Tipo de Equipo </label>
                                <select class="form-control" id="tipo_equipo" name="tipo_equipo">
                                    <option selected value="{{$equipo->tipo_equipo}}" >{{$equipo->tipo_equipo}}</option>
                                    @foreach($tipo_equipos as $tipos)
					<option value="{{$tipos->tipo_equipo}}">{{$tipos->tipo_equipo}}</option>
				    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="marca">Marca </label>
                                <input type="text" class="form-control" id="marca" name="marca" value="{{$equipo->marca}}" >
                            </div>

                            <div class="col-md-3">
                                <label for="modelo">Modelo </label>
                                <input type="text" class="form-control" id="modelo" name="modelo" value="{{$equipo->modelo}}" >
                            </div>
                            <div class="col-md-3">
                                <label for="numero_serie">Número de Serie </label>
                                <input type="text" class="form-control" id="numero_serie" name="numero_serie" value="{{$equipo->numero_serie}}" >
                            </div>
                        </div>
                        <br>
                        <div class="row g-3 align-items-center">
                            <div class="col-md-4">
                                <label for="mac">MAC separado por ":" ej 18:AB:34:45 </label>
                                <input type="text" class="form-control" id="mac" name="mac" value="{{$equipo->mac}}" >
                            </div>
                            
                            <div class="col-md-4">
                                <label for="tipo_conexion">Tipo de Conexión</label>
                                <select class="form-control" id="tipo_conexion" name="tipo_conexion">
                                    <option value="{{$equipo->tipo_conexion}}" selected>{{$equipo->tipo_conexion}}</option>
                                    <option disabled>Elegir otra opción</option>
                                    <option value="No Aplica">No Aplica</option>
                                    <option value="Red Cableada">Red Cableada</option>
                                    <option value="Solo Wifi<">Solo Wifi</option>
                                    <option value="Wifi y Ethernet">Wifi y Ethernet</option>
                                    <option value="Sin conexión">Sin conexión</option>
                                </select>
                            </div>
                        </div>
			<br>
                        <div class="row g-3 align-items-center">
                            <div class="col-md-6">
                                <label for="resguardante">Resguardante</label>
                                <select name="resguardante" id="resguardante" class="form-control">
				                    <option selected="">Elegir</option>
                                    <option value="{{$equipo->resguardante}}" selected>{{$equipo->resguardante}}</option>
                                    <option value="Otra dependencia">Otra dependencia</option>
                                    <option value="CTA">CTA</option>
                                    <option value="No inventariable">No inventariable</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="localizado_sici">localizado entrega recepción</label>
                                <select name="localizado_sici" id="localizado_sici" class="form-control">
                                    <option value="{{$equipo->localizado_sici}}" selected>{{$equipo->localizado_sici}}</option>
				    <option disable>Elegir</option>
                                    <option value="No">No</option>
                                    <option value="Si">Si</option>
                                </select>
                            </div>
                        </div>

                        <br>
                        <div class="row g-3 align-items-center">
                            <div class="col-md-12">
                                <label for="detalles">Detalles</label>
                                <textarea class="form-control" id="detalles" name="detalles">{{$equipo->detalles}}</textarea>
                            </div>
                        </div>
                        <br>
                        <hr>
                        <h5>Asignar ip</h5>
                        <div class="row g-3 align-items-center">
                            
                            <div class="col-md-4">
                                <label for="ip">IP </label>
                                <select class="form-control" id="js-example-basic-single2" name="ip_id">
                                            @if ($ip_equipo!=null)
                                                <option value="{{$ip_equipo->ip}}" selected>{{$ip_equipo->ip }} /subred:  {{ $subred_equipo->subred}} </option>
                                                <option value="No Especificado">No Especificado</option>
                                            @else
                                                <option value="No Especificado" selected>No Especificado</option>
                                            @endif



                                        @foreach($ips as $ip)
                                            <option value="{{$ip->ip}}">{{$ip->ip  }}/ subred: {{ $ip->subred}}</option>
                                        @endforeach
                                </select>

                

                            </div>
                            <div class="col-md-5">
                                <label for="tipo_conexion">Mascara de red</label>
                                @if ($ip_equipo!=null)
                                <input type="text" class="form-control" id="mascara" name="mascara"
                                                       pattern="[0-5]{3}\.[0-5]{3}\.[0-5]{3}\.[0-9]{1,3}"
                                                       title="El campo debe ser llenado en el formato correcto.
                                                        &#013; Ejemplo: (255.255.255.0)"
                                                       placeholder="255.255.255.255"
                                                       value="{{$ip_equipo->mascara}}">
                                @else
                                <input type="text" class="form-control" id="mascara" name="mascara"
                                                       pattern="[0-5]{3}\.[0-5]{3}\.[0-5]{3}\.[0-9]{1,3}"
                                                       title="El campo debe ser llenado en el formato correcto.
                                                        &#013; Ejemplo: (255.255.255.0)"
                                                       placeholder="255.255.255.255"
                                                       value="">
                                @endif
                            </div>
                            <div class="col-md-5">
                                @if ($ip_equipo!=null)
                                <label for="tipo_conexion">Gateway</label>
                                <input type="text" class="form-control" id="gateway" name="gateway"
                                            pattern="[0-9]{3}\.[0-9]{3}\.[0-9]{1,3}\.[0-9]{1,3}"
                                            title="El campo debe ser llenado en el formato correcto.
                                            &#013; Ejemplo: (192.168.1.1)"
                                            placeholder="192.168.1.1"
                                            value="{{$ip_equipo->gateway}}">
                                @else
                                <label for="tipo_conexion">Gateway</label>
                                <input type="text" class="form-control" id="gateway" name="gateway"
                                            pattern="[0-9]{3}\.[0-9]{3}\.[0-9]{1,3}\.[0-9]{1,3}"
                                            title="El campo debe ser llenado en el formato correcto.
                                            &#013; Ejemplo: (192.168.1.1)"
                                            placeholder="192.168.1.1"
                                            value="">
                                @endif

                            </div>

                        </div>
                        <br>
                        <br>

                <br>
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <a href="{{ route('home') }}" class="btn btn-danger">Cancelar</a>
                        <button type="submit" class="btn btn-success">Guardar datos</button>
                    </div>
                </div>
            </form>
            <br>
            <div class="row g-3 align-items-center">

                <br>
                <h5>En caso de inconsistencias enviar un correo a victor.ramirez@academicos.udg.mx</h5>
                <hr>

            </div>
    </div>

    @else
        El periodo de Registro de Proyectos a terminado
    @endif

@endsection
