<?php
include 'conexion.php';

class horarioCumplir{

    private $IdHorarioCumplir;
    private $IdEmpleado;
    private $dia;
    private $horaEntrada;
    private $horaSalida;
    private $comentarios;
    private $empleado;

    function getIdHorarioCumplir(){
        return $this->IdHorarioCumplir;
    }

    function getIdEmpleado(){
        return $this->IdEmpleado;
    }

    function getDia(){
        return $this->dia;
    }

    function getHoraEntrada(){
        return $this->horaEntrada;
    }

    function getHoraSalida(){
        return $this->horaSalida;
    }

    function getComentarios(){
        return $this->comentarios;
    }

    function getEmpleado(){
        return $this->empleado;
    }

    function setIdHorarioCumplir($IdHorarioCumplir) {
        $this->IdHorarioCumplir = $IdHorarioCumplir;
    }

    function setIdEmpleado($IdEmpleado) {
        $this->IdEmpleado = $IdEmpleado;
    }

    function setDia($dia) {
        $this->dia = $dia;
    }

    function setHoraEntrada($horaEntrada) {
        $this->horaEntrada = $horaEntrada;
    }

    function setHoraSalida($horaSalida) {
        $this->horaSalida = $horaSalida;
    }

    function setComentarios($comentarios) {
        $this->comentarios = $comentarios;
    }

    function setEmpleado($empleado) {
        $this->empleado = $empleado;
    }

    function consultaPersonalSinHorario() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT idEmpleado, nombre FROM empleado WHERE codigoUDG != 0 AND idEmpleado NOT IN (SELECT IdEmpleado FROM horariocumplir) ORDER BY nombre ASC;');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $value) {
            echo '<option value="'. $value['idEmpleado'] .'">'. $value['nombre'] .' - '.$value['idEmpleado'].'</option>';
        }
    }

    function horarioAlta() {
        try {
            $pdo = new Conexion();
            $query = $pdo->prepare("INSERT INTO horariocumplir (IdEmpleado,
                dia,
                horaEntrada,
                horaSalida,
                comentarios) VALUES (
                ".$this->getIdEmpleado().",
                '".$this->getDia()."',
                '".$this->getHoraEntrada()."',
                '".$this->getHoraSalida()."',
                '".$this->getComentarios()."');");
                $query->execute();

                echo '<div class="container">'
                    . '<br><br><center><img class="img-responsive" src="images/check.png" style="width:15%">'
                    . '<br><p class="text-success text-center text-uppercase">'
                    . 'La información se guardó correctamente</p></center>'
                    . '</div>';
        } catch (PDOException $e) {
            echo $query . "<br>" . $e->getMessage();
        }

        $pdo = null;
    }

    function horarioCumplirConsulta() {
        $pdo = new Conexion();
        $query = $pdo->prepare("SELECT h.IdEmpleado, e.nombre
                                ,GROUP_CONCAT(CASE WHEN dia = 'Lunes'
                                    THEN CONCAT(horaEntrada,' - ',horaSalida) ELSE NULL END) AS lunes
                                ,GROUP_CONCAT(CASE WHEN dia = 'Martes'
                                    THEN CONCAT(horaEntrada,' - ',horaSalida) ELSE NULL END) AS martes
                                ,GROUP_CONCAT(CASE WHEN dia = 'Miércoles'
                                    THEN CONCAT(horaEntrada,' - ',horaSalida) ELSE NULL END) AS miércoles
                                ,GROUP_CONCAT(CASE WHEN dia = 'Jueves'
                                    THEN CONCAT(horaEntrada,' - ',horaSalida) ELSE NULL END) AS jueves
                                ,GROUP_CONCAT(CASE WHEN dia = 'Viernes'
                                    THEN CONCAT(horaEntrada,' - ',horaSalida) ELSE NULL END) AS viernes
                                ,GROUP_CONCAT(CASE WHEN dia = 'Sábado'
                                    THEN CONCAT(horaEntrada,' - ',horaSalida) ELSE NULL END) AS sábado
                                ,GROUP_CONCAT(CASE WHEN dia = 'Domingo'
                                    THEN CONCAT(horaEntrada,' - ',horaSalida) ELSE NULL END) AS domingo
                                ,GROUP_CONCAT(CASE WHEN dia = 'Vacacional'
                                    THEN CONCAT(horaEntrada,' - ',horaSalida) ELSE NULL END) AS vacacional

                                FROM horariocumplir h JOIN empleado e ON h.IdEmpleado = e.idEmpleado
                                GROUP BY h.IdEmpleado;");
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            $modificar='<a href="horarioModificar.php?id='.$value['IdEmpleado'].'" class="btn btn-default">Modificar</a>';
          $cuentas[$key] = array(
                $value['IdEmpleado'],
                $value['nombre'],
                $value['lunes'],
                $value['martes'],
                $value['miércoles'],
                $value['jueves'],
                $value['viernes'],
                $value['sábado'],
                $value['domingo'],
                $value['vacacional']

            );
            if($_SESSION['privilegios'] == 'Administrador' or $_SESSION['privilegios'] == 'RH-Almacen'){
                array_push($cuentas[$key], $modificar);
            }
            $cont = $value;
        }
        return $cuentas;
    }


    function horarioModificar() {
        $pdo = new Conexion();
        $query = $pdo->prepare("SELECT h.horaEntrada,h.horaSalida,h.comentarios,e.nombre FROM horariocumplir h JOIN empleado e ON h.IdEmpleado=e.idEmpleado WHERE h.IdEmpleado=".$this->getIdEmpleado().";");
        $query->execute();
        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            $arregloHorarioMod[$key] = array(
                $value['horaEntrada'],
                $value['horaSalida'],
                $value['comentarios'],
                $value['nombre']
            );
        }
        return $arregloHorarioMod;
    }

    function horarioModificarGuardar(){
      $pdo = new Conexion();
      $query = $pdo->prepare("UPDATE horariocumplir"
              . " SET dia = :dia, horaEntrada = :horaEntrada,"
              . " horaSalida = :horaSalida, comentarios = :comentarios"
              . " WHERE idEmpleado = :idEmpleado ;");
      $query->bindValue(':dia', $this->getDia());
      $query->bindValue(':horaEntrada', $this->getHoraEntrada());
      $query->bindValue(':horaSalida', $this->getHoraSalida());
      $query->bindValue(':comentarios', $this->getComentarios());
      $query->bindValue(':idEmpleado', $this->getIdEmpleado());
      $query->execute();

          echo '<div class="container">'
              . '<br><br><center><img class="img-responsive" src="images/check.png" style="width:15%">'
              . '<br><p class="text-success text-center text-uppercase">'
              . 'La información se guardó correctamente</p></center>'
              . '</div>';
    }

}
