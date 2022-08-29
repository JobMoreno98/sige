<?php 
date_default_timezone_set("Mexico/General"); 

session_start();
include '../sige/loginSecurity.php';
     if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'Prestadores' ) {
    header('location: index.php');
}

    

if(isset($_GET['codigo'])){
    $_SESSION["codigo"]=$_GET['codigo'];
    //echo "variable id existe".$_SESSION["IdPrestador"];
    $filtrado="Mostrando todos los Registros de Asistencia";
}
else
{
   $_SESSION["codigo"]=$_POST[IdPrestador];
   $filtrado="Registros de Asistencia Filtrados";
}

include 'conexionPrestadores.php';
$fecha1=$_POST[date1];
$fecha2=$_POST[date2];

//print_r($_POST);
//print_r($_GET);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Detalle Asistencias Prestador. Prestadores. SIGE</title>
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
       
        <div class="container">
            <br>
            
            <br>
            <a href="prestadoresConsulta.php" class="btn btn-default btn-sm" role="button">
                <span class="glyphicon glyphicon-menu-left"></span> Regresar</a>
            <h3><center>Detalle Prestador</center></h3><!-- Cambiar título -->
            
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
                    <form class="form-inline"  name="formulario" id="frmNewReq" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
                            <div class="form-group">
                               
                                <input type="hidden" class="form-control" id="IdPrestador" name="IdPrestador" placeholder="IdPrestador" value="<?php echo $_SESSION["codigo"];?>" >
                                <label for="date1"> Fecha Inicial </label>
                                <input type="text" class="form-control" id="date1" name="date1" placeholder="Fecha">
                            </div>
                        <div class="form-group">
                            <label for="date2"> Fecha Final </label>
                            <input type="text" class="form-control" id="date2" name="date2" placeholder="Fecha">
                        </div>
                        <button type="submit" class="btn btn-default">Filtrar</button>
                        <br>
                        <hr>
                    </form>
        <?php
            
            $pdo = new Conexion();
            $query = $pdo->prepare('SELECT * FROM vs_prestadores WHERE codigo = :codigo;');
            $query->bindValue(':codigo',$_SESSION["codigo"]);
            $query->execute();
            $resultado = $query->fetchAll();
            foreach ($resultado as $key => $value) 
            {
  
             echo "<div class='row'>";   
            echo"<div class='col-xs-6 col-sm-6'><h4 class='titulo'>Código: ".$value['codigo']."</h4></div>";
            echo"<div class='col-xs-6 col-sm-6'><h4 class='titulo'>Nombre: ".$value['nombre']."</h4></div>";
             echo"<div class='col-xs-6 col-sm-6'><h4 class='titulo'>Prestación: ".$value['prestacion']."</h4></div>";
             echo"<div class='col-xs-6 col-sm-6'><h4 class='titulo'>Institución: </label>".$value['institucion']."</div>";
             echo"<div class='col-xs-12 col-sm-12'><h4 class='titulo'>Id Prestador: ".$value['IdPersona']."</h4></div>";
       if($value['fechaInicio']!='' && $value['fechaTermino']!='')
             {
            echo"<hr>";
            echo "<div class='col-xs-6 col-sm-6'><h4 class='titulo'>Fecha Inicio : </label>".$value['fechaInicio']."</h4></div>";  
            echo "<div class='col-xs-6 col-sm-6'><h4 class='titulo'>Fecha Fin : </label>".$value['fechaTermino']."</h4></div>"; 
            echo "</div>";
            
             echo"<hr>";
              }
             echo '
                 
                  
     
                 
                 ';
         
        }
        if((isset($fecha1) AND $fecha1!=null) AND (isset($fecha2) AND $fecha2!=null)){
            $texto=" fecha BETWEEN '".$fecha1." 00:00' AND '".$fecha2." 23:59' AND ";
        }
        //echo $fecha1;
        //echo $fecha2;
        //echo $IdPrestador;
        //echo $texto;
        $pdo = new Conexion();
        $query2 = $pdo->prepare('SELECT * FROM asistencias WHERE '.$texto.' codigo = :codigo order by fecha;');
      
        $query2->bindValue(':codigo', $_SESSION["codigo"]);
        $query2->execute();
        $resultado2 = $query2->fetchAll();
        $dia='';
                        
 echo "<div class='row'>";         
foreach ($resultado2 as $key => $value) 
        {
            $dia2=substr($value['fecha'],0,10);
         
            $valor=strnatcasecmp($dia,$dia2);
            
            if ($valor==0) {//si son iguales
                $RegistrosPorDia[$cont]++;
                $H2[$cont]=substr($value['fecha'],11,10); 
                $horai=substr($H1[$cont],0,2);
                $mini=substr($H1[$cont],3,2);
                $segi=substr($H1[$cont],6,2);
                $horaf=substr($H2[$cont],0,2);
                $minf=substr($H2[$cont],3,2);
                $segf=substr($H2[$cont],6,2);
                $ini=((($horai*60)*60)+($mini*60)+$segi);
                $fin=((($horaf*60)*60)+($minf*60)+$segf);
                $dif=$fin-$ini;
                $difh=floor($dif/3600);
                $difm=floor(($dif-($difh*3600))/60);
                $difs=$dif-($difm*60)-($difh*3600);
                $diferencia[$cont]=date("H:i:s",mktime($difh,$difm,$difs));
                
                $tiempoH=$tiempoH+intval(substr($diferencia[$cont],0,2));
                $tiempoM=$tiempoM+intval(substr($diferencia[$cont],3,2));
                if($tiempoM>=60){
                    $tiempoH=$tiempoH+1;
                    $tiempoM=$tiempoM-60;
                }
                $totalFinal+=$diferencia[$cont];
           
               
            }//Fin si los registros son del mismo día

            else  {
                $cont++;
                $fecha[$cont]=$dia2;
                $H1[$cont]=substr($value['fecha'],11,10);    
            } 
            
            $dia=substr($value['fecha'],0,10);
            

        } //fin del foreach 
       
        echo "</div>";
        echo"<hr>";       
        echo "<div class='row'>";               
        echo "<div class='col-xs-2 col-sm-2 text-center'><label>Intentos</label></div>";  
        echo "<div class='col-xs-2 col-sm-2'><label>Fecha</label></div>";  
        echo "<div class='col-xs-2 col-sm-2'><label>Hora Entrada</label></div>";  
        echo "<div class='col-xs-2 col-sm-3'><label>Hora Salida</label></div>";  
        echo "<div class='col-xs-2 col-sm-3'><label>Total por día</label></div>"; 
        echo "</div>";
    
          
       $limite=count($fecha);
                   
        for($i=1;$i<=$limite;$i++){
        $intentos=$RegistrosPorDia[$i]+1;
        echo "<div class='row'>";    
        if($intentos>=4){
            echo "<div class='col-xs-2 col-sm-2 text-center' ><a href='detalleAsistenciaDiaria.php?codigo=".$_SESSION["codigo"]."&fecha=".$fecha[$i]."'> Intentos: ".$intentos."</a></div>";
        }else{
             echo "<div class='col-xs-2 col-sm-2 text-center' ><label>".$intentos."</label></div>"; 
        }
        
            
        $datefila=date_create($fecha[$i]);
        echo "<div class='col-xs-2 col-sm-2'><label>".date_format($datefila,'d-m-Y')."</label></div>"; 
        
        echo "<div class='col-xs-2 col-sm-2'><label>".$H1[$i]."</label></div>";   
        if(isset($H2[$i]))
            echo "<div class='col-xs-3 col-sm-3'><label>".$H2[$i]."</label></div>";
        else
            echo "<div class='col-xs-3 col-sm-3'><label><a href='registroHoraManual.php?codigo=".$_SESSION["codigo"]."&fecha=".$fecha[$i]."'>Registro de Hora</a></label></div>";
        if(isset($H2[$i]))    
            echo "<div class='col-xs-3 col-sm-3'><label>".$diferencia[$i]."</label></div>";
        else
            echo "<div class='col-xs-3 col-sm-3'><label>-</label></div>";   
        echo "</div>";      
        }
        echo "<div class='row'>";                 
        if($tiempoH>0){
            echo "<div class='col-xs-12 col-sm-12'><label>Total: ".$tiempoH." Horas ".$tiempoM." minutos </label></div>";
        } 
        else
        {
            echo "<div class='col-xs-12 col-sm-12'><label>No existen Registros para este periodo de tiempo </label></div>";
        }
         echo "</div>";
                     
                                    


                                    
                            ?>  
                        </div>
                    </div>
                </div>
            </div>

        </div>
        
    </body>
</html>
