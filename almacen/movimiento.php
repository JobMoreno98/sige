<?php
//originalmente era horarios
include_once 'conexion.php';


class movimiento {

    private $IdMovimiento;
    private $IdCuenta;
    private $montoMovimiento;
    private $tipoMovimiento;//Apertura, Cargo, Abono
    private $observaciones;


    function getIdMovimiento() {
        return $this->IdMovimiento;
    }
    function getIdCuenta() {
        return $this->IdCuenta;
    }

    function getMontoMovimiento() {
        return $this->montoMovimiento;
    }

    function getTipoMovimiento() {
        return $this->tipoMovimiento;
    }

    function getObservaciones() {
        return $this->observaciones;
    }

    function setIdMovimiento($idMovimiento) {
        $this->IdMovimiento = $idMovimiento;
    }

    function setIdCuenta($idCuenta) {
        $this->IdCuenta = $idCuenta;
    }

    function setMontoMovimiento($MontoMovimiento) {
        $this->montoMovimiento = $MontoMovimiento;
    }

    function setTipoMovimiento($TipoMovimiento) {
        $this->tipoMovimiento = $TipoMovimiento;
    }
    function setObservaciones($Observaciones) {
        $this->observaciones = $Observaciones;
    }

    function movimientoAlta() {

        try {

        $pdo = new Conexion();
        $query = $pdo->prepare("INSERT INTO movimientosfinanzas (IdCuenta,
        montoMovimiento, tipoMovimiento, observaciones) VALUES (".$this->getIdCuenta().",
        ".$this->getMontoMovimiento().",
        '".$this->getTipoMovimiento()."',
        '".$this->getObservaciones()."');");
        $query->execute();

           }
        catch(PDOException $e)
        {
            echo $query . "<br>" . $e->getMessage();
        }

        $pdo = null;
    }
    function movimientoModificar() {
        try {

        $pdo = new Conexion();
        $query = $pdo->prepare("SELECT * FROM movimientosfinanzas WHERE IdMovimiento=".$this->getIdMovimiento().";");
        $query->execute();
        $resultado = $query->fetchAll();
        foreach ($resultado as $value) {
            $this ->setIdMovimiento($value['IdMovimiento']);
            $this ->setIdCuenta($value['IdCuenta']);
            $this ->setMontoMovimiento($value['montoMovimiento']);
            $this ->setTipoMovimiento($value['tipoMovimiento']);
            $this ->setObservaciones($value['observaciones']);
        }
        }
        catch(PDOException $e)
        {
            echo $query . "<br>" . $e->getMessage();
        }

        $pdo = null;
    }
    function movimientoModificarGuardar() {
        try {

        $pdo = new Conexion();
        $query = $pdo->prepare("UPDATE movimientosfinanzas"
                . " SET IdCuenta = :IdCuenta,"
                . " montoMovimiento = :montoMovimiento,"
                . " tipoMovimiento = :tipoMovimiento,"
                . " observaciones = :observaciones WHERE IdMovimiento = :IdMovimiento;");
        $query->bindValue(':IdCuenta', $this->getIdCuenta());
        $query->bindValue(':montoMovimiento', $this->getMontoMovimiento());
        $query->bindValue(':tipoMovimiento', $this->getTipoMovimiento());
        $query->bindValue(':observaciones', $this->getObservaciones());
        $query->bindValue(':IdMovimiento', $this->getIdMovimiento());
        $query->execute();
        //$cadena="UPDATE movimientosfinanzas"
        //        . " SET IdCuenta = ".$this->getIdCuenta().","
        //        . " montoMovimiento = ".$this->getMontoMovimiento().","
        //        . " tipoMovimiento = ".$this->getTipoMovimiento().","
        //        . " observaciones = ".$this->getObservaciones().", WHERE IdMovimiento = ".$this->getObservaciones().";";
        //echo $cadena;

        }
        catch(PDOException $e)
        {
            echo $query . "<br>" . $e->getMessage();
        }

        $pdo = null;
    }
    function movimientoConsulta() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT * FROM vs_movimientosFinanzas;');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
          $movimientos[$key] = array(
                $value['IdMovimiento'],
                //$value['IdCuenta'],
                '$ '.number_format($value['montoMovimiento'],2,'.',','),
                $value['tipoMovimiento'],
                $value['observaciones'],
                $value['COG'],
                $value['descripcion'],
                $value['anio'],
                '<a href="movimientoModificar.php?id='.$value['IdCuenta'].'" class="btn btn-default">Modificar</a>'
            );
        }
        return $movimientos;
    }
    function movimientoConsultaApertura($idCuenta) {
        $pdo = new Conexion();
        $query = $pdo->prepare("SELECT montoMovimiento FROM movimientosFinanzas WHERE tipoMovimiento='Apertura' AND IdCuenta= :IdCuenta;");
        $query->bindValue(':IdCuenta', $idCuenta);
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
          $montoApertura=$value['montoMovimiento'];
        }

        return $montoApertura;
    }
    function movimientoConsultaAbonos($idCuenta) {
        $pdo = new Conexion();
        $query = $pdo->prepare("SELECT * FROM movimientosFinanzas WHERE tipoMovimiento='Abono' AND IdCuenta= :IdCuenta;");
        $query->bindValue(':IdCuenta', $idCuenta);
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
          $montoAbonos+=$value['montoMovimiento'];
        }

        return $montoAbonos;
    }
    function movimientoConsultaCargos($idCuenta) {
        $pdo = new Conexion();
        $query = $pdo->prepare("SELECT * FROM movimientosFinanzas WHERE tipoMovimiento='Cargo' AND IdCuenta= :IdCuenta;");
        $query->bindValue(':IdCuenta', $idCuenta);
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
          $montoCargos+=$value['montoMovimiento'];
        }

        return $montoCargos;
    }

    function totales(){
        $pdo = new Conexion();
        //Apertura
        $query = $pdo->prepare("SELECT sum(montoMovimiento) AS  montoMovimiento FROM movimientosFinanzas WHERE IdCuenta>1 AND tipoMovimiento='Apertura';");
        $query->execute();
        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
          $montoApertura+=$value['montoMovimiento'];
        }


        //Abonos
        $query = $pdo->prepare("SELECT sum(monto) as montoPagos FROM relpagocuenta WHERE estatus='Activo' AND IdCuenta>1;");
        $query->execute();
        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
          $montoPagos+=$value['montoPagos'];
        }

       $saldo=$montoApertura-$montoPagos;

       echo '<form class="form-inline">
            <label>Inicial</label>
            <input type="text" class="form-control mb-2 mr-sm-2" id="inlineFormInputName2" value="$ '.number_format($montoApertura,2,'.',',').'" readonly>
            <label>Pagos</label>
            <input type="text" class="form-control mb-2 mr-sm-2" id="inlineFormInputName2" value="$ '.number_format($montoPagos,2,'.',',').'" readonly>
            <label>Saldo</label>
            <input type="text" class="form-control mb-2 mr-sm-2" id="inlineFormInputName2" value="$ '.number_format($saldo,2,'.',',').'" readonly>
            </form>';
    }//fin de totales


}//fin de la clase
