<?php
include_once 'conexionPrestadores.php';
class asistenciasSS {
    private $IdAsistencia;
    private $fecha=array();
    private $tipo=array();
    private $totalRegistros;
    private $fechaInicioFiltro;
    private $fechaFinFiltro;
    
    private $IdPersona;
    private $codigo;
    private $nombre;
    private $IdPrestacion;
    private $fechaInicio;
    private $fechaTermino;
    
    function getIdAsistencia() {
        return $this->IdAsistencia;
    }

    function getFecha($cont) {
        return $this->fecha[$cont];
    }

    function getTipo($cont) {
        return $this->tipo[$cont];
    }
    function getTotalRegistros() {
        return $this->totalRegistros;
    }
    function getFechaInicioFiltro() {
        return $this->fechaInicioFiltro;
    }

    function getFechaFinFiltro() {
        return $this->fechaFinFiltro;
    }
    
    function getIdPersona() {
        return $this->IdPersona;
    }
    
    function getCodigo() {
        return $this->codigo;
    }
    
    function getNombre() {
        return $this->nombre;
    }
    
    function getIdPrestacion() {
        return $this->IdPrestacion;
    }
    function getFechaInicio() {
        return $this->fechaInicio;
    }

    function getFechaTermino() {
        return $this->fechaTermino;
    }
    
    function setIdAsistencia($IdAsistencia) {
        $this->IdAsistencia = $IdAsistencia;
    }
    
    function setFecha($fecha, $cont) {
        $this->fecha[$cont] = $fecha;
    }

    function setTipo($tipo, $cont) {
        $this->tipo[$cont] = $tipo;
    }
    
    function setTotalRegistros($totalRegistros) {
        $this->totalRegistros = $totalRegistros;
    }
    
    function setFechaInicioFiltro($fechaInicioFiltro) {
        $this->fechaInicioFiltro = $fechaInicioFiltro;
    }

    function setFechaFinFiltro($fechaFinFiltro) {
        $this->fechaFinFiltro = $fechaFinFiltro;
    }
    
    function setIdPersona($IdPersona) {
        $this->IdPersona = $IdPersona;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    
    function setIdPrestacion($IdPrestacion) {
        $this->IdPrestacion = $IdPrestacion;
    }
    
    function setFechaInicio($fechaInicio) {
        $this->fechaInicio = $fechaInicio;
    }

    function setFechaTermino($fechaTermino) {
        $this->fechaTermino = $fechaTermino;
    }


    

    function cargarAsistencias() {
       try{
        
        $pdo = new Conexion();
        
        if($this->getFechaInicio()!='' && $this->getFechaTermino()!=''){
            if($this->getFechaInicioFiltro()!='' && $this->getFechaFinFiltro()!=''){
                $query = $pdo->prepare("SELECT DISTINCT fecha FROM asistencias WHERE codigo = :codigo AND fecha BETWEEN :fechaInicio AND :fechaTermino AND fecha BETWEEN :fechaInicioFiltro AND :fechaFinFiltro order by fecha;");
                $query->bindValue(':fechaInicioFiltro', $this->getFechaInicioFiltro());
                $query->bindValue(':fechaFinFiltro', $this->getFechaFinFiltro()); 
            }else{
                $query = $pdo->prepare("SELECT DISTINCT fecha FROM asistencias WHERE codigo = :codigo AND fecha BETWEEN :fechaInicio AND :fechaTermino order by fecha ;");
            }
            $query->bindValue(':fechaInicio', $this->getFechaInicio());
            $query->bindValue(':fechaTermino', $this->getFechaTermino());
        }
        else{
            if($this->getFechaInicioFiltro()!='' && $this->getFechaFinFiltro()!=''){
                $query = $pdo->prepare("SELECT DISTINCT fecha FROM asistencias WHERE codigo = :codigo AND fecha BETWEEN :fechaInicioFiltro AND :fechaFinFiltro order by fecha;");
                $query->bindValue(':fechaInicioFiltro', $this->getFechaInicioFiltro());
                $query->bindValue(':fechaFinFiltro', $this->getFechaFinFiltro()); 
            }else{
                $query = $pdo->prepare("SELECT DISTINCT fecha FROM asistencias WHERE codigo = :codigo order by fecha;"); 
            }
                       
        }
        $query->bindValue(':codigo', $this->getCodigo());
        
       /* if($this->getFechaInicioFiltro()!='' && $this->getFechaFinFiltro()!=''){
            $query = $pdo->prepare("SELECT DISTINCT fecha FROM vs_asistenciasPrestador WHERE codigo = :codigo AND IdPrestacion = :IdPrestacion AND fecha BETWEEN :fechaInicioFiltro AND :fechaFinFiltro order by fecha;");
            $query->bindValue(':fechaInicioFiltro', $this->getFechaInicioFiltro());
            $query->bindValue(':fechaFinFiltro', $this->getFechaFinFiltro());
        }else{
            
            $query = $pdo->prepare("SELECT DISTINCT fecha FROM asistencias WHERE codigo = :codigo AND fecha BETWEEN :fechaInicio AND :fechaTermino order by fecha;");

        }*/
        
        
      
        $query->execute();
        $resultado = $query->fetchAll();
        foreach ($resultado as $value) {
            $cont++;            
            $this ->setFecha($value['fecha'],$cont);
        }
       
        }
        catch(PDOException $e)
        {
            echo $query . "<br>" . $e->getMessage();
        }

        $pdo = null;
        $this->setTotalRegistros($cont);
        
    }
    function mostrarRegistrosPorDia() {
        for($i=1;$i<=$this->getTotalRegistros();$i++){  
            $dia2=substr($this->getFecha($i),0,10);
            $valor=strnatcasecmp($dia,$dia2);
            if ($valor==0) {//si son iguales
                $contRegistrosDiarios++;
                $hi=new DateTime($horainicial);
                $hi->add(new DateInterval('PT0H10M'));
                $dt = new DateTime(substr($this->getFecha($i),11,10));
                $hiStr=strtotime($hi->format('H:i:s'));
                $dtStr=strtotime($dt->format('H:i:s'));

                    if($hiStr>$dtStr){
                        //echo " <br>Registro Núm. ".$contRegistrosDiarios." - ".substr($this->getFecha($i),11,10);
                        //echo "- Registro Núm. ".$contRegistrosDiarios." Descartado por tener menos de 10 minutos de diferencia con el inmediato Anteiror";
                         
                    
                        
                    }
                    else{//Los registros tienen más de 10 minutos de diferencia
                     
                       if($lapsoTerminado==0){ //Cuando no se ha cerrado el periodo de dos horarios válidos
                           
                            $salida=substr($this->getFecha($i),11,10);
                            echo ' ----- <strong>Salida </strong>'.$salida;
                            $diferencia=$this->calcularDiferencia($horainicial,substr($this->getFecha($i),11,10));
                            echo ' ----- <strong>Tiempo </strong>'.$diferencia;
                            $tiempoH=$tiempoH+intval(substr($diferencia,0,2));
                            $tiempoM=$tiempoM+intval(substr($diferencia,3,2));
                            $tiempoS=$tiempoS+intval(substr($diferencia,5,2));
                            //if($tiempoM>=60){
                                $horaAdicionalesAcumuladas=floor($tiempoM/60);
                                $minutosAcumulados=$tiempoM%60;
                                
                            //}
                            $TiempoAcumulado=$tiempoH+$horaAdicionalesAcumuladas;
                            if($minutosAcumulados<10) echo ' ----- <strong>Acumulado -> </strong>'.$TiempoAcumulado.':0'.$minutosAcumulados;
                            else echo ' ----- <strong>Acumulado -> </strong>'.$TiempoAcumulado.':'.$minutosAcumulados;
                            
                            $lapsoTerminado=1;
                            $dtAnterior=$dt;
                            $salida='00:00:00';
                        }else{
                            $dtAnterior->add(new DateInterval('PT0H10M'));
                            $dtAnteriorStr=strtotime($dtAnterior->format('H:i:s'));
                            
                            if($dtStr>$dtAnteriorStr){
                                $horainicial=substr($this->getFecha($i),11,10);
                                echo '<br><strong>Día: </strong>'.substr($this->getFecha($i),0,10);
                                echo ' ----- <strong>Entrada: </strong>'.$horainicial;
                                $lapsoTerminado=0;
                            }else{
                                //echo "<br>Registro descartado por no haber pasado 10 minutos desde el último ".substr($this->getFecha($i),11,10);
                              
                            }
                        }
                        
                    }
            }else{
                echo '<br><strong> Día: </strong>'.substr($this->getFecha($i),0,10);
                $contRegistrosDiarios=1;
                $horainicial=substr($this->getFecha($i),11,10);
                echo ' ----- <strong>Entrada: </strong>'.$horainicial; 
                $lapsoTerminado=0;
            }
            $dia=substr($this->getFecha($i),0,10);
            
            
        } //fin del for que recorre todos los registros
        if($tiempoM>=60){
                $horaAdicionales=floor($tiempoM/60);
                $minutos=$tiempoM%60;
        }
        $TotalTiempo=$tiempoH+$horaAdicionales;
        //echo "<br>Total Horas = ".$TotalTiempo.":".$minutos;
    }
    function mostrarRegistrosPorDiaDetalle() {
        for($i=1;$i<=$this->getTotalRegistros();$i++){  
            $dia2=substr($this->getFecha($i),0,10);
            $valor=strnatcasecmp($dia,$dia2);
            if ($valor==0) {//si son iguales
                $contRegistrosDiarios++;
                $hi=new DateTime($horainicial);
                $hi->add(new DateInterval('PT0H10M'));
                $dt = new DateTime(substr($this->getFecha($i),11,10));
                $hiStr=strtotime($hi->format('H:i:s'));
                $dtStr=strtotime($dt->format('H:i:s'));

                    if($hiStr>$dtStr){
                        echo " <br>Registro Núm. ".$contRegistrosDiarios." - ".substr($this->getFecha($i),11,10);
                        echo "- Registro Núm. ".$contRegistrosDiarios." Descartado por tener menos de 10 minutos de diferencia con el inmediato Anterior<br>";
                    }
                    else{
                       if($lapsoTerminado==0){
                            echo " <br>Registro de Salida Núm. ".$contRegistrosDiarios." - ".substr($this->getFecha($i),11,10); 
                            
                            echo " Lapso de tiempo ".$this->calcularDiferencia($horainicial,substr($this->getFecha($i),11,10));
                            $lapsoTerminado=1;
                            $dtAnterior=$dt;
                        }else{
                            $dtAnterior->add(new DateInterval('PT0H10M'));
                            $dtAnteriorStr=strtotime($dtAnterior->format('H:i:s'));
                            
                            if($dtStr>$dtAnteriorStr){
                                $horainicial=substr($this->getFecha($i),11,10);
                                echo "<br>Registro Inicial Núm. ".$contRegistrosDiarios." - ".$horainicial; 
                                $lapsoTerminado=0;
                            }else{
                                echo "<br> Registro descartado por no haber pasado 10 minutos desde el último ".substr($this->getFecha($i),11,10);
                            }
                        }
                    
                    }
                    
                    
            }else{
                echo '<br> Día: '.substr($this->getFecha($i),0,10);
                $contRegistrosDiarios=1;
                $horainicial=substr($this->getFecha($i),11,10);
                
                echo "<br> Registro Inicial Núm. ".$contRegistrosDiarios." - ".$horainicial; 
                $lapsoTerminado=0;
                
            }
            $dia=substr($this->getFecha($i),0,10);
            $registro[0][0]=substr($this->getFecha($i),0,10);
       
        }        
    }
    function calcularDiferencia($HoraInicial, $HoraFinal){
       
        $horai=substr($HoraInicial,0,2);
        $mini=substr($HoraInicial,3,2);
        $segi=substr($HoraInicial,6,2);
        $horaf=substr($HoraFinal,0,2);
        $minf=substr($HoraFinal,3,2);
        $segf=substr($HoraFinal,6,2);
        $ini=((($horai*60)*60)+($mini*60)+$segi);
        $fin=((($horaf*60)*60)+($minf*60)+$segf);
        $dif=$fin-$ini;
        $difh=floor($dif/3600);
        $difm=floor(($dif-($difh*3600))/60);
        $difs=$dif-($difm*60)-($difh*3600);
        $diferencia=date("H:i:s",mktime($difh,$difm,$difs));

        return $diferencia;
    }
    function servicioSocialConsulta() {
        
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT * FROM vs_prestadores order by nombre;');
        $query->execute();
        
        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
          $prestadores[$key] = array(
                $value['IdPersona'],
                "<a href='asistenciasSSConsulta.php?codigo=". $value['codigo']."'>".$value['codigo']."</a>",  
                $value['nombre'],
                $value['IdPrestacion'],
                $value['prestacion'],
                $value['institucion'],
                $value['fechaInicio'],
                $value['fechaTermino']
           );
        }
        return $prestadores;    
    }
    function servicioSocialConsultaIndividual() {
        
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT * FROM vs_prestadores WHERE codigo = :codigo AND IdPrestacion = :IdPrestacion;');
        $query->bindValue(':codigo', $this->getCodigo());
        $query->bindValue(':IdPrestacion', $this->getIdPrestacion());
        $query->execute();
        
        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
           echo "<div class='row'>";   
            echo"<div class='col-xs-6 col-sm-6'><h4 class='titulo'>Código: ".$value['codigo']."</h4></div>";
            echo"<div class='col-xs-6 col-sm-6'><h4 class='titulo'>Nombre: ".$value['nombre']."</h4></div>";
            echo"<div class='col-xs-6 col-sm-6'><h4 class='titulo'>Prestación: ".$value['IdPrestacion']." - ".$value['prestacion']."</h4></div>";
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
        $this->setFechaInicio($value['fechaInicio']);
        $this->setFechaTermino($value['fechaTermino']);
        }
          
    }
    function servicioSocialConsultaPrestaciones() {
        
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT * FROM vs_prestadores WHERE codigo = :codigo;');
        $query->bindValue(':codigo', $this->getCodigo());
        
        $query->execute();
        
        $resultado = $query->fetchAll();
        
        if(count($resultado)== 0){
            echo "<div class='row'> ";
            echo "<div class 'col-xs-12 col-sm-12'><h4><center> No se encontró el código. </center></h4></div>" ;
            echo "<center><a href='index.php' class='btn btn-default'> Regresar </a></center>";
            echo "</div>";
        }else{
        foreach ($resultado as $key => $value) {
           
            echo "<div class='row'>";   
            echo"<div class='col-xs-12 col-sm-12'><h4 class='titulo'>Código: ".$value['codigo']."- ".$value['nombre']."</h4></div>";
            echo"<div class='col-xs-12 col-sm-12'><h4 class='titulo'><a href='asistenciasSSConsultaPrestadorHoras.php?codigo=".$value['codigo']."&prestacion=".$value['IdPrestacion']."'>Institución: ".$value['institucion'].". Prestación: ".$value['IdPrestacion']." - ".$value['prestacion']."</a></h4></div>";
             
             
             echo"<div class='col-xs-12 col-sm-12'>Número Interno: ".$value['IdPersona']."</div>";
       if($value['fechaInicio']!='' && $value['fechaTermino']!='')
             {
            echo"<hr>";
            echo "<div class='col-xs-6 col-sm-6'><h4 class='titulo'>Fecha Inicio : </label>".$value['fechaInicio']."</h4></div>";  
            echo "<div class='col-xs-6 col-sm-6'><h4 class='titulo'>Fecha Límite : </label>".$value['fechaTermino']."</h4></div>"; 
            echo "</div>";
            
             echo"<hr>";
              }
        $this->setFechaInicio($value['fechaInicio']);
        $this->setFechaTermino($value['fechaTermino']);
            }
      
           
        }          
    }
    function servicioSocialConsultaIndividualPrestador() {
        
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT * FROM vs_prestadores WHERE codigo = :codigo AND IdPrestacion = :IdPrestacion;');
        $query->bindValue(':codigo', $this->getCodigo());
        $query->bindValue(':IdPrestacion', $this->getIdPrestacion());
        $query->execute();
        
        $resultado = $query->fetchAll();
        
        foreach ($resultado as $key => $value) {
            
            
            echo"<div class='col-xs-6 col-sm-6'><h4 class='titulo'>Código: ".$value['codigo']."</h4></div>";
            echo"<div class='col-xs-6 col-sm-6'><h4 class='titulo'>Nombre: ".$value['nombre']."</h4></div>";
            echo"<div class='col-xs-6 col-sm-6'><h4 class='titulo'>Prestación: ".$value['IdPrestacion']." - ".$value['prestacion']."</h4></div>";
             
             echo"<div class='col-xs-6 col-sm-6'><h4 class='titulo'>Institución: </label>".$value['institucion']."</div>";
             echo"<div class='col-xs-12 col-sm-12'><h4 class='titulo'>Id Prestador: ".$value['IdPersona']."</h4></div>";
       if($value['fechaInicio']!='' && $value['fechaTermino']!='')
             {
            echo"<hr>";
            echo "<div class='col-xs-6 col-sm-6'><h4 class='titulo'>Fecha Inicio : </label>".$value['fechaInicio']."</h4></div>";  
            echo "<div class='col-xs-6 col-sm-6'><h4 class='titulo'>Fecha Límite : </label>".$value['fechaTermino']."</h4></div>"; 
        
            
             echo"<hr>";
              }
        $this->setFechaInicio($value['fechaInicio']);
        $this->setFechaTermino($value['fechaTermino']);
        
      
           
        }          
    }
}//Fin de la clase servicioSocial

