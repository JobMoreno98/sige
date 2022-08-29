<?php
include 'conexion.php';

class mensaje {

    private $fechaCaducidad;
    
            function __construct() {
        
    }
    
    function getFechaCaducidad() {
        return $this->fechaCaducidad;
    }

    function setFechaCaducidad($fechaCaducidad) {
        $this->fechaCaducidad = $fechaCaducidad;
    }

        
    function requisicionesPendientes() {
        
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT r.*, e.nombre
            FROM REQUISICION r JOIN EMPLEADO e ON r.idEmpleado=e.idEmpleado WHERE r.idRequisicion IN 
            (SELECT distinct idRequisicion FROM SALIDA_MATERIAL WHERE estado != "Surtido");');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            $arregloReqPend[$key] = array(
                $value['idRequisicion'],
                $value['fechaRequisicion'],
                $value['folio'],
                $value['tipo'],
                $value['responsableAlmacen'],
                $value['nombre']
            );
        }
        if (isset($arregloReqPend)) 
        {
            return $arregloReqPend;
        }
    }
    
    function comprasIncompletas() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT c.idCompra, c.fechaCompra, c.tipoCompra, e.nombre, p.nombreComercial
            FROM COMPRA c JOIN EMPLEADO e ON c.idEmpleado = e.idEmpleado JOIN PROVEEDOR p ON c.idProveedor = p.idProveedor WHERE c.idCompra IN
    (SELECT distinct idCompra FROM COMPRA_MATERIAL WHERE estadoMaterial != "Recibido");");');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            $arregloCompInc[$key] = array(
                $value['idCompra'],
                $value['fechaCompra'],
                $value['tipoCompra'],
                $value['nombre'],
                $value['nombreComercial']
            );
        }
        if (isset($arregloCompInc)) 
        {
            return $arregloCompInc;
        }
    }
    
    function requisicionesSurtir() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT r.*, e.nombre
            FROM REQUISICION r JOIN EMPLEADO e ON r.idEmpleado=e.idEmpleado WHERE r.idRequisicion IN 
            (SELECT distinct idRequisicion FROM SALIDA_MATERIAL WHERE estado = "Autorizado");');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            $arregloReqSurt[$key] = array(
                $value['idRequisicion'],
                $value['fechaRequisicion'],
                $value['folio'],
                $value['tipo'],
                $value['responsableAlmacen'],
                $value['nombre']
            );
        }
        if (isset($arregloReqSurt)) 
        {
            return $arregloReqSurt;
        }
    }
    
    function requisicionesRecibir() {
                $pdo = new Conexion();
        $query = $pdo->prepare('SELECT r.*, e.nombre FROM REQUISICION r JOIN EMPLEADO e ON r.idEmpleado=e.idEmpleado WHERE r.idRequisicion IN 
            (SELECT distinct sm.idRequisicion FROM SALIDA_MATERIAL sm JOIN REQUISICION r 
            ON sm.idRequisicion = r.idRequisicion WHERE sm.estado != "Surtido" AND r.idEmpleado = '. $_SESSION['idEmpleado'] .');');
        $query->execute();
        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            $arregloReqReci[$key] = array(
                $value['idRequisicion'],
                $value['fechaRequisicion'],
                $value['folio'],
                $value['tipo'],
                $value['responsableAlmacen'],
                $value['nombre']
            );
        }
        if (isset($arregloReqReci)) 
        {
            return $arregloReqReci;
        }
    }

    function permisosPendientes() {
                $pdo = new Conexion();
        $query = $pdo->prepare('SELECT p.*, e.nombre, a.area FROM PERMISO p JOIN EMPLEADO e ON p.idEmpleado = e.idEmpleado JOIN AREA a ON e.idArea = a.idArea WHERE p.estatus = "Pendiente";');
        $query->execute();
        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            $arregloPer[$key] = array(
                $value['idPermiso'],
                $value['nombre'],
                $value['area'],
                $value['fechaSolicitud'],
                $value['fechaPermiso'],
                $value['motivo'],
                $value['estatus'],
                '<a href="permisoPDF.php?id='.$value['idPermiso'].'" class="btn btn-success" target="_blank">Descargar</a>',
                '<a href="permisoModificar.php?id='.$value['idPermiso'].'" class="btn btn-default">Autorizar/Modificar</a>'
            );
        }
        if (isset($arregloPer)) 
        {
            return $arregloPer;
        }
    }

    function limpiezaResurtir() {
                $pdo = new Conexion();
        $query = $pdo->prepare('SELECT
            idMaterial, descripcion, tipo, existencia, stockMinimo, tiempoCaducidad, nivelExistencia, enUso
            FROM MATERIAL WHERE nivelExistencia = "Bajo" AND tipo = "Limpieza" AND enUso = "Activo"
            OR (nivelExistencia = "Bajo" AND tipo = "Limpieza" AND enUso = "Activo");');
        $query->execute();
        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            $arregloLimp[$key] = array(
                $value['idMaterial'],
                $value['descripcion'],
                $value['existencia'],
                $value['stockMinimo'],
                $value['tiempoCaducidad'],
                $value['nivelExistencia']
            );
        }
        if (isset($arregloLimp)) 
        {
            return $arregloLimp;
        }
    }
    
    function papeleríaResurtir() {
                $pdo = new Conexion();
        $query = $pdo->prepare('SELECT idMaterial, descripcion, tipo, existencia, stockMinimo, tiempoCaducidad, nivelExistencia, enUso
            FROM MATERIAL WHERE nivelExistencia = "Bajo" AND tipo = "Papelería" AND enUso = "Activo"
            OR (nivelExistencia = "Bajo" AND tipo = "Papelería" AND enUso = "Activo");');
        $query->execute();
        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            $arregloPap[$key] = array(
                $value['idMaterial'],
                $value['descripcion'],
                $value['existencia'],
                $value['stockMinimo'],
                $value['tiempoCaducidad'],
                $value['nivelExistencia']
            );
        }
        if (isset($arregloPap)) 
        {
            return $arregloPap;
        }
    }
    
    
    function consultaMaterialPapeleriaPorCaducar(){
       $conn=new Conexion();
       $sql=$conn->prepare('SELECT em.idMaterial, m.descripcion, m.existencia, e.fechaEntrega, em.fechaCaducidad, em.cantidad, e.idCompra, em.idEntrega 
FROM  ENTRADA_MATERIAL em 
JOIN MATERIAL m ON em.idMaterial = m.idMaterial 
JOIN ENTREGA e ON em.idEntrega = e.idEntrega
WHERE em.cantidad != 0 AND
em.idMaterial IN (SELECT idMaterial from MATERIAL WHERE tipo = "Papelería" AND existencia != 0 AND enUso = "Activo")  
ORDER BY em.idMaterial, em.fechaCaducidad, em.idEntrega;');
       $sql->execute();
       $resultado=$sql->fetchAll();
       foreach ($resultado as $key => $value){
          $arregloPapCad[$key] = array(
                $value['idMaterial'],
                $value['descripcion'],
                $value['existencia'],
                $value['fechaEntrega'],
                $value['fechaCaducidad'],
                $value['cantidad'],
                $value['idCompra'],
                $value['idEntrega']
            );
        }
        return $arregloPapCad;
    }
    
    function consultaMaterialLimpiezaPorCaducar(){
       $conn=new Conexion();
       $sql=$conn->prepare('SELECT em.idMaterial, m.descripcion, m.existencia, e.fechaEntrega, em.fechaCaducidad, em.cantidad, e.idCompra, em.idEntrega 
FROM  ENTRADA_MATERIAL em 
JOIN MATERIAL m ON em.idMaterial = m.idMaterial 
JOIN ENTREGA e ON em.idEntrega = e.idEntrega
WHERE em.cantidad != 0 AND
em.idMaterial IN (SELECT idMaterial from MATERIAL WHERE tipo = "Limpieza" AND existencia != 0 AND enUso = "Activo")  
ORDER BY em.idMaterial, em.fechaCaducidad, em.idEntrega;');
       $sql->execute();
       $resultado=$sql->fetchAll();
       foreach ($resultado as $key => $value){
          $arregloLimpCad[$key] = array(
                $value['idMaterial'],
                $value['descripcion'],
                $value['existencia'],
                $value['fechaEntrega'],
                $value['fechaCaducidad'],
                $value['cantidad'],
                $value['idCompra'],
                $value['idEntrega']
            );
        }
        return $arregloLimpCad;
    }
    
    function consultaMaterialPapeleríaGeneral(){
       $conn=new Conexion();
       $sql=$conn->prepare('SELECT idMaterial, existencia FROM material '
               . 'WHERE tipo = "Papelería" AND existencia != 0 AND enUso = "Activo" ORDER BY idMaterial;');
       $sql->execute();
       $resultado=$sql->fetchAll();
       foreach ($resultado as $key => $value){
          $arregloPapCad[$key] = array(
                $value['idMaterial'],
                $value['existencia']
            );
        }
        return $arregloPapCad;
    }
    
    function consultaMaterialLimpiezaGeneral(){
       $conn=new Conexion();
       $sql=$conn->prepare('SELECT idMaterial, existencia FROM material '
               . 'WHERE tipo = "Limpieza" AND existencia != 0 AND enUso = "Activo" ORDER BY idMaterial;');
       $sql->execute();
       $resultado=$sql->fetchAll();
       foreach ($resultado as $key => $value){
          $arregloLimpCad[$key] = array(
                $value['idMaterial'],
                $value['existencia']
            );
        }
        return $arregloLimpCad;
    }
    
    function calculoMaterialPapeleriaPorCaducar() {
        $entrada = $this->consultaMaterialPapeleriaPorCaducar();
        $material = $this->consultaMaterialPapeleríaGeneral();
        
        
        $j = (count($entrada)-1);
        for ($i = (count($material)-1); $i >= 0; $i--) {    
            
            $existenciaMaterial = $material[$i][1];
            
            while ($entrada[$j][0] == $material[$i][0] && $j > 0) {
                
                if ($entrada[$j][5] < $existenciaMaterial) {
                    
                    $existenciaMaterial = $existenciaMaterial - $entrada[$j][5];
                }else {
                    $entrada[$j][5] = $existenciaMaterial;
                    $existenciaMaterial = 0;
                }
                $j--;
            }
            if ($j == 0 && $entrada[$j][5] > $material[$i][1]) {
                $entrada[$j][5] = $material[$j][1];
            }
            
        }

        $fechaCad = strtotime($this->getFechaCaducidad());
        for ($k = 0; $k < count($entrada); $k++) {
            
            $fechaEn = strtotime($entrada[$k][4]);
            
            if ($entrada[$k][5] > 0 && $fechaEn <= $fechaCad) {
                $arregloPapCad[] = $entrada[$k];
            } 
        }
        
        if (isset($arregloPapCad)) 
        {
            return $arregloPapCad;
        }
    }
    
    function calculoMaterialLimpiezaPorCaducar() {
        $entrada = $this->consultaMaterialLimpiezaPorCaducar();
        $material = $this->consultaMaterialLimpiezaGeneral();
        
        
        $j = (count($entrada)-1);
        for ($i = (count($material)-1); $i >= 0; $i--) {    
            
            $existenciaMaterial = $material[$i][1];
            
            while ($entrada[$j][0] == $material[$i][0] && $j > 0) {
                
                if ($entrada[$j][5] < $existenciaMaterial) {
                    
                    $existenciaMaterial = $existenciaMaterial - $entrada[$j][5];
                }else {
                    $entrada[$j][5] = $existenciaMaterial;
                    $existenciaMaterial = 0;
                }
                $j--;
            }
            if ($j == 0 && $entrada[$j][5] > $material[$i][1]) {
                $entrada[$j][5] = $material[$j][1];
            }
            
        }

        $fechaCad = strtotime($this->getFechaCaducidad());
        for ($k = 0; $k < count($entrada); $k++) {
            
            $fechaEn = strtotime($entrada[$k][4]);
            
            if ($entrada[$k][5] > 0 && $fechaEn <= $fechaCad) {
                $arregloLimpCad[] = $entrada[$k];
            } 
        }
        
        if (isset($arregloLimpCad)) 
        {
            return $arregloLimpCad;
        }
    }
}

