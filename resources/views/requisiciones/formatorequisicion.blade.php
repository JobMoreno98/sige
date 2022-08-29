<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Imprimir de requisición. SIGE</title>

    <!-- Styles -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">

    <style>
        .pie {
            font-size: 10px;
            text-align: right;
        }

        td {
            font-size: 12px;
        }
    </style>
</head>

<body>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <p class="text-center"><img class="img-responsive" src="images/logo.jpg" width="100%"></p>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" colspan="2">
                                <center>
                                    <h5>REQUISICIÓN DE ARTÍCULOS DE SERVICIOS E INVENTARIO</h5>
                                </center>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><b>SOLICITUD:</b> {{ $requisicion->num_sol }}</td>
                            <td><b>DIA / MES / AÑO
                                </b>{{ \Carbon\Carbon::parse($requisicion->fecha_inicio)->format('d/m/Y') }} </td>
                        </tr>
                        <tr>
                            <td class="thead-light" colspan="2" bgcolor="#E8E8E8"><b> LUGAR EN QUE SE REQUIEREN LOS
                                    ARTÍCULOS</b></td>
                        </tr>
                        <tr>
                            <td class="thead-light" colspan="2">COORDINACIÓN PARA TECNOLOGÍAS DEL APRENDIZAJE</td>
                        </tr>
                    </tbody>
                </table><br>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">
                                <center>CODIGO</center>
                            </th>
                            <th scope="col">
                                <center>DESCRIPCIÓN</center>
                            </th>
                            <th scope="col">
                                <center>CANTIDAD</center>
                            </th>
                            <th scope="col">
                                <center>OBSERVACIÓN</center>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($articulos as $item)
                            <tr>
                                <td>{{ $item->codigo }}</td>
                                <td>{{ $item->descripcion }}</td>
                                <td>{{ $item->cantidad }}</td>
                                <td>{{ $item->observacion }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
        </div>
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <br>
                <br>
                <br>
                <br><br>
                <p class="pie">Hora y día de Impresión: {{ date('d-m-Y H:i:s') }}<br>
                    Realizado por: {{ Auth::user()->name }}<br>
                    Formato CTA-010. Actualización: 28/abril/2021</p>
            </div>
        </div>
    </div>
</body>

</html>
