<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Expediente</title>

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
                <th scope="col" colspan="2"><h5>Expediente equipo</h5></th>
            </tr>
            </thead>
            
        </table>

        <table class="table table-bordered" >
            <thead class="thead-light">
            <tr>
                <th scope="col" colspan="2"><h6>Información del equipo</h6></th>
            </tr>
            </thead>

            <tbody>
                <tr>
                    <td ><b>ID del equipo:</b> {{$expediente->idE}}</td>
                    <td rowspan="1"><b>Tipo de equipo :</b> {{$expediente->tipoE}} </td>
                    
                </tr>
                <tr>
                    <td><b>Marca del equipo: </b> {{$expediente->marcaE}}</td>
                    <td><b>Modelo del equipo: </b> {{$expediente->modeloE}}</td>
                </tr>
                <tr>
                    <td colspan="2"><b>Descripcion: </b>{{$expediente->detalleE}}</td>
                </tr>
                    
                    
                   
            </tbody>
            
        </table>

        
        @if ($Vsmantenimiento)
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th scope="col" colspan="2"><h6>Mantenimientos</h6></th>
                </tr>
                </thead>
                <tbody>
                   
                    @foreach ($Vsmantenimiento as $Vsmantenimientos)
                    <tr>
                        <td ><b>Fecha:</b> {{\Carbon\Carbon::parse($Vsmantenimientos->created_at)->format('d/m/y')}}</td>
                        <td><b>Detalles: </b>{{$Vsmantenimientos->detalles}}</td>
                    </tr>
                    @endforeach
                   
                </tbody>
            
        </table>
        @endif
        
       
        @if($VsTicket)
        <table class="table table-bordered" >
            <thead class="thead-light">
            <tr>
                <th scope="col" colspan="3"><h6>Tickets</h6></th>
            </tr>
            </thead>

            <tbody>
                @foreach ($VsTicket as $VsTickets)
                <tr>
                    <td ><b>ID Ticket: </b>{{$VsTickets->id}}</td>
                    <td><b>UdeG ID: </b>{{$VsTickets->udg_id}}</td>
                    <td><b>Resguardante</b> {{$VsTickets->resguardante}} </td>
     
                </tr>
                <tr>
                    <td  colspan="3"><b>Comentarios: </b>{{$VsTickets->comentarios}}</td>
                </tr>
                @endforeach
                
                    
                    
                   
            </tbody>
            
        </table>
        @endif


        @if($Vsproyecto)
        <table class="table table-bordered" >
            <thead class="thead-light">
            <tr>
                <th scope="col" colspan="3"><h6>Proyectos</h6></th>
            </tr>
            </thead>

            <tbody>
                @foreach ($Vsproyecto as $Vsproyectos)
                <tr>
                    
                    <td><b>Fecha de inicio: </b>{{\Carbon\Carbon::parse($Vsproyectos->fecha_inicio)->format('d/m/y')}}</td>
                    <td><b>Fecha de Fin: </b>{{\Carbon\Carbon::parse($Vsproyectos->fecha_fin)->format('d/m/y')}}</td>
                    
     
                </tr>
                <tr>
                    <td ><b>Titulo: </b>{{$Vsproyectos->titulo}}</td>
                    <td  colspan="2"><b>area interna: </b>{{$VsTickets->comentarios}}</td>
                </tr>
                @endforeach
                
                    
                   
            </tbody>
            
        </table>
        @endif


        @if($Vsrevicion)
        <table class="table table-bordered" >
            <thead class="thead-light">
            <tr>
                <th scope="col" colspan="3"><h6>Revición Express</h6></th>
            </tr>
            </thead>

            <tbody>
                @foreach ($Vsrevicion as $Vsreviciones)
                <tr>
                    
                    <td colspan="3" ><b>Sede: </b>{{$Vsreviciones->sede}} <b> Edificio: </b>{{$Vsreviciones->edificio}} <b> Piso:</b> {{$Vsreviciones->piso}}
                    <br><b>Fecha: </b> {{\Carbon\Carbon::parse($Vsreviciones->fechaHora)->format('d/m/y')}} <b> Hora: </b>{{\Carbon\Carbon::parse($Vsreviciones->fechaHora)->format('h/m/s')}}
                    <br><b> Estatus: </b>{{$Vsreviciones->estatus}}
                    </td>
                    
                    
     
                </tr>
                
                @endforeach
                
                    
                   
            </tbody>
            
        </table>
        @endif



        
              
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