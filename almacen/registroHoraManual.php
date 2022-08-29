<?php
require 'conexionPrestadores.php';

date_default_timezone_set("Mexico/General"); 



session_start();
include '../sige/loginSecurity.php';
     if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'Prestadores' ) {
    header('location: index.php');
}
//print_r($_GET);

$codigo=$_GET['codigo'];


if(!empty($_POST)){
//print_r($_POST);

$codigoPrestador=$_POST[codigoPrestador];
$fechaRegistro=$_POST[fecha];
$horaRegistro=$_POST[hora];

if(isset($horaRegistro) AND $horaRegistro!=''){
   
    
}
$fechaFinal=$fechaRegistro." ".$horaRegistro;
//echo $codigoPrestador;
//echo $fechaRegistro;
//echo $horaRegistro;
//echo $fechaFinal;


$pdo = new Conexion();
$queryi = $pdo->prepare('INSERT INTO `asistencias`(`codigo`, `fecha`, `tipo`) VALUES (:codigo,:fecha,:tipo);');
$queryi->bindValue(':codigo', $codigoPrestador);
$queryi->bindValue(':fecha', $fechaFinal);
$queryi->bindValue(':tipo', 'Salida');
$queryi->execute(); 
header("Location:prestadoresConsulta.php");   
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Registro Manual de Checada</title>
        <link rel="shortcut icon" href="favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--bootstrap-->
        <link rel="stylesheet" href="css/bootstrap.css"><!-- Editado -->
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <!--jquery-->
        <script src="js/jquery-3.2.1.min.js"></script>
        <!--bootstrap-js-->
        <script src="js/bootstrap.min.js"></script>   
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script>
            $( function() {
            $( "#date1" ).datepicker({dateFormat:"yy-m-d"});
            $( "#date2" ).datepicker({dateFormat:"yy-m-d"});
            } );
        </script>

    </head>
    <body>
        <?php
          include 'barraMenu.php';
        $menu = new menu();
        $menu ->barraMenu();
      ?>
        <div class="container-fluid">
          
            
          
            <div class="panel-group">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">Registro Manual de Checada
                          <a data-toggle="collapse" href="#collapse1"><center>
                                  <span class="glyphicon glyphicon-triangle-top"></span><?php echo $filtrado; ?></center></a>
                        </h4>
                    </div>
                    <div id="collapse1" class="panel-collapse collapse in">
                        
                    <div class="panel-body">
                    <form name="formulario" id="frmNewReq" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
                            <div class="form-group">
                                <div class='row'>
                                    <div class='col-xs-6 col-sm-3 col-md-2'><label for="codigoPrestador">Código</label></div>
                                    <div class='col-xs-6 col-sm-3 col-md-2'><input type="text" class="form-control" id="codigoPrestador" name="codigoPrestador" placeholder="Código" value="<?php echo $codigo; ?>"readonly></div>
                                <div class='col-xs-6 col-sm-2 col-md-2'><label for="fecha">Fecha</label></div>
                                <div class='col-xs-6 col-sm-3 col-md-2'><input type="date" class="form-control" id="fecha" name="fecha" placeholder="Fecha"></div>
                                    </div>
                                <br>
 
                                <br>
                              <div class='row'>
                
                            <div class='col-xs-3 col-sm-2'><label for="hora"> Hora Ej. 14:00  </label></div>
                            <div class='col-xs-3 col-sm-3'><input type="text" class="form-control" id="hora" name="hora" placeholder="hora"></div>

                            </div>
                        </div>
                 <button type="submit" class="btn btn-success">Guardar</button>
                 <input type="button" class="btn btn-danger" onclick="history.back()" value="Cancelar">
                        <br>
                        <hr>
                    </form>
       
        
       
            
         
                                    


                           
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </body>
</html>
