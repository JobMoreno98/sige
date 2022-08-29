<?php
include_once "conexion.php";
//originalmente era horariosr


class nodo {
    
    private $IdNodo;
    private $IdArea;
    private $status;
    private $tipo;
    private $identificacion;
    private $area;
    private $piso;
    private $edificio;
    
    function getIdNodo() {
        return $this->IdNodo;
    }

    function getIdArea() {
        return $this->IdArea;
    }

    function getStatus() {
        return $this->status;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getIdentificacion() {
        return $this->identificacion;
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

    function setIdNodo($IdNodo) {
        $this->IdNodo = $IdNodo;
    }

    function setIdArea($IdArea) {
        $this->IdArea = $IdArea;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setIdentificacion($identificacion) {
        $this->identificacion = $identificacion;
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
    function nodoConsulta() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT * FROM vs_nodos');
        //$query->bindValue(':anio', $this->getAnio());
        $query->execute();
        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
          $nodos[$key] = array(
                $value['IdNodo'],
                $value['IdArea'],  
                $value['status'],
                $value['tipo'],
                $value['identificacion'],
                $value['area'],
                $value['piso'],
                $value['edificio'],
                '<a href="nodoModificar.php?id='.$value['IdNodo'].'" class="btn btn-default">Modificar</a>'
            );
        }
        return $nodos;    
    }


    

}//Fin de la clase nodo

