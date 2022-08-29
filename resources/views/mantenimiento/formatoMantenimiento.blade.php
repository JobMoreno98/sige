<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Mantenimiento. SIGE</title>

    <!-- Styles -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">

<style>
    .pie{
        font-size: 10px;
        text-align: right;
    }
    td {
	font-size: 12px;
	}
</style>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <p class="text-center"><img class="img-responsive" src="images/logo.jpg" width="100%"></p>


        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-xs-12">
    <table class="table table-bordered" >
        <thead class="thead-light">
        <tr>
            <th scope="col" colspan="2"><h5>Formato de Mantenimiento</h5></th>
        </tr>
        </thead>
        <tbody>
            <tr>
                <td><b>Folio:</b> {{$mantenimiento->id}}</td>
                <td><b>Fecha: </b> {{$mantenimiento->fecha_mantenimiento}}</td>
            </tr>
            <tr>
                {{-- <td><b>Tipo:</b> {{$prestamo->estado}}</td> --}}
                <td><b>Solicitante: </b> {{$mantenimiento->nombre}}</td>
            </tr>
            <tr>
                <td><b>Contacto: </b> {{$mantenimiento->telefono}}</td>
                {{-- <td><b>Cargo: </b> {{$prestamo->cargo}}</td> --}}
            </tr>
            <tr>
                <td colspan="2"><b>Lugar:</b> {{$mantenimiento->sede. ', '.$mantenimiento->edificio. ', '. $mantenimiento->piso. ', '.$mantenimiento->division. ', '. $mantenimiento->coordinacion. ', '. $mantenimiento->area}}</td>
            </tr>
            {{-- <tr>
                <td colspan="2"><b>Equipos:</b> {{$prestamo->lista_equipos}}</td>
            </tr> --}}
            {{-- <tr>
                <td colspan="2"><b>Observaciones:</b> {{$prestamo->observaciones}}</td>
            </tr> --}}
        </tbody>
    </table>
            <br>
            <br>
    <table class="table table-bordered" >

        <tbody>
            <tr>
                <td align="center"><b>Entrega</b></td>
                <td align="center"><b>Recibe</b></td>
            </tr>
            <tr>
                <td align="center"><b>Nombre</b></td>
                <td align="center"><b>Nombre</b></td>
            </tr>
            <tr>
                <td><br></td>
                <td><br></td>
            </tr>
            <tr>
                <td align="center"><b>Firma:</b></td>
                <td align="center"><b>Firma:</b></td>
            </tr>
            <tr>
                <td><br></td>
                <td><br></td>
            </tr>
        </tbody>
    </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <br>
            <br>

            <p class="pie">Hora y día de Impresión:  {{ date('d-m-Y H:i:s') }}<br>
                Realizado por:  {{ Auth::user()->name }}<br>
                Formato CTA-010. Actualización: 22/Febrero/2022</p>
        </div>
    </div>
</div>
</body>
</html>
