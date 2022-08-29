<?php
include_once 'conexion.php';
date_default_timezone_set("America/Mexico_City");
class Log {

  private $IdLog;
  private $fechaHora;
  private $entidad;
  private $IdElemento;
  private $movimiento;
  private $cadena;
  private $usuario;

  function getIdLog() {
    return $this->IdLog;
  }

  function getFechaHora() {
      return $this->fechaHora;
  }

  function getEntidad() {
      return $this->entidad;
  }

  function getIdElemento() {
      return $this->IdElemento;
  }

  function getMovimiento() {
      return $this->movimiento;
  }

  function getCadena() {
      return $this->cadena;
  }

  function getUsuario() {
      return $this->usuario;
  }

  function setIdLog($IdLog) {
      $this->IdLog = $IdLog;
  }

  function setFechaHora($fechaHora) {
      $this->fechaHora = $fechaHora;
  }

  function setEntidad($entidad) {
      $this->entidad = $entidad;
  }

  function setIdElemento($IdElemento) {
      $this->IdElemento = $IdElemento;
  }

  function setUsuario($usuario) {
      $this->usuario = $usuario;
  }
  function setMovimiento($movimiento) {
      $this->movimiento = $movimiento;
  }

  function setCadena($cadena) {
      $this->cadena = $cadena;
  }

  function logAlta() {
      try {

      $pdo = new Conexion();
      $query = $pdo->prepare("INSERT INTO log (fechaHora, entidad, IdElemento, movimiento, cadena, usuario) VALUES ('".$this->getFechaHora()."',
      '".$this->getEntidad()."',
      ".$this->getIdElemento().",
      '".$this->getMovimiento()."',
      '".$this->getCadena()."',
      '".$this->getUsuario()."');");
      $query->execute();

      $otra="INSERT INTO log (fechaHora, entidad, IdElemento, movimiento, cadena, usuario) VALUES ('".$this->getFechaHora()."',
      '".$this->getEntidad()."',
      ".$this->getIdElemento().",
      '".$this->getMovimiento()."',
      '".$this->getCadena()."',
      '".$this->getUsuario()."');";
      //echo $otra;
         }
      catch(PDOException $e)
      {
          echo $query . "<br>" . $e->getMessage();
      }

      $pdo = null;
  }
  function logConsulta() {
    date_default_timezone_set("America/Mexico_City");
      $pdo = new Conexion();
      $query = $pdo->prepare('SELECT * FROM log;');
      $query->execute();

      $resultado = $query->fetchAll();
      foreach ($resultado as $key => $value) {
      $fecha = new DateTime($value['fechaHora']);

      $log[$key] = array(
              $value['IdLog'],
              $fecha->format('d-m-Y'),
              $fecha->format('H:m'),
              $value['entidad'],
              $value['IdElemento'],
              $value['movimiento'],
              $value['usuario'],
              $value['cadena']

          );
      }
      return $log;
  }

}//Fin de la clase
?>
