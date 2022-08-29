<?php
session_start();
 ?>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>BPEJ. Sistema Integral de Gestión</title>
        <link rel="shortcut icon" href="favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Valentín Camacho Veloz, Daniel Flores Rodriguez, Brian Valentín Franco, Nancy García Mesillas">
        <!--bootstrap-->
        <link rel="stylesheet" href="css/bootstrap.css"><!-- Editado para el menu -->
        <!--jquery-->
        <script src="js/jquery-3.2.1.min.js"></script>
        <!--bootstrap-js-->
        <script src="js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function() {
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="format-detection" content="telephone=no"/>
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
        <link href="css/estilos.css" rel="stylesheet">

    </head>
    <body background="images/biblioteca_.jpg" style="background-attachment: fixed" >
      <?php
          include 'barraMenu.php';
          $menu = new menu();
          $menu ->barraMenu();


       ?>
          <br>
          <br>
          <br>
          <div class="row">
            <br>
            <form class="form-horizontal" action="ticketsMostrar.php" method="GET" ><div class="row">
              <div class="form-group-sm" >
                <div class="col-xs-12 col-md-12">
                  <br>
    		            <center><h3 for="IdTicket">Ingresa el número de ticket a consultar.</h3></center>
                  </div>
                </div>
                <div class="form-group-sm" >
                  <div class="col-xs-12 col-sm-4 col-sm-offset-4">
                    <center><input  id="IdTicket"   name="IdTicket" type="text" class="form-control" ></center>
                    <br>
                  </div>

                </div>
              </div>
              <div class="row">
                <div class="form-group" class="col-xs-6 col-sm-3 col-sm-offset-3">
                  <div>
                    <center><input id="submit" type="submit" name="submit" class="btn  btn-md btn btn-primary  active" value="Consultar">
                      <button id="btn-limpiar" type="reset" name="limpiar" class="btn btn-danger active"> Limpiar <i class="fa fa-trash"></i> </button></center>
					        </div>
    	          </div>
             </div>
           </form>
           <div class="col-sm-offset-2 col-sm-8">
             <p class="mensaje"></p>
    	    </div>
        </div>


    <script src="http://code.jquery.com/jquery.js"></script>
        <script src="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.js"></script>



    </body>
    </html>
