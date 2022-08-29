
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>BAJA</title>

    <!-- Styles -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">

<style>
    .pie{
        font-size: 10px;
        text-align: right;
    }
    
    

    table{
        padding:0%;
        
        table-layout: fixed;
        min-width: 100%;
        max-width: 100%;
       
        
    }

    td {       
	    font-size: 13px;
        white-space: pre-line;
    
	}

    th{
        font-size: 12px;
        white-space:pre-line;
    }
    
    
    .container{
        
        margin-left: 0; 
    }
    div{
        width: 126%;
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
                <th scope="col" colspan="2"><h5>Formato de baja</h5></th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td><b>Folio:</b> {{$baja->id}}</td>
                    <td><b>Dependencia:</b> {{$baja->dependencia}}</td>
                    
                </tr>
                <tr>
                    <td><b>Fecha de creacion: </b> {{\Carbon\Carbon::parse($baja->fecha_de_creacion)->format('d/m/Y')}}</td>
                    <td><b>Fecha de finalización:</b> {{\Carbon\Carbon::parse($baja->fecha_de_finalizacion)->format('d/m/Y')}}</td>
                   
            </tbody>
        </table>
                <br>
                <br>
        @foreach ($item as $items)
        <table class="table table-bordered" >
            <thead class="thead-light">
            
            
                <th align="center"class="thead-light" colspan="3"><b>Descripción</b></th>
                <th align="center" colspan="3"><b>Motivo de la baja</b></th>
                <th align="center"><b>Año de  adquisición</b></th>
               
                
            </thead>
            
    
            <tbody>
                 
                <tr>
                    
                    <tr>
                    <td align="center" colspan="3"><b>{{$items->descripcion}}</b></td>
                    <td align="center" colspan="3"><b>{{$items->motivo_baja}}</b></td>
                    <td align="center"><b>{{$items->ano_adquisicion}}</b></td>
                    
                    
                    </tr>
                </tbody>

                    <thead class="thead-light">
                        <th align="center"><b>Fecha de revisión</b></th>
                        <th align="center" colspan="1"><b>encargado de revisión</b></th>
                        <th align="center" colspan="2"><b>encargado de revicion de mantenimiento</b></th>
                        <th align="center" colspan="3"><b>Motivo de no reparacion</b></th>
        
                    </thead>
                    
                <tbody>
                    <tr>
                        <td align="center"><b>{{\Carbon\Carbon::parse($items->fecha_revision)->format('d/m/Y')}}</b></td>
                        <td align="center" colspan="1"><b>{{ucwords($items->encargado_revicion)}}</b></td>
                        <td align="center" colspan="2"><b>{{ucwords($items->encargado_revicion_mantenimiento)}}</b></td>
                        <td align="center" colspan="3"><b>{{$items->motivo_de_no_reparacion}}</b></td>
                    </tr>
                    
                   
                    </tr>
                </tbody>
                
            
        </table>
        @endforeach
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <br>
                <br>
    
                <p class="pie">Hora y día de Impresión:  {{ date('d-m-Y H:i:s') }}<br>
                    Realizado por:  {{ Auth::user()->name }}<br>
                    Formato CTA-010. Actualización: 28/abril/2021</p>
            </div>
        </div>
    </div>
</body>