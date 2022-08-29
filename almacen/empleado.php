<?php
include_once 'conexion.php';

class empleado {

    public function __construct() {
        $this->setTitulo1('ID');
        $this->setTitulo2('Código UDG');
        $this->setTitulo3('Nombre');
        $this->setTitulo4('Área');
        $this->setTitulo5('Piso');
        $this->setTitulo6('Edificio');
        $this->setTitulo7('Puesto');
        $this->setTitulo8('Nombramiento');
        $this->setTitulo9('Carga Horaria');
        $this->setTitulo10('Escolaridad');
        $this->setTitulo11('Observaciones');
        $this->setTitulo12('Extensión');
        $this->setTitulo13('Estado');
        $this->setTitulo14('Privilegios');
    }
    private $idEmpleado;
    private $codigoUDG;
    private $nombre;
    private $puesto;
    private $cargaHoraria;
    private $gradoEstudios;
    private $observaciones;
    private $extension;
    private $estado;
    private $privilegios;
    private $idArea;
    private $idNombramiento;
    private $tipoReporte;
    private $generarReporte;

    private $titulo1;
    private $titulo2;
    private $titulo3;
    private $titulo4;
    private $titulo5;
    private $titulo6;
    private $titulo7;
    private $titulo8;
    private $titulo9;
    private $titulo10;
    private $titulo11;
    private $titulo12;
    private $titulo13;
    private $titulo14;

    function getIdEmpleado() {
        return $this->idEmpleado;
    }

    function getCodigoUDG() {
        return $this->codigoUDG;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getPuesto() {
        return $this->puesto;
    }

    function getCargaHoraria() {
        return $this->cargaHoraria;
    }

    function getGradoEstudios() {
        return $this->gradoEstudios;
    }

    function getObservaciones() {
        return $this->observaciones;
    }

    function getExtension() {
        return $this->extension;
    }

    function getEstado() {
        return $this->estado;
    }

    function getPrivilegios() {
        return $this->privilegios;
    }

    function getIdArea() {
        return $this->idArea;
    }

    function getIdNombramiento() {
        return $this->idNombramiento;
    }
    function getTipoReporte() {
        return $this->tipoReporte;
    }
    function getGenerarReporte() {
        return $this->generarReporte;
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

    function getTitulo9() {
        return $this->titulo9;
    }

    function getTitulo10() {
        return $this->titulo10;
    }

    function getTitulo11() {
        return $this->titulo11;
    }

    function getTitulo12() {
        return $this->titulo12;
    }

    function getTitulo13() {
        return $this->titulo13;
    }

    function getTitulo14() {
        return $this->titulo14;
    }

    function setIdEmpleado($idEmpleado) {
        $this->idEmpleado = $idEmpleado;
    }

    function setCodigoUDG($codigoUDG) {
        $this->codigoUDG = $codigoUDG;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setPuesto($puesto) {
        $this->puesto = $puesto;
    }

    function setCargaHoraria($cargaHoraria) {
        $this->cargaHoraria = $cargaHoraria;
    }

    function setGradoEstudios($gradoEstudios) {
        $this->gradoEstudios = $gradoEstudios;
    }

    function setObservaciones($observaciones) {
        $this->observaciones = $observaciones;
    }

    function setExtension($extension) {
        $this->extension = $extension;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setPrivilegios($privilegios) {
        $this->privilegios = $privilegios;
    }

    function setIdArea($idArea) {
        $this->idArea = $idArea;
    }

    function setIdNombramiento($idNombramiento) {
        $this->idNombramiento = $idNombramiento;
    }
    function setTipoReporte($tipoReporte) {
        $this->tipoReporte = $tipoReporte;
    }
    function setGenerarReporte($generarReporte) {
        $this->generarReporte = $generarReporte;
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

    function setTitulo9($titulo9) {
        $this->titulo9 = $titulo9;
    }

    function setTitulo10($titulo10) {
        $this->titulo10 = $titulo10;
    }

    function setTitulo11($titulo11) {
        $this->titulo11 = $titulo11;
    }

    function setTitulo12($titulo12) {
        $this->titulo12 = $titulo12;
    }

    function setTitulo13($titulo13) {
        $this->titulo13 = $titulo13;
    }

    function setTitulo14($titulo14) {
        $this->titulo14 = $titulo14;
    }




    function consultaAreaEmpleado() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT idArea, area FROM area WHERE estadoArea = "Activo" ORDER BY idArea ASC');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            echo '
                <option value="'. $value['idArea'] .'">'. $value['idArea'] .' - '. $value['area'] .'</option>';
        }
    }
    function listarEmpleados() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT idEmpleado, nombre FROM empleado WHERE estado = "Activo" AND codigoUDG<>0 ORDER BY nombre ASC');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            echo '
                <option value="'. $value['idEmpleado'] .'">'. $value['nombre'] .'</option>';
        }
    }
    function listarUsuarios() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT idEmpleado, nombre FROM empleado WHERE estado = "Activo" ORDER BY nombre ASC');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            echo '
                <option value="'. $value['idEmpleado'] .'">'. $value['nombre'] .'</option>';
        }
    }


    function consultaNombramiento() {
                $pdo = new Conexion();
        $query = $pdo->prepare('SELECT idNombramiento, nombramiento FROM nombramiento WHERE estadoNombramiento = "Activo" ORDER BY idNombramiento ASC');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            echo '
                <option value="'. $value['idNombramiento'] .'">'. $value['idNombramiento'] .' - '. $value['nombramiento'] .'</option>';
        }
    }

    function empleadoAlta() {
        try {
        $pdo = new Conexion();

        $codigoUDG = $this->getCodigoUDG();
        $nombre = $this->getNombre();
        $puesto = $this->getPuesto();
        $cargaHoraria = $this->getCargaHoraria();
        $gradoEstudios = $this->getGradoEstudios();
        $observaciones = $this->getObservaciones();
        $extension = $this->getExtension();
        $privilegios = $this->getPrivilegios();
        $idNombramiento = $this->getIdNombramiento();
        $idArea = $this->getIdArea();
        $tipoReporte = $this->getTipoReporte();
        $generarReporte = $this->getGenerarReporte();

        $query = $pdo->prepare("INSERT INTO empleado (codigoUDG, nombre, puesto,
            cargaHoraria, gradoEstudios, observaciones, extension, privilegios,
            idNombramiento, idArea, tipoReporte, generarReporte) VALUES (
                :codigoUDG, :nombre, :puesto,
                :cargaHoraria, :gradoEstudios, :observaciones,
                :extension, :privilegios, :idNombramiento,
                :idArea, :tipoReporte, :generarReporte)");

        $query->bindparam(':codigoUDG', $codigoUDG, PDO::PARAM_INT);
        $query->bindparam(':nombre', $nombre, PDO::PARAM_STR, 50);
        $query->bindparam(':puesto', $puesto, PDO::PARAM_STR, 50);
        $query->bindparam(':cargaHoraria', $cargaHoraria, PDO::PARAM_INT);
        $query->bindparam(':gradoEstudios', $gradoEstudios, PDO::PARAM_STR, 150);
        $query->bindparam(':observaciones', $observaciones, PDO::PARAM_STR, 100);
        $query->bindparam(':extension', $extension, PDO::PARAM_INT);
        $query->bindparam(':privilegios', $privilegios, PDO::PARAM_STR, 16);
        $query->bindparam(':idNombramiento', $idNombramiento, PDO::PARAM_INT);
        $query->bindparam(':idArea', $idArea, PDO::PARAM_INT);
        $query->bindparam(':tipoReporte', $tipoReporte, PDO::PARAM_STR, 24);
        $query->bindparam(':generarReporte', $generarReporte, PDO::PARAM_STR, 1);


        $query->execute();
            echo '<div class="container">'
        . '<br><center><img class="img-responsive" src="images/check.png" style="width:15%">'
                    . '<center><br><p class="text-success text-center text-uppercase">'
                    . 'La información se guardó correctamente</p>'
                    . '</div>';
           }
        catch(PDOException $e)
        {
            echo $query . "<br>" . $e->getMessage();
        }

        $pdo = null;
    }

    function titulosEmpleado(){

            echo '<tr>
                <th>'.$this ->getTitulo1().'</th>
                <th>'.$this ->getTitulo2().'</th>
                <th>'.$this ->getTitulo3().'</th>
                <th>'.$this ->getTitulo4().'</th>
                <th>'.$this ->getTitulo5().'</th>
                <th>'.$this ->getTitulo6().'</th>
                <th>'.$this ->getTitulo7().'</th>
                <th>'.$this ->getTitulo8().'</th>
                <th>'.$this ->getTitulo9().'</th>
                <th>'.$this ->getTitulo10().'</th>
                <th>'.$this ->getTitulo11().'</th>
                <th>'.$this ->getTitulo12().'</th>
                <th>'.$this ->getTitulo13().'</th>
                <th>'.$this ->getTitulo14().'</th>
                <th>Mostrar</th>
                <th>Movimiento</th>
            </tr>';
    }

    function consultaEmpleado() {

        $pdo = new Conexion();
        //Los select hay que modificar por los campos a usar
        $query = $pdo->prepare('SELECT * FROM empleadovista
             WHERE codigoUDG<>222 AND codigoUDG LIKE "'.$this->getCodigoUDG().'%"'
                . 'AND nombre LIKE "%'.$this->getNombre().'%"'
                . 'AND area LIKE "%'.$this->getIdArea().'%"'
                . 'AND nombramiento LIKE "%'.$this->getIdNombramiento().'%"'
                . 'AND cargaHoraria LIKE "'.$this->getCargaHoraria().'%"'
                . 'AND extension LIKE "'.$this->getExtension().'%"'
                . 'AND estado LIKE "%'.$this->getEstado().'%"'
                . 'AND codigoUDG != 0;');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            echo '
                <tr>
                    <td>'. $value['idEmpleado'] .'</td>
                    <td>'. $value['codigoUDG'] .'</td>
                    <td>'. $value['nombre'] .'</td>
                    <td>'. $value['area'] .'</td>
                    <td>'. $value['piso'] .'</td>
                    <td>'. $value['edificio'] .'</td>
                    <td>'. $value['puesto'] .'</td>
                    <td>'. $value['nombramiento'] .'</td>
                    <td>'. $value['cargaHoraria'] .'</td>
                    <td>'. $value['gradoEstudios'] .'</td>
                    <td>'. $value['observaciones'] .'</td>
                    <td>'. $value['extension'] .'</td>
                    <td>'. $value['estado'] .'</td>
                    <td>'. $value['privilegios'] .'</td>
                    <td><a href="expedienteModificar.php?id='. $value['idEmpleado'] .'" class="btn btn-default">Expedientes</a></td>
                    <td><a href="empleadoModificar.php?id='. $value['idEmpleado'] .'"'
                        . ' class="btn btn-default" role="button">Modificar</a></td>
                </tr>
            ';
        }
    }

    function empleadoSeleccionModificar() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT * FROM empleadovista WHERE idEmpleado = '.$this ->getIdEmpleado().';');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            $arregloEmp = array(
                $value['idEmpleado'],
                $value['nombre'],
                $value['codigoUDG'],
                $value['puesto'],
                $value['idNombramiento'],
                $value['nombramiento'],
                $value['cargaHoraria'],
                $value['gradoEstudios'],
                $value['observaciones'],
                $value['extension'],
                $value['idArea'],
                $value['area'],
                $value['privilegios'],
                $value['estado'],
                $value['tipoReporte'],
                $value['generarReporte']
            );
        }
        return $arregloEmp;
    }
        function empleadoListaUnico() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT * FROM empleado WHERE idEmpleado = '.$this ->getIdEmpleado().';');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            echo '<option value="'.$value['idEmpleado'].'">'.$value['nombre'].'</option>';
        }
    }

    function empleadoModificar() {
        $pdo = new Conexion();
/*
        $query = $pdo->prepare("UPDATE empleado SET codigoUDG = :codigoUDG, nombre = :nombre, puesto = :puesto, cargaHoraria = :cargaHoraria,
                gradoEstudios = :gradoEstudios, observaciones = :observaciones, extension = :extension, privilegios = :privilegios, estado= :estado,
                idNombramiento = :idNombramiento, idArea = :idArea, tipoReporte = :tipoReporte, generarReporte = :generarReporte
                WHERE idEmpleado = :idEmpleado;");
*/
        $query = $pdo->prepare("UPDATE empleado SET codigoUDG = :codigoUDG, nombre = :nombre, puesto = :puesto, cargaHoraria = :cargaHoraria,
                gradoEstudios = :gradoEstudios, observaciones = :observaciones, extension = :extension, privilegios = :privilegios, estado= :estado,
                idNombramiento = :idNombramiento, idArea = :idArea, tipoReporte = :tipoReporte,  generarReporte = :generarReporte
                WHERE idEmpleado = :idEmpleado;");
        $query->bindValue(':idEmpleado', $this->getIdEmpleado());
        $query->bindValue(':codigoUDG', $this->getCodigoUDG());
        $query->bindValue(':nombre', $this->getNombre());
        $query->bindValue(':puesto', $this->getPuesto());
        $query->bindValue(':cargaHoraria', $this->getCargaHoraria());
        $query->bindValue(':gradoEstudios', $this->getGradoEstudios());
        $query->bindValue(':observaciones', $this->getObservaciones());
        $query->bindValue(':extension', $this->getExtension());
        $query->bindValue(':privilegios', $this->getPrivilegios());
        $query->bindValue(':estado', $this->getEstado());
        $query->bindValue(':idNombramiento', $this->getIdNombramiento());
        $query->bindValue(':idArea', $this->getIdArea());
        $query->bindValue(':tipoReporte', $this->getTipoReporte());
        $query->bindValue(':generarReporte', $this->getGenerarReporte());
        $query->execute();

    /*
        echo "UPDATE empleado SET codigoUDG = ".$this->getCodigoUDG().", nombre = ".$this->getNombre().", puesto = ".$this->getPuesto().", cargaHoraria = ".$this->getCargaHoraria().",
                gradoEstudios = ".$this->getGradoEstudios().", observaciones = ".$this->getObservaciones().", extension = ".$this->getExtension().", privilegios = ".$this->getPrivilegios().", estado= ".$this->getEstado().",
                idNombramiento = ".$this->getIdNombramiento().", idArea = ".$this->getIdArea()."
                WHERE idEmpleado = ".$this->idEmpleado().";";
*/
        echo '<div class="container">'
        . '<br><center><img class="img-responsive" src="images/check.png" style="width:15%">'
                    . '<center><br><p class="text-success text-center text-uppercase">'
                    . 'La información se guardó correctamente</p>'
                    . '</div>';
    }


    function expedienteModificar($valor, $nombre) {
        $pdo = new Conexion();
        $query = $pdo->prepare('UPDATE expediente SET '. $valor .' = "'. $nombre .'" WHERE idEmpleado = '. $this->getIdEmpleado() .';');
        $query->execute();
    }

    function empleadoDetalle() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT * FROM empleadovista WHERE idEmpleado = '.$this ->getIdEmpleado().';');
        $query->execute();
        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            $arregloEmpl[$key] = array(
                $value['codigoUDG'],
                $value['nombre'],
                $value['area'],
                $value['puesto'],
                $value['nombramiento'],
                $value['cargaHoraria'],
                $value['gradoEstudios'],
                $value['observaciones'],
                $value['extension'],
                $value['estado'],
                $value['privilegios']
            );
        }
        return $arregloEmpl;
    }

    function expedienteDetalle() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT * FROM expediente WHERE idEmpleado = '.$this ->getIdEmpleado().';');
        $query->execute();
        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            $arregloExp[$key] = array(
                $value['fichaUIP'],
                $value['CV'],
                $value['INE'],
                $value['RFC'],
                $value['IMSS'],
                $value['actaNacimiento'],
                $value['CURP'],
                $value['comprobanteDom'],
                $value['titulo']
            );
        }
        return $arregloExp;
    }


}
