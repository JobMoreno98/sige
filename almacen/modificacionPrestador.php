<?php
require 'conexionPrestadores.php';

date_default_timezone_set("Mexico/General"); 

session_start();
include '../sige/loginSecurity.php';
     if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'Prestadores' ) {
    header('location: index.php');
}
$_SESSION["codigo"]=$_GET['codigo'];
$_SESSION["IdPrestacion"]=$_GET['prestacion'];
if(!empty($_POST)){
    

//print_r($_POST);

$codigoPrestador=$_POST[codigoPrestador];
$nombrePrestador=$_POST[nombrePrestador];
$institucion=$_POST[institucion];
$IdPersona=$_POST[IdPersona];
$estatus=$_POST[estatus];
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
$queryu = $pdo->prepare("UPDATE persona SET codigo = :codigo, nombre=:nombre, IdPrestacion=:IdPrestacion, fechaInicio=:fechaInicio, fechaTermino=:fechaTermino, estatus = :estatus WHERE IdPersona=:IdPersona;");

$queryu->bindValue(':codigo', $codigoPrestador);
$queryu->bindValue(':nombre', $nombrePrestador);
$queryu->bindValue(':IdPrestacion', $institucion);
$queryu->bindValue(':fechaInicio', $fechaInicio);
$queryu->bindValue(':fechaTermino', $fechaFin);
$queryu->bindValue(':estatus', $estatus);
$queryu->bindValue(':IdPersona', $IdPersona);


$queryu->execute(); 
echo $queryu->rowCount() . " records UPDATED successfully";
header("Location:prestadoresConsulta.php");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Modificación Prestador de Servicio o Prácticas</title>
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
         
          <?php  
          $pdo1 = new Conexion();
            $query1 = $pdo1->prepare('SELECT * FROM vs_prestadores WHERE codigo = :codigo AND IdPrestacion = :IdPrestacion;');
            $query1->bindValue(':codigo',$_SESSION["codigo"]);
            $query1->bindValue(':IdPrestacion',$_SESSION["IdPrestacion"]);
            $query1->execute();
            $resultado1 = $query1->fetchAll();
            foreach ($resultado1 as $key => $value1) 
            {
            }
         ?>
            <div class="panel-group">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" href="#collapse1"><center>
                                  <span class="glyphicon glyphicon-triangle-top"></span><?php echo $filtrado; ?></center></a>
                        </h4>
                    </div>
                    <div id="collapse1" class="panel-collapse collapse in">
                        
                    <div class="panel-body">
                    <form name="formulario" id="frmNewReq" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
                            <div class="form-group">
                                <div class='row'>
                                <div class='col-xs-2 col-sm-2'><label for="IdPersona">IdPrestador</label></div>
                                <div class='col-xs-4 col-sm-4'><input type="text" class="form-control" id="IdPersona" name="IdPersona" placeholder="Código" value="<?php echo $value1['IdPersona'];?>" readonly></div>
                                <div class='col-xs-2 col-sm-2'><label for="codigoPrestador">Código</label></div>
                                <div class='col-xs-4 col-sm-4'><input type="text" class="form-control" id="codigoPrestador" name="codigoPrestador" placeholder="Código" value="<?php echo $value1['codigo'];?>" required></div>
                                <div class='col-xs-2 col-sm-2'><label for="nombrePrestador">Nombre</label></div>
                                <div class='col-xs-4 col-sm-4'><input type="text" class="form-control" id="nombrePrestador" name="nombrePrestador" placeholder="Nombre" value="<?php echo $value1['nombre'];?>"required></div>
                                <div class='col-xs-2 col-sm-2'><label for="estatus">Estatus</label></div>
                                <div class='col-xs-4 col-sm-4'><select id="estatus" name="estatus" type="text" class="form-control">
                                <option value="<?php echo $value1['estatus'];?>"><?php echo $value1['estatus'];?></option>
                                <option value="Activo">Activo</option>
                                <option value="Baja">Baja</option>
                                <option value="Terminado">Terminado</option>

                                </select></div>
                                
                                </div>
                                <div class='row'>
                                <div class='col-xs-4 col-sm-4'><label for="institucion">Institución y Prestación</label></div>
                                <div class='col-xs-8 col-sm-8'><select id="institucion" name="institucion" type="text" class="form-control">
                                <option value="<?php echo $value1['IdPrestacion'];?>"><?php echo $value1['institucion'].",".$value1['prestacion'];?></option>
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
                                
                
                            <div class='col-xs-3 col-sm-3'><label for="date1"> Fecha Inicial </label></div>
                            <div class='col-xs-3 col-sm-3'><input type="text" class="form-control" id="date1" name="date1" placeholder="Fecha Inicial" value="<?php echo $value1['fechaInicio'];?>" ></div>
                           
                        
                            <div class='col-xs-3 col-sm-3'><label for="date2"> Fecha Límite </label></div>
                            <div class='col-xs-3 col-sm-3'><input type="text" class="form-control" id="date2" name="date2" placeholder="Fecha Límite" value="<?php echo $value1['fechaTermino'];?>"></div>
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
