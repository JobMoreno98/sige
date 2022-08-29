<?php
include 'conexion.php';

class suplencia{
    private $idNombramiento;
    private $idEmpleado;
    private $idCadena;
    private $cargaHoraria;
    private $fechaInicio;
    private $fechaFin;
    private $anioRegistro;
    private $idSuplencia;
    private $nombramiento;
    private $estadoNombramiento;

    private $titulo1;
    private $titulo2;
    private $titulo3;
    private $titulo4;
    private $titulo5;
    private $titulo6;
    private $titulo7;
    private $titulo8;

        function __construct() {
        $this->setTitulo1('ID');
        $this->setTitulo2('Cadena');
        $this->setTitulo3('Empleado');
        $this->setTitulo4('Nombramiento');
        $this->setTitulo5('Carga Horaria');
        $this->setTitulo6('Fecha de Inicio');
        $this->setTitulo7('Fecha de Fin');
        $this->setTitulo8('Año Registro');
    }

    function getIdNombramiento() {
        return $this->idNombramiento;
    }

    function getIdEmpleado() {
        return $this->idEmpleado;
    }

    function getIdCadena() {
        return $this->idCadena;
    }

    function getCargaHoraria() {
        return $this->cargaHoraria;
    }

    function getFechaInicio() {
        return $this->fechaInicio;
    }

    function getFechaFin() {
        return $this->fechaFin;
    }

    function getAnioRegistro() {
        return $this->anioRegistro;
    }

    function getIdSuplencia() {
        return $this->idSuplencia;
    }

    function getNombramiento() {
        return $this->nombramiento;
    }

    function getEstadoNombramiento() {
        return $this->estadoNombramiento;
    }

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

    function setIdNombramiento($idNombramiento) {
        $this->idNombramiento = $idNombramiento;
    }

    function setIdEmpleado($idEmpleado) {
        $this->idEmpleado = $idEmpleado;
    }

    function setIdCadena($idCadena) {
        $this->idCadena = $idCadena;
    }

    function setCargaHoraria($cargaHoraria) {
        $this->cargaHoraria = $cargaHoraria;
    }

    function setFechaInicio($fechaInicio) {
        $this->fechaInicio = $fechaInicio;
    }

    function setFechaFin($fechaFin) {
        $this->fechaFin = $fechaFin;
    }

    function setAnioRegistro($anioRegistro) {
        $this->anioRegistro = $anioRegistro;
    }

    function setIdSuplencia($idSuplencia) {
        $this->idSuplencia = $idSuplencia;
    }

    function setNombramiento($nombramiento) {
        $this->nombramiento = $nombramiento;
    }

    function setEstadoNombramiento($estadoNombramiento) {
        $this->estadoNombramiento = $estadoNombramiento;
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



    function consultaNombreEmpleado() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT idEmpleado, nombre FROM empleado WHERE estado = "Activo";');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $value) {
             echo '
                <option value="'. $value['idEmpleado'] .'">'. $value['idEmpleado'] .' - '. $value['nombre'] .'</option>';
        }
    }

    function consultaNombramiento() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT idNombramiento, nombramiento FROM nombramiento WHERE estadoNombramiento = "Activo";');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $value) {
             echo '
                <option value="'. $value['idNombramiento'] .'">'. $value['nombramiento'] .'</option>';
        }
    }

    function consultaIdCadena() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT MAX(idCadena) AS idCadena FROM suplencia WHERE anioRegistro = '. $this->getAnioRegistro() .';');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $value) {
            $IdCad = $value['idCadena']+1;
        }
        return $IdCad;
    }

    function consultaReinicioCadena($i) {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT count(idCadena) AS idCadena FROM suplencia WHERE idCadena = 1 AND anioRegistro = '. $i .';');
        $query->execute();

        $resultado = $query->fetchAll();
            foreach ($resultado as $value) {
                     $IdCad = $value['idCadena'];
            }
        return $IdCad;
    }

    function suplenciaAlta() {
        try {
            $pdo = new Conexion();
            $query = $pdo->prepare("INSERT INTO suplencia (
            idNombramiento,
            idEmpleado,
            idCadena,
            cargaHoraria,
            fechaInicio,
            fechaFin,
            anioRegistro) VALUES (
            ".$this->getIdNombramiento().",
            ".$this->getIdEmpleado().",
            ".$this->getIdCadena().",
            ".$this->getCargaHoraria().",
            '".$this->getFechaInicio()."',
            '".$this->getFechaFin()."',
            ".$this->getAnioRegistro().");");
            $query->execute();
           }
        catch(PDOException $e)
        {
            echo $query . "<br>error" . $e->getMessage();
        }
        $pdo = null;
    }

        function titulosSuplencia()   {

        echo '<tr>
            <th>'.$this ->getTitulo1().'</th>
            <th>'.$this ->getTitulo2().'</th>
            <th>'.$this ->getTitulo3().'</th>
            <th>'.$this ->getTitulo4().'</th>
            <th>'.$this ->getTitulo5().'</th>
            <th>'.$this ->getTitulo6().'</th>
            <th>'.$this ->getTitulo7().'</th>
            <th>'.$this ->getTitulo8().'</th>
        </tr>';

    }

    function consultaSuplencia(){
       $conn=new Conexion();
       $sql=$conn->prepare('SELECT s.*, n.nombramiento, e.nombre FROM suplencia s '
               . 'JOIN NOMBRAMIENTO n ON s.idNombramiento = n.idNombramiento '
               . 'JOIN EMPLEADO e ON s.idEmpleado = e.idEmpleado '
               . 'WHERE S.idCadena LIKE "'.$this->getIdCadena().'%"'
               . 'AND e.nombre LIKE "%'.$this->getIdEmpleado().'%"'
               . 'AND n.nombramiento LIKE "%'.$this->getIdNombramiento().'%"'
               . 'AND s.cargaHoraria LIKE "'.$this->getCargaHoraria().'%"'
               . 'AND s.anioRegistro LIKE "'.$this->getAnioRegistro().'%";');
       $sql->execute();
       $resultado=$sql->fetchAll();
       foreach ($resultado as $key => $value){
          $arregloSup[$key] = array(
                $value['idSuplencia'],
                $value['idCadena'],
                $value['nombre'],
                $value['nombramiento'],
                $value['cargaHoraria'],
                $value['fechaInicio'],
                $value['fechaFin'],
                $value['anioRegistro']
            );
        }
        return $arregloSup;
    }

    function nombramientoAlta() {
        try {
            $pdo = new Conexion();
            $query = $pdo->prepare("INSERT INTO nombramiento (
            nombramiento) VALUES (
            '".$this->getNombramiento()."');");
            $query->execute();
            echo '<div class="container">'
        . '<br><br><center><img class="img-responsive" src="images/check.png" style="width:15%">'
                    . '<br><p class="text-success text-center text-uppercase">'
                    . 'La información se guardó correctamente</p></center>'
                    . '</div>';
           }
        catch(PDOException $e)
        {
            echo $query . "<br>error" . $e->getMessage();
        }
        $pdo = null;
    }

        function consultaNombramientoTabla() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT idNombramiento, nombramiento, estadoNombramiento FROM nombramiento;');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
          $arregloNomb[$key] = array(
                $value['idNombramiento'],
                $value['nombramiento'],
                $value['estadoNombramiento'],
                '<a href="nombramientoModificar.php?id='.$value['idNombramiento'].'" class="btn btn-default">Modificar</a>'
            );
        }
        return $arregloNomb;
    }

        function consultaNombramientoPorID() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT idNombramiento, nombramiento, estadoNombramiento FROM nombramiento WHERE idNombramiento = '. $this->getIdNombramiento() .';');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $value) {
          $arregloNomb = array(
                $value['idNombramiento'],
                $value['nombramiento'],
                $value['estadoNombramiento']
            );
        }
        return $arregloNomb;
    }

        function nombramientoModificar() {
        try {
        $pdo = new Conexion();
        $query = $pdo->prepare("UPDATE nombramiento SET nombramiento = :nombramiento,"
                . "estadoNombramiento = :estadoNombramiento"
                . " WHERE idNombramiento = :idNombramiento;");
        $query->bindValue(':idNombramiento', $this->getIdNombramiento());
        $query->bindValue(':nombramiento', $this->getNombramiento());
        $query->bindValue(':estadoNombramiento', $this->getEstadoNombramiento());
        $query->execute();
            echo '<div class="container">'
        . '<br><br><center><img class="img-responsive" src="images/check.png" style="width:15%">'
                    . '<br><p class="text-success text-center text-uppercase">'
                    . 'La información se guardó correctamente</p>'
                    . '</div>';
           }
        catch(PDOException $e)
        {
            echo $query . "<br>" . $e->getMessage();
        }

        $pdo = null;
    }
}
