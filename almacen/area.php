<?php
include_once 'conexion.php';

class area{

    public function __construct() {
        $this->setTitulo1('ID');
        $this->setTitulo2('Área');
        $this->setTitulo3('Piso');
        $this->setTitulo4('Edificio');
        $this->setTitulo5('Tipo');
        $this->setTitulo6('Estatus');
    }
    private $idArea;
    private $area;
    private $piso;
    private $edificio;
    private $tipo;
    private $estadoArea;

    private $titulo1;
    private $titulo2;
    private $titulo3;
    private $titulo4;
    private $titulo5;
    private $titulo6;

    function getIdArea() {
        return $this->idArea;
    }

    function getArea() {
        return $this->area;
    }

    function getPiso() {
        return $this->piso;
    }

    function getEdificio() {
        return $this->edificio;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getEstadoArea() {
        return $this->estadoArea;
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

    function setIdArea($idArea) {
        $this->idArea = $idArea;
    }

    function setArea($area) {
        $this->area = $area;
    }

    function setPiso($piso) {
        $this->piso = $piso;
    }

    function setEdificio($edificio) {
        $this->edificio = $edificio;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setEstadoArea($estadoArea) {
        $this->estadoArea = $estadoArea;
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


    function areaAlta() {
        try {
        $pdo = new Conexion();
        $query = $pdo->prepare("INSERT INTO area (area, piso, edificio, tipo)
        VALUES (:area, :piso, :edificio, :tipo);");
        $query->bindValue(':area', $this->getArea());
        $query->bindValue(':piso', $this->getPiso());
        $query->bindValue(':edificio', $this->getEdificio());
        $query->bindValue(':tipo', $this->getTipo());
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

    function titulosArea(){
            echo '<tr>
                <th>'.$this ->getTitulo1().'</th>
                <th>'.$this ->getTitulo2().'</th>
                <th>'.$this ->getTitulo3().'</th>
                <th>'.$this ->getTitulo4().'</th>
                <th>'.$this ->getTitulo5().'</th>
                <th>'.$this ->getTitulo6().'</th>
                <th>Operación</th>
            </tr>';
    }

    function consultaArea() {

        $pdo = new Conexion();
        //Los select hay que modificar por los campos a usar
        $query = $pdo->prepare('SELECT *
            FROM area WHERE area LIKE :area'
                . ' AND piso LIKE :piso'
                . ' AND edificio LIKE :edificio'
                . ' AND tipo LIKE :tipo'
                . ' AND estadoArea LIKE :estadoArea'
                . ';');
        $query->bindValue(':area', '%'.$this->getArea().'%');
        $query->bindValue(':piso', '%'.$this->getPiso().'%');
        $query->bindValue(':edificio', '%'.$this->getEdificio().'%');
        $query->bindValue(':tipo', '%'.$this->getTipo().'%');
        $query->bindValue(':estadoArea', '%'.$this->getEstadoArea().'%');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            echo '
                <tr>
                    <td>'. $value['idArea'] .'</td>
                    <td>'. $value['area'] .'</td>
                    <td>'. $value['piso'] .'</td>
                    <td>'. $value['edificio'] .'</td>
                    <td>'. $value['tipo'] .'</td>
                    <td>'. $value['estadoArea'] .'</td>
                    <td><a href="areaModificar.php?id='. $value['idArea'] .'"'
                        . ' class="btn btn-default" role="button">Modificar</a></td>
                </tr>
            ';
        }

    }

    function areaSeleccionModificar() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT * FROM area WHERE idArea = :idArea;');
        $query->bindValue(':idArea', $this->getIdArea());
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            $arregloArea = array(
                $value['idArea'],
                $value['area'],
                $value['piso'],
                $value['edificio'],
                $value['tipo'],
                $value['estadoArea']
            );
        }
        return $arregloArea;
    }

    function areaModificar() {
        $pdo = new Conexion();
        $query = $pdo->prepare("UPDATE area SET area = :area, piso = :piso, edificio = :edificio, tipo = :tipo, estadoArea = :estadoArea WHERE idArea = :idArea;");
        $query->bindValue(':idArea', $this->getIdArea());
        $query->bindValue(':area', $this->getArea());
        $query->bindValue(':piso', $this->getPiso());
        $query->bindValue(':edificio', $this->getEdificio());
        $query->bindValue(':tipo', $this->getTipo());
        $query->bindValue(':estadoArea', $this->getEstadoArea());
        $query->execute();
        echo '<div class="container">'
        . '<br><center><img class="img-responsive" src="images/check.png" style="width:15%">'
                    . '<center><br><p class="text-success text-center text-uppercase">'
                    . 'La información se guardó correctamente</p>'
                    . '</div>';
    }
    function listarAreaUnica() {

        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT * FROM area WHERE idArea= :idArea;');
        $query->bindValue(':idArea', $this->getIdArea());
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            echo '<option value="'.$value['idArea'].'">'.$value['area'].' - '.$value['idArea'].' - '.$value['piso'].' - '.$value['edificio'].'</option>';

        }

    }
    function listarAreas() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT * FROM area order by area asc;');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {


            echo '<option value="'.$value['idArea'].'">'.$value['area'].' - '.$value['idArea'].' - '.$value['piso'].' - '.$value['edificio'].'</option>';

        }
    }
}
