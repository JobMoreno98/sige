<?php
include 'conexion.php';

class permiso {

    private $IdFalta;
    private $IdEmpleado;
    private $IdJefeInmediato;
    private $fechaSolicitud;
    private $motivo;
    private $motivoDiferente;
    private $observaciones;
    private $estatus;
    private $IdFechaPermiso;
    private $fechaPermiso;
    private $IdPermiso;
    private $IdFechaReposicion;
    private $fechaReposicion;
    private $IdFechaPermisoN;
    private $fechaPermisoN;
    private $IdFechaReposicionN;
    private $fechaReposicionN;
    private $periodoLargo;

    function getIdFalta(){
        return $this->IdFalta;
    }

    function getPeriodoLargo(){
        return $this->periodoLargo;
    }
    function setPeriodoLargo($periodoLargo){
        $this->periodoLargo = $periodoLargo;
    }

    function getIdEmpleado(){
        return $this->IdEmpleado;
    }

    function getIdJefeInmediato(){
        return $this->IdJefeInmediato;
    }

    function getFechaSolicitud(){
        return $this->fechaSolicitud;
    }

    function getMotivo(){
        return $this->motivo;
    }

    function getMotivoDiferente(){
        return $this->motivoDiferente;
    }

    function getObservaciones(){
        return $this->observaciones;
    }

    function getEstatus(){
        return $this->estatus;
    }

    function getIdFechaPermiso(){
        return $this->IdFechaPermiso;
    }

    function getFechaPermiso(){
        return $this->fechaPermiso;
    }

    function getIdPermiso(){
        return $this->IdPermiso;
    }

    function getIdFechaReposicion(){
        return $this->IdFechaReposicion;
    }

    function getFechaReposicion(){
        return $this->fechaReposicion;
    }

    function getIdFechaPermisoN(){
        return $this->IdFechaPermisoN;
    }

    function getFechaPermisoN(){
        return $this->fechaPermisoN;
    }

    function getIdFechaReposicionN(){
        return $this->IdFechaReposicionN;
    }

    function getFechaReposicionN(){
        return $this->fechaReposicionN;
    }

    function setIdFalta($IdFalta){
        $this->IdFalta = $IdFalta;
    }

    function setIdEmpleado($IdEmpleado){
        $this->IdEmpleado = $IdEmpleado;
    }

    function setIdJefeInmediato($IdJefeInmediato){
        $this->IdJefeInmediato = $IdJefeInmediato;
    }

    function setFechaSolicitud($fechaSolicitud){
        $this->fechaSolicitud = $fechaSolicitud;
    }

    function setMotivo($motivo){
        $this->motivo = $motivo;
    }

    function setMotivoDiferente($motivoDiferente){
        $this->motivoDiferente = $motivoDiferente;
    }

    function setObservaciones($observaciones){
        $this->observaciones = $observaciones;
    }

    function setEstatus($estatus){
        $this->estatus = $estatus;
    }

    function setIdFechaPermiso($IdFechaPermiso){
        $this->IdFechaPermiso = $IdFechaPermiso;
    }

    function setFechaPermiso($fechaPermiso){
        $this->fechaPermiso = $fechaPermiso;
    }

    function setIdPermiso($IdPermiso){
        $this->IdPermiso = $IdPermiso;
    }

    function setIdFechaReposicion($IdFechaReposicion){
        $this->IdFechaReposicion = $IdFechaReposicion;
    }

    function setFechaReposicion($fechaReposicion){
        $this->fechaReposicion = $fechaReposicion;
    }

    function setIdFechaPermisoN($IdFechaPermisoN){
        $this->IdFechaPermisoN = $IdFechaPermisoN;
    }

    function setFechaPermisoN($fechaPermisoN){
        $this->fechaPermisoN = $fechaPermisoN;
    }

    function setIdFechaReposicionN($IdFechaReposicionN){
        $this->IdFechaReposicionN = $IdFechaReposicionN;
    }

    function setFechaReposicionN($fechaReposicionN){
        $this->fechaReposicionN = $fechaReposicionN;
    }

    //Funciones permisoAlta.php

    function consultaEmpleados() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT e.idEmpleado, e.nombre, a.area, e.codigoUDG FROM empleado e JOIN area a ON e.idArea = a.idArea WHERE '
                . 'e.codigoUDG != 0 AND e.estado = "Activo" ORDER BY e.nombre ASC');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $value) {
            echo '
                <option value="'. $value['idEmpleado'] .'">'.$value['nombre'] .' - '. $value['codigoUDG'] . " - " .$value['area'] .'</option>';
        }
    }

    function consultaNombreEmpleado() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT idEmpleado, nombre FROM empleado WHERE '
                . 'idEmpleado = '.$_SESSION['idEmpleado']);
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            echo '
                <option value="'. $value['idEmpleado'] .'">'. $value['idEmpleado'] .' - '. $value['nombre'] .'</option>';
        }
    }

    function consultaJefeInmediato() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT e.idEmpleado, e.nombre, a.area FROM empleado e JOIN area a ON e.idArea = a.idArea'
                . ' WHERE e.estado = "Activo" AND e.privilegios = "Responsable"
                    OR e.privilegios = "Administrador"
                    OR e.idEmpleado = 74
                    OR e.idEmpleado = 13
                    ORDER BY e.nombre ASC');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            echo '
                <option value="'. $value['idEmpleado'] .'">'. $value['nombre'] .' - '. $value['area'] .'</option>';
        }
    }

    function permisoAlta() {
        try {
            $pdo = new Conexion();
            $query = $pdo->prepare("INSERT INTO permiso (IdEmpleado, IdJefeInmediato, fechaSolicitud, motivo, motivoDiferente, observaciones, estatus, periodoLargo) VALUES (
            ".$this->getIdEmpleado().",
            '".$this->getIdJefeInmediato()."',
            '".$this->getFechaSolicitud()."',
            '".$this->getMotivo()."',
            '".$this->getMotivoDiferente()."',
            '".$this->getObservaciones()."',
            '".$this->getEstatus()."',
            '".$this->getPeriodoLargo()."'
            );");
            $query->execute();
                echo '<div class="container">'
                    . '<br><br><center><img class="img-responsive" src="images/check.png" style="width:15%">'
                    . '<br><p class="text-success text-center text-uppercase">'
                    . 'La información se guardó correctamente</p>'
                    . '</div>';
        }catch(PDOException $e){
            echo $query . "<br>" . $e->getMessage();
        }

        $pdo = null;
    }

    function idUltimoPermiso(){
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT MAX(IdPermiso) AS IdPermiso FROM permiso');
        $query->execute();

        $resultado = $query->fetchAll();

        foreach ($resultado as $value) {
            $idPer = $value['IdPermiso'];
        }
        return $idPer;
    }

    function fechaPermisoAlta() {
        try {
            $pdo = new Conexion();
            $query = $pdo->prepare("INSERT INTO fechapermiso (fechaPermiso, idPermiso) VALUES (
            '".$this->getFechaPermiso()."',
            ".$this->getIdPermiso().");");
            $query->execute();
        }catch(PDOException $e){
            echo $query . "<br>error" . $e->getMessage();
        }
        $pdo = null;
    }

    function fechaReposicionAlta() {
        try {
            $pdo = new Conexion();
            $query = $pdo->prepare("INSERT INTO fechareposicion (fechaReposicion, idPermiso) VALUES (
            '".$this->getFechaReposicion()."',
            ".$this->getIdPermiso().");");
            $query->execute();
        }catch(PDOException $e){
            echo $query . "<br>error" . $e->getMessage();
        }
        $pdo = null;
    }

    //Funciones permisoConsulta.php

    function permisoConsulta() {
        $cuentas = array();
        $pdo = new Conexion();

        $query = $pdo->prepare(
            "SELECT p.IdPermiso, e.nombre,
            CONCAT(j.nombre, ' - ', a.area) AS jefeInmediato,
            f.fechapermiso, p.motivo, p.motivoDiferente,
            p.observaciones, p.estatus FROM permiso p
            INNER JOIN empleado e ON p.IdEmpleado = e.IdEmpleado
            INNER JOIN empleado j ON p.IdJefeInmediato = j.idEmpleado
            INNER JOIN area a ON j.idArea = a.idArea
            INNER JOIN fechapermiso f ON f.IdPermiso = p.IdPermiso
            WHERE periodoLargo = 'no' AND activo = 'si'"
        );
        $query->execute();


        $resultado = $query->fetchAll();
        while (sizeof($resultado) != 0) {
            $actual = array_shift($resultado);
            $eliminar = $this->botonEliminar2($actual['IdPermiso']);
            //$modificar="<a href='permisoModificar.php?id=".$actual['IdPermiso']."' class='btn btn-default'>Modificar</a>";
            $descargar="<a href='permisoPDF.php?id=".$actual['IdPermiso']."' class='btn btn-success' target='_blank'>Descargar PDF</a>";

            if (isset($resultado[0]) && $actual['IdPermiso'] == $resultado[0]['IdPermiso']) {
                $listaDias = array($actual['fechapermiso']);
                foreach ($resultado as $reg) {
                    if ($actual['IdPermiso'] == $reg['IdPermiso']) {
                        $regSiguiente = array_shift($resultado);
                        array_push($listaDias, $regSiguiente['fechapermiso']);
                    }else{
                        break;
                    }
                }
                $fechas = "";
                foreach ($listaDias as $dia) {
                    $fechas = $fechas.$dia."<br>";
                }
                $insertar = array(
                    $actual['IdPermiso'],
                    $actual['nombre'],
                    $actual['jefeInmediato'],
                    $fechas,
                    $actual['motivo'],
                    $actual['motivoDiferente'],
                    $actual['observaciones'],
                    $actual['estatus'],
                    $eliminar,
                    $descargar
                );
                array_push($cuentas, $insertar);

            }else{
                array_push($actual, $eliminar ,$descargar);
                array_push($cuentas, $actual);
            }

        }
        return $cuentas;
    }

    // Funciones permisoPDF.php

    function consultaPermisoPDF() {
        $pdo = new Conexion();
        $query = $pdo->prepare("SELECT p.IdPermiso, e.nombre, DATE_FORMAT(p.fechaSolicitud, '%d-%m-%Y') AS fechaSolicitud, CONCAT(em.nombre, ' - ', a.area) AS jefeInmediato, p.motivo, p.motivoDiferente, p.observaciones, p.estatus FROM permiso p JOIN empleado e ON p.IdEmpleado = e.idEmpleado JOIN empleado em ON p.IdJefeInmediato = em.idEmpleado JOIN area a ON em.idArea = a.idArea WHERE p.IdPermiso=". $this->getIdFalta() .";");
        $query->execute();
        $resultado = $query->fetchAll();
        foreach ($resultado as $value) {
            $falPDF = array(
                $value['IdPermiso'],
                $value['nombre'],
                $value['fechaSolicitud'],
                $value['jefeInmediato'],
                $value['motivo'],
                $value['motivoDiferente'],
                $value['observaciones'],
                $value['estatus']
            );
        }
        return $falPDF;
    }

    function consultaFechaPermisoPDF() {
        $pdo = new Conexion();
        $query = $pdo->prepare("SELECT fechaPermiso FROM fechapermiso WHERE IdPermiso=". $this->getIdFalta() .";");
        $query->execute();
        $resultado = $query->fetchAll();
        if($resultado == null){
            $fechPerPDF[0][0] = "0";
            $fechPerPDF[0][1] = "No Aplica";
        }else{
            foreach ($resultado as $key => $value) {
                $fechPerPDF[$key] = array(
                    $key+1,
                    $value['fechaPermiso']
                );
            }
        }
        return $fechPerPDF;
    }

    function consultaFechaReposicionPDF() {
        $pdo = new Conexion();
        $query = $pdo->prepare("SELECT fechaReposicion FROM fechareposicion WHERE IdPermiso=". $this->getIdFalta() .";");
        $query->execute();
        $resultado = $query->fetchAll();
        if($resultado == null){
            $fechRepPDF[0][0] = "0";
            $fechRepPDF[0][1] = "No Aplica";
        }else{
            foreach ($resultado as $key => $value) {
                $fechRepPDF[$key] = array(
                    $key+1,
                    $value['fechaReposicion']
                );
            }
        }
        return $fechRepPDF;
    }

    //Funciones permisoModificar.php

    function permisoModificar() {
        $pdo = new Conexion();
        $query = $pdo->prepare("SELECT p.*, e.nombre, CONCAT(em.nombre, ' - ', a.area) AS jefeInmediato FROM permiso p JOIN empleado e ON p.IdEmpleado = e.idEmpleado JOIN empleado em ON p.IdJefeInmediato = em.idEmpleado JOIN area a ON em.idArea = a.idArea WHERE IdPermiso=".$this ->getIdFalta().";");
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $value) {
             $arregloPeMod = array(
                $value['IdPermiso'],
                $value['IdEmpleado'],
                $value['IdJefeInmediato'],
                $value['fechaSolicitud'],
                $value['motivo'],
                $value['motivoDiferente'],
                $value['observaciones'],
                $value['estatus'],
                $value['nombre'],
                $value['jefeInmediato']
            );
        }
        return $arregloPeMod;
    }

    function fechaPermiso() {
        $pdo = new Conexion();
        $query = $pdo->prepare("SELECT fechaPermiso FROM fechapermiso WHERE IdPermiso=". $this->getIdFalta() .";");
        $query->execute();
        $resultado = $query->fetchAll();
        if($resultado == null){
            $fechPer[0][0] = "";
            $fechPer[0][1] = "";
        }else{
            foreach ($resultado as $key => $value) {
                $fechPer[$key] = array(
                    $key+1,
                    $value['fechaPermiso']
                );
            }
        }
        return $fechPer;

    }

    function fechaReposicion() {
        $pdo = new Conexion();
        $query = $pdo->prepare("SELECT fechaReposicion FROM fechareposicion WHERE IdPermiso=". $this->getIdFalta() .";");
        $query->execute();
        $resultado = $query->fetchAll();
        if($resultado == null){
            $fechRep[0][0] = "";
            $fechRep[0][1] = "";
        }else{
            foreach ($resultado as $key => $value) {
                $fechRep[$key] = array(
                    $key+1,
                    $value['fechaReposicion']
                );
            }
        }
        return $fechRep;
    }

    function permisoModificarGuardar() {
        try {
            $pdo = new Conexion();
            $query = $pdo->prepare("UPDATE permiso SET IdPermiso = :IdPermiso,"
                . " IdEmpleado = :IdEmpleado,"
                . " IdJefeInmediato = :IdJefeInmediato,"
                . " fechaSolicitud = :fechaSolicitud,"
                . " motivo = :motivo,"
                . " motivoDiferente = :motivoDiferente,"
                . " observaciones = :observaciones,"
                . " estatus = :estatus WHERE IdPermiso = :IdPermiso;");
            $query->bindValue(':IdPermiso', $this->getIdFalta());
            $query->bindValue(':IdEmpleado', $this->getIdEmpleado());
            $query->bindValue(':IdJefeInmediato', $this->getIdJefeInmediato());
            $query->bindValue(':fechaSolicitud', $this->getFechaSolicitud());
            $query->bindValue(':motivo', $this->getMotivo());
            $query->bindValue(':motivoDiferente', $this->getMotivoDiferente());
            $query->bindValue(':observaciones', $this->getObservaciones());
            $query->bindValue(':estatus', $this->getEstatus());
            $query->execute();
        } catch(PDOException $e) {
            echo $query . "<br>" . $e->getMessage();
        }
        $pdo = null;
    }

    function fechaPermisoGuardar() {
        try {
            $pdo = new Conexion();
            $query = $pdo->prepare("UPDATE fechaPermiso SET fechaPermiso = :fechaPermiso WHERE IdPermiso = :IdPermiso;");
            $query->bindValue(':IdPermiso', $this->getIdFalta());
            $query->bindValue(':fechaPermiso', $this->getFechaPermiso());
            $query->execute();
        } catch(PDOException $e) {
            echo $query . "<br>" . $e->getMessage();
        }
        $pdo = null;
    }

    function fechaReposicionGuardar() {
        try {
            $pdo = new Conexion();
            $query = $pdo->prepare("UPDATE fechaReposicion SET fechaReposicion = :fechaReposicion WHERE IdPermiso = :IdPermiso;");
            $query->bindValue(':IdPermiso', $this->getIdFalta());
            $query->bindValue(':fechaReposicion', $this->getFechaReposicion());
            $query->execute();
        } catch(PDOException $e) {
            echo $query . "<br>" . $e->getMessage();
        }
        $pdo = null;
    }

    function fechaPermisoNueva() {
        try {
            $pdo = new Conexion();
            $query = $pdo->prepare("INSERT INTO fechapermiso (fechaPermiso, idPermiso) VALUES (
            '".$this->getFechaPermisoN()."',
            ".$this->getIdPermiso().");");
            $query->execute();
        }catch(PDOException $e){
            echo $query . "<br>error" . $e->getMessage();
        }
        $pdo = null;
    }

    function fechaReposicionNueva() {
        try {
            $pdo = new Conexion();
            $query = $pdo->prepare("INSERT INTO fechareposicion (fechaReposicion, idPermiso) VALUES (
            '".$this->getFechaReposicionN()."',
            ".$this->getIdPermiso().");");
            $query->execute();
        }catch(PDOException $e){
            echo $query . "<br>error" . $e->getMessage();
        }
        $pdo = null;
    }

    function tableIncapacidad(){
        $conn = new Conexion();
        $query = $conn->prepare("SELECT p.IdPermiso, e.nombre,
        CONCAT(j.nombre, ' - ', a.area) AS jefeInmediato,
        f.fechapermiso,
        p.observaciones, p.estatus FROM permiso p
        INNER JOIN empleado e ON p.IdEmpleado = e.IdEmpleado
        INNER JOIN empleado j ON p.IdJefeInmediato = j.idEmpleado
        INNER JOIN area a ON j.idArea = a.idArea
        INNER JOIN fechapermiso f ON f.IdPermiso = p.IdPermiso
        WHERE p.periodoLargo = 'si' AND p.motivo = 'Incapacidad' AND p.activo = 'si'
        ORDER BY p.IdPermiso ASC");

        $query->execute();
        $resultado = $query->fetchAll();
        //echo var_dump($resultado);
        $data = array();
        while(sizeof($resultado) > 0){
            $actual = array_shift($resultado);
            if (isset($resultado[0]) && $actual['IdPermiso'] == $resultado[0]['IdPermiso']) {
                $modificar="<a href='incapacidadModificar.php?id=".$actual['IdPermiso']."' class='btn btn-default'>Modificar</a>";
                $eliminar = $this->botonEliminar($actual['IdPermiso']);
                $siguiente = array_shift($resultado);
                $reg = array(
                    $actual['IdPermiso'],
                    $actual['nombre'],
                    $actual['jefeInmediato'],
                    "Del ".$actual['fechapermiso']." al ".$siguiente['fechapermiso'],
                    $actual['observaciones'],
                    $actual['estatus'],
                    $modificar.$eliminar
                );
                array_push($data, $reg);
            }
        }
        return $data;
    }

    function tableLicencia(){
        $conn = new Conexion();
        $query = $conn->prepare("SELECT p.IdPermiso, e.nombre,
        CONCAT(j.nombre, ' - ', a.area) AS jefeInmediato,
        f.fechapermiso,
        p.observaciones, p.estatus FROM permiso p
        INNER JOIN empleado e ON p.IdEmpleado = e.IdEmpleado
        INNER JOIN empleado j ON p.IdJefeInmediato = j.idEmpleado
        INNER JOIN area a ON j.idArea = a.idArea
        INNER JOIN fechapermiso f ON f.IdPermiso = p.IdPermiso
        WHERE p.periodoLargo = 'si' AND p.motivo = 'Licencia' AND p.activo = 'si'
        ORDER BY p.IdPermiso ASC");

        $query->execute();
        $resultado = $query->fetchAll();
        //echo var_dump($resultado);
        $data = array();
        while(sizeof($resultado) > 0){

            $actual = array_shift($resultado);
            if (isset($resultado[0]) && $actual['IdPermiso'] == $resultado[0]['IdPermiso']) {
                $eliminar = $this->botonEliminar($actual['IdPermiso']);
                $modificar="<a href='incapacidadModificar.php?id=".$actual['IdPermiso']."' class='btn btn-default'>Modificar</a>";
                $siguiente = array_shift($resultado);
                $reg = array(
                    $actual['IdPermiso'],
                    $actual['nombre'],
                    $actual['jefeInmediato'],
                    "Del ".$actual['fechapermiso']." al ".$siguiente['fechapermiso'],
                    $actual['observaciones'],
                    $actual['estatus'],
                    $modificar.$eliminar
                );
                array_push($data, $reg);
            }
        }
        return $data;
    }

    function tableComision(){
        $conn = new Conexion();
        $query = $conn->prepare("SELECT p.IdPermiso, e.nombre,
        CONCAT(j.nombre, ' - ', a.area) AS jefeInmediato,
        f.fechapermiso,
        p.observaciones, p.estatus FROM permiso p
        INNER JOIN empleado e ON p.IdEmpleado = e.IdEmpleado
        INNER JOIN empleado j ON p.IdJefeInmediato = j.idEmpleado
        INNER JOIN area a ON j.idArea = a.idArea
        INNER JOIN fechapermiso f ON f.IdPermiso = p.IdPermiso
        WHERE p.periodoLargo = 'si' AND p.motivo = 'Comision' AND p.activo = 'si'
        ORDER BY p.IdPermiso ASC");

        $query->execute();
        $resultado = $query->fetchAll();
        //echo var_dump($resultado);
        $data = array();
        while(sizeof($resultado) > 0){

            $actual = array_shift($resultado);
            if (isset($resultado[0]) && $actual['IdPermiso'] == $resultado[0]['IdPermiso']) {
                $eliminar = $this->botonEliminar($actual['IdPermiso']);
                $modificar="<a href='incapacidadModificar.php?id=".$actual['IdPermiso']."' class='btn btn-default'>Modificar</a>";
                $siguiente = array_shift($resultado);
                $reg = array(
                    $actual['IdPermiso'],
                    $actual['nombre'],
                    $actual['jefeInmediato'],
                    "Del ".$actual['fechapermiso']." al ".$siguiente['fechapermiso'],
                    $actual['observaciones'],
                    $actual['estatus'],
                    $modificar.$eliminar
                );
                array_push($data, $reg);
            }
        }
        return $data;
    }

    function datosPermisoModificar($id){
        $conn = new Conexion();
        $data = array();
        $query = $conn->prepare("SELECT p.IdPermiso, e.nombre, e.idEmpleado,
        CONCAT(j.nombre, ' - ', a.area) AS jefeInmediato,
        j.idEmpleado as idJefe, f.fechapermiso, p.motivo,
        p.observaciones, p.estatus, f.IdFechaPermiso FROM permiso p
        INNER JOIN empleado e ON p.IdEmpleado = e.IdEmpleado
        INNER JOIN empleado j ON p.IdJefeInmediato = j.idEmpleado
        INNER JOIN area a ON j.idArea = a.idArea
        INNER JOIN fechapermiso f ON f.IdPermiso = p.IdPermiso
        WHERE p.IdPermiso = '$id'
        ORDER BY f.fechaPermiso ASC");

        $query->execute();
        $resultado = $query->fetchAll();
        $data['idPermiso'] = $resultado[0]['IdPermiso'];
        $data['empleado'] = $resultado[0]['nombre'];
        $data['idEmpleado'] = $resultado[0]['idEmpleado'];
        $data['jefe'] = $resultado[0]['jefeInmediato'];
        $data['idJefe'] = $resultado[0]['idJefe'];
        $data['fechaInicio'] = $resultado[0]['fechapermiso'];
        $data['fechaFin'] = $resultado[1]['fechapermiso'];
        $data['observaciones'] = $resultado[0]['observaciones'];
        $data['estatus'] = $resultado[0]['estatus'];
        $data['motivo'] = $resultado[0]['motivo'];
        $data['idFechaInicio'] = $resultado[0]['IdFechaPermiso'];
        $data['idFechaFin'] = $resultado[1]['IdFechaPermiso'];

        return $data;
    }

    function modificarPermisoLargo($datos){
        $conn = new Conexion();
        $query = $conn->prepare("UPDATE permiso SET
            IdEmpleado = :idEmpleado, IdJefeInmediato = :idJefe, motivo = :motivo,
            observaciones = :observaciones, estatus = :estatus
            WHERE IdPermiso = :idPermiso
        ");
        $query->bindValue(':idEmpleado', $datos['empleado']);
        $query->bindValue(':idJefe', $datos['jefe']);
        $query->bindValue(':motivo', $datos['motivo']);
        $query->bindValue(':observaciones', $datos['observaciones']);
        $query->bindValue(':estatus', $datos['estatus']);
        $query->bindValue(':idPermiso', $datos['idPermiso']);
        $query->execute();

        $inicio = $conn->prepare("UPDATE fechapermiso SET
            fechaPermiso = :fechaInicio
            WHERE IdFechaPermiso = :idFechaInicio
        ");
        $inicio->bindValue(':fechaInicio', $datos['rangoInicio']);
        $inicio->bindValue(':idFechaInicio', $datos['idFechaInicio']);

        $fin = $conn->prepare("UPDATE fechapermiso SET
            fechaPermiso = :fechaFin
            WHERE IdFechaPermiso = :idFechaFin
        ");
        $fin->bindValue(':fechaFin', $datos['rangoFin']);
        $fin->bindValue(':idFechaFin', $datos['idFechaFin']);
        $inicio->execute();
        $fin->execute();
    }

    function botonEliminar($id){
        $html = '<form action="incapacidadConsulta.php" method="post" onsubmit="return confirm(\'¿Seguro que deseas eliminar este registro?\');">
        <input type="hidden" name="idPermiso" value="'.$id.'"/>
        <button type="submit" name="eliminar" class="btn btn-default"/>Eliminar</button>
        </form>';
        return $html;
    }

    function botonEliminar2($id){
        $html = '<form action="permisoConsulta.php" method="post" onsubmit="return confirm(\'¿Seguro que deseas eliminar este registro?\');">
        <input type="hidden" name="idPermiso" value="'.$id.'"/>
        <button type="submit" name="eliminar" class="btn btn-default"/>Eliminar</button>
        </form>';
        return $html;
    }

    function eliminarPermisoLargo($id){
        $conn = new Conexion();
        $query = $conn->prepare("UPDATE permiso SET activo = 'no' WHERE IdPermiso = $id");
        $query->execute();
    }
}
