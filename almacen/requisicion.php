<?php
include 'conexion.php';

class requisicion {

    private $idRequisicion;
    private $tipo;
    private $folio;
    private $fechaRequisicion;
    private $responsableAlmacen;
    private $idEmpleado;
    private $idArea;
    private $idMaterial;
    private $cantidad;
    private $estado;

    private $titulo1;
    private $titulo2;
    private $titulo3;
    private $titulo4;
    private $titulo5;
    private $titulo6;
    private $titulo7;
    private $titulo8;
    private $titulo9;

    function __construct() {
        $this->setTitulo1('IdWeb');
        $this->setTitulo2('Folio');
        $this->setTitulo3('Fecha');
        $this->setTitulo4('Tipo');
        $this->setTitulo5('Responsable');
        $this->setTitulo6('Solicitante');
        $this->setTitulo7('Área');
        $this->setTitulo8('Piso');
        $this->setTitulo9('Edificio');
    }

    function getIdRequisicion() {
        return $this->idRequisicion;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getFolio() {
        return $this->folio;
    }

    function getFechaRequisicion() {
        return $this->fechaRequisicion;
    }

    function getResponsableAlmacen() {
        return $this->responsableAlmacen;
    }

    function getIdEmpleado() {
        return $this->idEmpleado;
    }

    function getIdArea() {
        return $this->idArea;
    }

    function getIdMaterial() {
        return $this->idMaterial;
    }

    function getCantidad() {
        return $this->cantidad;
    }

    function getEstado() {
        return $this->estado;
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

    function getTitulo6() {
        return $this->titulo6;
    }

    function getTitulo7() {
        return $this->titulo7;
    }

    function getTitulo8() {
        return $this->titulo8;
    }

    function getTitulo9() {
        return $this->titulo9;
    }

    function setIdRequisicion($idRequisicion) {
        $this->idRequisicion = $idRequisicion;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setFolio($folio) {
        $this->folio = $folio;
    }

    function setFechaRequisicion($fechaRequisicion) {
        $this->fechaRequisicion = $fechaRequisicion;
    }

    function setResponsableAlmacen($responsableAlmacen) {
        $this->responsableAlmacen = $responsableAlmacen;
    }

    function setIdEmpleado($idEmpleado) {
        $this->idEmpleado = $idEmpleado;
    }

    function setIdArea($idArea) {
        $this->idArea = $idArea;
    }

    function setIdMaterial($idMaterial) {
        $this->idMaterial = $idMaterial;
    }

    function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    function setEstado($estado) {
        $this->estado = $estado;
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

    function setTitulo6($titulo6) {
        $this->titulo6 = $titulo6;
    }

    function setTitulo7($titulo7) {
        $this->titulo7 = $titulo7;
    }

    function setTitulo8($titulo8) {
        $this->titulo8 = $titulo8;
    }

    function setTitulo9($titulo9) {
        $this->titulo9 = $titulo9;
    }



    function consultafolioRequisicion() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT MAX(folio) AS folio FROM requisicion WHERE '
                . 'tipo = "'.$this->getTipo().'";');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            $folio1 = $value['folio']+1;
        }
        return $folio1;
    }
    function consultaIdRequisicion() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT MAX(idRequisicion) AS idRequisicion FROM requisicion');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            $idReq1 = $value['idRequisicion'];
        }
        return $idReq1;
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

    function consultaEmpleadosPapeleria() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT e.idEmpleado, e.nombre, a.area FROM empleado e JOIN area a ON e.idArea = a.idArea WHERE '
                . 'e.codigoUDG != 0 AND e.privilegios != "Colaborador" ORDER BY e.nombre ASC');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            echo '
                <option value="'. $value['idEmpleado'] .'">'. $value['nombre'] .' - '. $value['area'] .'</option>';
        }
    }

    function consultaEmpleadosLimpieza() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT e.idEmpleado, e.nombre, a.area FROM empleado e JOIN area a ON e.idArea = a.idArea WHERE '
                . 'e.codigoUDG != 0 AND e.privilegios = "Administrador" ORDER BY e.nombre ASC');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            echo '
                <option value="'. $value['idEmpleado'] .'">'. $value['nombre'] .' - '. $value['area'] .'</option>';
        }
    }

    function consultaAreaEmpleado() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT a.idArea, a.area FROM area a JOIN empleado e ON a.idArea = e.idArea WHERE '
                . 'e.idEmpleado = '.$_SESSION['idEmpleado']);
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $value) {
            echo '
                <option value="'. $value['idArea'] .'">'. $value['area'] .'</option>';
        }
    }

    function consultaAreasPapeleria() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT idArea, area, piso, edificio FROM area WHERE '
                . 'tipo != "Operaciones" ORDER BY area ASC');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $value) {
            echo '
                <option value="'. $value['idArea'] .'">'. $value['area'] .', '. $value['piso'] .', '. $value['edificio'] .'</option>';
        }
    }

    function consultaAreasLimpieza() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT idArea, area, piso, edificio FROM area WHERE '
                . 'tipo = "Gestión" ORDER BY area ASC');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $value) {
            echo '
                <option value="'. $value['idArea'] .'">'. $value['area'] .' - '. $value['piso'] .' - '. $value['edificio'] .'</option>';
        }
    }

    function consultaMaterialAlmacen() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT idMaterial, descripcion FROM material WHERE '
                . 'tipo = "'.$this->getTipo().'" AND enUso = "Activo"');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            echo '
                <option value="'. $value['idMaterial'] .'">'. $value['descripcion'] .' \ Id: '. $value['idMaterial'] .'</option>';
        }
    }

    function consultaMaterialConExistencia() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT idMaterial, descripcion, existencia FROM material WHERE '
                . 'tipo = "'.$this->getTipo().'" AND enUso = "Activo" AND existencia >= 0 ORDER BY descripcion ASC');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            echo '
                <option value="'. $value['idMaterial'] .'" id="'. $value['existencia'] .'">'
                    . $value['descripcion'] .' \ Id: '. $value['idMaterial'] .' \ Existencia: '. $value['existencia'] .'</option>';
        }
    }

    function requisicionAlta() {
        try {
            $pdo = new Conexion();
            $query = $pdo->prepare("INSERT INTO requisicion (
            idRequisicion,
            fechaRequisicion,
            folio,
            tipo,
            responsableAlmacen,
            idArea,
            idEmpleado) VALUES (
            '".$this->getIdRequisicion()."',
            '".$this->getFechaRequisicion()."',
            ".$this->getFolio().",
            '".$this->getTipo()."',
            '".$this->getResponsableAlmacen()."',
            ".$this->getIdArea().",
            ".$this->getIdEmpleado().");");
            $query->execute();
            echo '<div class="container">'
            . '<br><br><center><img class="img-responsive" src="images/check.png" style="width:15%">'
                        . '<br><p class="text-success text-center text-uppercase">'
                        . 'La información se guardó correctamente</p>'
                        . '<h3><small>Folio Requisición:</small> '.$this->getFolio().'<h3></center>'
                        . '</div>';
        }
        catch(PDOException $e) {
            echo $query . "<br>" . $e->getMessage();
        }
        $pdo = null;
    }

    function requisicionMaterialAlta() {
        try {
            $pdo = new Conexion();
            $query = $pdo->prepare("INSERT INTO salida_material (
            idRequisicion,
            estado,
            idMaterial,
            cantidad) VALUES (
            ".$this->getIdRequisicion().",
            '".$this->getEstado()."',
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

    function titulosRequisicion(){
            echo '<tr>
                <th>'.$this ->getTitulo1().'</th>
                <th>'.$this ->getTitulo2().'</th>
                <th>'.$this ->getTitulo3().'</th>
                <th>'.$this ->getTitulo4().'</th>
                <th>'.$this ->getTitulo5().'</th>
                <th>'.$this ->getTitulo6().'</th>
                <th>'.$this ->getTitulo7().'</th>
                <th>'.$this ->getTitulo8().'</th>
                <th>'.$this ->getTitulo9().'</th>
                <th></th>
                <th></th>
                <th></th>
            </tr>';
    }

    function requisicionConsulta() {

        $pdo = new Conexion();
        //Los select hay que modificar por los campos a usar
        $query = $pdo->prepare('SELECT
            r.*, e.nombre, a.area, a.piso, a.edificio
            FROM requisicion r JOIN empleado e ON r.idEmpleado=e.idEmpleado JOIN area a ON r.idArea = a.idArea
            WHERE r.fechaRequisicion LIKE "%'.$this->getFechaRequisicion().'%"'
                . 'AND r.folio LIKE "'.$this->getFolio().'%" '
                . 'AND r.tipo = "'.$this->getTipo().'" '
                . 'AND r.responsableAlmacen LIKE "%'.$this->getResponsableAlmacen().'%" '
                . 'AND e.nombre LIKE "%'.$this->getIdEmpleado().'%"'
                 . ';');
        $query->execute();
        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            if($_SESSION['privilegios'] == 'Ayudante Almacén')
            {
                $fila='<td><a href="requisicionSurtir.php?id='. $value['idRequisicion'] .'"'
                        . ' class="btn btn-default" role="button">Surtir</a></td>';
            }
            else if ($_SESSION['privilegios'] =='Encargado Almacén' || $_SESSION['privilegios'] == 'Administrador' || $_SESSION['privilegios'] == 'RH-Almacen')
            {
                $fila='<td><a href="requisicionModificar.php?id='. $value['idRequisicion'] .'"'
                        . ' class="btn btn-default" role="button">Modificar/Autorizar</a></td>';
            }
            $arregloReq[$key] = array(
                $value['idRequisicion'],
                $value['folio'],
                $value['fechaRequisicion'],
                $value['tipo'],
                $value['responsableAlmacen'],
                $value['nombre'],
                $value['area'],
                $value['piso'],
                $value['edificio'],
                '<a href="requisicionDetalle.php?id='. $value['idRequisicion'] .'"'
                        . ' class="btn btn-primary" target="_blank" role="button">Ver Detalle</a>',
                '<a href="requisicionEditar.php?id='. $value['idRequisicion'] .'"'
                        . ' class="btn btn-warning" role="button">Editar</a>',
                $fila,
            );
        }
        return $arregloReq;
    }

    function requisicionConsultaPorArea() {

        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT
            r.*, e.nombre, a.area
            FROM requisicion r JOIN empleado e ON r.idEmpleado=e.idEmpleado JOIN area a ON r.idArea = a.idArea
            WHERE a.area = "'. $_SESSION['area'] .'" AND r.tipo = "'.$this->getTipo().'";');
        $query->execute();
        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            $arregloReq[$key] = array(
                $value['idRequisicion'],
                $value['folio'],
                $value['fechaRequisicion'],
                $value['tipo'],
                $value['responsableAlmacen'],
                $value['nombre'],
                $value['area'],
                '<td><a href="requisicionDetalle.php?id='. $value['idRequisicion'] .'" class="btn btn-default" target="_blank" role="button">Ver Detalle</a></td>'
            );
        }
        return $arregloReq;
    }


    function consultaDatosRequisicion() {
//        ejemplo de consulta con arreglo multidimensional
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT r.*, e.nombre, a.area
            FROM requisicion r JOIN empleado e ON r.idEmpleado = e.idEmpleado JOIN area a ON r.idArea = a.idArea WHERE r.idRequisicion = "'. $this->getIdRequisicion() .'";');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            $arregloReq[$key] = array(
                $value['folio'],
                $value['nombre'],
                $value['area'],
                $value['fechaRequisicion'],
                $value['tipo'],
                $value['responsableAlmacen']
            );
        }
        return $arregloReq;
    }

    function consultaResponsableAlmacen() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT idEmpleado, nombre FROM empleado WHERE '
                . 'idEmpleado = '.$_SESSION['idEmpleado']);
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            echo '
                <option>'. $value['nombre'] .'</option>';
        }
    }

    function consultaMaterialRequisicion() {
//        ejemplo de consulta con arreglo multidimensional
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT sm.idMaterial, sm.cantidad, sm.estado, m.descripcion, m.existencia
            FROM salida_material sm JOIN material m ON sm.idMaterial = m.idMaterial WHERE sm.idRequisicion = "'. $this->getIdRequisicion() .'";');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            $arregloMatReq[$key] = array(
                $key+1,
                $value['idMaterial'],
                $value['descripcion'],
                $value['existencia'],
                $value['cantidad'],
                $value['estado']
            );
        }
        if (isset($arregloMatReq)) {
            return $arregloMatReq;
        }
    }

        function requisicionModificar() {
        $pdo = new Conexion();
        $query = $pdo->prepare("UPDATE requisicion"
                . " SET responsableAlmacen = :responsableAlmacen WHERE idRequisicion = :idRequisicion;");
        $query->bindValue(':responsableAlmacen', $this->getResponsableAlmacen());
        $query->bindValue(':idRequisicion', $this->getIdRequisicion());
        $query->execute();
        echo '<div class="container">'
        . '<br><br><center><img class="img-responsive" src="images/check.png" style="width:15%">'
                    . '<br><p class="text-success text-center text-uppercase">'
                    . 'La información se guardó correctamente</p></center>'
                    . '</div>';
    }

    function salidaMaterialModificar() {
        $pdo = new Conexion();
        $query = $pdo->prepare("UPDATE salida_material"
                . " SET cantidad = :cantidad, estado = :estado WHERE idRequisicion = :idRequisicion AND idMaterial = :idMaterial;");
        $query->bindValue(':cantidad', $this->getCantidad());
        $query->bindValue(':estado', $this->getEstado());
        $query->bindValue(':idRequisicion', $this->getIdRequisicion());
        $query->bindValue(':idMaterial', $this->getIdMaterial());
        $query->execute();
    }

    function salidaMaterialSurtir() {
        $pdo = new Conexion();
        $query = $pdo->prepare("UPDATE salida_material"
                . " SET estado = :estado WHERE idRequisicion = :idRequisicion AND idMaterial = :idMaterial;");
        $query->bindValue(':estado', $this->getEstado());
        $query->bindValue(':idRequisicion', $this->getIdRequisicion());
        $query->bindValue(':idMaterial', $this->getIdMaterial());
        $query->execute();
    }

    function consultaEstadoRequisicion() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT estado FROM salida_material WHERE '
                . 'idRequisicion = '. $this->getIdRequisicion() .' AND idMaterial = '. $this->getIdMaterial() .';');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $value) {
            $estad = $value['estado'];
        }
        return $estad;
    }


    function salidaMaterialProcedure() {
        $pdo = new Conexion();
        $query = $pdo->prepare("CALL existenciaEntradas('". $this->getEstado() ."', ". $this->getIdMaterial() .", ". $this->getCantidad() .");");
        $query->execute();
    }

    function validacionInicialExistencia() {
        $pdo = new Conexion();
        $query = $pdo->prepare("CALL validacionInicialExistencia('". $this->getEstado() ."',"
                . " ". $this->getIdMaterial() .", ". $this->getCantidad() .");");
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $value) {
            $resp = $value['respuesta'];
        }
        return $resp;
    }

    function surtirSalidaMaterial() {
        $pdo = new Conexion();
        try {
            $query = $pdo->prepare("CALL surtirSalidaMaterial('". $this->getEstado() ."',"
                . " ". $this->getIdMaterial() .", ". $this->getCantidad() .", ". $this->getIdRequisicion() .");");
            $query->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function eliminarSalidaMaterial() {
        $pdo = new Conexion();
        $query = $pdo->prepare("CALL eliminarSalidaMaterial(:idRequisicion, :idMaterial);");
        $query->bindValue(':idRequisicion', $this->getIdRequisicion());
        $query->bindValue(':idMaterial', $this->getIdMaterial());
        $query->execute();
        $resultado = $query->fetchAll();
        foreach ($resultado as $value) {
            $resp = $value['respuesta'];
        }
        return $resp;
    }

    function eliminarRequisicion() {
        $pdo = new Conexion();
        $query = $pdo->prepare("CALL eliminarRequisicion(:idRequisicion);");
        $query->bindValue(':idRequisicion', $this->getIdRequisicion());
        $query->execute();
        $resultado = $query->fetchAll();
        foreach ($resultado as $value) {
            $resp = $value['respuesta'];
        }
        return $resp;
    }

    function modificarSalidaMaterial() {
        $pdo = new Conexion();
        $query = $pdo->prepare("CALL modificarSalidaMaterial(:idRequisicion, :idMaterial, :cantidad);");
        $query->bindValue(':idRequisicion', $this->getIdRequisicion());
        $query->bindValue(':idMaterial', $this->getIdMaterial());
        $query->bindValue(':cantidad', $this->getCantidad());
        $query->execute();
        $resultado = $query->fetchAll();
        foreach ($resultado as $value) {
            $resp = $value['respuesta'];
        }
        return $resp;
    }

    function insertarSalidaMaterialEntregado() {
        $pdo = new Conexion();
        $query = $pdo->prepare("CALL insertarSalidaMaterialEntregado(:idRequisicion, :idMaterial, :cantidad);");
        $query->bindValue(':idRequisicion', $this->getIdRequisicion());
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
                    '</strong>.<br>Puede que este artículo ya exista en la requisición.</div>';
        }    
    }

    function consultaSalidasPorMaterial(){
       $conn=new Conexion();
       $sql=$conn->prepare('SELECT sm.idRequisicion, r.folio, r.fechaRequisicion, a.area, a.piso, a.edificio, sm.cantidad
FROM salida_material sm JOIN requisicion r ON sm.idRequisicion = r.idRequisicion
JOIN area a ON r.idArea = a.idArea WHERE sm.estado = "Surtido"
AND sm.idMaterial = '. $this->getIdMaterial() .''
               . ' AND r.fechaRequisicion BETWEEN "'.$this->getFechaRequisicion().'" AND "'. $this->getCantidad() .'"'
               . 'AND a.area LIKE "%'.$this->getIdArea().'%";');
       $sql->execute();
       $resultado=$sql->fetchAll();
       foreach ($resultado as $key => $value){
          $arregloSal[$key] = array(
                $value['idRequisicion'],
                $value['folio'],
                $value['fechaRequisicion'],
                $value['area'],
                $value['piso'],
                $value['edificio'],
                $value['cantidad'],
                '<a href="requisicionDetalle.php?id='. $value['idRequisicion'] .'" class="btn btn-default" target="_blank" role="button">Requisición</a>'
            );
        }
        return $arregloSal;
    }


    function consultaDatosMaterial(){
       $conn=new Conexion();
       $sql=$conn->prepare('SELECT * FROM material WHERE idMaterial = '. $this->getIdMaterial() .';');
       $sql->execute();
       $resultado=$sql->fetchAll();
       foreach ($resultado as $value){
          $mater = array(
                $value['descripcion'],
                $value['tipo'],
                $value['stockMinimo'],
                $value['tiempoCaducidad'],
                $value['existencia'],
                $value['nivelExistencia'],
                $value['enUso']
            );
        }
        return $mater;
    }

    function consultaInventarioInicial(){
       $conn=new Conexion();
       $sql=$conn->prepare('SELECT SUM(em.cantidad) AS inicial FROM entrada_material em
JOIN entrega e ON em.idEntrega = e.idEntrega
JOIN compra c ON e.idCompra = c.idCompra
WHERE c.tipoCompra = "Inventario inicial" AND em.idMaterial = '. $this->getIdMaterial() .';');
       $sql->execute();
       $resultado=$sql->fetchAll();
       foreach ($resultado as $value){
          $inicial = $value['inicial'];

        }
        return $inicial;
    }

    function consultaEntradasMaterial(){
       $conn=new Conexion();
       $sql=$conn->prepare('SELECT SUM(em.cantidad) AS entradas FROM entrada_material em
JOIN entrega e ON em.idEntrega = e.idEntrega
JOIN compra c ON e.idCompra = c.idCompra
WHERE c.tipoCompra != "Inventario inicial" AND em.idMaterial = '. $this->getIdMaterial() .';');
       $sql->execute();
       $resultado=$sql->fetchAll();
       foreach ($resultado as $value){
          $entradas = $value['entradas'];

        }
        return $entradas;
    }

    function consultaSalidasMaterial(){
       $conn=new Conexion();
       $sql=$conn->prepare('SELECT SUM(cantidad) AS salidas FROM salida_material
WHERE estado = "Surtido" AND idMaterial = '. $this->getIdMaterial() .';');
       $sql->execute();
       $resultado=$sql->fetchAll();
       foreach ($resultado as $value){
          $salidas = $value['salidas'];

        }
        return $salidas;
    }

    function consultaAreasConRequisicion(){
       $conn=new Conexion();
       $sql=$conn->prepare('SELECT distinct r.idArea, a.area, a.piso, a.edificio
FROM salida_material sm
JOIN requisicion r ON sm.idRequisicion = r.idRequisicion
JOIN material m ON sm.idMaterial = m.idMaterial
JOIN area a ON r.idArea = a.idArea
WHERE sm.estado = "Surtido" AND m.tipo = "'. $this->getTipo() .'";');
       $sql->execute();
       $resultado=$sql->fetchAll();
       foreach ($resultado as $key => $value){
          $areasReq[$key] = array(
                $value['idArea'],
                $value['area'],
                $value['piso'],
                $value['edificio'],
                '<a href="requisicionConsultaAreasDetalle.php?id='. $value['idArea'] .'&tipo='. $this->getTipo() .'" class="btn btn-default" role="button">Entregas</a>'
            );
        }
        return $areasReq;
    }

    function consultaEntregasPorArea(){
       $conn=new Conexion();
       $sql=$conn->prepare('SELECT sm.idRequisicion, r.folio, r.fechaRequisicion, sm.idMaterial, m.descripcion, sm.cantidad
FROM salida_material sm JOIN material m ON sm.idMaterial = m.idMaterial
JOIN requisicion r ON sm.idRequisicion = r.idRequisicion
JOIN area a ON r.idArea = a.idArea
WHERE sm.estado = "Surtido" AND r.idArea = '. $this->getIdArea() .' AND m.tipo = "'. $this->getTipo() .'";');
       $sql->execute();
       $resultado=$sql->fetchAll();
       foreach ($resultado as $key => $value){
          $EntregasArea[$key] = array(
                $value['idRequisicion'],
                $value['folio'],
                $value['fechaRequisicion'],
                $value['idMaterial'],
                $value['descripcion'],
                $value['cantidad'],
                '<a href="requisicionDetalle.php?id='. $value['idRequisicion'] .'" class="btn btn-default" target="_blank" role="button">Requisición</a>'
            );
        }
        return $EntregasArea;
    }

    function consultaDatosArea(){
       $conn=new Conexion();
       $sql=$conn->prepare('SELECT * FROM area WHERE idArea = '. $this->getIdArea() .';');
       $sql->execute();
       $resultado=$sql->fetchAll();
       foreach ($resultado as $value){
          $areaDat = array(
                $value['area'],
                $value['piso'],
                $value['edificio']
            );
        }
        return $areaDat;
    }

        function consultaRequisicionMaterialPDF() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT sm.idMaterial, m.descripcion, sm.cantidad
            FROM salida_material sm
            JOIN material m ON sm.idMaterial = m.idMaterial
            WHERE sm.idRequisicion = '. $this->getIdRequisicion() .';');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            $reqMatPDF[$key] = array(
                $key+1,
                $value['idMaterial'].' - '.$value['descripcion'],
                $value['cantidad']
            );
        }
            return $reqMatPDF;
    }

    function consultaRequisicionPDF() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT r.folio, r.idRequisicion, r.fechaRequisicion, r.tipo, e.nombre, a.area
            FROM requisicion r
            JOIN empleado e ON r.idEmpleado = e.idEmpleado
            JOIN area a ON r.idArea = a.idArea
            WHERE r.idRequisicion = '. $this->getIdRequisicion() .';');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $value) {
            $reqPDF = array(
                $value['tipo'],
                $value['folio'],
                $value['idRequisicion'],
                $value['fechaRequisicion'],
                $value['nombre'],
                $value['area']
            );
        }
            return $reqPDF;
    }

}
