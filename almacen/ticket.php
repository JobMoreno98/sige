<?php


include_once 'conexion.php';
date_default_timezone_set("America/Mexico_City");
session_start();

class ticket {

    private $IdTicket;
    private $IdEquipo;
    private $IdArea;
    private $IdSolicitante;
    private $IdTecnico;
    private $status;
    private $datosDelReporte;
    private $tomoSolicitud;
    private $fechaReporte;
    private $fechaInicio;
    private $fechaTermino;
    private $solucion;
    private $prioridad;
    private $statusAnterior;
    private $fechaActualizacion;
    //---- Administra los registros de cambio de estado para el conteo de tiempo de vida del ticket
    private $IdEstatusTickets;
    private $estadoTicket;
    private $fechaInicioEstatus;
    private $fechaFin;
    private $diasAcumulados;

    function getIdTicket() {
        return $this->IdTicket;
    }

    function getIdEquipo() {
        return $this->IdEquipo;
    }

    function getIdArea() {
        return $this->IdArea;
    }

    function getIdSolicitante() {
        return $this->IdSolicitante;
    }

    function getIdTecnico() {
        return $this->IdTecnico;
    }

    function getStatus() {
        return $this->status;
    }

    function getDatosDelReporte() {
        return $this->datosDelReporte;
    }

    function getTomoSolicitud() {
        return $this->tomoSolicitud;
    }

    function getFechaReporte() {
        return $this->fechaReporte;
    }

    function getFechaInicio() {
        return $this->fechaInicio;
    }

    function getFechaTermino() {
        return $this->fechaTermino;
    }

    function getSolucion() {
        return $this->solucion;
    }

    function getPrioridad() {
        return $this->prioridad;
    }

    function getStatusAnterior() {
        return $this->statusAnterior;
    }

    function getFechaActualizacion() {
        return $this->fechaActualizacion;
    }

    function getIdEstatusTickets() {
        return $this->IdEstatusTickets;
    }

    function getEstadoTicket() {
        return $this->estadoTicket;
    }

    function getFechaInicioEstatus() {
        return $this->fechaInicioEstatus;
    }

    function getFechaFin() {
        return $this->fechaFin;
    }

    function getDiasAcumulados() {
       return $this->diasAcumulados;
    }

    function setIdTicket($IdTicket) {
        $this->IdTicket = $IdTicket;
    }

    function setIdEquipo($IdEquipo) {
        $this->IdEquipo = $IdEquipo;
    }

    function setIdArea($IdArea) {
        $this->IdArea = $IdArea;
    }

    function setIdSolicitante($IdSolicitante) {
        $this->IdSolicitante = $IdSolicitante;
    }

    function setIdTecnico($IdTecnico) {
        $this->IdTecnico = $IdTecnico;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setDatosDelReporte($datosDelReporte) {
        $this->datosDelReporte = $datosDelReporte;
    }

    function setTomoSolicitud($tomoSolicitud) {
        $this->tomoSolicitud = $tomoSolicitud;
    }

    function setFechaReporte($fechaReporte) {
        $this->fechaReporte = $fechaReporte;
    }

    function setFechaInicio($fechaInicio) {
        $this->fechaInicio = $fechaInicio;
    }

    function setFechaTermino($fechaTermino) {
        $this->fechaTermino = $fechaTermino;
    }

    function setSolucion($solucion) {
        $this->solucion = $solucion;
    }

    function setPrioridad($prioridad) {
        $this->prioridad = $prioridad;
    }

    function setStatusAnterior($statusAnterior) {
        $this->statusAnterior = $statusAnterior;
    }

    function setFechaActualizacion($fechaActualizacion) {
        $this->fechaActualizacion = $fechaActualizacion;
    }

    function setIdEstatusTickets($IdEstatusTickets) {
        $this->IdEstatusTickets = $IdEstatusTickets;
    }

    function setEstadoTicket($estadoTicket) {
        $this->estadoTicket = $estadoTicket;
    }

    function setFechaInicioEstatus($fechaInicioEstatus) {
        $this->fechaInicioEstatus = $fechaInicioEstatus;
    }

    function setFechaFin($fechaFin) {
        $this->fechaFin = $fechaFin;
    }

    function setDiasAcumulados($diasAcumulados) {
        $this->diasAcumulados = $diasAcumulados;
    }

    function ticketAlta() {
        try {

        $pdo = new Conexion();
        $query = $pdo->prepare("INSERT INTO tickets (IdEquipo,
        prioridad, IdArea, IdSolicitante, IdTecnico, Status, DatosDelReporte, TomoSolicitud, FechaReporte, fechaActualizacion) VALUES (".$this->getIdEquipo().",
        '".$this->getPrioridad()."',
        ".$this->getIdArea().",
        ".$this->getIdSolicitante().",
        ".$this->getIdTecnico().",
        '".$this->getStatus()."',
        '".$this->getDatosDelReporte()."',
        '".$this->getTomoSolicitud()."',
        '".$this->getFechaReporte()."','".date('Y-m-d')."');");
        $query->execute();
        $lastId=$pdo->lastInsertId();

        $cadena="INSERCIÓN tabla tickets IdEquipo=".$this->getIdEquipo().", prioridad=".$this->getPrioridad().", IdArea=".$this->getIdArea().", IdSolicitante=".$this->getIdSolicitante().",
        IdTecnico=".$this->getIdTecnico().", Status=".$this->getStatus().", DatosDelReporte=".$this->getDatosDelReporte().", TomoSolicitud=".$this->getTomoSolicitud().", FechaReporte="
        .$this->getFechaReporte().", fechaActualizacion=".date('Y-m-d').".";


        include_once 'log.php';
        $log=new log();
        $log->setFechaHora(date("Y-m-d H:s"));
        $log->setEntidad("tickets");
        $log->setIdElemento($lastId);
        $log->setMovimiento("Insertar");
        $log->setCadena($cadena);
        $log->setUsuario($_SESSION['nombreUsuario']);
        $log->logAlta();

           }
        catch(PDOException $e)
        {
            echo $query . "<br>" . $e->getMessage();
        }

        $pdo = null;
    }

    function ticketAltaEstatus() {
        try {
//echo "usted esta en ticketAltaEstatus";
//echo "INSERT INTO estatusTickets (IdTicket, estadoTicket, fechaInicio, fechaFin, diasAcumulados) VALUES (".$this->getIdTicket().",'".$this->getEstadoTicket()."','".$this->getFechaInicioEstatus()."','".$this->getFechaFin()."',".$this->getDiasAcumulados().");";
        $pdo = new Conexion();
        $query = $pdo->prepare("INSERT INTO estatusTickets (IdTicket, estadoTicket, fechaInicio, fechaFin, diasAcumulados) VALUES (".$this->getIdTicket().",'".$this->getEstadoTicket()."','".$this->getFechaInicioEstatus()."','".$this->getFechaFin()."',".$this->getDiasAcumulados().");");
        $query->execute();


           }
        catch(PDOException $e)
        {
            echo $query . "<br>" . $e->getMessage();
        }

        $pdo = null;
    }

    function ticketModificar() {
        try {

        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT * FROM tickets WHERE IdTicket='.$this->getIdTicket().';');
        $query->execute();
        $resultado = $query->fetchAll();
        foreach ($resultado as $value) {
            $this ->setIdTicket($value['IdTicket']);
            $this ->setIdEquipo($value['IdEquipo']);
            $this ->setPrioridad($value['prioridad']);
            $this ->setIdArea($value['IdArea']);
            $this ->setIdSolicitante($value['IdSolicitante']);
            $this ->setIdTecnico($value['IdTecnico']);
            $this ->setStatus($value['Status']);
            $this ->setDatosDelReporte($value['DatosDelReporte']);
            $this ->setFechaReporte($value['FechaReporte']);
            $this ->setFechaInicio($value['FechaInicio']);
            $this ->setFechaTermino($value['FechaTermino']);
            $this ->setTomoSolicitud($value['TomoSolicitud']);
            $this ->setSolucion($value['Solucion']);
            $this ->setFechaActualizacion($value['fechaActualizacion']);

        }
        }
        catch(PDOException $e)
        {
            echo $query . "<br>" . $e->getMessage();
        }

        $pdo = null;
    }
    function ticketModificarGuardar() {
        try {

        $pdo = new Conexion();
        $strsql2="UPDATE tickets"
                . " SET IdEquipo = :IdEquipo,"
                . " prioridad = :prioridad,"
                . " IdArea = :IdArea,"
                . " IdSolicitante = :IdSolicitante,"
                . " IdTecnico = :IdTecnico,"
                . " Status = :Status,"
                . " DatosDelReporte = :DatosDelReporte,"
                . " TomoSolicitud = :TomoSolicitud,"
                . " FechaReporte = :FechaReporte,"
                . " fechaActualizacion = :fechaActualizacion,";
        if($this->getFechaInicio()!=''){ $strsql2.=" FechaInicio = :FechaInicio,";}
        if($this->getFechaTermino()!=''){ $strsql2.=" FechaTermino = :FechaTermino,";}
        $strsql2.=" solucion = :solucion WHERE IdTicket = :IdTicket;";
        $query = $pdo->prepare($strsql2);

        $query->bindValue(':IdEquipo', $this->getIdEquipo());
        $query->bindValue(':prioridad', $this->getPrioridad());
        $query->bindValue(':IdArea', $this->getIdArea());
        $query->bindValue(':IdSolicitante', $this->getIdSolicitante());
        $query->bindValue(':IdTecnico', $this->getIdTecnico());
        $query->bindValue(':Status', $this->getStatus());
        $query->bindValue(':DatosDelReporte', $this->getDatosDelReporte());
        $query->bindValue(':TomoSolicitud', $this->getTomoSolicitud());
        $query->bindValue(':FechaReporte', $this->getFechaReporte());
        $query->bindValue(':fechaActualizacion', date('Y-m-d'));
        if($this->getFechaInicio()!=''){ $query->bindValue(':FechaInicio', $this->getFechaInicio());}
        if($this->getFechaTermino()!=''){$query->bindValue(':FechaTermino', $this->getFechaTermino());}
        $query->bindValue(':solucion', $this->getSolucion());
        $query->bindValue(':IdTicket', $this->getIdTicket());
        $query->execute();


          $fechaUltimaActualizacion=new DateTime($this->getFechaActualizacion());
          $hoy = new DateTime("now");
          $diff=$fechaUltimaActualizacion->diff($hoy);
          $tiempoAcumuado=$diff->format('%a');
          $this->setFechaInicioEstatus($fechaUltimaActualizacion->format('Y-m-d'));
          $this->setFechaFin($hoy->format('Y-m-d'));
          $this->setDiasAcumulados($tiempoAcumuado);
          if(($this->getStatusAnterior()=='Abierto') && ($this->getStatus()=='Pendiente respuesta del Usuario')){
            $this->setEstadoTicket("Abierto");
            echo "<h3>Se ha puesto en espera el ticket</h3>";
          }
          if(($this->getStatusAnterior()=='Pendiente respuesta del Usuario') && ($this->getStatus()=='Abierto')){
            $this->setEstadoTicket("Pendiente respuesta del Usuario");
            echo "<h3>Se ha quitado de espera el ticket</h3>";
          }
          //echo $tiempoAcumuado;
          $this->ticketAltaEstatus();

//------------------- Registra en el log el cambio realizado
        include_once 'log.php';
        $log=new log();
        $log->setFechaHora(date("Y-m-d H:s"));
        $log->setEntidad("tickets");
        $log->setIdElemento($this->getIdTicket());
        $log->setMovimiento("Modificar");
        $cadena="ACTUALIZACIÓN en tabla tickets IdTicket=".$this->getIdTicket()." Nuevos Valores: IdEquipo=".$this->getIdEquipo().", prioridad =".$this->getPrioridad()
        . ", IdArea =".$this->getIdArea().", IdSolicitante =".$this->getIdSolicitante().", IdTecnico =".$this->getIdTecnico()
        . ", Status =".$this->getStatus().", DatosDelReporte =".$this->getDatosDelReporte().", TomoSolicitud =".$this->getTomoSolicitud()
        . ", FechaReporte =".$this->getFechaReporte().", FechaInicio =".$this->getFechaInicio().",  FechaTermino =".$this->getFechaTermino()
        . ", solucion =".$this->getSolucion();
        $log->setCadena($cadena);
        $log->setUsuario($_SESSION['nombreUsuario']);
        $log->logAlta();



        }
        catch(PDOException $e)
        {
            echo $query . "<br>" . $e->getMessage();
        }

        $pdo = null;
    }
    function ticketConsulta() {
      date_default_timezone_set("America/Mexico_City");
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT * FROM vs_tickets;');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
        $fechaReporte = new DateTime($value['FechaReporte']);

        if(empty($value['FechaInicio'])) $fechaInicio='-';
        else{
            $fechaInicio = new DateTime($value['FechaInicio']);
            $fechaInicio = $fechaInicio->format('d-m-Y');
            }
        if(empty($value['FechaTermino'])) $fechaTermino='-';
        else{
            $fechaTermino = new DateTime($value['FechaTermino']);
            $fechaTermino = $fechaTermino->format('d-m-Y');
            }
            if($value['Status']=='Cerrado'){
              $date2=new DateTime($value['FechaTermino']);
            }else{
              $date2 = new DateTime("now");
            }
            $diff=$fechaReporte->diff($date2);
            $tiempoAcumuado=$diff->format('%a días');
          $tickets[$key] = array(
                $value['IdTicket'],
                '<a href="ticketModificacion.php?id='.$value['IdTicket'].'" class="btn btn-default">Modificar</a>',
                $value['Status'],
                $value['prioridad'],
                $tiempoAcumuado,
                $value['DatosDelReporte'],
                $value['IdEquipo'],
                $value['descripcion'],
                $value['marca'],
                $value['modelo'],
                $value['numSerie'],
                $fechaReporte->format('d-m-Y'),
                $fechaInicio,

                $fechaTermino,

                $value['area'],
                $value['piso'],
                $value['edificio'],
                $value['nombre'],
                $value['Solucion'],
                $value['tecnico']

            );
        }
        return $tickets;
    }

    function ticketMensaje() {
        $pdo = new Conexion();
        $query = $pdo->prepare("SELECT IdTicket, prioridad, datosDelReporte, area, piso, edificio, IdEquipo, descripcion, marca, numSerie, fechaReporte FROM vs_tickets WHERE Status='Abierto' ORDER BY prioridad, IdTicket asc;");
        $query->execute();
        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            $modificar='<a href="ticketModificacion.php?id='.$value['IdTicket'].'" class="btn btn-default">Modificar</a>';
            $fechaReporte = new DateTime($value['FechaReporte']);
            $arregloTicketsMsg[$key] = array(
                $value['IdTicket'],
                $value['prioridad'],
                $fechaReporte->format('d-m-Y'),
                $value['DatosDelReporte'],
                $value['area'],
                $value['piso'],
                $value['edificio'],
                $value['IdEquipo'],
                $value['descripcion'],
                $value['marca'],
                $value['numSerie'],
                $modificar
            );
        }

            return $arregloTicketsMsg;

    }//fin de método ticket mensaje

    function ticketBuscarID(){
      $pdo = new Conexion();
      $query = $pdo->prepare('SELECT * FROM tickets WHERE IdTicket = :IdTicket;');
      $query->bindValue(':IdTicket', $this->getIdTicket());

      $query->execute();

      $resultado = $query->fetchAll();

      if(count($resultado)== 0){
          echo "<div class='row'> ";
          echo "<div class 'col-xs-12 col-sm-12'><h4><center> No se encontró el ticket. </center></h4></div>" ;
          echo "</div>";
      }else{
      foreach ($resultado as $key => $value) {

          echo "<div class='row'>";
           echo"<div class='col-xs-12 col-md-12'>Detalles: ".$value['DatosDelReporte']."</div>";
           echo "<br>";
           echo"<div class='col-xs-12 col-md-4'>Técnico atiende:  ".$value['TomoSolicitud']."</div>";
           echo "<br>";
           echo"<div class='col-xs-12 col-md-4'>Fecha de registro: ".$value['FechaReporte']."</div>";
           echo"<div class='col-xs-12 col-md-4'>Status: ".$value['Status']."</div>";

           if($value['Status'] == "Cerrado" ){
             echo"<div class='col-xs-12 col-md-4'>Fecha Inicio: ".$value['FechaInicio']."</div>";
             echo"<div class='col-xs-12 col-md-4'>Fecha de Cierre: ".$value['FechaTermino']."</div>";
             echo"<div class='col-xs-12 col-md-12'>Solución: ".$value['Solucion']."</div>";
           }else {
             echo "<div class='col-xs-12 col-sm-12'>Datos del Reporte: ".$value['DatosDelReporte']."</div>";
           }


      }
    }
  }//fin del metodo buscar ticket por ID



}//fin de la clase ticket
