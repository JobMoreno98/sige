<?php

include_once 'conexion.php';
session_start();
class muebleSIIAU {
    
    private $IdMuebleSIIAU;
    private $IdUDG;
    private $clasificador;
    private $clasificadorDescripcion;
    private $IdResguardante;
    private $resguardanteNombre;
    private $fechaAdquisicion;
    private $descripcion;
    private $origen;
    private $tramiteAlta;
    private $ubicacion;
    private $IdRelacion;
    
   
        
    function muebleAlta() {
        try {
        
       $pdo = new Conexion();

          

    $query = $pdo->prepare("INSERT INTO mobiliario (IdUdG,
        detalles, IdEmpleado, IdArea, IdCatalogoM) VALUES ('".$this->getIdUdG()."', "
                ."'".$this->getDetalles()."', "
                . $this->getIdEmpleado().", "
                . $this->getIdArea().", "
                . $this->getIdCatalogoM().");");
       $query->execute();
            //$lastId=$pdo->lastInsertId();
            //return $lastId;
           }
        catch(PDOException $e)
        {
            echo $query . "<br>" . $e->getMessage();
        }

        $pdo = null;
    }
    function muebleModificar() {
        try {
        
        $pdo = new Conexion();
        $query = $pdo->prepare("SELECT * FROM mobiliario WHERE idMobiliario=".$this->getIdMobiliario().";");
        $query->execute();
        $resultado = $query->fetchAll();
        foreach ($resultado as $value) {
            $this ->setIdMobiliario($value['idMobiliario']);
            $this ->setIdUdG($value['IdUdG']);
            $this ->setDetalles($value['detalles']);
            $this ->setIdEmpleado($value['IdEmpleado']);
            $this ->setIdArea($value['IdArea']);
            $this ->setIdCatalogoM($value['IdCatalogoM']);
            $this ->setVerificado($value['verificado']);
            $this ->setEstatus($value['estatus']);
            
        }
        }
        catch(PDOException $e)
        {
            echo $query . "<br>" . $e->getMessage();
        }

        $pdo = null;
    }
    function muebleModificarGuardar() {
        try {
        
        $pdo = new Conexion();
        
        $query = $pdo->prepare("UPDATE mobiliario SET IdUdG=:IdUdG,"
                . " detalles= :detalles,"
                . " verificado = :verificado,"
                . " IdEmpleado = :IdEmpleado,"
                . " IdArea = :IdArea,"
                . " IdCatalogoM = :IdCatalogoM,"
                . " estatus = :estatus WHERE idMobiliario =:idMobiliario;");
                //. " WHERE idMobiliario =:idMobiliario;");
        $query->bindValue(':IdUdG', $this->getIdUdG());         
        $query->bindValue(':detalles', $this->getDetalles());
        $query->bindValue(':verificado', $this->getVerificado());
        $query->bindValue(':IdEmpleado', $this->getIdEmpleado());
        $query->bindValue(':IdArea', $this->getIdArea());
        $query->bindValue(':IdCatalogoM', $this->getIdCatalogoM());
        $query->bindValue(':estatus', $this->getEstatus());
        $query->bindValue(':idMobiliario', $this->getIdMobiliario());
        $query->execute();
        /*echo "UPDATE mobiliario SET IdUdG=".$this->getIdUdG().", "
                . " detalles= ".$this->getDetalles().","
                . " verificado= ".$this->getVerificado().","
                . " IdEmpleado= ".$this->getIdEmpleado().","
                . " IdArea= ".$this->getIdArea().","
                . " IdCatalagoM= ".$this->getIdCatalogoM().","
                . " WHERE idMobiliario = ".$this->getIdMobiliario().";";*/
        
        }
        catch(PDOException $e)
        {
            echo $query . "<br>" . $e->getMessage();
        }

        $pdo = null;
    }
    
    function muebleSIIAUConsulta() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT * FROM mobiliariosiiau');
        $query->execute();
                
        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            
            $mueblesSIIAU[$key] = array(
              $value['IdMuebleSIIAU'],
              $value['IdUDG'], 
              $value['clasificador'], 
              $value['clasificadorDescripcion'], 
              $value['IdResguardante'],
              $value['resguardanteNombre'],
              $value['fechaAdquisicion'],
              $value['descripcion'],
              $value['origen'],
              $value['tramiteAlta'],
              $value['ubicacion'],
              $value['IdTipoSIIAU']
            );
        }
        return $mueblesSIIAU;    
    }
    function muebleListadoTotales() {
        $pdo = new Conexion();
        $query = $pdo->prepare("SELECT count(*) as cantidadMueble, idCatalogoM, descripcion, imgFrente FROM vs_muebles WHERE categoria='Utilitario' group by idCatalogoM order by descripcion");
        //$query = $pdo->prepare('SELECT count(*) as cantidadMueble, descripcion, piso, edificio FROM vs_muebles group by descripcion, piso order by piso, descripcion');
        $query->execute();
                
        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            for($i=1;$i<=15;$i++){
                switch($i){ 
                    case 1:$piso="Piso -1"; $edificio="Contemporáneo"; break;
                    case 2:$piso="Planta Baja"; $edificio="Contemporáneo"; break;
                    case 3:$piso="Piso 1"; $edificio="Contemporáneo"; break;
                    case 4:$piso="Piso 2"; $edificio="Contemporáneo"; break;
                    case 5:$piso="Piso 3"; $edificio="Contemporáneo"; break;
                    case 6:$piso="Piso 4"; $edificio="Contemporáneo"; break;
                    case 7:$piso="Piso 5"; $edificio="Contemporáneo"; break;
                    case 8:$piso="Piso 6"; $edificio="Contemporáneo"; break;
                    case 9:$piso="Planta Baja"; $edificio="Histórico"; break;
                    case 10:$piso="Piso 1"; $edificio="Histórico"; break;
                    case 11:$piso="Piso 2"; $edificio="Histórico"; break;
                    case 12:$piso="Piso 3"; $edificio="Histórico"; break;
                    case 13:$piso="Piso 4"; $edificio="Histórico"; break;
                    case 14:$piso="Piso 5"; $edificio="Histórico"; break;
                    case 15:$piso="Piso 6"; $edificio="Histórico"; break;
                }
                $queryPisos = $pdo->prepare("SELECT count(*) as cantidadMueblePisos FROM vs_muebles where idCatalogoM=".$value['idCatalogoM']." AND piso='".$piso."' AND edificio='".$edificio."'");
                $queryPisos->execute();
                $resultadoPisos = $queryPisos->fetchAll();
                foreach ($resultadoPisos as $keyPisos => $valuePisos) {
                    if($piso=="Piso -1" && $edificio=="Contemporáneo") {if($valuePisos['cantidadMueblePisos']==0){$P0C="-";}else{$P0C=$valuePisos['cantidadMueblePisos'];}}
                    if($piso=="Planta Baja" && $edificio=="Contemporáneo") {if($valuePisos['cantidadMueblePisos']==0){$PBC="-";}else{$PBC=$valuePisos['cantidadMueblePisos'];}}
                    if($piso=="Piso 1" && $edificio=="Contemporáneo") {if($valuePisos['cantidadMueblePisos']==0){$P1C="-";}else{$P1C=$valuePisos['cantidadMueblePisos'];}}
                    if($piso=="Piso 2" && $edificio=="Contemporáneo") {if($valuePisos['cantidadMueblePisos']==0){$P2C="-";}else{$P2C=$valuePisos['cantidadMueblePisos'];}}
                    if($piso=="Piso 3" && $edificio=="Contemporáneo") {if($valuePisos['cantidadMueblePisos']==0){$P3C="-";}else{$P3C=$valuePisos['cantidadMueblePisos'];}}
                    if($piso=="Piso 4" && $edificio=="Contemporáneo") {if($valuePisos['cantidadMueblePisos']==0){$P4C="-";}else{$P4C=$valuePisos['cantidadMueblePisos'];}}
                    if($piso=="Piso 5" && $edificio=="Contemporáneo") {if($valuePisos['cantidadMueblePisos']==0){$P5C="-";}else{$P5C=$valuePisos['cantidadMueblePisos'];}}
                    if($piso=="Piso 6" && $edificio=="Contemporáneo") {if($valuePisos['cantidadMueblePisos']==0){$P6C="-";}else{$P6C=$valuePisos['cantidadMueblePisos'];}}
                    if($piso=="Planta Baja" && $edificio=="Histórico") {if($valuePisos['cantidadMueblePisos']==0){$PBH="-";}else{$PBH=$valuePisos['cantidadMueblePisos'];}}
                    if($piso=="Piso 1" && $edificio=="Histórico") {if($valuePisos['cantidadMueblePisos']==0){$P1H="-";}else{$P1H=$valuePisos['cantidadMueblePisos'];}}
                    if($piso=="Piso 2" && $edificio=="Histórico") {if($valuePisos['cantidadMueblePisos']==0){$P2H="-";}else{$P2H=$valuePisos['cantidadMueblePisos'];}}
                    if($piso=="Piso 3" && $edificio=="Histórico") {if($valuePisos['cantidadMueblePisos']==0){$P3H="-";}else{$P3H=$valuePisos['cantidadMueblePisos'];}}
                    if($piso=="Piso 4" && $edificio=="Histórico") {if($valuePisos['cantidadMueblePisos']==0){$P4H="-";}else{$P4H=$valuePisos['cantidadMueblePisos'];}}
                    if($piso=="Piso 5" && $edificio=="Histórico") {if($valuePisos['cantidadMueblePisos']==0){$P5H="-";}else{$P5H=$valuePisos['cantidadMueblePisos'];}}
                    if($piso=="Piso 6" && $edificio=="Histórico") {if($valuePisos['cantidadMueblePisos']==0){$P6H="-";}else{$P6H=$valuePisos['cantidadMueblePisos'];}}
                }
            }
            if($value['imgFrente']!='No Disponible') $codigoImagen = "<a href='imgMuebles/".$value['imgFrente']."'  target='_blank'>".$value['idCatalogoM']."</a>"; else $codigoImagen =$value['idCatalogoM'];
            
            $muebleListadoTotales[$key] = array(
              $codigoImagen,  
              $value['descripcion'],
              $value['cantidadMueble'],
              $P0C,
              $PBC,
              $P1C,
              $P2C,
              $P3C,
              $P4C,
              $P5C,
              $P6C,
              $PBH,
              $P1H,
              $P2H,
              $P3H,
              $P4H,
              $P5H,
              $P6H
            );
        }
        return $muebleListadoTotales;    
    }
    
    


    

}// fin de la clase muebleSIIAU

