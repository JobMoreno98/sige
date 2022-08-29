<?php
//originalmente era horariosr
include_once 'pago.php';
include_once 'conexion.php';
include_once 'movimiento.php';


class cuenta {

    private $IdCuenta;
    private $anio;
    private $COG;
    private $descripcion;
    private $tipo;//Servicios Fijos, Servicios Variables


    function getIdCuenta() {
        return $this->IdCuenta;
    }
    function getAnio() {
        return $this->anio;
    }

    function getCOG() {
        return $this->COG;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getTipo() {
        return $this->tipo;
    }

    function setIdCuenta($idCuenta) {
        $this->IdCuenta = $idCuenta;
    }

    function setAnio($Anio) {
        $this->anio = $Anio;
    }

    function setCOG($cog) {
        $this->COG = $cog;
    }

    function setDescripcion($Descripcion) {
        $this->descripcion = $Descripcion;
    }

    function setTipo($Tipo) {
        $this->tipo = $Tipo;
    }

    function cuentaAlta() {
        try {

        $pdo = new Conexion();
        $query = $pdo->prepare("INSERT INTO cuenta (anio,
        COG, descripcion, tipo) VALUES (".$this->getAnio().",
        ".$this->getCOG().",
        '".$this->getDescripcion()."',
        '".$this->getTipo()."');");
        $query->execute();
            $lastId=$pdo->lastInsertId();
            return $lastId;
           }
        catch(PDOException $e)
        {
            echo $query . "<br>" . $e->getMessage();
        }

        $pdo = null;
    }
    function cuentaModificar() {
        try {

        $pdo = new Conexion();
        $query = $pdo->prepare("SELECT * FROM cuenta WHERE IdCuenta=".$this->getIdCuenta().";");
        $query->execute();
        $resultado = $query->fetchAll();
        foreach ($resultado as $value) {
            $this ->setAnio($value['anio']);
            $this ->setCOG($value['COG']);
            $this ->setDescripcion($value['descripcion']);
            $this ->setTipo($value['tipo']);
        }
        }
        catch(PDOException $e)
        {
            echo $query . "<br>" . $e->getMessage();
        }

        $pdo = null;
    }
    function cuentaModificarGuardar() {
        try {

        $pdo = new Conexion();
        $query = $pdo->prepare("UPDATE cuenta"
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

        }
        catch(PDOException $e)
        {
            echo $query . "<br>" . $e->getMessage();
        }

        $pdo = null;
    }
    function cuentaConsulta() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT * FROM cuenta WHERE IdCuenta >1;');
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
                '<a href="cuentaConsultaPagos.php?cuenta='.$value['IdCuenta'].'" ">'.'$ '.number_format($sumaPagos=$pago ->sumaMontoPorPagoConsulta($value['IdCuenta']),2,'.',',').'</a>',
                '$ '.number_format($saldo=$montoApertura+$montoAbonos-$montoCargos-$sumaPagos,2,'.',','),
                '<a href="cuentaModificar.php?id='.$value['IdCuenta'].'" class="btn btn-default">Modificar</a>'

            );
        }
        return $cuentas;
    }




}//Fin de la clase Cuenta
