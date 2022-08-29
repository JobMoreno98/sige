


<?php

include_once 'ticket.php';
$ticket = new ticket();
$ticket->setIdTicket($_GET['IdTicket']);

 ?>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>BPEJ. Sistema Integral de Gestión</title>
        <link rel="shortcut icon" href="favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Equipo de Desarrollo BPEJ">
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
  <body>
    <?php
        include 'barraMenu.php';
        $menu = new menu();
        $menu ->barraMenu();

    ?>
    <div class="container">

       <h3><center>Datos del ticket. </center></h3><!-- Título de módulo -->
       <?php $ticket->ticketBuscarID();


       echo "<div class='row'>";
       echo '<div class="col-xs-12 col-sm-12"><br><a href="ticketReporte.php?idticket='.$ticket->getIdTicket().'" class="btn btn-danger btn-sm"> Reportar como no Concluído </a></div>';
       echo "</div>";
       ?>
       <br> <br>
       <div class="row">
         <div class="col-xs-12 col-sm-12">
           <center><br><br><a href="index.php" class="btn btn-primary"> Regresar </a></center>
         </div>
       </div>
       <br>
    </div>
   </body>
</html>
