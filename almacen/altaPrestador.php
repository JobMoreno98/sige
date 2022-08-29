<?php
require 'conexionPrestadores.php';

date_default_timezone_set("Mexico/General"); 

session_start();
include '../sige/loginSecurity.php';
     if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'Prestadores' ) {
    header('location: index.php');
}
if(!empty($_POST)){
$hoy=date("Y/m/d");


//print_r($_POST);

$codigoPrestador=$_POST[codigoPrestador];
$nombrePrestador=$_POST[nombrePrestador];
$institucion=$_POST[institucion];
if(isset($_POST[date1]) AND $_POST[date1]!=''){
    $fechaInicio=$_POST[date1];
}else {
    $fechaInicio=$hoy;
}
if(isset($_POST[date2]) AND $_POST[date2]!=''){
    $fechaFin=$_POST[date2];
}else{
    $fechaFin = date('Y-m-d', strtotime('+2 year')) ;
}
/*echo $codigoPrestador;
echo $nombrePrestador;
echo $institucion;
echo $fechaInicio;
echo $fechaFin;*/

$pdo = new Conexion();
$queryi = $pdo->prepare('INSERT INTO `persona`(`codigo`, `nombre`, `IdPrestacion`, `fechaInicio`, `fechaTermino`) VALUES (:codigo,:nombre,:IdPrestacion,:fechaInicio,:fechaFin);');
$queryi->bindValue(':codigo', $codigoPrestador);
$queryi->bindValue(':nombre', $nombrePrestador);
$queryi->bindValue(':IdPrestacion', $institucion);
$queryi->bindValue(':fechaInicio', $fechaInicio);
$queryi->bindValue(':fechaFin', $fechaFin);
$queryi->execute(); 
header("Location:prestadoresConsulta.php");   
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Alta Presador de Servicio o Prácticas</title>
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
                        <h4 class="panel-title">
                          <a data-toggle="collapse" href="#collapse1"><center> ALTA PRESTADOR 
                                  <span class="glyphicon glyphicon-triangle-top">  </span><?php echo $filtrado; ?></center></a>
                        </h4>
                    </div>
                    <div id="collapse1" class="panel-collapse collapse in">
                        
                    <div class="panel-body">
                    <form name="formulario" id="frmNewReq" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
                            <div class="form-group">
                                <div class='row'>
                                    <div class='col-xs-6 col-sm-3 col-md-2'><label for="codigoPrestador">Código</label></div>
                                    <div class='col-xs-6 col-sm-3 col-md-2'><input type="text" class="form-control" id="codigoPrestador" name="codigoPrestador" placeholder="Código" required></div>
                                <div class='col-xs-6 col-sm-3 col-md-2'><label for="nombrePrestador">Nombre</label></div>
                                <div class='col-xs-6 col-sm-3 col-md-2'><input type="text" class="form-control" id="nombrePrestador" name="nombrePrestador" placeholder="Nombre" required></div>
                                    </div>
                                <br>
                              <div class='row'>
                                <div class='col-xs-4 col-sm-3 col-md-3'><label for="institucion">Institución y Prestación</label></div>
                                <div class='col-xs-8 col-sm-6 col-md-6'><select id="institucion" name="institucion" type="text" class="form-control">
                                <option value="0">Sin seleccionar</option>
                                <?php
                              
                                $pdo = new Conexion();
                                $query = $pdo->prepare('SELECT IdPrestacion, institucion, prestacion FROM prestacion order by institucion;');
                             
                                $query->execute();
                                $resultado = $query->fetchAll();
                                foreach ($resultado as $key => $value) 
                                {
                                    echo "<option value=".$value['IdPrestacion'].">".$value['institucion'].",".$value['prestacion']."</option>";
                                }
                                ?>
                                
                              
                            
                                </select></div>
                                       </div>
                                <br>
                              <div class='row'>
                
                            <div class='col-xs-3 col-sm-2'><label for="date1"> Fecha Inicial </label></div>
                            <div class='col-xs-3 col-sm-3'><input type="text" class="form-control" id="date1" name="date1" placeholder="Fecha Inicial"></div>
                           
                        
                            <div class='col-xs-3 col-sm-2'><label for="date2"> Fecha Límite </label></div>
                            <div class='col-xs-3 col-sm-3'><input type="text" class="form-control" id="date2" name="date2" placeholder="Fecha Límite"></div>
                            </div>
                        </div>
                 <button type="submit" class="btn btn-success">Guardar</button>
                 <button type="submit" class="btn btn-danger" onclick="location.href='prestadoresConsulta.php'">Cancelar</button>
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
