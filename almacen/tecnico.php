<?php
include_once 'conexion.php';

class tecnico {
    
    private $IdTecnico;
    private $nombre;
    private $telefono;
    private $telEmergencia;
    private $comentarios;
    private $estatus; //Activo o Inactivo
    
    function getIdTecnico() {
        return $this->IdTecnico;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getTelefono() {
        return $this->telefono;
    }

    function getTelEmergencia() {
        return $this->telEmergencia;
    }

    function getComentarios() {
        return $this->comentarios;
    }
    function getEstatus() {
        return $this->estatus;
    }
    function setIdTecnico($IdTecnico) {
        $this->IdTecnico = $IdTecnico;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    function setTelEmergencia($telEmergencia) {
        $this->telEmergencia = $telEmergencia;
    }

    function setComentarios($comentarios) {
        $this->comentarios = $comentarios;
    }

    function setEstatus($estatus) {
        $this->estatus = $estatus;
    }
        
    function tecnicoAlta() {
        try {
        
        $pdo = new Conexion();
        $query = $pdo->prepare("INSERT INTO tecnico (nombre,
        telefono, telEmergencia, comentarios, estatus) VALUES ('".$this->getNombre()."',
        '".$this->getTelefono()."',
        '".$this->getTelEmergencia()."',
        '".$this->getComentarios()."',
        '".$this->getEstatus()."');");
        $query->execute();
          
           }
        catch(PDOException $e)
        {
            echo $query . "<br>" . $e->getMessage();
        }

        $pdo = null;
    }
    function tecnicoModificar() {
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
        }*/
        }
        catch(PDOException $e)
        {
            echo $query . "<br>" . $e->getMessage();
        }

        $pdo = null;
    }
    function tecnicoModificarGuardar() {
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
        */
        }
        catch(PDOException $e)
        {
            echo $query . "<br>" . $e->getMessage();
        }

        $pdo = null;
    }
    function tecnicoConsulta() {
        $pdo = new Conexion();
        $query = $pdo->prepare("SELECT * FROM tecnico WHERE estatus = :estatus;");
        $query->bindValue(':estatus', $this->getEstatus());
        $query->execute();
      
        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
          $tecnicos[$key] = array(
                $value['IdTecnico'],
                $value['nombre'],  
                $value['telefono'],
                $value['telEmergencias'],
                $value['comentarios'],
                $value['estatus']
            );
        }
        return $tecnicos;    
    }
    function tecnicosListado() {

        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT * FROM tecnico WHERE estatus ="Activo";');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            echo '<option value="'.$value['IdTecnico'].'">'.$value['nombre'].'</option>';
        }
    } // fin tecnicosListado
    function tecnicosListadoUnico() {

        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT * FROM tecnico WHERE IdTecnico= :IdTecnico;');
        $query->bindValue(':IdTecnico', $this->getIdTecnico());
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            echo '<option value="'.$value['IdTecnico'].'">'.$value['nombre'].'</option>';
        }
    } // fin tecnicosListado
}
