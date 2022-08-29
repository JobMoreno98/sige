
<?php
session_start();
include './loginSecurity.php';

date_default_timezone_set("America/Mexico_City");

if(isset($_GET['idticket']) && $_GET['idticket']!=''){ $IdTicket=$_GET['idticket'];}

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Reportar Ticket no Concluído. SIGE. BPEJ</title>
        <link rel="shortcut icon" href="favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Equipo de Desarrollo BPEJ">
         <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
        <!--bootstrap-->
        <link rel="stylesheet" href="css/bootstrap.css"><!-- Editado para el menu -->
        <!--jquery-->
        <script src="js/jquery-3.2.1.min.js"></script>
        <!--bootstrap-js-->
        <script src="js/bootstrap.min.js"></script>
        <style>
            .form-control {
                margin-bottom: 12px;
            }
        </style>

    </head>
    <body>
        <?php

          include 'barraMenu.php';
        $menu = new menu();
        $menu ->barraMenu();


        include 'ticket.php';
        $ticket = new ticket();
        $ticket->setIdTicket($_GET['idticket']);
        ?>
        <div class="container">
            <div class="page-header">
                <div class="row">

    <div class="col-xs-12"><h3 style="text-align: center">Reporte de Tickets no Concluídos
       <br>
        <small> Sistema Integral de Gestión. BPEJ</small></h3></div>
</div>

            </div>
<?php
            echo '<div class="panel panel-default">
              <div class="panel-heading"><h4>Datos del Ticket Número: '.$ticket->getIdTicket().'</h4></div>
              <div class="panel-body">';

                         $ticket->ticketBuscarID();

                      echo '</div>
                       </div>';

                       ?>
            <form action="aplicarMovimiento.php" class="form-horizontal" method="post"
                  onsubmit="return confirm('¿Seguro que quieres guardar este formulario?');">


                      <div class="form-group">

                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <label for="IdTicket">IdTicket</label>
                            <input class="form-control" id="IdTicket" name="IdTicket" value="<?php echo $IdTicket; ?>" readonly>
                        </div>
                       <div  class="col-xs-12 col-sm-6 col-md-6">
                            <label for="fechaReporte">Fecha de Reporte</label>
                            <input class="form-control" id="fechaReporte" type="date" name="fechaReporte" value="<?php echo date('Y-m-d'); ?>" readonly>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <label for="reporte">Descripción Adicional del problema</label>
                            <input class="form-control" id="reporte" type="text" name="reporte" placeholder="Reporte" value="-">
                        </div>
                         <div class="col-xs-12 col-sm-6 col-md-6">
                            <label for="email">Si desea ser contactado por email  o extensión respecto a su comentario puede dejar sus datos el cúal será utilizado únicamente para informarle del seguimiento de su reporte (Opcional)</label></div><div class="col-xs-12 col-sm-6 col-md-6">
                            <input class="form-control" id="reporte" type="text" name="email" value="">
                        </div>
                    </div>




                    <div class="form-group">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <button type="submit" class="btn btn-primary" name="reporteAlta">Guardar</button>

                            <button name="Salir" class="btn btn-default" onclick="window.close();" >Regresar</button>
                        </div>
                    </div>

                </form>


        <br>
    </body>
</html>
