<?php
include 'conexion.php';

class compra {

    private $idCompra;
    private $fechaCompra;
    private $tipoCompra;
    private $pdfFactura;
    private $pedidoEspecial;
    private $idEmpleado;
    private $idProveedor;
    private $idMaterial;
    private $cantidad;

    private $idEntrega;
    private $personaEntrega;
    private $fechaCaducidad;


    private $titulo1;
    private $titulo2;
    private $titulo3;
    private $titulo4;
    private $titulo5;
    private $titulo6;

    function __construct() {
        $this->setTitulo1('Folio Compra');
        $this->setTitulo2('Fecha');
        $this->setTitulo3('Tipo');
        $this->setTitulo4('Recibió');
        $this->setTitulo5('Proveedor');
    }

    function getIdCompra() {
        return $this->idCompra;
    }

    function getFechaCompra() {
        return $this->fechaCompra;
    }

    function getTipoCompra() {
        return $this->tipoCompra;
    }

    function getPdfFactura() {
        return $this->pdfFactura;
    }

    function getPedidoEspecial() {
        return $this->pedidoEspecial;
    }

    function getIdEmpleado() {
        return $this->idEmpleado;
    }

    function getIdProveedor() {
        return $this->idProveedor;
    }

    function getIdMaterial() {
        return $this->idMaterial;
    }

    function getCantidad() {
        return $this->cantidad;
    }

    function getIdEntrega() {
        return $this->idEntrega;
    }

    function getPersonaEntrega() {
        return $this->personaEntrega;
    }

    function getFechaCaducidad() {
        return $this->fechaCaducidad;
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

    function setIdCompra($idCompra) {
        $this->idCompra = $idCompra;
    }

    function setFechaCompra($fechaCompra) {
        $this->fechaCompra = $fechaCompra;
    }

    function setTipoCompra($tipoCompra) {
        $this->tipoCompra = $tipoCompra;
    }

    function setPdfFactura($pdfFactura) {
        $this->pdfFactura = $pdfFactura;
    }

    function setPedidoEspecial($pedidoEspecial) {
        $this->pedidoEspecial = $pedidoEspecial;
    }

    function setIdEmpleado($idEmpleado) {
        $this->idEmpleado = $idEmpleado;
    }

    function setIdProveedor($idProveedor) {
        $this->idProveedor = $idProveedor;
    }

    function setIdMaterial($idMaterial) {
        $this->idMaterial = $idMaterial;
    }

    function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    function setIdEntrega($idEntrega) {
        $this->idEntrega = $idEntrega;
    }

    function setPersonaEntrega($personaEntrega) {
        $this->personaEntrega = $personaEntrega;
    }

    function setFechaCaducidad($fechaCaducidad) {
        $this->fechaCaducidad = $fechaCaducidad;
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


    function consultaIdCompra() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT MAX(idCompra) AS idCompra FROM compra;');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            $IdCom1 = $value['idCompra'];
        }
        return $IdCom1;
    }

    function consultaNombreProveedor() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT idProveedor, nombreComercial FROM proveedor WHERE estadoProveedor = "Activo" ORDER BY idProveedor ASC;');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            echo '
                <option value="'. $value['idProveedor'] .'">'. $value['nombreComercial'] .'</option>';
        }
    }

    function consultanombreEmpleado() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT idEmpleado, nombre FROM empleado WHERE '
                . 'idEmpleado = '.$_SESSION['idEmpleado']);
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            echo '
                <option value="'. $value['idEmpleado'] .'">'. $value['nombre'] .'</option>';
        }
    }

    function consultaMaterialAlmacen() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT idMaterial, descripcion FROM material WHERE '
                . 'tipo = "'.$this->getTipoCompra().'" AND enUso = "Activo" Order by descripcion');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            echo '
                <option value="'. $value['idMaterial'] .'">'. $value['descripcion'] .' \ Id: '. $value['idMaterial'] .'</option>';
        }
    }

    function compraAlta() {
        try {
            $pdo = new Conexion();
            $query = $pdo->prepare("INSERT INTO compra (
            idCompra,
            fechaCompra,
            tipoCompra,
            pedidoEspecial,
            idEmpleado,
            idProveedor) VALUES (
            ".$this->getIdCompra().",
            '".$this->getFechaCompra()."',
            '".$this->getTipoCompra()."',
            ".$this->getPedidoEspecial().",
            ".$this->getIdEmpleado().",
            ".$this->getIdProveedor().");");
            $query->execute();
                echo '<div class="container">'
            . '<br><br><center><img class="img-responsive" src="images/check.png" style="width:15%">'
                        . '<br><p class="text-success text-center text-uppercase">'
                        . 'La información se guardó correctamente</p>'
                        . '<h3><small>Folio Compra:</small> '.$this->consultaIdCompra().'<h3></center>'
                        . '</div>';
           }
        catch(PDOException $e)
        {
            echo $query . "<br>" . $e->getMessage();
        }

        $pdo = null;
    }

    function compraMaterialAlta() {
        try {
            $pdo = new Conexion();
            $query = $pdo->prepare("INSERT INTO compra_material (
            idCompra,
            idMaterial,
            cantidad) VALUES (
            ".$this->getIdCompra().",
            ".$this->getIdMaterial().",
            ".$this->getCantidad().");");
            $query->execute();
           }
        catch(PDOException $e)
        {
            echo $query . "<br>error" . $e->getMessage();
        }
        $pdo = null;
    }

    function consultaIdEntrega() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT MAX(idEntrega) AS idEntrega FROM entrega;');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            $IdEn = $value['idEntrega'];
        }
        return $IdEn;
    }

    function primerEntregaAlta() {
        try {
            $pdo = new Conexion();
            $query = $pdo->prepare("INSERT INTO entrega (
            idEntrega,
            fechaEntrega,
            personaEntrega,
            idEmpleado,
            idCompra) VALUES (
            ".$this->getIdEntrega().",
            '".$this->getFechaCompra()."',
            '".$this->getPersonaEntrega()."',
            ".$this->getIdEmpleado().",
            ".$this->getIdCompra().");");
            $query->execute();
           }
        catch(PDOException $e)
        {
            echo $query . "<br>" . $e->getMessage();
        }

        $pdo = null;
    }

    function caducidadAnio($anio){
        $f= date('Y-m-d');
        $fecha= strtotime($anio.' year',strtotime($f));
        $fecha= date('Y-m-d',$fecha);

        return $fecha;
    }

        function entradaMaterialAlta() {
        try {
            $pdo = new Conexion();
            $query = $pdo->prepare("INSERT INTO entrada_material (
            idEntrega,
            idMaterial,
            fechaCaducidad,
            cantidad) VALUES (
            ".$this->getIdEntrega().",
            ".$this->getIdMaterial().",
            '".$this->getFechaCaducidad()."',
            ".$this->getCantidad().");");
            $query->execute();
           }
        catch(PDOException $e)
        {
            echo $query . "<br>error" . $e->getMessage();
        }
        $pdo = null;
    }

    function titulosCompra()   {
        echo '<tr>
            <th>'.$this ->getTitulo1().'</th>
            <th>'.$this ->getTitulo2().'</th>
            <th>'.$this ->getTitulo3().'</th>
            <th>'.$this ->getTitulo4().'</th>
            <th>'.$this ->getTitulo5().'</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>';
    }

    function consultaCompra() {
        $pdo = new Conexion();
        //Los select hay que modificar por los campos a usar
        $query = $pdo->prepare('SELECT c.idCompra, c.fechaCompra, c.tipoCompra, e.nombre, p.nombreComercial
            FROM compra c JOIN empleado e ON c.idEmpleado = e.idEmpleado JOIN proveedor p ON c.idProveedor = p.idProveedor
            WHERE tipoCompra = "'. $this->getTipoCompra() .'";');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            $arregloCom[$key] = array(
                $value['idCompra'],
                $value['fechaCompra'],
                $value['tipoCompra'],
                $value['nombre'],
                $value['nombreComercial'],
                '<a href="compraDetalle.php?id='. $value['idCompra'] .'&t='. $value['tipoCompra'] .'" class="btn btn-primary">Ver Detalle</a>',
                '<a href="compraEditar.php?id='. $value['idCompra'] .'" class="btn btn-warning">Editar</a>',
                '<a href="entregaAlta.php?id='. $value['idCompra'] .'&t='. $value['tipoCompra'] .'" class="btn btn-default">Agregar Entrega</a>'
            );
        }
        return $arregloCom;
    }

    function consultaDetalleCompra() {
        $pdo = new Conexion();
        //Los select hay que modificar por los campos a usar
        $query = $pdo->prepare('SELECT c.idCompra, c.fechaCompra, c.tipoCompra, e.nombre, p.nombreComercial
            FROM compra c JOIN empleado e ON c.idEmpleado = e.idEmpleado JOIN proveedor p ON c.idProveedor = p.idProveedor
            WHERE c.idCompra = "'. $this->getIdCompra() .'";');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            $arregloCom[$key] = array(
                $value['idCompra'],
                $value['fechaCompra'],
                $value['tipoCompra'],
                $value['nombre'],
                $value['nombreComercial']
            );
        }
        return $arregloCom;
    }

    function consultaCompraMaterial() {
        $pdo = new Conexion();
        //Los select hay que modificar por los campos a usar
        $query = $pdo->prepare('SELECT cm.idMaterial, m.descripcion, cm.cantidad, cm.cantidadRecibida, cm.estadoMaterial
            FROM compra_material cm JOIN material m ON cm.idMaterial = m.idMaterial
            WHERE cm.idCompra = '. $this->getIdCompra() .';');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            $arregloCom[$key] = array(
                $value['idMaterial'],
                $value['descripcion'],
                $value['cantidad'],
                $value['cantidadRecibida'],
                $value['estadoMaterial']
            );
        }
        if (isset($arregloCom))
        {
            return $arregloCom;
        }
    }

    function consultaProveedorCompra() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT p.nombreComercial FROM proveedor p JOIN compra c ON p.idProveedor = c.idProveedor WHERE c.idCompra = '. $this->getIdCompra() .';');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            $Prov = $value['nombreComercial'];
        }
        return $Prov;
    }

    function tablaEntradaMaterial() {
                $pdo = new Conexion();
        //Los select hay que modificar por los campos a usar
        $query = $pdo->prepare('SELECT cm.idMaterial, cm.cantidad, cm.cantidadRecibida, m.descripcion
            FROM compra_material cm JOIN material m ON cm.idMaterial = m.idMaterial WHERE cm.idCompra = '. $this->getIdCompra() .';');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            $arregloEntr[$key] = array(
                $value['idMaterial'],
                $value['descripcion'],
                $value['cantidad'],
                $value['cantidadRecibida']
            );
        }
        return $arregloEntr;
    }

    function entregaAlta() {
        try {
            $pdo = new Conexion();
            $query = $pdo->prepare("INSERT INTO entrega (
            idEntrega,
            fechaEntrega,
            personaEntrega,
            idEmpleado,
            idCompra) VALUES (
            ".$this->getIdEntrega().",
            '".$this->getFechaCompra()."',
            '".$this->getPersonaEntrega()."',
            ".$this->getIdEmpleado().",
            ".$this->getIdCompra().");");
            $query->execute();
            echo '<div class="container">'
            . '<br><br><center><img class="img-responsive" src="images/check.png" style="width:15%">'
                        . '<br><p class="text-success text-center text-uppercase">'
                        . 'La información se guardó correctamente</p>'
                        . '<h3><small>Folio Entrega:</small> '.$this->consultaIdEntrega().'<h3></center>'
                        . '</div>';
           }
        catch(PDOException $e)
        {
            echo $query . "<br>" . $e->getMessage();
        }

        $pdo = null;
    }

    function entregaConsulta() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT e.*, em.nombre FROM entrega e JOIN empleado em ON e.idEmpleado = em.idEmpleado WHERE e.idCompra = '. $this->getIdCompra() .' ORDER BY e.idEntrega ASC;');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            $arregloConEntr[$key] = array(
                $key + 1,
                $value['idEntrega'],
                $value['fechaEntrega'],
                $value['personaEntrega'],
                $value['nombre']
            );
        }
        if (isset($arregloConEntr))
        {
            return $arregloConEntr;
        }
    }

        function consultaDatosEntrega() {
//        ejemplo de consulta con arreglo multidimensional
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT en.*, e.nombre
            FROM entrega en JOIN empleado e ON en.idEmpleado = e.idEmpleado WHERE en.idEntrega = "'. $this->getIdEntrega() .'";');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            $arregloEntr[$key] = array(
                $value['fechaEntrega'],
                $value['personaEntrega'],
                $value['nombre']
            );
        }
        return $arregloEntr;
    }

    function consultaEntradaMaterial() {

        $pdo = new Conexion();
        //Los select hay que modificar por los campos a usar
        $query = $pdo->prepare('SELECT em.*, m.descripcion
            FROM entrada_material em JOIN material m ON em.idMaterial = m.idMaterial
            WHERE em.idEntrega = "'. $this->getIdEntrega() .'";');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            $arregloEntr[$key] = array(
                $value['idMaterial'],
                $value['descripcion'],
                $value['fechaCaducidad'],
                $value['cantidad']
            );
        }
        if (isset($arregloEntr)) {
            return $arregloEntr;
        } 
    }
    
    function consultaCompraMaterialSinSurtir() {

        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT cm.idMaterial, m.descripcion, cm.cantidad, cm.cantidadRecibida
            FROM compra_material cm JOIN material m ON cm.idMaterial = m.idMaterial
            WHERE cm.idCompra = '. $this->getIdCompra() .' AND estadoMaterial != "Recibido";');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            $arregloCom[$key] = array(
                $value['idMaterial'],
                $value['descripcion'],
                $value['cantidad'],
                $value['cantidadRecibida']
            );
        }
        if (isset($arregloCom)) {
            return $arregloCom;
        } 
    }    
    
    function modificarCompraMaterial() {
        $pdo = new Conexion();
        $query = $pdo->prepare("CALL modificarCompraMaterial(:idCompra, :idMaterial, :cantidad);");
        $query->bindValue(':idCompra', $this->getIdCompra());
        $query->bindValue(':idMaterial', $this->getIdMaterial());
        $query->bindValue(':cantidad', $this->getCantidad());
        $query->execute();
        $resultado = $query->fetchAll();
        foreach ($resultado as $value) {
            $resp = $value['respuesta'];
        }
        return $resp;
    }
    
    function eliminarCompraMaterial() {
        $pdo = new Conexion();
        $query = $pdo->prepare("CALL eliminarCompraMaterial(:idCompra, :idMaterial);");
        $query->bindValue(':idCompra', $this->getIdCompra());
        $query->bindValue(':idMaterial', $this->getIdMaterial());
        $query->execute();
        $resultado = $query->fetchAll();
        foreach ($resultado as $value) {
            $resp = $value['respuesta'];
        }
        return $resp;
    }    
    
    function insertarCompraMaterial() {
        $pdo = new Conexion();
        $query = $pdo->prepare("CALL insertarCompraMaterial(:idCompra, :idMaterial, :cantidad);");
        $query->bindValue(':idCompra', $this->getIdCompra());
        $query->bindValue(':idMaterial', $this->getIdMaterial());
        $query->bindValue(':cantidad', $this->getCantidad());
        $query->execute();
        $resultado = $query->fetchAll();
        foreach ($resultado as $value) {
            $resp = $value['respuesta'];
        }
        if (isset($resp)) {
            return $resp;
        } else {
            return '<div class="alert alert-danger">'
            . 'Ocurrió un problema al ingresar el artículo con ID: <strong>'.$this->getIdMaterial().
                    '</strong>.<br>Puede que este artículo ya exista en la compra.</div>';
        }
    }
        
    function eliminarCompra() {
        $pdo = new Conexion();
        $query = $pdo->prepare("CALL eliminarCompra(:idCompra);");
        $query->bindValue(':idCompra', $this->getIdCompra());
        $query->execute();
        $resultado = $query->fetchAll();
        foreach ($resultado as $value) {
            $resp = $value['respuesta'];
        }
        return $resp;
    } 
        
    function modificarEntradaMaterial() {
        $pdo = new Conexion();
        $query = $pdo->prepare("CALL modificarEntradaMaterial(:idEntrega, :idMaterial, :cantidad);");
        $query->bindValue(':idEntrega', $this->getIdEntrega());
        $query->bindValue(':idMaterial', $this->getIdMaterial());
        $query->bindValue(':cantidad', $this->getCantidad());
        $query->execute();
        $resultado = $query->fetchAll();
        foreach ($resultado as $value) {
            $resp = $value['respuesta'];
        }
        return $resp;
    }
        
    function eliminarEntradaMaterial() {
        $pdo = new Conexion();
        $query = $pdo->prepare("CALL eliminarEntradaMaterial(:idMaterial, :idEntrega);");
        $query->bindValue(':idMaterial', $this->getIdMaterial());
        $query->bindValue(':idEntrega', $this->getIdEntrega());
        $query->execute();
        $resultado = $query->fetchAll();
        foreach ($resultado as $value) {
            $resp = $value['respuesta'];
        }
        return $resp;
    }    
            
    function eliminarEntrega() {
        $pdo = new Conexion();
        $query = $pdo->prepare("CALL eliminarEntrega(:idEntrega);");
        $query->bindValue(':idEntrega', $this->getIdEntrega());
        $query->execute();
        $resultado = $query->fetchAll();
        foreach ($resultado as $value) {
            $resp = $value['respuesta'];
        }
        return $resp;
    } 
        
    function insertarEntradaMaterial() {
        $pdo = new Conexion();
        $query = $pdo->prepare("CALL insertarEntradaMaterial(:idEntrega, :idMaterial, :fechaCaducidad, :cantidad);");
        $query->bindValue(':idEntrega', $this->getIdEntrega());
        $query->bindValue(':idMaterial', $this->getIdMaterial());
        $query->bindValue(':fechaCaducidad', $this->getFechaCaducidad());
        $query->bindValue(':cantidad', $this->getCantidad());
        $query->execute();
        $resultado = $query->fetchAll();
        foreach ($resultado as $value) {
            $resp = $value['respuesta'];
        }
        if (isset($resp)) {
            return $resp;
        } else {
            return '<div class="alert alert-danger">'
            . 'Ocurrió un problema al ingresar el artículo con ID: <strong>'.$this->getIdMaterial().
                    '</strong>.<br>Puede que este artículo ya exista en la entrega.</div>';
        }
    }
}
