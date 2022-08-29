<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Detalle de la información del Personal</title>

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
    <div class="row">
        <div class="col">
            <p class="text-center"><img class="img-responsive" src="images/logo.jpg" width="100%"></p>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <p><b>ID:</b> {{$personal->id}} <b>Código:</b> {{$personal->Codigo}} <b>Fecha: </b> {{date('d/m/Y', $timestamp = time())}}</p>
            <p><b>Información del Personal:</b></p>
            <p><b>Nombre:</b> {{$personal->NombreYApellidos}} <b>Nacionalidad:</b>{{$personal->Nacionalidad}}</p>
            <p><b>Teléfono Celular: </b> {{$personal->TelefonoCelular}} <b>Teléfono:</b> {{$personal->Telefono}} <b>Correo Electrónico:</b> {{$personal->CorreoE}}</p>
            <p><b>Domicilio: </b> {{$personal->Domicilio}} <b>Código Postal:</b> {{$personal->CodigoPostal}}</p>
            <p><b>RFC:</b> {{$personal->RFC}} <b>CURP:</b> {{$personal->CURP}}</p>
            <p><b>Adscrito:</b></p>
            <p><b>Nombramiento: </b>{{$personal->NombramientoDirectivoTemporal}}</p>
            <p><b>Categoría: </b>{{$personal->Categoria}}</p>
            <p><b>Departamento Adscrito: </b>{{$personal->DepartamentoAdscripcion}}</p>
            <p><b>Departamento Laboral: </b>{{$personal->DepartamentoLabora}}</p>
            <p><b>División: </b>{{$personal->Division}} <b></p>
            <p><b>Observaciones: </b>{{$personal->OBSERVACIONES_1}}</p>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <br>
            <br>

            <p class="pie">Hora y día de Impresión:  {{ date('d-m-Y H:i:s') }}<br>
                Realizado por:  {{ Auth::user()->name }}<br>
                Formato CTA-011. Actualización: 28/Abril/2022</p>
        </div>
    </div>
</div>
</body>
</html>
