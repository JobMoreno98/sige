<?php
include_once "conexion.php";
//originalmente era horariosr


class ct {
    
    private $IdArea;
    private $identificacion;
    private $observaciones;
    private $area;
    private $piso;
    private $edificio;
    private $tipo;
    function getIdArea() {
        return $this->IdArea;
    }

    function getIdentificacion() {
        return $this->identificacion;
    }

    function getObservaciones() {
        return $this->observaciones;
    }

    function getArea() {
        return $this->area;
    }

    function getPisoo() {
        return $this->pisoo;
    }

    function getEdificio() {
        return $this->edificio;
    }

    function getTipo() {
        return $this->tipo;
    }

    function setIdArea($IdArea) {
        $this->IdArea = $IdArea;
    }

    function setIdentificacion($identificacion) {
        $this->identificacion = $identificacion;
    }

    function setObservaciones($observaciones) {
        $this->observaciones = $observaciones;
    }

    function setArea($area) {
        $this->area = $area;
    }

    function setPisoo($piso) {
        $this->pisoo = $piso;
    }

    function setEdificio($edificio) {
        $this->edificio = $edificio;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

        
    function nodoAlta() {
        try {
        /*
        $pdo = new Conexion();
        $query = $pdo->prepare("INSERT INTO CUENTA (anio,
        COG, descripcion, tipo) VALUES (".$this->getAnio().",
        ".$this->getCOG().",
        '".$this->getDescripcion()."',
        '".$this->getTipo()."');");
        $query->execute();
            $lastId=$pdo->lastInsertId();
            return $lastId;
           */}
        catch(PDOException $e)
        {
            echo $query . "<br>" . $e->getMessage();
        }

        $pdo = null;
    }
    function nodoModificar() {
        try {
        /*
        $pdo = new Conexion();
        $query = $pdo->prepare("SELECT * FROM CUENTA WHERE IdCuenta=".$this->getIdCuenta().";");
        $query->execute();
        $resultado = $query->fetchAll();
        foreach ($resultado as $value) {
            $this ->setAnio($value['anio']);
            $this ->setCOG($value['COG']);
            $this ->setDescripcion($value['descripcion']);
            $this ->setTipo($value['tipo']);
        }
        */}
        catch(PDOException $e)
        {
            echo $query . "<br>" . $e->getMessage();
        }

        $pdo = null;
    }
    function nodoModificarGuardar() {
        try {
        /*
        $pdo = new Conexion();
        $query = $pdo->prepare("UPDATE CUENTA"
                . " SET anio = :anio,"
                . " COG = :COG,"
                . " descripcion = :descripcion,"
                . " tipo = :tipo WHERE IdCuenta = :IdCuenta;");
        $query->bindValue(':anio', $this->getAnio());
        $query->bindValue(':COG', $this->getCOG());
        $query->bindValue(':descripcion', $this->getDescripcion());
        $query->bindValue(':tipo', $this->getTipo());
        $query->bindValue(':IdCuenta', $this->getIdCuenta());
        $query->execute();
        
        */}
        catch(PDOException $e)
        {
            echo $query . "<br>" . $e->getMessage();
        }

        $pdo = null;
    }
    function ctConsulta() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT * FROM vs_ct');
        //$query->bindValue(':anio', $this->getAnio());
        $query->execute();
        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
          $ct[$key] = array(
                $value['IdArea'],  
                $value['identificacion'],
                $value['observaciones'],
                $value['area'],
                $value['piso'],
                $value['edificio'],
                $value['tipo'],
                '<a href="ctModificar.php?id='.$value['IdArea'].'" class="btn btn-default">Modificar</a>'
            );
        }
        return $ct;    
    }


    

}//Fin de la clase ct

