<?php
include_once 'conexionPrestadores.php';
class servicioSocial {
    
    private $IdPersona;
    private $codigo;
    private $nombre;
    private $IdPrestacion;
    private $fechaInicio;
    private $fechaTermino;
    
    function getIdPersona() {
        return $this->IdPersona;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getIdPrestacion() {
        return $this->IdPrestacion;
    }

    function getFechaInicio() {
        return $this->fechaInicio;
    }

    function getFechaTermino() {
        return $this->fechaTermino;
    }

    function setIdPersona($IdPersona) {
        $this->IdPersona = $IdPersona;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setIdPrestacion($IdPrestacion) {
        $this->IdPrestacion = $IdPrestacion;
    }

    function setFechaInicio($fechaInicio) {
        $this->fechaInicio = $fechaInicio;
    }

    function setFechaTermino($fechaTermino) {
        $this->fechaTermino = $fechaTermino;
    }

        
    
    function cuentaAlta() {
        try {
        /*
        $pdo = new Conexion();
        $query = $pdo->prepare("INSERT INTO CUENTA (anio,
        COG, descripcion, tipo) VALUES (".$this->getAnio().",
        ".$this->getCOG().",
        '".$this->getDescripcion()."',
        '".$this->getTipo()."');");
        $query->execute$query->bindValue(':anio', $this->getAnio());$query->bindValue(':anio', $this->getAnio());

        $pdo = null;
    }
    function cuentaModificar() {
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
    function cuentaModificarGuardar() {
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
    function servicioSocialConsulta() {
        
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT * FROM vs_prestadores order by nombre;');
        $query->execute();
        
        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
          $prestadores[$key] = array(
                $value['IdPersona'],
                "<a href='asistenciasSSConsulta.php?codigo=". $value['codigo']."'>".$value['codigo']."</a>",  
                $value['nombre'],
                $value['IdPrestacion'],
                $value['prestacion'],
                $value['institucion'],
                $value['fechaInicio'],
                $value['fechaTermino']
           );
        }
        return $prestadores;    
    }
    function servicioSocialConsultaIndividual() {
        
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT * FROM vs_prestadores WHERE codigo = :codigo AND IdPrestacion = :IdPrestacion;');
        $query->bindValue(':codigo', $this->getCodigo());
        $query->bindValue(':IdPrestacion', $this->getIdPrestacion());
        $query->execute();
        
        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
           echo "<div class='row'>";   
            echo"<div class='col-xs-6 col-sm-6'><h4 class='titulo'>Código: ".$value['codigo']."</h4></div>";
            echo"<div class='col-xs-6 col-sm-6'><h4 class='titulo'>Nombre: ".$value['nombre']."</h4></div>";
             echo"<div class='col-xs-6 col-sm-6'><h4 class='titulo'>Prestación: ".$value['IdPrestacion']." - ".$value['prestacion']."</h4></div>";
             echo"<div class='col-xs-6 col-sm-6'><h4 class='titulo'>Institución: </label>".$value['institucion']."</div>";
             echo"<div class='col-xs-12 col-sm-12'><h4 class='titulo'>Id Prestador: ".$value['IdPersona']."</h4></div>";
       if($value['fechaInicio']!='' && $value['fechaTermino']!='')
             {
            echo"<hr>";
            echo "<div class='col-xs-6 col-sm-6'><h4 class='titulo'>Fecha Inicio : </label>".$value['fechaInicio']."</h4></div>";  
            echo "<div class='col-xs-6 col-sm-6'><h4 class='titulo'>Fecha Fin : </label>".$value['fechaTermino']."</h4></div>"; 
            echo "</div>";
            
             echo"<hr>";
              }
        $this->setFechaInicio($value['fechaInicio']);
        $this->setFechaTermino($value['fechaTermino']);
        }
          
    }

    

}//Fin de la clase servicioSocial

