<?php
session_start();
$host= $_SERVER["HTTP_HOST"];
$url= $_SERVER["REQUEST_URI"];
$_SESSION['direccionURL']="http://" . $host . $url;

include './loginSecurity.php';

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Detalle Mueble. SIGE. BPEJ</title>
        <link rel="shortcut icon" href="favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--bootstrap-->
        <link rel="stylesheet" href="css/bootstrap.css"><!-- Editado -->
        <!--jquery-->
        <script src="js/jquery-3.2.1.min.js"></script>
        <!--bootstrap-js-->
        <script src="js/bootstrap.min.js"></script>
    </head>
    <body>
        <img src="images/logoccd.jpg">
        <img src="images/BIBLIOTECA_logotipo.jpg"  style="float: right">
        <div class="container">
            <br>
            <a href="muebleConsulta.php" class="btn btn-default btn-sm" role="button">
                <span class="glyphicon glyphicon-step-backward"></span> Regresar</a>
            <h3><center>Detalle Mueble</center></h3><!-- Cambiar título -->
            <div class="panel-group">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" href="#collapse1"><center>
                                  <span class="glyphicon glyphicon-book"></span> Informaci&oacute;n</center></a>
                        </h4>
                    </div>
                    <div id="collapse1" class="panel-collapse collapse in">
                        <div class="panel-body">
                            <?php
                            include 'mueble.php';
                            $con = new mueble();
                            $con ->setIdMobiliario($_GET['id']);
                           
                                    
                                    
                                    $con ->datosMueble();
                                           
                                    


                                    
                            ?>  
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </body>
</html>
