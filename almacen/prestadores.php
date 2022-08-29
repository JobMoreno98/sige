<?php
date_default_timezone_set("Mexico/General"); 
include './conexionPrestadores.php';
class prestadores {
    
//    Renombrar los titulos
//    NOTA: Los titulos sirven para darle nombre a los titulos de las tablas y los Combobox
    public function __construct() {
   
        $this->setTitulo1("Código");
        $this->setTitulo2("Nombre");
        $this->setTitulo3("Institución");
        $this->setTitulo4("Prestación");
        $this->setTitulo5("Fecha Inicio");
        $this->setTitulo6("Fecha Fin");
        $this->setTitulo7("Editar");
        $this->setTitulo8("Estatus");
        
    }


    private $filtro1;
    private $filtro2;
    private $filtro3;
    private $filtro4;
    
    function getTitulo1() {
        return $this->titulo1;
    }

    function getTitulo2() {
        return $this->titulo2;
    }

    function getTitulo3() {
        return $this->titulo3;
    }

    function getTitulo4() {
        return $this->titulo4;
    }

    function getTitulo5() {
        return $this->titulo5;
    }

    function getTitulo6() {
        return $this->titulo6;
    }

    function getTitulo7() {
        return $this->titulo7;
    }
    
    function getTitulo8() {
        return $this->titulo8;
    }

    function setTitulo1($titulo1) {
        $this->titulo1 = $titulo1;
    }

    function setTitulo2($titulo2) {
        $this->titulo2 = $titulo2;
    }

    function setTitulo3($titulo3) {
        $this->titulo3 = $titulo3;
    }

    function setTitulo4($titulo4) {
        $this->titulo4 = $titulo4;
    }

    function setTitulo5($titulo5) {
        $this->titulo5 = $titulo5;
    }

    function setTitulo6($titulo6) {
        $this->titulo6 = $titulo6;
    }

    function setTitulo7($titulo7) {
        $this->titulo7 = $titulo7;
    }
    
    function setTitulo8($titulo8) {
        $this->titulo8 = $titulo8;
    }
  

        
    function getFiltro1() {
        return $this->filtro1;
    }

    function getFiltro2() {
        return $this->filtro2;
    }

    function getFiltro3() {
        return $this->filtro3;
    }

    function getFiltro4() {
        return $this->filtro4;
    }

    
    function setFiltro1($filtro1) {
        $this->filtro1 = $filtro1;
    }

    function setFiltro2($filtro2) {
        $this->filtro2 = $filtro2;
    }

    function setFiltro3($filtro3) {
        $this->filtro3 = $filtro3;
    }

    function setFiltro4($filtro4) {
        $this->filtro4 = $filtro4;
    }

    
    
//    Función para agregar los encabezados de las tablas
    function tituloConsulta1()   {
        echo '<tr>
                <th>'.$this ->getTitulo1().'</th>
                <th>'.$this ->getTitulo2().'</th>
                <th>'.$this ->getTitulo3().'</th>
                <th>'.$this ->getTitulo4().'</th>
                <th>'.$this ->getTitulo5().'</th>
                <th>'.$this ->getTitulo6().'</th>
                <th>'.$this ->getTitulo7().'</th>
     
            </tr>';
    }
    function tituloConsultaTodos()   {
        echo '<tr>
                <th>'.$this ->getTitulo1().'</th>
                <th>'.$this ->getTitulo2().'</th>
                <th>'.$this ->getTitulo3().'</th>
                <th>'.$this ->getTitulo4().'</th>
                <th>'.$this ->getTitulo5().'</th>
                <th>'.$this ->getTitulo6().'</th>
                <th>'.$this ->getTitulo8().'</th>
                <th>'.$this ->getTitulo7().'</th>
     
            </tr>';
    }
      
//        Esta función muestra los datos de la consulta en la tabla.
//        NOTA: Todas las variables VARCHAR en la base de datos deben de tener en las consultas comparaciones con LIKE y a su vez con =
//        en filtros con ComboBox para su buen funcionamiento.
//        En este caso, la consulta contiene dos variables VARCHAR y se deben realizar las combinaciones posibles con OR.
        function consultaFiltroActivos() {
        $pdo = new Conexion();
        $query = $pdo->prepare("SELECT * FROM vs_prestadores WHERE estatus='Activo' AND
            institucion LIKE :institucion AND prestacion LIKE :prestacion 
            OR (institucion = :institucion  AND prestacion LIKE :prestacion)
            OR (prestacion = :prestacion AND institucion LIKE :institucion) order by codigo;");
        $query->bindValue(':institucion', $this->getFiltro1());
        $query->bindValue(':prestacion', $this->getFiltro2());
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            $codigo="<a href='asistenciasSSConsulta.php?codigo=". $value['codigo']."&prestacion=".$value['IdPrestacion']."' >".$value['codigo']."</a>";
   
            $nombre = $value['nombre'];
            $institucion = $value['institucion'];
            $prestacion = $value['prestacion'];
            $fechaInicio = $value['fechaInicio'];
            $fechaTermino = $value['fechaTermino'];
            $editar="<a href='modificacionPrestador.php?codigo=". $value['codigo']."&prestacion=".$value['IdPrestacion']."'  target='_blank'>Editar</a>";
            echo '<tr>
                  
                    <td>'. $codigo .'</td>
                    <td>'. $nombre .'</td>
                    <td>'. $institucion .'</td>
                    <td>'. $prestacion .'</td>
                    <td>'. $fechaInicio .'</td>
                    <td>'. $fechaTermino .'</td>
                    <td>'. $editar .'</td>
                </tr>
            ';
        }     
    }
        function consultaFiltro() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT * FROM vs_prestadores WHERE
            institucion LIKE :institucion AND prestacion LIKE :prestacion 
            OR (institucion = :institucion  AND prestacion LIKE :prestacion)
            OR (prestacion = :prestacion AND institucion LIKE :institucion) order by codigo;');
        $query->bindValue(':institucion', $this->getFiltro1());
        $query->bindValue(':prestacion', $this->getFiltro2());
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            $codigo="<a href='asistenciasSSConsulta.php?codigo=". $value['codigo']."&prestacion=".$value['IdPrestacion']."' >".$value['codigo']."</a>";
   
            $nombre = $value['nombre'];
            $institucion = $value['institucion'];
            $prestacion = $value['prestacion'];
            $fechaInicio = $value['fechaInicio'];
            $fechaTermino = $value['fechaTermino'];
            $estatus=$value['estatus'];
            $editar="<a href='modificacionPrestador.php?codigo=". $value['codigo']."&prestacion=".$value['IdPrestacion']."'  target='_blank'>Editar</a>";
            echo '<tr>
                  
                    <td>'. $codigo .'</td>
                    <td>'. $nombre .'</td>
                    <td>'. $institucion .'</td>
                    <td>'. $prestacion .'</td>
                    <td>'. $fechaInicio .'</td>
                    <td>'. $fechaTermino .'</td>
                    <td>'. $estatus .'</td>
                    <td>'. $editar .'</td>
                </tr>
            ';
        }     
    }
//    Esta función muestra los datos de la consulta en cada ComboBox.
//    NOTA: Las variables varchar en los ComboBox se pueden ordenar con ORDER BY
    function comboBoxFiltro()   {
        $pdo = new Conexion();
        
        $query2 = $pdo->prepare('SELECT distinct institucion FROM prestacion WHERE
            institucion LIKE :institucion AND prestacion LIKE :prestacion
            OR (prestacion = :prestacion  AND institucion LIKE :institucion)
            ORDER BY institucion ASC;');
        $query2->bindValue(':institucion', $this->getFiltro1());
        $query2->bindValue(':prestacion', $this->getFiltro2());
        $query2->execute();
        $resultado2 = $query2->fetchAll();
        $query3 = $pdo->prepare('SELECT distinct prestacion FROM prestacion WHERE
            institucion LIKE :institucion AND prestacion LIKE :prestacion
            OR (prestacion = :prestacion  AND institucion LIKE :institucion)
            ORDER BY prestacion ASC;');
        $query3->bindValue(':institucion', $this->getFiltro1());
        $query3->bindValue(':prestacion', $this->getFiltro2());
        $query3->execute();
        $resultado3 = $query3->fetchAll();
        /*$query4 = $pdo->prepare('SELECT distinct edificio FROM area WHERE
            area LIKE :area AND piso LIKE :piso AND edificio LIKE :edificio AND tipo LIKE :tipo
            OR (area = :area  AND piso LIKE :piso AND edificio LIKE :edificio AND tipo LIKE :tipo)
            OR (piso = :piso AND area LIKE :area AND edificio LIKE :edificio AND tipo LIKE :tipo)
            OR (area = :area  AND piso = :piso AND edificio LIKE :edificio AND tipo LIKE :tipo);');
        $query4->bindValue(':area', $this->getFiltro1());
        $query4->bindValue(':piso', $this->getFiltro2());
        $query4->bindValue(':edificio', $this->getFiltro3());
        $query4->bindValue(':tipo', $this->getFiltro4());
        $query4->execute();
        $resultado4 = $query4->fetchAll();
        $query5 = $pdo->prepare('SELECT distinct tipo FROM area WHERE
            area LIKE :area AND piso LIKE :piso AND edificio LIKE :edificio AND tipo LIKE :tipo
            OR (area = :area  AND piso LIKE :piso AND edificio LIKE :edificio AND tipo LIKE :tipo)
            OR (piso = :piso AND area LIKE :area AND edificio LIKE :edificio AND tipo LIKE :tipo)
            OR (area = :area  AND piso = :piso AND edificio LIKE :edificio AND tipo LIKE :tipo);');
        $query5->bindValue(':area', $this->getFiltro1());
        $query5->bindValue(':piso', $this->getFiltro2());
        $query5->bindValue(':edificio', $this->getFiltro3());
        $query5->bindValue(':tipo', $this->getFiltro4());
        $query5->execute();
        $resultado5 = $query5->fetchAll();*/
        
        echo '<div class="form-group">
                    <label>'. $this->getTitulo3() .':</label>
                    <select class="form-control input-sm" name="filtro1" id="lista1">
                    <option value="%">Buscar '. $this->getTitulo3() .'</option>';
         foreach ($resultado2 as $key => $value) {
            $area = $value['institucion'];
            echo '<option>'. $area .'</option>';
         }
         echo '</select>
                </div>
                <div class="form-group">
                    <label>'. $this->getTitulo4() .':</label>
                    <select class="form-control input-sm" name="filtro2" id="lista2">
                    <option value="%">Buscar '. $this->getTitulo4() .'</option>';
          foreach ($resultado3 as $key => $value) {
            $piso = $value['prestacion'];
             echo '<option>'. $piso .'</option>';
         }
         echo '</select>
                </div>';
                
         /*           <label>'. $this->getTitulo4() .':</label>
                    <select class="form-control input-sm" name="filtro3" id="lista3">
                    <option value="%">Buscar '. $this->getTitulo4() .'</option>';
         foreach ($resultado4 as $key => $value) {
            $edificio = $value['edificio'];
            echo '<option>'. $edificio .'</option>';
         }
         echo '</select>
                </div>
                <div class="form-group">
                    <label>'. $this->getTitulo5() .':</label>
                    <select class="form-control input-sm" name="filtro4" id="lista4">
                    <option value="%">Buscar '. $this->getTitulo5() .'</option>';
         foreach ($resultado5 as $key => $value) {
            $tipo = $value['tipo'];
            echo '<option>'. $tipo .'</option>';
         }
         echo '</select>
                </div>';*/
    }
 function registroAsistencia() 
    {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT * FROM vs_prestadores WHERE idpersona = :idpersona;');
        $query->bindValue(':idpersona', $this->getFiltro1());
        $query->execute();
        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) 
        {
  
             echo "<div class='row'>";   
            echo"<div class='col-xs-12 col-sm-4'><h4 class='titulo'>Código: ".$value['codigo']."</h4></div>";
            echo"<div class='col-xs-12 col-sm-8'><h4 class='titulo'>Nombre: ".$value['nombre']."</h4></div>";
             echo"<div class='col-xs-12 col-sm-6'><h4 class='titulo'>Nombre: ".$value['nombre']."</h4></div>";
             echo"<div class='col-xs-12 col-sm-6'><label>IdPersona: </label>".$value['idpersona']."</div>";
             echo"<div class='col-xs-6 col-sm-6'><label>Institución: </label>".$value['institucion']."</div>";
             echo"<div class='col-xs-6 col-sm-6'><label>Prestación: </label>".$value['prestacion']."</div>";
             echo"<hr>";
             echo "</div>";
             echo"<hr>";
        
             echo "<div class='row'>";
             echo "<div class='col-xs-6 col-sm-3'><label>". $this->getTitulo6()." : </label>".$value['fechaInicio']."</div>";    
             echo "<div class='col-xs-6 col-sm-3'><label>". $this->getTitulo7()." : </label>".$value['fechaTermino']."</div>";   
             echo "</div>";
             
             echo "<div class='row'>";
             echo "<div class='col-xs-6 col-sm-3'><label></label></div>";    
             echo "<div class='col-xs-6 col-sm-3'><label></label></div>";   
             echo "<div class='col-xs-6 col-sm-6'><label></label></div>";
             echo "</div>";
             echo"<hr>";
             
             echo '
                 
                  
     
                 
                 ';
             $IdCodigo=$value['codigo'];
        }
        $pdo = new Conexion();
        $query2 = $pdo->prepare('SELECT * FROM asistencias WHERE codigo = :codigo;');
        $query2->bindValue(':codigo', $IdCodigo);
        $query2->execute();
        $resultado2 = $query2->fetchAll();
        $dia='';
                        $horaini="10:00:42";
$horafin="19:00:41";
 echo "<div class='row'>";         
foreach ($resultado2 as $key => $value) 
        {
            $dia2=substr($value['fecha'],0,10);
            
            
            
                    
            $valor=strnatcasecmp($dia,$dia2);
            if ($valor==0) {//si son iguales
                
                $hora2=substr($value['fecha'],11,10);
                echo "<div class='col-xs-3 col-sm-2'><label>".$hora."</label></div>";
                echo "<div class='col-xs-3 col-sm-2'><label>".$hora2."</label></div>";
                
                $horai=substr($hora,0,2);
                $mini=substr($hora,3,2);
                $segi=substr($hora,6,2);
                $horaf=substr($hora2,0,2);
                $minf=substr($hora2,3,2);
                $segf=substr($hora2,6,2);
                $ini=((($horai*60)*60)+($mini*60)+$segi);
                $fin=((($horaf*60)*60)+($minf*60)+$segf);
                $dif=$fin-$ini;
                $difh=floor($dif/3600);
                $difm=floor(($dif-($difh*3600))/60);
                $difs=$dif-($difm*60)-($difh*3600);
                $diferencia=date("H:i:s",mktime($difh,$difm,$difs));
                
                $tiempoH=$tiempoH+intval(substr($diferencia,0,2));
                $tiempoM=$tiempoM+intval(substr($diferencia,3,2));
                if($tiempoM>=60){
                    $tiempoH=$tiempoH+1;
                    $tiempoM=$tiempoM-60;
                }
 
echo "<div class='col-xs-3 col-sm-2'><label>".$diferencia."</label></div>";
                //$difHoras=RestarHoras($horaini,$horafin);
        
            } else  {
               echo "<div class='col-xs-3 col-sm-2'><label>".$dia2."</label></div>";
                $hora=substr($value['fecha'],11,10);
    
            } 
            
            $dia=substr($value['fecha'],0,10);

        } //fin del foreach    
         
        echo "<div class='col-xs-4 col-sm-2'><label>Total horas: ".$tiempoH."</label></div>";
        echo "<div class='col-xs-4 col-sm-2'><label>Total Minutos: ".$tiempoM."</label></div>";
        echo "</div>";
    }//Fin datos equipo
function RestarHoras($horaini,$horafin)

{

	$horai=substr($horaini,0,2);

	$mini=substr($horaini,3,2);

	$segi=substr($horaini,6,2);

 

	$horaf=substr($horafin,0,2);

	$minf=substr($horafin,3,2);

	$segf=substr($horafin,6,2);

 

	$ini=((($horai*60)*60)+($mini*60)+$segi);

	$fin=((($horaf*60)*60)+($minf*60)+$segf);

 

	$dif=$fin-$ini;

 

	$difh=floor($dif/3600);

	$difm=floor(($dif-($difh*3600))/60);

	$difs=$dif-($difm*60)-($difh*3600);

	return date("H:i:s",mktime($difh,$difm,$difs));

}


}
