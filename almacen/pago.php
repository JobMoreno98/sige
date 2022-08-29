<?php
//originalmente era horarios
include_once 'conexion.php';


class pago {

    private $IdPago;
    private $numDoctoAfin;
    private $tipoTramite;
    private $beneficiario;
    private $concepto;
    private $monto;
    private $noCheque;
    private $estatus;
    private $observaciones;
    private $COG;
    private $anio;
    private $descripcion;
    private $IdCuenta;
    private $IdRelPagoCuenta;
    private $estatusDetalle;



    function getIdPago() {
        return $this->IdPago;
    }
    function getNumDoctoAfin() {
        return $this->numDoctoAfin;
    }
    function getTipoTramite() {
        return $this->tipoTramite;
    }
    function getBeneficiario() {
        return $this->beneficiario;
    }
    function getConcepto() {
        return $this->concepto;
    }
    function getMonto() {
        return $this->monto;
    }
    function getNoCheque() {
        return $this->noCheque;
    }
    function getEstatus() {
        return $this->estatus;
    }
    function getObservaciones() {
        return $this->observaciones;
    }
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
    function getIdRelPagoCuenta() {
        return $this->IdRelPagoCuenta;
    }
    function getEstatusDetalle() {
        return $this->estatusDetalle;
    }
    function setIdPago($idPago) {
        $this->IdPago = $idPago;
    }
    function setNumDoctoAfin($NumDoctoAfin) {
        $this->numDoctoAfin = $NumDoctoAfin;
    }
    function setTipoTramite($TipoTramite) {
        $this->tipoTramite = $TipoTramite;
    }
    function setBeneficiario($Beneficiario) {
        $this->beneficiario = $Beneficiario;
    }
    function setConcepto($Concepto) {
        $this->concepto = $Concepto;
    }
    function setMonto($Monto) {
        $this->monto = $Monto;
    }
    function setNoCheque($NoCheque) {
        $this->noCheque = $NoCheque;
    }
    function setEstatus($Estatus) {
        $this->estatus = $Estatus;
    }
    function setObservaciones($Observaciones) {
        $this->observaciones = $Observaciones;
    }
    function setIdCuenta($idCuenta) {
        $this->IdCuenta= $idCuenta;
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
    function setIdRelPagoCuenta($IdRelPagoCuenta) {
        $this->IdRelPagoCuenta = $IdRelPagoCuenta;
    }
    function setEstatusDetalle($estatusDetalle) {
        $this->estatusDetalle = $estatusDetalle;
    }

        function pagoAlta() {
        try {

        $pdo = new Conexion();
        $query = $pdo->prepare("INSERT INTO pago(numDoctoAfin, tipoTramite, beneficiario, concepto, noCheque, estatus, observaciones) VALUES (".$this->getNumDoctoAfin().",
        '".$this->getTipoTramite()."',
        '".$this->getBeneficiario()."',
        '".$this->getConcepto()."',
        ".$this->getNoCheque().",
        '".$this->getEstatus()."',
        '".$this->getObservaciones()."');");
        $query->execute();
        return $pdo->lastInsertId();
           }
        catch(PDOException $e)
        {
            echo $query . "<br>" . $e->getMessage();
        }

        $pdo = null;
    }
        function cargoPorPagoAlta() {
        try {

        $pdo = new Conexion();
        $query = $pdo->prepare("INSERT INTO relpagocuenta(IdPago, IdCuenta, monto) VALUES (".$this->getIdPago().",
        ".$this->getIdCuenta().",
        ".$this->getMonto().");");
        $query->execute();

           }
        catch(PDOException $e)
        {
            echo $query . "<br>" . $e->getMessage();
        }

        $pdo = null;
    }
    function pagoModificar() {
        try {

        $pdo = new Conexion();
        $query = $pdo->prepare("SELECT * FROM pago WHERE IdPago=".$this->getIdPago().";");
        $query->execute();
        $resultado = $query->fetchAll();
        foreach ($resultado as $value) {
            $this ->setNumDoctoAfin($value['numDoctoAfin']);
            $this ->setTipoTramite($value['tipoTramite']);
            $this ->setBeneficiario($value['beneficiario']);
            $this ->setConcepto($value['concepto']);
            $this ->setNoCheque($value['noCheque']);
            $this ->setEstatus($value['estatus']);
            $this ->setObservaciones($value['observaciones']);
            $this ->setAnio($value['anio']);
            $this ->setCOG($value['COG']);
            $this ->setDescripcion($value['descripcion']);

        }
        }
        catch(PDOException $e)
        {
            echo $query . "<br>" . $e->getMessage();
        }

        $pdo = null;
    }
    function pagoModificarGuardar() {
        try {

        $pdo = new Conexion();
        $query = $pdo->prepare("UPDATE pago"
                . " SET numDoctoAfin = :numDoctoAfin,"
                . " tipoTramite = :tipoTramite,"
                . " beneficiario = :beneficiario,"
                . " concepto = :concepto,"
                . " noCheque = :noCheque,"
                . " observaciones = :observaciones,"
                . " estatus = :estatus WHERE IdPago = :IdPago;");
        $query->bindValue(':numDoctoAfin', $this->getNumDoctoAfin());
        $query->bindValue(':tipoTramite', $this->getTipoTramite());
        $query->bindValue(':beneficiario', $this->getBeneficiario());
        $query->bindValue(':concepto', $this->getConcepto());
        $query->bindValue(':noCheque', $this->getNoCheque());
        $query->bindValue(':observaciones', $this->getObservaciones());
        $query->bindValue(':estatus', $this->getEstatus());
        $query->bindValue(':IdPago', $this->getIdPago());
        $query->execute();

        }
        catch(PDOException $e)
        {
            echo $query . "<br>" . $e->getMessage();
        }

        $pdo = null;
    }
    function pagoConsulta() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT * FROM pago WHERE IdPago>1;');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
        $this->setIdPago($value['IdPago']);

        $monto=$this->sumaMontoPorPagoConsulta(0);

        $monto='$'.number_format($monto,2,'.',',');
        $pagos[$key] = array(
                $value['IdPago'],
                $value['numDoctoAfin'],
                $value['tipoTramite'],
                $value['beneficiario'],
                $value['concepto'],
                '<a href="cargosPorPago.php?pago='.$value['IdPago'].'">'.$monto.'</a>',
                $value['noCheque'],
                $value['estatus'],
                $value['observaciones'],
                '<a href="pagoModificar.php?id='.$value['IdPago'].'" class="btn btn-default">Modificar</a>'
            );
        }
        return $pagos;
    }
function cuentaConsultaPagos() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT * FROM detallepago WHERE estatusDetalle="Activo" AND IdCuenta = :IdCuenta;');
        $query->bindValue(':IdCuenta', $this->getIdCuenta());
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {

        $cuentaConsultaPagos[$key] = array(
            $value['IdPago'],
            $value['COG'],
            $value['descripcion'],
            $value['numDoctoAfin'],
                $value['tipoTramite'],
                $value['beneficiario'],
                $value['concepto'],
                '$'.number_format($value['monto'],2,'.',','),
                $value['noCheque'],
                $value['estatus'],
                $value['observaciones'],
                '<a href="pagoModificar.php?id='.$value['IdPago'].'" class="btn btn-default">Modificar</a>'
            );
        }
        return $cuentaConsultaPagos;
    }
function sumaMontoPorPagoConsulta($IdCuenta) {
        $pdo = new Conexion();
        if($IdCuenta==0){
            $query = $pdo->prepare('SELECT sum(monto) as monto FROM relpagocuenta WHERE estatus="Activo" AND IdPago = :IdPago;');
            $query->bindValue(':IdPago', $this->getIdPago());
        }else{
            $query = $pdo->prepare('SELECT sum(monto) as monto FROM relpagocuenta WHERE estatus="Activo" AND IdCuenta = :IdCuenta;');
            $query->bindValue(':IdCuenta', $IdCuenta);
        }
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            $montoTotal+=$value['monto'];
        }

           return $montoTotal;


}
function listaCargosPorPago() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT * FROM detallePago WHERE estatusDetalle="Activo" AND IdPago = :IdPago;');
        $query->bindValue(':IdPago', $this->getIdPago());
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
        $acum+=acum+$value['monto'];
        $acumulado='$'.number_format($acum,2,'.',',');
        $monto='$'.number_format($value['monto'],2,'.',',');
        $detallePago[$key] = array(
                $value['IdRelPagoCuenta'],
                $value['IdPago'],
                $value['IdCuenta'],
                $value['COG'],
                $value['descripcion'],
                $monto,
                '<a href="cargosPorPagoModificar.php?id='.$value['IdRelPagoCuenta'].'" class="btn btn-default">Modificar</a>',
                $acumulado
            );
        }
        return $detallePago;
}
function detalleCargoPorPagoModificar(){
    try {

        $pdo = new Conexion();
        $query = $pdo->prepare("SELECT * FROM detallepago WHERE estatusDetalle='Activo' AND IdRelPagoCuenta=".$this->getIdRelPagoCuenta().";");
        $query->execute();
        $resultado = $query->fetchAll();
        foreach ($resultado as $value) {
            $this ->setNumDoctoAfin($value['numDoctoAfin']);
            $this ->setTipoTramite($value['tipoTramite']);
            $this ->setBeneficiario($value['beneficiario']);
            $this ->setConcepto($value['concepto']);
            $this ->setNoCheque($value['noCheque']);
            $this ->setEstatus($value['estatus']);
            $this ->setObservaciones($value['observaciones']);
            $this ->setMonto($value['monto']);
            $this ->setCOG($value['COG']);
            $this ->setIdCuenta($value['IdCuenta']);
            $this ->setIdPago($value['IdPago']);
            $this ->setDescripcion($value['descripcion']);
            $this ->setEstatusDetalle($value['estatusDetalle']);

        }
        }
        catch(PDOException $e)
        {
            echo $query . "<br>" . $e->getMessage();
        }

        $pdo = null;
}

function detalleCargoPorPagoModificarGuardar() {
        try {

        $pdo = new Conexion();
        $query = $pdo->prepare("UPDATE relpagocuenta"
                . " SET IdPago = :IdPago,"
                . " IdCuenta = :IdCuenta,"
                . " estatus = :estatus,"
                . " monto = :monto WHERE IdRelPagoCuenta = :IdRelPagoCuenta;");
        $query->bindValue(':IdPago', $this->getIdPago());
        $query->bindValue(':IdCuenta', $this->getIdCuenta());
        $query->bindValue(':monto', $this->getMonto());
        $query->bindValue(':estatus', $this->getEstatusDetalle());
        $query->bindValue(':IdRelPagoCuenta', $this->getIdRelPagoCuenta());
        $query->execute();
        //echo "UPDATE relpagocuenta SET IdPago=".$this->getIdPago().", IdCuenta=".$this->getIdCuenta().", estatus=".$this->getEstatusDetalle().", monto=".$this->getMonto().", IdRelPagoCuenta=".$this->getIdRelPagoCuenta();
        }
        catch(PDOException $e)
        {
            echo $query . "<br>" . $e->getMessage();
        }

        $pdo = null;
    }
function cuentasListado() {
        include_once 'movimiento.php';
        $movimiento=new movimiento();
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT * FROM cuenta WHERE IdCuenta>1;');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            $saldo=$movimiento->movimientoConsultaApertura($value['IdCuenta'])+$movimiento->movimientoConsultaAbonos($value['IdCuenta'])-$movimiento->movimientoConsultaCargos($value['IdCuenta'])-$this->sumaMontoPorPagoConsulta($value['IdCuenta']);
            echo '<option value="'.$value['IdCuenta'].'">'.$value['COG'].'-'.$value['descripcion'].'-'.$value['anio'].' Saldo $ '.$saldo.'</option>';

        }

}//Fin función cuentas listado
function muestraCuentaEspecifica() {
        include_once 'movimiento.php';
        $movimiento=new movimiento();
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT * FROM cuenta WHERE IdCuenta = :IdCuenta;');
        $query->bindValue(':IdCuenta', $this->getIdCuenta());
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            $saldo=$movimiento->movimientoConsultaApertura($value['IdCuenta'])+$movimiento->movimientoConsultaAbonos($value['IdCuenta'])-$movimiento->movimientoConsultaCargos($value['IdCuenta'])-$this->sumaMontoPorPagoConsulta($value['IdCuenta']);
            echo '<option value="'.$value['IdCuenta'].'">'.$value['COG'].'-'.$value['descripcion'].'-'.$value['anio'].' Saldo $ '.$saldo.'</option>';

        }

}//Fin función cuentas listado


}
