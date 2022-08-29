<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Recibo de Equipo para Soporte. SIGE</title>

    <!-- Styles -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">

<style>
    .pie{
        font-size: 10px;
        text-align: right;
    }
    td, th, p {
        font-size: 12px;
    }
    h5 {
        font-size: 14px;
    }
</style>
</head>
<body>

<div class="container">
    <div class="row"><br>
        <div class="col">
            <p class="text-center"><img class="img-responsive" src="images/logo.jpg" width="100%"></p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" colspan="3"><center><b>Formato de recibo de equipo</b></center></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><b>Folio: </b>{{$ticket->id}}</td>
                        <td><b>Fecha: </b>{{\Carbon\Carbon::parse($ticket->fecha_reporte)->format('d/m/Y')}}</td>
                        <td><b>Técnico: </b>{{$ticket->tecnico}}</td>                    
                    </tr>
                    <tr>
                        <td colspan="2"><b>Solicitante: </b>{{$ticket->solicitante}}</td>
                        <td><b>Contacto: </b>{{$ticket->contacto}}</td>
                    </tr>
                    <tr>
                        <td colspan="3"><b>Área: </b>{{$ticket->area}}</td>
                    </tr>
                    <tr>
                        <td colspan="3"><b>Reporte: </b>{{$ticket->datos_reporte}}</td>
                    </tr>
                </tbody>

            </table>

            @foreach($equipoPorTickets as $equipoPorTicket)
                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" colspan="3"><center><b>Equipo Entregado a CTA</b></center></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><b>Id SIGE: </b> {{$equipoPorTicket->id}}</td>
                                    <td><b>Id UdeG: </b> {{$equipoPorTicket->udg_id}}</td>
                                    <td><b>Equipo: </b> {{$equipoPorTicket->tipo_equipo}}</td>
                                </tr>
                                <tr>
                                    <td><b>Marca: </b> {{$equipoPorTicket->marca}}</td>
                                    <td><b>Modelo: </b> {{$equipoPorTicket->modelo}}</td>
                                    <td><b>Núm. Serie: </b> {{$equipoPorTicket->numero_serie}}</td>
                                </tr>
                                <tr>
                                    <td colspan="3"><b>Detalles: </b> {{$equipoPorTicket->detalles}}</td>
                                </tr>
                                <tr>
                                    <td colspan="3"><b>Comentarios: </b> {{$equipoPorTicket->comentarios}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
            <table class="table table-bordered" >
                <tbody>
                    <tr>
                        <td align="center" colspan="2" style="background-color: #BEC6C7;"><b>Recepción del Equipo en CTA</b></td>
                    </tr>
                    <tr>
                        <td align="left" colspan="2"><b>Nombre de quién recibe: </b>____________________________________________________</td>
                    </tr>
                    <tr>
                        <td align="left"><b>Firma de recibido: </b>_______________________</td>
                        <td align="left"><b>Fecha:</b> _______________________</td>

                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered" >
                <tbody>
                    <tr>
                        <td align="center" colspan="2" style="background-color: #BEC6C7;"><b>Devolución del Equipo al Usuario</b></td>
                    </tr>
                    <tr>
                        <td align="left" colspan="2"><b>Nombre de quién recibe:</b> ____________________________________________________</td>
                    </tr>
                    <tr>
                        <td align="left"><b>Firma de recibido:</b> _______________________</td>
                        <td align="left"><b>Fecha:</b> _______________________</td>

                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <br>
            <br>

            <p class="pie">Hora y día de Impresión:  {{ date('d-m-Y H:i:s') }}<br>
                Realizado por:  {{ Auth::user()->name }}<br>
                Formato CTA-011. Actualización: 29/abril/2021</p>
        </div>
    </div>
</div>
</body>
</html>
