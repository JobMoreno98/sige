<?php
//originalmente era horarios
include 'conexion.php';


class factura {

    private $IdFactura;
    private $folioFactura;
    private $IdProveedor;
    private $fechaFactura;
    private $montoFactura;
    private $IdPago;
    private $pdfFactura;



    function getIdFactura() {
        return $this->IdFactura;
    }
    function getFolioFactura() {
        return $this->folioFactura;
    }
    function getIdProveedor() {
        return $this->IdProveedor;
    }
    function getFechaFactura() {
        return $this->fechaFactura;
    }
    function getMontoFactura() {
        return $this->montoFactura;
    }
    function getIdPago() {
        return $this->IdPago;
    }
    function getPdfFactura() {
        return $this->pdfFactura;
    }

    function setIdFactura($idFactura) {
        $this->IdFactura = $idFactura;
    }
    function setFolioFactura($FolioFactura) {
        $this->folioFactura = $FolioFactura;
    }
    function setIdProveedor($idProveedor) {
        $this->IdProveedor = $idProveedor;
    }
    function setFechaFactura($FechaFactura) {
        $this->fechaFactura = $FechaFactura;
    }
    function setMontoFactura($MontoFactura) {
        $this->montoFactura = $MontoFactura;
    }
    function setIdPago($idPago) {
        $this->IdPago = $idPago;
    }
    function setPdfFactura($PdfFactura) {
        $this->pdfFactura = $PdfFactura;
    }


    function facturaAlta() {
        try {
        $cadena="INSERT INTO factura(folioFactura, IdProveedor, fechaFactura, montoFactura, IdPago, pdfFactura) VALUES (".$this->getFolioFactura().",
        ".$this->getIdProveedor().",
        '".$this->getFechaFactura()."',
        ".$this->getMontoFactura().",
        ".$this->getIdPago().",
        '".$this->getPdfFactura()."');";
        echo "cadena ".$cadena;
        $pdo = new Conexion();
        $query = $pdo->prepare("INSERT INTO factura(folioFactura, IdProveedor, fechaFactura, montoFactura, IdPago, pdfFactura) VALUES (".$this->getFolioFactura().",
        ".$this->getIdProveedor().",
        '".$this->getFechaFactura()."',
        ".$this->getMontoFactura().",
        ".$this->getIdPago().",
        '".$this->getPdfFactura()."');");
        $query->execute();

           }
        catch(PDOException $e)
        {
            echo $query . "<br>" . $e->getMessage();
        }

        $pdo = null;
    }
    function facturaModificar() {
        try {

        $pdo = new Conexion();
        $query = $pdo->prepare("SELECT * FROM factura WHERE IdFactura=".$this->getIdFactura().";");
        $query->execute();
        $resultado = $query->fetchAll();
        foreach ($resultado as $value) {
            $this ->setIdFactura($value['IdFactura']);
            $this ->setFolioFactura($value['folioFactura']);
            $this ->setIdProveedor($value['IdProveedor']);
            $this ->setFechaFactura($value['fechaFactura']);
            $this ->setMontoFactura($value['montoFactura']);
            $this ->setIdPago($value['IdPago']);
            $this ->setPdfFactura($value['pdfFactura']);
            }//Fin for each
        }
        catch(PDOException $e)
        {
            echo $query . "<br>" . $e->getMessage();
        }

        $pdo = null;
    }
    function facturaModificarGuardar() {
        try {
        $pdo = new Conexion();
        $query = $pdo->prepare("UPDATE factura"
                . " SET folioFactura = :folioFactura,"
                . " IdProveedor = :IdProveedor,"
                . " fechaFactura = :fechaFactura,"
                . " montoFactura = :montoFactura,"
                . " IdPago = :IdPago WHERE IdFactura = :IdFactura;");
        $query->bindValue(':folioFactura', $this->getFolioFactura());
        $query->bindValue(':IdProveedor', $this->getIdProveedor());
        $query->bindValue(':fechaFactura', $this->getFechaFactura());
        $query->bindValue(':montoFactura', $this->getMontoFactura());
        $query->bindValue(':IdPago', $this->getIdPago());
        $query->bindValue(':IdFactura', $this->getIdFactura());
        $query->execute();

        }
        catch(PDOException $e)
        {
            echo $query . "<br>" . $e->getMessage();
        }

        $pdo = null;
    }
    function facturaConsulta() {


        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT * FROM vs_factura order by fechaFactura desc;');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
        $montoFactura='$'.number_format($value['montoFactura'],2,'.',',');
        $monto='$'.number_format($value['monto'],2,'.',',');

        $facturas[$key] = array(
                $value['IdFactura'],
                $value['folioFactura'],
                $value['fechaFactura'],
                $montoFactura,
                $value['nombreComercial'],
                $value['concepto'],
                $monto,
                $value['COG'],
                $value['numDoctoAfin'],
                 '<a href="facturas/'.$value['pdfFactura'].'" class="btn btn-default">Ver Factura</a>',
                '<a href="facturaModificar.php?id='.$value['IdFactura'].'" class="btn btn-default">Modificar</a>'
            );
        }
        return $facturas;
    }
function cuentasListado() {


        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT * FROM cuenta;');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
        echo '<option value="'.$value['IdCuenta'].'">'.$value['COG'].'-'.$value['descripcion'].'-'.$value['anio'].'</option>';

        }

    }//fin funcion listado de cuentas
function proveedoresListado($IdProveedores) {
        $pdo = new Conexion();
        if($IdProveedores!=0){
            $query = $pdo->prepare('SELECT * FROM proveedor WHERE IdProveedor= :IdProveedor ORDER BY nombreComercial;');
        $query->bindValue(':IdProveedor', $IdProveedores);
        }else{
             $query = $pdo->prepare('SELECT * FROM proveedor ORDER BY nombreComercial;');
        }
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
        echo '<option value="'.$value['idProveedor'].'">'.$value['nombreComercial'].'</option>';

        }

}//fin funcion listado de proveedores
function pagosListado($IdPagos, $anio) {
        $pdo = new Conexion();
        if($IdPagos!=0){
            $query = $pdo->prepare('SELECT * FROM vs_pagocuenta WHERE IdPago= :IdPago AND anio= :anio;');
            $query->bindValue(':IdPago', $IdPagos);
            $query->bindValue(':anio', $anio);
        }
        else{
            $query = $pdo->prepare('SELECT * FROM vs_pagocuenta WHERE anio= :anio;');
            $query->bindValue(':anio', $anio);
        }
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
        echo '<option value="'.$value['IdPago'].'">Doctor. AFIN '.$value['numDoctoAfin'].' - '.$value['concepto'].' - $'.$value['monto'].' - '.' - Cheque '.$value['noCheque'].' - '.' - COG '.$value['COG'].' - Año '.$value['anio'].'</option>';


        }

    }//fin funcion listado de proveedores

}
