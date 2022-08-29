<?php
include 'conexion.php';

class horario {
    private $idHorario;
    private $entradaLunVie;
    private $salidaLunVie;
    private $entradaSabDom;
    private $salidaSabDom;
    private $entradaVacaciones;
    private $salidaVacaciones;
    private $comentarios;
    private $codigo;

    function getIdHorario() {
        return $this->idHorario;
    }

    function getEntradaLunVie() {
        return $this->entradaLunVie;
    }

    function getSalidaLunVie() {
        return $this->salidaLunVie;
    }

    function getEntradaSabDom() {
        return $this->entradaSabDom;
    }

    function getSalidaSabDom() {
        return $this->salidaSabDom;
    }

    function getEntradaVacaciones() {
        return $this->entradaVacaciones;
    }

    function getSalidaVacaciones() {
        return $this->salidaVacaciones;
    }

    function getComentarios() {
        return $this->comentarios;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function setIdHorario($idHorario) {
        $this->idHorario = $idHorario;
    }

    function setEntradaLunVie($entradaLunVie) {
        $this->entradaLunVie = $entradaLunVie;
    }

    function setSalidaLunVie($salidaLunVie) {
        $this->salidaLunVie = $salidaLunVie;
    }

    function setEntradaSabDom($entradaSabDom) {
        $this->entradaSabDom = $entradaSabDom;
    }

    function setSalidaSabDom($salidaSabDom) {
        $this->salidaSabDom = $salidaSabDom;
    }

    function setEntradaVacaciones($entradaVacaciones) {
        $this->entradaVacaciones = $entradaVacaciones;
    }

    function setSalidaVacaciones($salidaVacaciones) {
        $this->salidaVacaciones = $salidaVacaciones;
    }

    function setComentarios($comentarios) {
        $this->comentarios = $comentarios;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

//    function consultaPersonalConHorario() {
//        $pdo = new Conexion();
//        $query = $pdo->prepare('SELECT COUNT(codigo) AS numero FROM HORARIO WHERE codigo = '. $this->getCodigo() .';');
//        $query->execute();
//
//        $resultado = $query->fetchAll();
//        foreach ($resultado as $value) {
//            $numero = $value['numero'];
//        }
//        return $numero;
//    }

    function consultaPersonalSinHorario() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT codigoUDG, nombre FROM empleado WHERE '
                . 'codigoUDG != 0 AND codigoUDG NOT IN (SELECT codigo FROM HORARIO) ORDER BY nombre ASC;');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $value) {
            echo '<option value="'. $value['codigoUDG'] .'">'. $value['nombre'] .'</option>';
        }
    }


    function horarioAlta() {
        try {
        $pdo = new Conexion();
        $query = $pdo->prepare("INSERT INTO horario (entradaLunVie,
        salidaLunVie, entradaSabDom, salidaSabDom,
        entradaVacaciones, salidaVacaciones, comentarios, codigo) VALUES (
        '".$this->getEntradaLunVie()."',
        '".$this->getSalidaLunVie()."',
        '".$this->getEntradaSabDom()."',
        '".$this->getSalidaSabDom()."',
        '".$this->getEntradaVacaciones()."',
        '".$this->getSalidaVacaciones()."',
        '".$this->getComentarios()."',
        ".$this->getCodigo().");");
        $query->execute();
            echo '<div class="container">'
        . '<br><br><center><img class="img-responsive" src="images/check.png" style="width:15%">'
                    . '<br><p class="text-success text-center text-uppercase">'
                    . 'La información se guardó correctamente</p></center>'
                    . '</div>';
           }
        catch(PDOException $e)
        {
            echo $query . "<br>" . $e->getMessage();
        }

        $pdo = null;
    }

    function consultaHorarios() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT h.*, e.nombre FROM horario h JOIN empleado e ON h.codigo = e.codigoUDG;');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
          $conHora[$key] = array(
                $value['codigo'],
                $value['nombre'],
                $value['entradaLunVie'],
                $value['salidaLunVie'],
                $value['entradaSabDom'],
                $value['salidaSabDom'],
                $value['entradaVacaciones'],
                $value['salidaVacaciones'],
                $value['comentarios'],
                '<a href="horarioModificar.php?id='.$value['idHorario'].'" class="btn btn-default">Modificar</a>'
            );
        }
        return $conHora;
    }

    function horarioSeleccionModificar() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT * FROM horario WHERE idHorario = '.$this ->getIdHorario().';');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $value) {
             $conHora = array(
                $value['codigo'],
                $value['entradaLunVie'],
                $value['salidaLunVie'],
                $value['entradaSabDom'],
                $value['salidaSabDom'],
                $value['entradaVacaciones'],
                $value['salidaVacaciones'],
                $value['comentarios']
            );
        }
        return $conHora;
    }

    function horarioModificar() {
        $pdo = new Conexion();
        $query = $pdo->prepare("UPDATE horario"
                . " SET entradaLunVie = :entradaLunVie, salidaLunVie = :salidaLunVie,"
                . " entradaSabDom = :entradaSabDom, salidaSabDom = :salidaSabDom,"
                . " entradaVacaciones = :entradaVacaciones, salidaVacaciones = :salidaVacaciones,"
                . " comentarios = :comentarios WHERE idHorario = :idHorario;");
        $query->bindValue(':entradaLunVie', $this->getEntradaLunVie());
        $query->bindValue(':salidaLunVie', $this->getSalidaLunVie());
        $query->bindValue(':entradaSabDom', $this->getEntradaSabDom());
        $query->bindValue(':salidaSabDom', $this->getSalidaSabDom());
        $query->bindValue(':entradaVacaciones', $this->getEntradaVacaciones());
        $query->bindValue(':salidaVacaciones', $this->getSalidaVacaciones());
        $query->bindValue(':comentarios', $this->getComentarios());
        $query->bindValue(':idHorario', $this->getIdHorario());
        $query->execute();
        echo '<div class="container">'
        . '<br><br><center><img class="img-responsive" src="images/scheck.png" style="width:15%">'
                    . '<br><p class="text-success text-center text-uppercase">'
                    . 'La información se guardó correctamente</p></center>'
                    . '</div>';
    }
}
