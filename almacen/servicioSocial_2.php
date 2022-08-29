<?php

class servicioSocial {
    
    private $IdPersona;
    private $codigo;
    private $nombre;
    private $IdPrestacion;
    private $fechaInicio;
    private $fechaTermino;
    
    
    
    
    function cuentaAlta() {
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
          */ }
        catch(PDOException $e)
        {
            echo $query . "<br>" . $e->getMessage();
        }

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
    function cuentaConsulta() {
        /*
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT * FROM CUENTA WHERE anio = :anio;');
        $query->bindValue(':anio', $this->getAnio());
        $query->execute();
        $pago=new pago();
        $pago->setAnio($this->getAnio());
        $movimiento=new movimiento();
        
        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
          $cuentas[$key] = array(
                $value['IdCuenta'],
                $value['anio'],  
                $value['COG'],
                $value['descripcion'],
                $value['tipo'],
                '$ '.number_format($montoApertura=$movimiento->movimientoConsultaApertura($value['IdCuenta']),2,'.',','),
                '$ '.number_format($montoAbonos=$movimiento->movimientoConsultaAbonos($value['IdCuenta']),2,'.',','),
                '$ '.number_format($montoCargos=$movimiento->movimientoConsultaCargos($value['IdCuenta']),2,'.',','),
                '<a href="pagoConsulta.php?anio='.$pago->getAnio().'&id='.$value['IdCuenta'].'" ">'.'$ '.number_format($sumaPagos=$pago ->pagoSumaConsulta($value['IdCuenta']),2,'.',',').'</a>',
                '$ '.number_format($saldo=$montoApertura+$montoAbonos-$montoCargos-$sumaPagos,2,'.',','),
                '<a href="cuentaModificar.php?id='.$value['IdCuenta'].'" class="btn btn-default">Modificar</a>'
            );
        }
        return $cuentas;    */
    }


    

}//Fin de la clase servicioSocial

