<?php
session_start();
include './loginSecurity.php';

include_once 'conexion.php';
class equipo {

//    Renombrar los titulos
//    NOTA: Los titulos sirven para darle nombre a los titulos de las tablas y los Combobox
    public function __construct() {
        $this->setTitulo1("Info");
        $this->setTitulo2("Equipo");
        $this->setTitulo3("Área");
        $this->setTitulo4("Piso");
        $this->setTitulo5("Edificio");
        $this->setTitulo6("Usuario");
        $this->setTitulo7("Descripción");
        $this->setTitulo8("Marca");
        $this->setTitulo9("Modelo");
        $this->setTitulo10("Núm. Serie");
        $this->setTitulo11("IdUDG");
        $this->setTitulo12("MAC");
        $this->setTitulo13("Tipo Conexión");
        $this->setTitulo14("Detalles");
        $this->setTitulo15("Img Frente");
        $this->setTitulo16("Img Serie");


    }


    private $filtro1;
    private $filtro2;
    private $filtro3;
    private $filtro4;

    private $titulo1;
    private $titulo2;
    private $titulo3;
    private $titulo4;
    private $titulo5;
    private $titulo6;
    private $titulo7;
    private $titulo8;
    private $titulo9;
    private $titulo10;
    private $titulo11;
    private $titulo12;
    private $titulo13;
    private $titulo14;
    private $titulo15;
    private $titulo16;
    private $titulo17;
    private $titulo18;
    private $titulo19;
    private $fecha;
    private $solicitante;
    private $idEquipo;
    private $idArea;
    private $idResguardante;
    private $idUsuario;
    private $comentarios;
    private $descripcion;
    private $marca;
    private $modelo;
    private $numSerie;
    private $idUdg;
    private $mac;
    private $IP;
    private $tipoConexion;
    private $detalles;
    private $verificado;
    private $imgFrente;
    private $imgSerie;
    private $pdfFactura;
    private $estadoEquipo;

    function getFecha() {
        return $this->fecha;
    }
    function getSolicitante() {
        return $this->solicitante;
    }
    function getIdEquipo() {
        return $this->idEquipo;
    }
    function getIdArea() {
        return $this->idArea;
    }
    function getIdResguardante() {
        return $this->idResguardante;
    }
    function getIdUsuario() {
        return $this->idUsuario;
    }
    function getComentarios() {
        return $this->comentarios;
    }

    function getDescripcion() {
        return $this->descripcion;
    }
    function getMarca() {
        return $this->marca;
    }
    function getModelo() {
        return $this->modelo;
    }
    function getNumSerie() {
        return $this->numSerie;
    }
    function getIdUdg() {
        return $this->idUdg;
    }
    function getMac() {
        return $this->mac;
    }
    function getIP() {
        return $this->IP;
    }
    function getTipoConexion() {
        return $this->tipoConexion;
    }
    function getDetalles() {
        return $this->detalles;
    }
    function getVerificado() {
        return $this->verificado;
    }
    function getImgFrente() {
        return $this->imgFrente;
    }
    function getImgSerie() {
        return $this->imgSerie;
    }
    function getPdfFactura() {
        return $this->pdfFactura;
    }
    function getEstadoEquipo() {
        return $this->estadoEquipo;
    }


    function getFiltro1() {
        return $this->filtro1;
    }

    function getFiltro2() {
        return $this->filtro2;
    }

    function getFiltro3() {
        return $this->filtro3;
    }

    function getFiltro4() {
        return $this->filtro4;
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

    function getTitulo10() {
        return $this->titulo10;
    }

    function getTitulo11() {
        return $this->titulo11;
    }

    function getTitulo12() {
        return $this->titulo12;
    }

    function getTitulo13() {
        return $this->titulo13;
    }

    function getTitulo14() {
        return $this->titulo14;
    }

    function getTitulo15() {
        return $this->titulo15;
    }
    function getTitulo16() {
        return $this->titulo16;
    }
    function getTitulo17() {
        return $this->titulo17;
    }
    function getTitulo18() {
        return $this->titulo18;
    }
    function getTitulo19() {
        return $this->titulo19;
    }

    function getidEmpleado() {
        return $this->idEmpleado;
    }
    function setFecha($fecha) {
        $this->fecha = $fecha;
    }
    function setSolicitante($solicitante) {
        $this->solicitante = $solicitante;
    }
    function setIdEquipo($idEquipo) {
        $this->idEquipo = $idEquipo;
    }
    function setIdArea($idArea) {
        $this->idArea = $idArea;
    }
    function setIdResguardante($idResguardante) {
        $this->idResguardante = $idResguardante;
    }
    function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }
    function setComentarios($comentarios) {
        $this->comentarios = $comentarios;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }
    function setMarca($marca) {
        $this->marca = $marca;
    }
    function setModelo($modelo) {
        $this->modelo = $modelo;
    }
    function setNumSerie($numSerie) {
        $this->numSerie = $numSerie;
    }
    function setIdUdg($idUdg) {
        $this->idUdg = $idUdg;
    }
    function setMac($mac) {
        $this->mac = $mac;
    }
    function setIP($IP) {
        $this->IP = $IP;
    }
    function setTipoConexion($tipoConexion) {
        $this->tipoConexion = $tipoConexion;
    }
    function setDetalles($detalles) {
        $this->detalles = $detalles;
    }

    function setVerificado($verificado) {
        $this->verificado = $verificado;
    }
    function setImgFrente($imgFrente) {
        $this->imgFrente = $imgFrente;
    }
    function setImgSerie($imgSerie) {
        $this->imgSerie = $imgSerie;
    }
    function setPdfFactura($pdfFactura) {
        $this->pdfFactura = $pdfFactura;
    }
    function setEstadoEquipo($estadoEquipo) {
        $this->estadoEquipo = $estadoEquipo;
    }

    function setFiltro1($filtro1) {
        $this->filtro1 = $filtro1;
    }

    function setFiltro2($filtro2) {
        $this->filtro2 = $filtro2;
    }

    function setFiltro3($filtro3) {
        $this->filtro3 = $filtro3;
    }

    function setFiltro4($filtro4) {
        $this->filtro4 = $filtro4;
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

    function setTitulo10($titulo10) {
        $this->titulo10 = $titulo10;
    }

    function setTitulo11($titulo11) {
        $this->titulo11 = $titulo11;
    }

    function setTitulo12($titulo12) {
        $this->titulo12 = $titulo12;
    }

    function setTitulo13($titulo13) {
        $this->titulo13 = $titulo13;
    }

    function setTitulo14($titulo14) {
        $this->titulo14 = $titulo14;
    }

    function setTitulo15($titulo15) {
        $this->titulo15 = $titulo15;
    }
    function setTitulo16($titulo16) {
        $this->titulo16 = $titulo16;
    }
    function setTitulo17($titulo17) {
        $this->titulo17 = $titulo17;
    }
    function setTitulo18($titulo18) {
        $this->titulo18 = $titulo18;
    }
    function setTitulo19($titulo19) {
        $this->titulo19 = $titulo19;
    }
    function setidEmpleado($idEmpleado) {
        $this->idEmpleado = $idEmpleado;
    }



    function equipoAlta() {
        try {



        $pdo = new Conexion();
        $query = $pdo->prepare("INSERT INTO equipo(descripcion, marca, modelo, numSerie, idUdg, mac, IP, tipoConexion, detalles, imgFrente, imgSerie, pdfFactura, estadoEquipo)
        VALUES ('".$this->getDescripcion()."',
        '".$this->getMarca()."',
        '".$this->getModelo()."',
        '".$this->getNumSerie()."',
        '".$this->getIdUdg()."',
        '".$this->getMac()."',
        '".$this->getIP()."',
        '".$this->getTipoConexion()."',
        '".$this->getDetalles()."',
        '".$this->getImgFrente()."',
        '".$this->getImgSerie()."',
        '".$this->getPdfFactura()."',
        '".$this->getEstadoEquipo()."');");
        $query->execute();
        $lastId=$pdo->lastInsertId();

        $pdo1 = new Conexion();
        $query1 = $pdo1->prepare("INSERT INTO movimiento_equipo (fechaAsignacion, idSolicitante, comentarios, idEmpleado, idResguardante, idEquipo, idArea)
        VALUES (
        '".$this->getFecha()."',
        ".$this->getIdResguardante().",
        'Asignación',
        ".$this->getIdUsuario().",
        ".$this->getIdResguardante().",
        ".$lastId.",
        ".$this->getIdArea().");");
        $query1->execute();

            echo '<div class="container">'
        . '<br><center><img class="img-responsive" src="../../sige/images/check.png" style="width:15%">'
                    . '<center><br><p class="text-success text-center text-uppercase">'
                    . 'La información se guardó correctamente</p>'
                    . '</div>';
           }
        catch(PDOException $e)
        {
            echo $query . "<br>" . $e->getMessage();
        }

        $pdo = null;
    }
    function movimientoEquipoAlta() {
        try {

        $pdo = new Conexion();
        $query = $pdo->prepare("INSERT INTO movimiento_equipo (fechaAsignacion, idSolicitante, comentarios, idEmpleado, idResguardante, idEquipo, idArea)
        VALUES (
        '".$this->getFecha()."',
        ".$this->getSolicitante().",
        '".$this->getComentarios()."',
        ".$this->getIdUsuario().",
        ".$this->getIdResguardante().",
        ".$this->getIdEquipo().",
        ".$this->getIdArea().");");
        $query->execute();
            echo '<div class="container">'
        . '<br><center><img class="img-responsive" src="../../sige/images/check.png" style="width:15%">'
                    . '<center><br><p class="text-success text-center text-uppercase">'
                    . 'La información se guardó correctamente</p>'
                    . '</div>';
           }
        catch(PDOException $e)
        {
            echo $query . "<br>" . $e->getMessage();
        }

        $pdo = null;
    }
//    Función para agregar los encabezados de las tablas
    function tituloConsulta1()   {
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
                <th>'.$this ->getTitulo10().'</th>
                <th>'.$this ->getTitulo11().'</th>
                <th>'.$this ->getTitulo12().'</th>
                <th>'.$this ->getTitulo13().'</th>
                <th>'.$this ->getTitulo14().'</th>
                <th>'.$this ->getTitulo15().'</th>
                <th>'.$this ->getTitulo16().'</th>';
        if($_SESSION['privilegios'] == 'Administrador' or $_SESSION['privilegios'] == 'Dirección') {
                echo '<th>'.$this ->getTitulo17().'</th>';}
                echo '<th>'.$this ->getTitulo18().'</th>';
                if($_SESSION['privilegios'] == 'Administrador' or $_SESSION['privilegios'] == 'Sistemas') {
                echo '<th>'.$this ->getTitulo19().'</th>

            </tr>';}
    }

//        Esta función muestra los datos de la consulta en la tabla.
//        NOTA: Todas las variables VARCHAR en la base de datos deben de tener en las consultas comparaciones con LIKE y a su vez con =
//        en filtros con ComboBox para su buen funcionamiento.
//        En este caso, la consulta contiene dos variables VARCHAR y se deben realizar las combinaciones posibles con OR.
    function equipoModificar() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT * FROM equipo WHERE idEquipo = '.$this ->getIdEquipo().';');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $value) {

            $this ->setDescripcion($value['descripcion']);

            $this ->setMarca($value['marca']);

            $this ->setModelo($value['modelo']);
            $this ->setNumSerie($value['numSerie']);
            $this ->setIdUdg($value['idUdg']);
            $this ->setMac($value['mac']);
            $this ->setIP($value['IP']);
            $this ->setTipoConexion($value['tipoConexion']);
            $this ->setDetalles($value['detalles']);
            $this ->setVerificado($value['verificado']);
            $this ->setImgFrente($value['imgFrente']);
            $this ->setImgSerie($value['imgSerie']);
            $this ->setPdfFactura($value['pdfFactura']);
            $this ->setEstadoEquipo($value['estadoEquipo']);



        }

    }
 function equipoModificarGuardar() {


        $pdo = new Conexion();
        $query = $pdo->prepare("UPDATE equipo"
                . " SET descripcion = :descripcion,"
                . " marca = :marca,"
                . " modelo = :modelo,"
                . " numSerie = :numSerie,"
                . " idUdg = :idUdg,"
                . " mac = :mac,"
                . " IP = :IP,"
                . " tipoConexion = :tipoConexion,"
                . " detalles = :detalles,"
                . " verificado = :verificado,"
                . " modelo = :modelo,"
                . " imgFrente = :imgFrente,"
                . " imgSerie = :imgSerie,"
                . " pdfFactura = :pdfFactura,"
                . " estadoEquipo = :estadoEquipo WHERE IdEquipo = :IdEquipo;");
        $query->bindValue(':descripcion', $this->getDescripcion());
        $query->bindValue(':marca', $this->getMarca());
        $query->bindValue(':modelo', $this->getModelo());
        $query->bindValue(':numSerie', $this->getNumSerie());
        $query->bindValue(':idUdg', $this->getIdUdg());
        $query->bindValue(':mac', $this->getMac());
        $query->bindValue(':IP', $this->getIP());
        $query->bindValue(':tipoConexion', $this->getTipoConexion());
        $query->bindValue(':detalles', $this->getDetalles());
        $query->bindValue(':verificado', $this->getVerificado());
        $query->bindValue(':imgFrente', $this->getImgFrente());
        $query->bindValue(':imgSerie', $this->getImgSerie());
        $query->bindValue(':pdfFactura', $this->getPdfFactura());
        $query->bindValue(':estadoEquipo', $this->getEstadoEquipo());
        $query->bindValue(':IdEquipo', $this->getIdEquipo());
        $query->execute();





    }
function consultaFiltro($IdResguardante) {
        $pdo = new Conexion();
        if($_SESSION['privilegios']=="Sistemas" OR $_SESSION['privilegios']=="Administrador" OR $_SESSION['privilegios']=="Revisiones"){
            $query = $pdo->prepare("SELECT * FROM vs_equipos WHERE (estadoEquipo='Activo' OR estadoEquipo='Baja');");
        }elseif ($_SESSION['privilegios']=="Director") {
            $query = $pdo->prepare("SELECT * FROM vs_equipos WHERE clasificacionInventario LIKE 'Inventariable -En%' AND (estadoEquipo='Activo' OR estadoEquipo='Baja') AND idResguardante= :idResguardante;");
            $query->bindValue(':idResguardante', $IdResguardante);
        }
        else{
            $query = $pdo->prepare("SELECT * FROM vs_equipos WHERE (estadoEquipo='Activo' OR estadoEquipo='Baja') AND idResguardante= :idResguardante;");
            $query->bindValue(':idResguardante', $IdResguardante);
        }

        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {

            $texto="<a href='detalleEquipo.php?id=".$value['IdEquipo']."' target='_blanck'>";
            switch($value['descripcion']){
                case 'CPU':$texto.="<img src='images/pc_mini.png'>"; break;
                case 'Mouse':$texto.="<img src='images/mouse_mini.png'>"; break;
                case 'Teclado':$texto.="<img src='images/teclado_mini.png'>"; break;
                case 'Regulador':$texto.="<img src='images/regulador_mini.png'>"; break;
                case 'Impresora':$texto.="<img src='images/impresora_mini.png'>"; break;
                case 'Proyector':$texto.="<img src='images/proyector_mini.png'>"; break;
                case 'Monitor':$texto.="<img src='images/monitor_mini.png'>"; break;
                case 'Bocinas':$texto.="<img src='images/bocinas_mini.png'>"; break;
                case 'Teléfono':$texto.="<img src='images/telefono_mini.png'>"; break;
                case 'Reproductor Blu-ray':$texto.="<img src='images/bluray_mini.png'>";break;
                case 'Router':$texto.="<img src='images/router_mini.png'>"; break;
                case 'Servidor NAS':$texto.="<img src='images/nasserver_mini.png'>"; break;
                case 'Lector Inalambrico p/ código de barras':$texto.="<img src='images/lector_mini.png'>"; break;
                case 'Disco Duro Externo':$texto.="<img src='images/discoduroexterno_mini.png'>"; break;
                default:
                    $texto.="<img src='images/info.png'>"; break;
            }


            $texto.="</a>";
            $img=$texto;
            $img=$texto;
            if(($value['imgFrente']!='No Disponible') and ($value['imgFrente']!='No disponible'))  $imgFrente = "<a href='imgEquipos/".$value['imgFrente']."'  target='_blank'>".$value['descripcion']."</a>"; else $imgFrente =$value['descripcion'];
            if(($value['imgSerie']!='No Disponible') and ($value['imgFrente']!='No disponible')) $imgSerie ="<a href='imgEquipos/".$value['imgSerie']."'  target='_blank'>".$value['numSerie']."</a>"; else $imgSerie =$value['numSerie'];
            if($_SESSION['privilegios'] == 'Administrador' or $_SESSION['privilegios'] == 'Dirección') {
            if($value['pdfFactura']!='No disponible') $imgFactura ="<a href='./imgFacturas/".$value['pdfFactura']."'  target='_blank'>Factura</a>"; else $imgFactura =$value['pdfFactura'];}


            if($_SESSION['privilegios'] == 'Administrador' or $_SESSION['privilegios'] == 'Sistemas') {
                $inventariable=$value['clasificacionInventario'];
                $modificar='<a href="equipoModificacion.php?id='.$value['IdEquipo'].'" class="btn btn-default">Modificar</a>';
                $modificarResguardante='<a href="equipoModificacionResguardante.php?id='.$value['IdEquipo'].'" class="btn btn-default">Modificar Resguardante</a>';
            }else {$inventariable="-";}


$equipos[$key] = array(
            $texto,
            "<a href='detalleEquipo.php?id=".$value['IdEquipo']."'  target='_blanck'>".$value['IdEquipo']."</a>",
            $imgFrente,
            $value['idUdg'],
            $value['idArea']."-".$value['area'],
            $value['piso'],
            $value['edificio'],
            $value['nombre'],
            $value['marca'],
            $value['modelo'],
            $imgSerie,

            $value['resguardante'],
            $value['tipoConexion'],
            $value['Detalles'],
            $inventariable,
            $value['mac']

 );
            if($_SESSION['privilegios'] == 'Administrador' or $_SESSION['privilegios'] == 'Direccion') {
                array_push($equipos[$key], $imgFactura);}

            if($_SESSION['privilegios'] == 'Administrador' or $_SESSION['privilegios'] == 'Sistemas') {
                array_push($equipos[$key], $modificar,$modificarResguardante);}
        }
     return $equipos;
    }
function equipoInventariableConsulta() {
        $pdo = new Conexion();

        $query = $pdo->prepare("SELECT * FROM vs_equipos WHERE nombre<>'Ajuste' AND clasificacionInventario like 'Inventariable -En%' AND (estadoEquipo='Activo' OR estadoEquipo='Baja');");


        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {

            $texto="<a href='detalleEquipo.php?id=".$value['IdEquipo']."' target='_blanck'>";
            switch($value['descripcion']){
                case 'CPU':$texto.="<img src='images/pc_mini.png'>"; break;
                case 'Mouse':$texto.="<img src='images/mouse_mini.png'>"; break;
                case 'Teclado':$texto.="<img src='images/teclado_mini.png'>"; break;
                case 'Regulador':$texto.="<img src='images/regulador_mini.png'>"; break;
                case 'Impresora':$texto.="<img src='images/impresora_mini.png'>"; break;
                case 'Proyector':$texto.="<img src='images/proyector_mini.png'>"; break;
                case 'Monitor':$texto.="<img src='images/monitor_mini.png'>"; break;
                case 'Bocinas':$texto.="<img src='images/bocinas_mini.png'>"; break;
                case 'Teléfono':$texto.="<img src='images/telefono_mini.png'>"; break;
                case 'Reproductor Blu-ray':$texto.="<img src='images/bluray_mini.png'>";break;
                case 'Router':$texto.="<img src='images/router_mini.png'>"; break;
                case 'Servidor NAS':$texto.="<img src='images/nasserver_mini.png'>"; break;
                case 'Disco Duro Externo':$texto.="<img src='images/discoduroexterno_mini.png'>"; break;
                case 'Lector Inalambrico p/ código de barras':$texto.="<img src='images/lector_mini.png'>"; break;
                default:
                    $texto.="<img src='images/info.png'>"; break;
            }


            $texto.="</a>";
            $img=$texto;
            if($value['imgFrente']!='No Disponible') $imgFrente = "<a href='imgEquipos/".$value['imgFrente']."'  target='_blank'>".$value['descripcion']."</a>"; else $imgFrente =$value['descripcion'];
            if($value['imgSerie']!='No Disponible') $imgSerie ="<a href='imgEquipos/".$value['imgSerie']."'  target='_blank'>".$value['numSerie']."</a>"; else $imgSerie =$value['numSerie'];
            if($_SESSION['privilegios'] == 'Administrador' or $_SESSION['privilegios'] == 'Dirección') {
            if($value['pdfFactura']!='No disponible') $imgFactura ="<a href='./imgFacturas/".$value['pdfFactura']."'  target='_blank'>Factura</a>"; else $imgFactura =$value['pdfFactura'];}


            if($_SESSION['privilegios'] == 'Administrador' or $_SESSION['privilegios'] == 'Sistemas') {
                $inventariable=$value['clasificacionInventario'];
                $modificar='<a href="equipoModificacion.php?id='.$value['IdEquipo'].'" class="btn btn-default">Modificar</a>';
            }else {$inventariable="-";}


$equipos[$key] = array(
            $texto,
            "<a href='detalleEquipo.php?id=".$value['IdEquipo']."'  target='_blanck'>".$value['IdEquipo']."</a>",
            $imgFrente,
            $value['idUdg'],
            $value['idArea']."-".$value['area'],
            $value['piso'],
            $value['edificio'],
            $value['nombre'],
            $value['marca'],
            $value['modelo'],
            $imgSerie,
            $value['resguardante'],
            $value['Detalles'],
            $inventariable

 );
            if($_SESSION['privilegios'] == 'Administrador' or $_SESSION['privilegios'] == 'Direccion') {
                array_push($equipos[$key], $imgFactura);}

            if($_SESSION['privilegios'] == 'Administrador' or $_SESSION['privilegios'] == 'Sistemas') {
                array_push($equipos[$key], $modificar);}
        }
     return $equipos;
    }

    function consultaFiltroHistorial($IdElemento) {
        $pdo = new Conexion();
        if($IdElemento=='Todos'){
            $query = $pdo->prepare("SELECT * FROM vs_historial_equipos");/* AND
            area LIKE :area AND piso LIKE :piso AND edificio LIKE :edificio AND descripcion LIKE :descripcion
            OR (area = :area  AND piso LIKE :piso AND edificio LIKE :edificio AND descripcion LIKE :descripcion)
            OR (piso = :piso AND area LIKE :area AND edificio LIKE :edificio AND descripcion LIKE :descripcion)
            OR (area = :area  AND piso = :piso AND edificio LIKE :edificio AND descripcion LIKE :descripcion);");
        $query->bindValue(':area', $this->getFiltro1());
        $query->bindValue(':piso', $this->getFiltro2());
        $query->bindValue(':edificio', $this->getFiltro3());
        $query->bindValue(':descripcion', $this->getFiltro4());*/
        }else{
            $query = $pdo->prepare("SELECT * FROM vs_historial_equipos WHERE IdEquipo = :IdEquipo");
            $query->bindValue(':IdEquipo', $IdElemento);
        }

        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {

            $texto="<a href='detalleEquipo.php?id=".$value['IdEquipo']."' target='_blanck'>";
            switch($value['descripcion']){
                case 'CPU':$texto.="<img src='images/pc_mini.png'>"; break;
                case 'Mouse':$texto.="<img src='images/mouse_mini.png'>"; break;
                case 'Teclado':$texto.="<img src='images/teclado_mini.png'>"; break;
                case 'Regulador':$texto.="<img src='images/regulador_mini.png'>"; break;
                case 'Impresora':$texto.="<img src='images/impresora_mini.png'>"; break;
                case 'Proyector':$texto.="<img src='images/proyector_mini.png'>"; break;
                case 'Monitor':$texto.="<img src='images/monitor_mini.png'>"; break;
                case 'Bocinas':$texto.="<img src='images/bocinas_mini.png'>"; break;
                case 'Teléfono':$texto.="<img src='images/telefono_mini.png'>"; break;
                case 'Reproductor Blu-ray':$texto.="<img src='images/bluray_mini.png'>";break;
                case 'Router':$texto.="<img src='images/router_mini.png'>"; break;
                case 'Servidor NAS':$texto.="<img src='images/nasserver_mini.png'>"; break;
                case 'Lector Inalambrico p/ código de barras':$texto.="<img src='images/lector_mini.png'>"; break;
                case 'Disco Duro Externo':$texto.="<img src='images/discoduroexterno_mini.png'>"; break;
                default:
                    $texto.="<img src='images/info.png'>"; break;
            }


            $texto.="</a>";
            $img=$texto;
            $img=$texto;
            if($value['imgFrente']!='No Disponible') $imgFrente = "<a href='imgEquipos/".$value['imgFrente']."'  target='_blank'>Ver Imagen</a>"; else $imgFrente =$value['imgFrente'];
            if($value['imgSerie']!='No Disponible') $imgSerie ="<a href='imgEquipos/".$value['imgSerie']."'  target='_blank'>Ver Imagen</a>"; else $imgSerie =$value['imgSerie'];
            if($_SESSION['privilegios'] == 'Administrador' or $_SESSION['privilegios'] == 'Dirección') {
            if($value['pdfFactura']!='No disponible') $imgFactura ="<a href='./imgFacturas/".$value['pdfFactura']."'  target='_blank'>Factura</a>"; else $imgFactura =$value['pdfFactura'];}

            if($_SESSION['privilegios'] == 'Administrador' or $_SESSION['privilegios'] == 'Sistemas') {
            $modificar='<a href="equipoModificacion.php?id='.$value['IdEquipo'].'" class="btn btn-default">Modificar</a>';}

$equipos[$key] = array(
            $texto,
            "<a href='detalleEquipo.php?id=".$value['IdEquipo']."'  target='_blanck'>".$value['IdEquipo']."</a>",
            $value['idMovimiento'],
            $value['descripcion'],
            $value['area'],
            $value['piso'],

            $value['edificio'],
            $value['nombre'],

            $value['marca'],
            $value['modelo'],

    $value['numSerie'],
            $value['idUdg'],
            $value['mac'],
            $value['tipoConexion'],
            $value['Detalles'],
            $imgFrente,
            $imgSerie,
            $imgFactura,
            $value['idResguardante'],
            $modificar
 );
        }
     return $equipos;
    }
function consultaImpresoras() {
        $pdo = new Conexion();
        $query = $pdo->prepare("SELECT * FROM vs_equipos WHERE descripcion like '%Impresora%' AND idarea<>147");/* AND
            area LIKE :area AND piso LIKE :piso AND edificio LIKE :edificio AND descripcion LIKE :descripcion
            OR (area = :area  AND piso LIKE :piso AND edificio LIKE :edificio AND descripcion LIKE :descripcion)
            OR (piso = :piso AND area LIKE :area AND edificio LIKE :edificio AND descripcion LIKE :descripcion)
            OR (area = :area  AND piso = :piso AND edificio LIKE :edificio AND descripcion LIKE :descripcion);");
        $query->bindValue(':area', $this->getFiltro1());
        $query->bindValue(':piso', $this->getFiltro2());
        $query->bindValue(':edificio', $this->getFiltro3());
        $query->bindValue(':descripcion', $this->getFiltro4());*/
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {

            $texto="<a href='detalleEquipo.php?id=".$value['IdEquipo']."' target='_blanck'>";
            switch($value['descripcion']){
                case 'CPU':$texto.="<img src='images/pc_mini.png'>"; break;
                case 'Mouse':$texto.="<img src='images/mouse_mini.png'>"; break;
                case 'Teclado':$texto.="<img src='images/teclado_mini.png'>"; break;
                case 'Regulador':$texto.="<img src='images/regulador_mini.png'>"; break;
                case 'Impresora':$texto.="<img src='images/impresora_mini.png'>"; break;
                case 'Proyector':$texto.="<img src='images/proyector_mini.png'>"; break;
                case 'Monitor':$texto.="<img src='images/monitor_mini.png'>"; break;
                case 'Bocinas':$texto.="<img src='images/bocinas_mini.png'>"; break;
                case 'Teléfono':$texto.="<img src='images/telefono_mini.png'>"; break;
                case 'Reproductor Blu-ray':$texto.="<img src='images/bluray_mini.png'>";break;
                case 'Router':$texto.="<img src='images/router_mini.png'>"; break;
                case 'Servidor NAS':$texto.="<img src='images/nasserver_mini.png'>"; break;
                case 'Disco Duro Externo':$texto.="<img src='images/discoduroexterno_mini.png'>"; break;
                default:
                    $texto.="<img src='images/info.png'>"; break;
            }


            $texto.="</a>";
            $img=$texto;
            $img=$texto;
            if($value['imgFrente']!='No Disponible') $imgFrente = "<a href='imgEquipos/".$value['imgFrente']."'  target='_blank'>Ver Imagen</a>"; else $imgFrente =$value['imgFrente'];
            if($value['imgSerie']!='No Disponible') $imgSerie ="<a href='imgEquipos/".$value['imgSerie']."'  target='_blank'>Ver Imagen</a>"; else $imgSerie =$value['imgSerie'];
            if($_SESSION['privilegios'] == 'Administrador' or $_SESSION['privilegios'] == 'Dirección') {
            if($value['pdfFactura']!='No disponible') $imgFactura ="<a href='./imgFacturas/".$value['pdfFactura']."'  target='_blank'>Factura</a>"; else $imgFactura =$value['pdfFactura'];}

            if($_SESSION['privilegios'] == 'Administrador' or $_SESSION['privilegios'] == 'Sistemas') {
            $modificar='<a href="equipoModificacion.php?id='.$value['IdEquipo'].'" class="btn btn-default">Modificar</a>';}

$equipos[$key] = array(
            $texto,
            "<a href='detalleEquipo.php?id=".$value['IdEquipo']."'  target='_blanck'>".$value['IdEquipo']."</a>",
            $value['descripcion'],
            $value['area'],
            $value['piso'],

            $value['edificio'],
            $value['nombre'],

            $value['marca'],
            $value['modelo'],

    $value['numSerie'],
            $value['idUdg'],
            $value['mac'],
            $value['tipoConexion'],
            $value['Detalles'],
            $imgFrente,
            $imgSerie,
            $imgFactura,
            $value['idResguardante'],
            $modificar
 );
        }
     return $equipos;
    }

    function listarEquipoUnico() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT * FROM vs_equipos WHERE idEquipo= :idEquipo;');
        $query->bindValue(':idEquipo', $this->getIdEquipo());
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {


            echo '<option value="'.$value['IdEquipo'].'">'.$value['IdEquipo'].' - '.$value['descripcion'].' - '.$value['marca'].' - '.$value['numSerie'].' - '.$value['idUdg'].' - '.$value['area'].' - '.$value['piso'].' - '.$value['edificio'].'</option>';

        }
    }
    function listarEquipos() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT * FROM vs_equipos order by idEquipo asc;');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {


            echo '<option value="'.$value['IdEquipo'].'">'.$value['IdEquipo'].' - '.$value['descripcion'].' - '.$value['marca'].' - '.$value['numSerie'].' - '.$value['idUdg'].' - '.$value['area'].' - '.$value['piso'].' - '.$value['edificio'].'</option>';

        }
    }
    function listarTipoEquipo() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT DISTINCT descripcion FROM equipo order by descripcion asc;');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {


            echo '<option value="'.$value['descripcion'].'">'.$value['descripcion'].'</option>';

        }
    }
    function listarAreas() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT * FROM area order by area asc;');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {


            echo '<option value="'.$value['idArea'].'">'.$value['area'].' - '.$value['idArea'].' - '.$value['piso'].' - '.$value['edificio'].'</option>';

        }
    }
    function listarEmpleado() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT idEmpleado, codigoUDG, nombre FROM empleado WHERE codigoUDG <>0 OR codigoUDG=8 order by nombre asc;');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {


            echo '<option value="'.$value['idEmpleado'].'">'.$value['nombre'].' - '.$value['codigo'].' - '.$value['idEmpleado'].'</option>';

        }
    }
    function listarUsuario() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT idEmpleado, codigoUDG, nombre FROM empleado  order by nombre asc;');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {


            echo '<option value="'.$value['idEmpleado'].'">'.$value['nombre'].' - '.$value['codigo'].' - '.$value['idEmpleado'].'</option>';

        }
    }

//    Esta función muestra los datos de la consulta en cada ComboBox.
//    NOTA: Las variables varchar en los ComboBox se pueden ordenar con ORDER BY
    function comboBoxFiltro()   {
        $pdo = new Conexion();

        $query2 = $pdo->prepare('SELECT distinct area FROM vs_equipos WHERE
            area LIKE :area AND piso LIKE :piso AND edificio LIKE :edificio AND descripcion LIKE :descripcion
            OR (area = :area  AND piso LIKE :piso AND edificio LIKE :edificio AND descripcion LIKE :descripcion)
            OR (piso = :piso AND area LIKE :area AND edificio LIKE :edificio AND descripcion LIKE :descripcion)
            OR (area = :area  AND piso = :piso AND edificio LIKE :edificio AND descripcion LIKE :descripcion)
            ORDER BY area ASC;');
        $query2->bindValue(':area', $this->getFiltro1());
        $query2->bindValue(':piso', $this->getFiltro2());
        $query2->bindValue(':edificio', $this->getFiltro3());
        $query2->bindValue(':descripcion', $this->getFiltro4());
        $query2->execute();
        $resultado2 = $query2->fetchAll();
        $query3 = $pdo->prepare('SELECT distinct piso FROM vs_equipos WHERE
            area LIKE :area AND piso LIKE :piso AND edificio LIKE :edificio AND descripcion LIKE :descripcion
            OR (area = :area  AND piso LIKE :piso AND edificio LIKE :edificio AND descripcion LIKE :descripcion)
            OR (piso = :piso AND area LIKE :area AND edificio LIKE :edificio AND descripcion LIKE :descripcion)
            OR (area = :area  AND piso = :piso AND edificio LIKE :edificio AND descripcion LIKE :descripcion)
            ORDER BY piso ASC;');
        $query3->bindValue(':area', $this->getFiltro1());
        $query3->bindValue(':piso', $this->getFiltro2());
        $query3->bindValue(':edificio', $this->getFiltro3());
        $query3->bindValue(':descripcion', $this->getFiltro4());
        $query3->execute();
        $resultado3 = $query3->fetchAll();
        $query4 = $pdo->prepare('SELECT distinct edificio FROM vs_equipos WHERE
            area LIKE :area AND piso LIKE :piso AND edificio LIKE :edificio AND descripcion LIKE :descripcion
            OR (area = :area  AND piso LIKE :piso AND edificio LIKE :edificio AND descripcion LIKE :descripcion)
            OR (piso = :piso AND area LIKE :area AND edificio LIKE :edificio AND descripcion LIKE :descripcion)
            OR (area = :area  AND piso = :piso AND edificio LIKE :edificio AND descripcion LIKE :descripcion);');
        $query4->bindValue(':area', $this->getFiltro1());
        $query4->bindValue(':piso', $this->getFiltro2());
        $query4->bindValue(':edificio', $this->getFiltro3());
        $query4->bindValue(':descripcion', $this->getFiltro4());
        $query4->execute();
        $resultado4 = $query4->fetchAll();
        $query5 = $pdo->prepare('SELECT distinct descripcion FROM vs_equipos WHERE
            area LIKE :area AND piso LIKE :piso AND edificio LIKE :edificio AND descripcion LIKE :descripcion
            OR (area = :area  AND piso LIKE :piso AND edificio LIKE :edificio AND descripcion LIKE :descripcion)
            OR (piso = :piso AND area LIKE :area AND edificio LIKE :edificio AND descripcion LIKE :descripcion)
            OR (area = :area  AND piso = :piso AND edificio LIKE :edificio AND descripcion LIKE :descripcion)
            ORDER BY descripcion ASC;');
        $query5->bindValue(':area', $this->getFiltro1());
        $query5->bindValue(':piso', $this->getFiltro2());
        $query5->bindValue(':edificio', $this->getFiltro3());
        $query5->bindValue(':descripcion', $this->getFiltro4());
        $query5->execute();
        $resultado5 = $query5->fetchAll();

        echo '<div class="form-group">
                    <label>'. $this->getTitulo3() .':</label>
                    <select class="form-control input-sm" name="filtro1" id="lista1">
                    <option value="%">Buscar '. $this->getTitulo3() .'</option>';
         foreach ($resultado2 as $key => $value) {
            $area = $value['area'];
            echo '<option>'. $area .'</option>';
         }
         echo '</select>
                </div>
                <div class="form-group">
                    <label>'. $this->getTitulo4() .':</label>
                    <select class="form-control input-sm" name="filtro2" id="lista2">
                    <option value="%">Buscar '. $this->getTitulo4() .'</option>';
          foreach ($resultado3 as $key => $value) {
            $piso = $value['piso'];
             echo '<option>'. $piso .'</option>';
         }
         echo '</select>
                </div>
                <div class="form-group">
                    <label>'. $this->getTitulo5() .':</label>
                    <select class="form-control input-sm" name="filtro3" id="lista3">
                    <option value="%">Buscar '. $this->getTitulo5() .'</option>';
         foreach ($resultado4 as $key => $value) {
            $edificio = $value['edificio'];
            echo '<option>'. $edificio .'</option>';
         }
         echo '</select>
                </div>
                <div class="form-group">
                    <label>'. $this->getTitulo7() .':</label>
                    <select class="form-control input-sm" name="filtro4" id="lista4">
                    <option value="%">Buscar '. $this->getTitulo7() .'</option>';
         foreach ($resultado5 as $key => $value) {
            $tipo = $value['descripcion'];
            echo '<option>'. $tipo .'</option>';
         }
         echo '</select>
                </div>';
    }
function datosEquipo()
    {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT * FROM vs_equipos WHERE IdEquipo = :IdEquipo;');
        $query->bindValue(':IdEquipo', $this->getIdEquipo());
        $query->execute();
        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value)
        {

             echo "<div class='row'>";

            echo"<div class='col-xs-6 col-sm-6'><h4 class='titulo'>";

            switch($value['descripcion']){
                case 'CPU':echo "<img src='images/cpu.png'>"; break;
                case 'Mouse':echo "<img src='images/mouse.png'>"; break;
                case 'Teclado':echo "<img src='images/teclado.png'>"; break;
                case 'Regulador':echo "<img src='images/regulador.png'>"; break;
                case 'Impresora':echo "<img src='images/impresora.png'>"; break;
                case 'Proyector':echo "<img src='images/proyector.png'>"; break;
                case 'Monitor':echo "<img src='images/monitor.png'>"; break;
                case 'Bocinas':echo "<img src='images/bocinas.png'>"; break;
                case 'Teléfono':echo "<img src='images/telefono.png'>"; break;
                case 'Reproductor Blu-ray':echo "<img src='images/bluray.png'>"; break;
                case 'Router':echo "<img src='images/router.png'>"; break;
                case 'Servidor NAS':echo "<img src='images/nasserver.png'>"; break;
                case 'Disco Duro Externo':echo "<img src='images/discoduroexterno.png'>"; break;
                case 'Lector Inalambrico p/ código de barras':echo "<img src='images/lector.png'>"; break;
                default:
                    echo "<img src='images/info.png'>"; break;


            }

            echo " ".$value['descripcion'];
             echo "</h4></div>";
             echo"<div class='col-xs-12 col-sm-6'><h4 class='titulo'>Usuario: ".$value['nombre']."</h4></div>";
             echo"<div class='col-xs-12 col-sm-6'><label>&Aacute;rea: </label>".$value['area']."</div>";
             echo"<div class='col-xs-6 col-sm-6'><label>Piso: </label>".$value['piso']."</div>";
             echo"<div class='col-xs-6 col-sm-6'><label>Edificio: </label>".$value['edificio']."</div>";
             echo"<hr>";
             echo "</div>";
             echo"<hr>";

             echo "<div class='row'>";
             echo "<div class='col-xs-6 col-sm-3'><label>Marca : </label>".$value['marca']."</div>";
             echo "<div class='col-xs-6 col-sm-3'><label>Modelo : </label>".$value['modelo']."</div>";
             echo "<div class='col-xs-6 col-sm-3'><label>Núm.Serie : </label>".$value['numSerie']."</div>";
             echo "<div class='col-xs-6 col-sm-3'><label>Id UDG : </label>".$value['idUdg']."</div>";
             echo "</div>";

             echo "<div class='row'>";
             echo "<div class='col-xs-6 col-sm-3'><label>MAC Address : </label>".$value['MAC']."</div>";
             echo "<div class='col-xs-6 col-sm-3'><label>Tipo Conexión : </label>".$value['tipoConexion']."</div>";
             echo "<div class='col-xs-6 col-sm-6'><label>Detalles : </label>".$value['Detalles']."</div>";
             echo "</div>";
             echo"<hr>";
             echo "<div class='row'>";
             if ($value['imgFrente']!="No Disponible") echo "<div class='col-xs-6 col-sm-4'><label>Img Frente : </label><img src='imgEquipos/".$value['imgFrente']."' class='img-responsive'></div>";
             if ($value['imgSerie']!="No Disponible") echo "<div class='col-xs-6 col-sm-4'><label> Img Serie : </label><img src='imgEquipos/".$value['imgSerie']."' class='img-responsive'></div>";
            if($_SESSION['privilegios'] == 'Administrador' or $_SESSION['privilegios'] == 'Dirección') {
            if ($value['pdfFactura']!="No disponible") echo "<div class='col-xs-6 col-sm-4'><label>Img Factura : </label><a href='imgFacturas/".$value['pdfFactura']."' target=\"_blank\">Ver Factura</a></div>";}
             echo "</div>";
             echo '




                 ';
        } //fin del foreach
    }//Fin datos equipo
    function equipoListadoTotales() {
        $pdo = new Conexion();
        $query = $pdo->prepare("SELECT count(*) as cantidadEquipo, descripcion, marca, modelo FROM vs_equipos where estadoEquipo='Activo' group by descripcion, marca, modelo order by descripcion");
        //$query = $pdo->prepare('SELECT count(*) as cantidadMueble, descripcion, piso, edificio FROM vs_muebles group by descripcion, piso order by piso, descripcion');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            for($i=1;$i<=15;$i++){
                switch($i){
                    case 1:$piso="Piso -1"; $edificio="Contemporáneo"; break;
                    case 2:$piso="Planta Baja"; $edificio="Contemporáneo"; break;
                    case 3:$piso="Piso 1"; $edificio="Contemporáneo"; break;
                    case 4:$piso="Piso 2"; $edificio="Contemporáneo"; break;
                    case 5:$piso="Piso 3"; $edificio="Contemporáneo"; break;
                    case 6:$piso="Piso 4"; $edificio="Contemporáneo"; break;
                    case 7:$piso="Piso 5"; $edificio="Contemporáneo"; break;
                    case 8:$piso="Piso 6"; $edificio="Contemporáneo"; break;
                    case 9:$piso="Planta Baja"; $edificio="Histórico"; break;
                    case 10:$piso="Piso 1"; $edificio="Histórico"; break;
                    case 11:$piso="Piso 2"; $edificio="Histórico"; break;
                    case 12:$piso="Piso 3"; $edificio="Histórico"; break;
                    case 13:$piso="Piso 4"; $edificio="Histórico"; break;
                    case 14:$piso="Piso 5"; $edificio="Histórico"; break;
                    case 15:$piso="Piso 6"; $edificio="Histórico"; break;
                }
                //$queryPisos = $pdo->prepare("SELECT count(*) as cantidadEquipoPisos FROM vs_equipos where marca='".$value['marca']."' AND modelo='".$value['modelo']."'AND piso='".$piso."' AND edificio='".$edificio."'");
                //$queryPisos->execute();
                //$resultadoPisos = $queryPisos->fetchAll();
                /*foreach ($resultadoPisos as $keyPisos => $valuePisos) {
                    if($piso=="Piso -1" && $edificio=="Contemporáneo") {if($valuePisos['cantidadEquipoPisos']==0){$P0C="-";}else{$P0C=$valuePisos['cantidadEquipoPisos'];}}
                    if($piso=="Planta Baja" && $edificio=="Contemporáneo") {if($valuePisos['cantidadEquipoPisos']==0){$PBC="-";}else{$PBC=$valuePisos['cantidadEquipoPisos'];}}
                    if($piso=="Piso 1" && $edificio=="Contemporáneo") {if($valuePisos['cantidadEquipoPisos']==0){$P1C="-";}else{$P1C=$valuePisos['cantidadEquipoPisos'];}}
                    if($piso=="Piso 2" && $edificio=="Contemporáneo") {if($valuePisos['cantidadEquipoPisos']==0){$P2C="-";}else{$P2C=$valuePisos['cantidadEquipoPisos'];}}
                    if($piso=="Piso 3" && $edificio=="Contemporáneo") {if($valuePisos['cantidadEquipoPisos']==0){$P3C="-";}else{$P3C=$valuePisos['cantidadEquipoPisos'];}}
                    if($piso=="Piso 4" && $edificio=="Contemporáneo") {if($valuePisos['cantidadEquipoPisos']==0){$P4C="-";}else{$P4C=$valuePisos['cantidadEquipoPisos'];}}
                    if($piso=="Piso 5" && $edificio=="Contemporáneo") {if($valuePisos['cantidadEquipoPisos']==0){$P5C="-";}else{$P5C=$valuePisos['cantidadEquipoPisos'];}}
                    if($piso=="Piso 6" && $edificio=="Contemporáneo") {if($valuePisos['cantidadEquipoPisos']==0){$P6C="-";}else{$P6C=$valuePisos['cantidadEquipoPisos'];}}
                    if($piso=="Planta Baja" && $edificio=="Histórico") {if($valuePisos['cantidadEquipoPisos']==0){$PBH="-";}else{$PBH=$valuePisos['cantidadEquipoPisos'];}}
                    if($piso=="Piso 1" && $edificio=="Histórico") {if($valuePisos['cantidadEquipoPisos']==0){$P1H="-";}else{$P1H=$valuePisos['cantidadEquipoPisos'];}}
                    if($piso=="Piso 2" && $edificio=="Histórico") {if($valuePisos['cantidadEquipoPisos']==0){$P2H="-";}else{$P2H=$valuePisos['cantidadEquipoPisos'];}}
                    if($piso=="Piso 3" && $edificio=="Histórico") {if($valuePisos['cantidadEquipoPisos']==0){$P3H="-";}else{$P3H=$valuePisos['cantidadEquipoPisos'];}}
                    if($piso=="Piso 4" && $edificio=="Histórico") {if($valuePisos['cantidadEquipoPisos']==0){$P4H="-";}else{$P4H=$valuePisos['cantidadEquipoPisos'];}}
                    if($piso=="Piso 5" && $edificio=="Histórico") {if($valuePisos['cantidadEquipoPisos']==0){$P5H="-";}else{$P5H=$valuePisos['cantidadEquipoPisos'];}}
                    if($piso=="Piso 6" && $edificio=="Histórico") {if($valuePisos['cantidadEquipoPisos']==0){$P6H="-";}else{$P6H=$valuePisos['cantidadEquipoPisos'];}}
                }*/
            }
            //if($value['imgFrente']!='No Disponible') $codigoImagen = "<a href='imgMuebles/".$value['imgFrente']."'  target='_blank'>".$value['idCatalogoM']."</a>"; else $codigoImagen =$value['idCatalogoM'];

            $equipoListadoTotales[$key] = array(
              $value['descripcion'],
              $value['marca'],
              $value['modelo'],
              $value['cantidadEquipo']
            );
        }
        return $equipoListadoTotales;
    }

    function ModificarResguardante() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT * FROM vs_equipos  WHERE IdEquipo = '.$this ->getIdEquipo().';');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $value) {
            $this ->setidEmpleado($value['idEmpleado']);
            $this ->setDescripcion($value['descripcion']);
            $this ->setidResguardante($value['idResguardante']);

        }

    }
 function ModificarResguardanteGuardar() {


        $pdo = new Conexion();
         echo $query = $pdo->prepare("UPDATE movimiento_equipo"
                . " setidEmpleado = :idEmpleado,"
                . " idResguardante = :idResguardante WHERE IdEquipo = :IdEquipo;");
        $query->bindValue(':IdEmpleado', $this->getIdEmpleado());
        $query->bindValue(':IdResguardante', $this->getIdResguardante());
        $query->execute();


    }


}
//    Desarrollado por: Carlos Valentín Camacho Veloz
