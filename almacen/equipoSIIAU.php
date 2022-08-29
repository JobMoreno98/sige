<?php

include_once 'conexion.php';
session_start();
class equipoSIIAU {
    
    private $IdEquipoSIIAU;
    private $IdUDG;
    private $cogDescripcion;
    private $clasificador;
    private $clasificadorDescripcion;
    private $IdResguardante;
    private $resguardanteNombre;
    private $fechaAdquisicion;
    private $descripcion;
    private $origen;
    private $tramAlta;
    private $marca;
    private $modelo;
    private $numSerie;
    private $IdTipoSIIAU;
    
    
    function equipoSIIAUConsulta() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT * FROM equiposiiau');
        $query->execute();
                
        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            
            $mueblesSIIAU[$key] = array(
              $value['IdEquipoSIIAU'],
              $value['IdUDG'],
              $value['cogDescripcion'],
              $value['clasificador'], 
              $value['clasificadorDescripcion'], 
              $value['IdResguardante'],
              $value['nombreResguardante'],
              $value['fechaAdquisicion'],
              $value['descripcion'],
              $value['origen'],
              $value['tramAlta'],
              $value['marca'],
              $value['modelo'],
              $value['numSerie'],
              $value['IdTipoSIIAU']
            );
        }
        return $mueblesSIIAU;    
    }
    function equipoListadoTotales() {
        $pdo = new Conexion();
        $query = $pdo->prepare("SELECT count(*) as cantidadEquipo, descripcion, marca, modelo FROM vs_equipos group by descripcion, marca, modelo order by descripcion");
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
                $queryPisos = $pdo->prepare("SELECT count(*) as cantidadEquipoPisos FROM vs_equipos where marca='".$value['marca']."' AND modelo='".$value['modelo']."'AND piso='".$piso."' AND edificio='".$edificio."'");
                $queryPisos->execute();
                $resultadoPisos = $queryPisos->fetchAll();
                foreach ($resultadoPisos as $keyPisos => $valuePisos) {
                    if($piso=="Piso -1" && $edificio=="Contemporáneo") {if($valuePisos['cantidadEquipoPisos']==0){$P0C="-";}else{$P0C=$valuePisos['cantidadEquipoPisos'];}}
                    if($piso=="Planta Baja" && $edificio=="Contemporáneo") {if($valuePisos['cantidadEquipoPisos']==0){$PBC="-";}else{$PBC=$valuePisos['cantidadEquipoPisos'];}}
                    if($piso=="Piso 1" && $edificio=="Contemporáneo") {if($valuePisos['cantidadEquipoPisos']==0){$P1C="-";}else{$P1C=$valuePisos['cantidadEquipoPisos'];}}
                    if($piso=="Piso 2" && $edificio=="Contemporáneo") {if($valuePisos['cantidadEquipoPisos']==0){$P2C="-";}else{$P2C=$valuePisos['cantidadEquipoPisos'];}}
                    if($piso=="Piso 3" && $edificio=="Contemporáneo") {if($valuePisos['cantidadEquipoPisos']==0){$P3C="-";}else{$P3C=$valuePisos['cantidadEquipoPisos'];}}
                    if($piso=="Piso 4" && $edificio=="Contemporáneo") {if($valuePisos['cantidadEquipoPisos']==0){$P4C="-";}else{$P4C=$valuePisos['cantidadEquipoPisos'];}}
                    if($piso=="Piso 5" && $edificio=="Contemporáneo") {if($valuePisos['cantidadEquipoPisos']==0){$P5C="-";}else{$P5C=$valuePisos['cantidadEquipoPisos'];}}
                    if($piso=="Piso 6" && $edificio=="Contemporáneo") {if($valuePisos['cantidadEquipoPisos']==0){$P6C="-";}else{$P6C=$valuePisos['cantidadEquipoPisos'];}}
                    if($piso=="Planta Baja" && $edificio=="Histórico") {if($valuePisos['cantidadEquipoPisos']==0){$PBH="-";}else{$PBH=$valuePisos['cantidadEquipoPisos'];}}
                    if($piso=="Piso 1" && $edificio=="Histórico") {if($valuePisos['cantidadEquipoPisos']==0){$P1H="-";}else{$P1H=$valuePisos['cantidadEquipoPisos'];}}
                    if($piso=="Piso 2" && $edificio=="Histórico") {if($valuePisos['cantidadEquipoPisos']==0){$P2H="-";}else{$P2H=$valuePisos['cantidadEquipoPisos'];}}
                    if($piso=="Piso 3" && $edificio=="Histórico") {if($valuePisos['cantidadEquipoPisos']==0){$P3H="-";}else{$P3H=$valuePisos['cantidadEquipoPisos'];}}
                    if($piso=="Piso 4" && $edificio=="Histórico") {if($valuePisos['cantidadEquipoPisos']==0){$P4H="-";}else{$P4H=$valuePisos['cantidadEquipoPisos'];}}
                    if($piso=="Piso 5" && $edificio=="Histórico") {if($valuePisos['cantidadEquipoPisos']==0){$P5H="-";}else{$P5H=$valuePisos['cantidadEquipoPisos'];}}
                    if($piso=="Piso 6" && $edificio=="Histórico") {if($valuePisos['cantidadEquipoPisos']==0){$P6H="-";}else{$P6H=$valuePisos['cantidadEquipoPisos'];}}
                }
            }
            //if($value['imgFrente']!='No Disponible') $codigoImagen = "<a href='imgMuebles/".$value['imgFrente']."'  target='_blank'>".$value['idCatalogoM']."</a>"; else $codigoImagen =$value['idCatalogoM'];
            
            $equipoListadoTotales[$key] = array(
              $value['descripcion'],
              $value['Marca'],
              $value['Modelo'],
              $value['cantidadEquipo'],
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
        return $equipoListadoTotales;    
    }
    
    


    

}// fin de la clase muebleSIIAU

