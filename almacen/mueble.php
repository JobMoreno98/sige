<?php
//originalmente era horariosr

include_once 'conexion.php';
session_start();
class mueble {
    
    private $IdMobiliario;
    private $IdUdG;
    private $detalles;
    private $verificado;
    private $IdEmpleado;
    private $IdArea;
    private $IdCatalogoM;
    private $estatus;
    private $descripcion;
    private $marca;
    private $modelo;
    private $medidas;
    private $imgFrente;
    private $imgLateral;
    private $estadoCatalogoMueble;
    private $tipo;
    private $fichaTecnica;
    private $categoria;
    private $IdTipoSIIAU;
    private $origenMueble;
    
    function getOrigenMueble() {
        return $this->origenMueble;
    }
    
    function getIdTipoSIIAU() {
        return $this->IdTipoSIIAU;
    }
        //atributos catálogoMueble
    
    function getDescripcion() {
        return $this->descripcion;
    }

    function getMarca() {
        return $this->marca;
    }

    function getModelo() {
        return $this->modelo;
    }

    function getMedidas() {
        return $this->medidas;
    }

    function getImgFrente() {
        return $this->imgFrente;
    }

    function getImgLateral() {
        return $this->imgLateral;
    }

    function getEstadoCatalogoMueble() {
        return $this->estadoCatalogoMueble;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getFichaTecnica() {
        return $this->fichaTecnica;
    }

    function getCategoria() {
        return $this->categoria;
    }
    
    function setOrigenMueble($origenMueble) {
        $this->origenMueble = $origenMueble;
    }
    function setIdTipoSIIAU($IdTipoSIIAU) {
        $this->IdTipoSIIAU = $IdTipoSIIAU;
    }
    
    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setMarca($marca) {
        $this->marca = $marca;
    }

    function setModelo($modelo) {
        $this->modelo = $modelo;
    }

    function setMedidas($medidas) {
        $this->medidas = $medidas;
    }

    function setImgFrente($imgFrente) {
        $this->imgFrente = $imgFrente;
    }

    function setImgLateral($imgLateral) {
        $this->imgLateral = $imgLateral;
    }

    function setEstadoCatalogoMueble($estadoCatalogoMueble) {
        $this->estadoCatalogoMueble = $estadoCatalogoMueble;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setFichaTecnica($fichaTecnica) {
        $this->fichaTecnica = $fichaTecnica;
    }

    function setCategoria($categoria) {
        $this->categoria = $categoria;
    }
    //fin atributos catálogoMueble
    
    function getIdMobiliario() {
        return $this->IdMobiliario;
    }

    function getIdUdG() {
        return $this->IdUdG;
    }

    function getDetalles() {
        return $this->detalles;
    }

    function getVerificado() {
        return $this->verificado;
    }

    function getIdEmpleado() {
        return $this->IdEmpleado;
    }

    function getIdArea() {
        return $this->IdArea;
    }

    function getIdCatalogoM() {
        return $this->IdCatalogoM;
    }
    function getEstatus() {
        return $this->estatus;
    }

    function setIdMobiliario($IdMobiliario) {
        $this->IdMobiliario = $IdMobiliario;
    }

    function setIdUdG($IdUdG) {
        $this->IdUdG = $IdUdG;
    }

    function setDetalles($detalles) {
        $this->detalles = $detalles;
    }

    function setVerificado($verificado) {
        $this->verificado = $verificado;
    }

    function setIdEmpleado($IdEmpleado) {
        $this->IdEmpleado = $IdEmpleado;
    }

    function setIdArea($IdArea) {
        $this->IdArea = $IdArea;
    }

    function setIdCatalogoM($IdCatalogoM) {
        $this->IdCatalogoM = $IdCatalogoM;
    }
    
    function setEstatus($estatus) {
        $this->estatus = $estatus;
    }
        
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
    function muebleConsulta($IdResguardante) {
        $pdo = new Conexion();
        if($_SESSION['privilegios']!="Sistemas" AND $_SESSION['privilegios']!="Administrador" AND $_SESSION['privilegios']!="Revisiones" AND $_SESSION['privilegios']!='Director'){
            $query = $pdo->prepare("SELECT * FROM vs_muebles WHERE estatus='Activo' AND Idempleado= :Idempleado;");
            $query->bindValue(':Idempleado', $IdResguardante);
        }else{
            $query = $pdo->prepare("SELECT * FROM vs_muebles WHERE estatus='Activo';");
        }
        $query->execute();
                
        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            $str1="No Disponible";
            $str2=$data['imgFrente'];
        
            $valor=strnatcasecmp ($str1,$str2 );
            if ($valor==0) {$fulltextf="-";} else  {$fulltextf="<a href='imgMuebles/".$value['imgFrente']."' target=\"_blank\"><center><img src='images/camara.png'></center></a>";} 
    
            $str3="No Disponible";
            $str4=$value['imgLateral'];
        
            $valor2=strnatcasecmp ($str3,$str4 );
            if ($valor2==0) {$fulltextl="<center>-</center>";} else  {$fulltextl="<a href='imgMuebles/".$value['imgLateral']." ' target=\"_blank\"><center><img src='images/fotos.png'></center></a>";} 
            
            $str5="No Disponible";
            $str6=$value['fichaTecnica'];
            
            $valor3=strnatcasecmp ($str5,$str6 );
            if ($valor3==0) {$fulltextft="<center>-</center>";} else  {$fulltextft="<a href='imgCatalogo/".$value['fichaTecnica']." ' target=\"_blank\">Ver</a>";} 
            
            $imgFrente = $fulltextf;
            $imgLateral = $fulltextl;
            $imgFichaTecnica = $fulltextft;
            
           
                $modificar="<a href='muebleModificar.php?id=".$value['IdMobiliario']."' class='btn btn-default'>Modificar</a>";
         
            $muebles[$key] = array(
              $value['IdMobiliario'], 
              $value['idUdg'],
              $value['descripcion'], 
              $value['marca'], 
              $value['modelo'],
              $value['Medidas'], 
              $value['IdArea']."-".$value['area'],
              $value['piso'],  
              $value['edificio'],
              $value['codigoUDG'],
              $value['nombre'],
              $imgFrente,
              $imgLateral,
              $imgFichaTecnica
            );
            if($_SESSION['privilegios'] == 'Administrador' or $_SESSION['privilegios'] == 'Sistemas' or $_SESSION['privilegios'] == 'Encargado AVS'){
                array_push($muebles[$key], $value['IdTipoSIIAU'], $modificar);
            }
        }
        return $muebles;    
    }
        
    function muebleCatalogoConsulta($tipo) {
        $pdo = new Conexion();
        if($tipo!="Todos"){ $query = $pdo->prepare("SELECT * FROM catalogomueble WHERE estadoCatalogoMueble='Activo' AND tipo='".$tipo."'");}
        else{ $query = $pdo->prepare("SELECT * FROM catalogomueble WHERE estadoCatalogoMueble='Activo'");}
        $query->execute();
                
        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            if($value['imgFrente']!='No Disponible') $imgFrente = "<a href='imgMuebles/".$value['imgFrente']."'  target='_blank'><img src=\"imgMuebles/".$value['imgFrente']."\" width=\"150\"></a>"; else $imgFrente =$value['imgFrente'];
            if($value['imgLateral']!='No Disponible') $imgLateral ="<a href='imgMuebles/".$value['imgLateral']."'  target='_blank'><img src=\"imgMuebles/".$value['imgLateral']."\" width=\"150\"></a>"; else $imgLateral =$value['imgLateral'];
            $modificar='<a href="muebleCatalogoModificar.php?id='.$value['idCatalogoM'].'" class="btn btn-default">Modificar</a>';
            
            $muebles[$key] = array(
              $value['idCatalogoM'],
              $value['origenMueble'],
              $value['tipo'], 
              $value['descripcion'], 
              $value['marca'], 
              $value['modelo'],
              $value['medidas'],
              $value['categoria'],
              $imgFrente,
              $imgLateral
              
            );
            if($_SESSION['privilegios'] == 'Administrador' or $_SESSION['privilegios'] == 'Sistemas'){
                array_push($muebles[$key], $value['IdTipoSIIAU'], $modificar);
            }
            if($_SESSION['privilegios'] == 'EncargadoCat3raG' and $value['tipo']=='Contemporáneo Belenes'){
                array_push($muebles[$key], $modificar);
            }
            if($_SESSION['privilegios'] == 'EncargadoCat2daG' and $value['tipo']=='Contemporáneo 2da Generación'){
                array_push($muebles[$key], $modificar);
            }
            if($_SESSION['privilegios'] == 'EncargadoCatHist' and $value['tipo']=='Histórico'){
                array_push($muebles[$key], $modificar);
            }
        }
        return $muebles;    
    }
    function muebleListadoPorTipo($idCatalogoM) {
        $pdo = new Conexion();
        $query = $pdo->prepare("SELECT * FROM vs_muebles WHERE estatus='Activo' AND idCatalogoM= :idCatalagoM;");
        $query->bindValue(':idCatalagoM', $idCatalogoM);    
        $query->execute();
              
        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
          
            $mueblesPorTipo[$key] = array(
              $value['IdMobiliario'], 
              $value['idUdg'],
              $value['descripcion'], 
              $value['marca'], 
              $value['modelo'],
              $value['medidas'], 
              $value['area'],
              $value['piso'],  
              $value['edificio'],
              $value['codigoUDG'],
              $value['nombre']
              
            );
            
        }
        return $mueblesPorTipo;    
    }
    function muebleListadoTotales() {
        $pdo = new Conexion();
        $query = $pdo->prepare("SELECT count(*) as cantidadMueble, idCatalogoM, IdTipoSIIAU, descripcion, Medidas, imgFrente FROM vs_muebles WHERE categoria='Utilitario' group by IdTipoSIIAU order by descripcion");
        $query->execute();
        $resultado = $query->fetchAll();
        
        foreach ($resultado as $key => $value) {
            $queryTotalSIIAU = $pdo->prepare('SELECT count(*) as cantidadSIIAU FROM mobiliariosiiau WHERE IdTipoSIIAU='.$value['IdTipoSIIAU'].'');
            $queryTotalSIIAU->execute();
            $resultadoTotalSIIAU = $queryTotalSIIAU->fetchAll();
            foreach ($resultadoTotalSIIAU as $keyTotalSIIAU => $valueTotalSIIAU) {
                if($valueTotalSIIAU['cantidadSIIAU']==0){ $TS='-';} else{ $TS=$valueTotalSIIAU['cantidadSIIAU'];}
            }
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
                $queryPisos = $pdo->prepare("SELECT count(*) as cantidadMueblePisos FROM vs_muebles where IdTipoSIIAU=".$value['IdTipoSIIAU']." AND piso='".$piso."' AND edificio='".$edificio."'");
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
              $value['IdTipoSIIAU'],  
              $value['descripcion'],
              $value['Medidas'],
              $value['cantidadMueble'],
              $TS,
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
    function muebleListadoTotalesSIGE() {
        $pdo = new Conexion();
        $query = $pdo->prepare("SELECT count(*) as cantidadMueble, idCatalogoM, IdTipoSIIAU, descripcion, Medidas, imgFrente FROM vs_muebles WHERE categoria='Utilitario' group by idCatalogoM order by descripcion");
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
              $value['IdTipoSIIAU'],  
              $value['descripcion'],
              $value['Medidas'],
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
    function listarCatalogoM() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT idCatalogoM, descripcion, marca, modelo, medidas FROM catalogomueble order by descripcion');
        $query->execute();
                
        $resultado = $query->fetchAll();
        
        foreach ($resultado as $key => $value) {
            echo '
                <option value="'. $value['idCatalogoM'] .'">'. $value['descripcion'] .' - '.$value['marca'] .' - '.$value['modelo'] .' - '.$value['medidas'] .'</option>';
        } 
    }
    function listarCatalogoMUnico() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT idCatalogoM, descripcion, marca, modelo, medidas FROM catalogomueble WHERE idCatalogoM='.$this->getIdCatalogoM().' order by descripcion');
        $query->execute();
                
        $resultado = $query->fetchAll();
        
        foreach ($resultado as $key => $value) {
            echo '
                <option value="'. $value['idCatalogoM'] .'">'. $value['descripcion'] .' - '.$value['marca'] .' - '.$value['modelo'] .' - '.$value['medidas'] .'</option>';
        } 
    }
function datosMueble() 
    {
        $pdo = new Conexion();
        
        $query = $pdo->prepare('SELECT * FROM vs_muebles WHERE 
             IdMobiliario = :IdMobiliario;');
        $query->bindValue(':IdMobiliario', $this->getIdMobiliario());
        $query->execute();
        
        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) 
        {
              echo"<div class='col-xs-12 col-sm-6'><h4 class='titulo'>Descripción: ".$value['descripcion']."</h4></div>";
             echo"<div class='col-xs-12 col-sm-6'><label><h4 class='titulo'>&Aacute;rea: </label>".$value['area']."</h4></div>";
             echo"<div class='col-xs-6 col-sm-6'><label><h4 class='titulo'>Piso: </label>".$value['piso']."</h4></div>";
             echo"<div class='col-xs-6 col-sm-6'><label><h4 class='titulo'>Edificio: </label>".$value['edificio']."</h4></div>";
            echo"<div class='col-xs-6 col-sm-6'><label><h4 class='titulo'>Id UdeG: </label>".$value['idUdg']."</h4></div>";
             echo"<hr>";
             echo "</div>";
             echo"<hr>";
        
          
             echo "<div class='col-xs-6 col-sm-4'><label><h4 class='titulo'>Marca: </label>".$value['marca']."</h4></div>";    
             echo "<div class='col-xs-6 col-sm-4'><label><h4 class='titulo'>Modelo: </label>".$value['modelo']."</h4></div>";   
             echo "<div class='col-xs-6 col-sm-4'><label><h4 class='titulo'>Medidas: </label>".$value['Medidas']."</h4></div>";
             echo "<div class='col-xs-4 col-sm-4'><label><h4 class='titulo'>Código UDG: </label>".$value['codigoUDG']."</h4></div>";
            echo "<div class='col-xs-8 col-sm-8'><label><h4 class='titulo'>Resguardante: </label>".$value['nombre']."</h4></div>";
             echo "</div>";
             

             echo"<hr>";
             echo "<div class='row'>";
             if ($value['imgFrente']!="No Disponible") echo "<div class='col-xs-12 col-sm-6'><label>ImgFrente : </label><img src='imgMuebles/".$value['imgFrente']."' heigth=\"20\"></div>";
             if ($value['imgSerie']!="No Disponible") echo "<div class='col-xs-12 col-sm-6'><label>Img Lateral : </label><img src='imgMuebles/".$value['imgLateral']."' heigth=\"20\"></div>";
             echo "</div>";
            
        } //fin del foreach    
    }//Fin datos mueble

function catalogoMuebleAlta() {
        try {
        
       $pdo = new Conexion();

          

     $query = $pdo->prepare("INSERT INTO catalogomueble (descripcion, marca, modelo, medidas, imgFrente, imgLateral, estadoCatalogoMueble, tipo, fichaTecnica, categoria,IdTipoSIIAU) VALUES ('".$this->getDescripcion()."', "
                ."'".$this->getMarca()."', "
                ."'". $this->getModelo()."', "
                ."'". $this->getMedidas()."', "
                ."'". $this->getImgFrente()."', "
                ."'". $this->getImgLateral()."', "
                ."'". $this->getEstadoCatalogoMueble()."', "
                ."'". $this->getTipo()."', "
                ."'". $this->getFichaTecnica()."', "
                ."'". $this->getCategoria()."', "
                . $this->getIdTipoSIIAU().");");
            
            //echo "INSERT INTO catalogomueble (descripcion, marca, modelo, medidas, imgFrente, imgLateral, estadoCatalogoMueble, tipo, fichaTecnica, categoria,IdTipoSIIAU) VALUES ('".$this->getDescripcion()."', "
            //    ."'".$this->getMarca()."', "
            //    . $this->getModelo().", "
            //    . $this->getMedidas().", "
            //    . $this->getImgFrente().", "
            //    . $this->getImgLateral().", "
            //    . $this->getEstadoCatalogoMueble().", "
            //    . $this->getTipo().", "
            //    . $this->getFichaTecnica().", "
            //    . $this->getCategoria().", "
            //    . $this->getIdTipoSIIAU().");";
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
    function muebleCatalogoModificar() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT * FROM catalogomueble WHERE idCatalogoM= '.$this ->getIdCatalogoM().';');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $value) {
        $this->setDescripcion($value['descripcion']);
        $this->setOrigenMueble($value['origenMueble']);
        $this->setMarca($value['marca']);
        $this->setModelo($value['modelo']);
        $this->setMedidas($value['medidas']);
        $this->setImgFrente($value['imgFrente']);
        $this->setImgLateral($value['imgLateral']);
        $this->setEstadoCatalogoMueble($value['estadoCatalogoMueble']);
        $this->setTipo($value['tipo']);
        $this->setFichaTecnica($value['fichaTecnica']);
        $this->setCategoria($value['categoria']);
        $this->setIdTipoSIIAU($value['IdTipoSIIAU']);
        }

    }
    function muebleCatalogoModificarGuardar() {
    try {
        
        $pdo = new Conexion();
        
        $query = $pdo->prepare("UPDATE catalogomueble SET descripcion=:descripcion,"
                . " origenMueble= :origenMueble,"
                . " marca = :marca,"
                . " modelo = :modelo,"
                . " medidas = :medidas,"
                . " imgFrente = :imgFrente,"
                . " imgLateral = :imgLateral,"
                . " estadoCatalogoMueble = :estadoCatalogoMueble,"
                . " tipo = :tipo,"
                . " fichaTecnica = :fichaTecnica,"
                . " categoria = :categoria,"
                . " IdTipoSIIAU = :IdTipoSIIAU WHERE idCatalogoM =:idCatalogoM;");
                //. " WHERE idMobiliario =:idMobiliario;");
        $query->bindValue(':descripcion', $this->getDescripcion());         
        $query->bindValue(':origenMueble', $this->getOrigenMueble());
        $query->bindValue(':marca', $this->getMarca());
        $query->bindValue(':modelo', $this->getModelo());
        $query->bindValue(':medidas', $this->getMedidas());
        $query->bindValue(':imgFrente', $this->getImgFrente());
        $query->bindValue(':imgLateral', $this->getImgLateral());
        $query->bindValue(':estadoCatalogoMueble', $this->getEstadoCatalogoMueble());
        $query->bindValue(':tipo', $this->getTipo());
        $query->bindValue(':fichaTecnica', $this->getFichaTecnica());
        $query->bindValue(':categoria', $this->getCategoria());
        $query->bindValue(':IdTipoSIIAU', $this->getIdTipoSIIAU());
        $query->bindValue(':idCatalogoM', $this->getIdCatalogoM());
        $query->execute();
        /*echo "UPDATE catalogomueble SET descripion=".$this->getDescripcion().", "
                . " origenMueble= ".$this->getOrigenMueble().","
                . " marca= ".$this->getMarca().","
                . " modelo= ".$this->getModelo().","
                . " medidas= ".$this->getMedidas().","
                . " imgFrente= ".$this->getImgFrente().","
                . " imgLateral= ".$this->getImgLateral().","
                . " estadoCatalogoMueble= ".$this->getEstadoCatalogoMueble().","
                . " tipo= ".$this->getTipo().","
                . " fichaTecnica= ".$this->getFichaTecnica().","
                . " categoria= ".$this->getCategoria().","
                . " IdtipoSIIAU= ".$this->getIdTipoSIIAU().","
                . " WHERE idMobiliario = ".$this->getIdCatalogoM().";";*/
        
        }
        catch(PDOException $e)
        {
            echo $query . "<br>" . $e->getMessage();
        }

        $pdo = null;
    }
    
    
    function arteCatalogoConsulta() {
        $pdo = new Conexion();
        $query = $pdo->prepare("SELECT * FROM catalogomueble WHERE categoria = 'Obra de Arte'");
        $query->execute();
                
        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            if($value['imgFrente']!='No Disponible') $imgFrente = "<a href='imgMuebles/".$value['imgFrente']."'  target='_blank'><img       src=\"imgMuebles/".$value['imgFrente']."\" width=\"150\"></a>"; else $imgFrente =$value['imgFrente'];
            if($value['imgLateral']!='No Disponible') $imgLateral ="<a href='imgMuebles/".$value['imgLateral']."'  target='_blank'><img src=\"imgMuebles/".$value['imgLateral']."\" width=\"150\"></a>"; else $imgLateral =$value['imgLateral'];
            
            $modificar='<a href="arteModificar.php?id='.$value['idCatalogoM'].'" class="btn btn-default">Modificar</a>';
            $arte[$key] = array(
                
              $value['idCatalogoM'],
              $value['origenMueble'],            
              $value['descripcion'], 
              $value['medidas'],
              $value['categoria'],
              $imgFrente,
              $imgLateral
              
             // '<a href="arteModificar.php?id='.$value['idCatalogoM'].'" class="btn btn-default">Modificar</a>'
            );
           
            if($_SESSION['privilegios'] == 'Administrador' or $_SESSION['privilegios'] == 'Sistemas' or $_SESSION['privilegios'] == 'EncargadoCatHist'){
                array_push($arte[$key],$modificar);
            }
        }
        return $arte;    
    }
    

    function arteModificar() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT * FROM catalogomueble WHERE idCatalogoM= '.$this ->getIdCatalogoM().';');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $value) {
        $this->setDescripcion($value['descripcion']);
        $this->setOrigenMueble($value['origenMueble']);
        $this->setMedidas($value['medidas']);
        $this->setImgFrente($value['imgFrente']);
        $this->setImgLateral($value['imgLateral']);
        $this->setCategoria($value['categoria']);
        }

    }
    
    
    function arteModificarGuardar() {
    try {
        
        $pdo = new Conexion();
        
        $query = $pdo->prepare("UPDATE catalogomueble SET descripcion=:descripcion,"
                . " origenMueble= :origenMueble,"
                . " medidas = :medidas,"
                . " imgFrente = :imgFrente,"
                . " imgLateral = :imgLateral,"
                . " categoria = :categoria WHERE idCatalogoM =:idCatalogoM;");
                //. " WHERE idMobiliario =:idMobiliario;");
        $query->bindValue(':descripcion', $this->getDescripcion());         
        $query->bindValue(':origenMueble', $this->getOrigenMueble());
        $query->bindValue(':medidas', $this->getMedidas());
        $query->bindValue(':imgFrente', $this->getImgFrente());
        $query->bindValue(':imgLateral', $this->getImgLateral());
        $query->bindValue(':categoria', $this->getCategoria());
        $query->bindValue(':idCatalogoM', $this->getIdCatalogoM());
        $query->execute();
        /*echo "UPDATE catalogomueble SET descripion=".$this->getDescripcion().", "
                . " origenMueble= ".$this->getOrigenMueble().","
                . " marca= ".$this->getMarca().","
                . " modelo= ".$this->getModelo().","
                . " medidas= ".$this->getMedidas().","
                . " imgFrente= ".$this->getImgFrente().","
                . " imgLateral= ".$this->getImgLateral().","
                . " estadoCatalogoMueble= ".$this->getEstadoCatalogoMueble().","
                . " tipo= ".$this->getTipo().","
                . " fichaTecnica= ".$this->getFichaTecnica().","
                . " categoria= ".$this->getCategoria().","
                . " IdtipoSIIAU= ".$this->getIdTipoSIIAU().","
                . " WHERE idMobiliario = ".$this->getIdCatalogoM().";";*/
        
        }
        catch(PDOException $e)
        {
            echo $query . "<br>" . $e->getMessage();
        }

        $pdo = null;
    }
    
    
    
}//Fin de la clase

