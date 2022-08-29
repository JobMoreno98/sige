<?php
include 'conexion.php';

class periodoVacacional {
    private $idPeriodo;
    private $descripcionPeriodo;
    private $inicioPeriodo;
    private $finPeriodo;

    function getIdPeriodo() {
        return $this->idPeriodo;
    }

    function getDescripcionPeriodo() {
        return $this->descripcionPeriodo;
    }

    function getInicioPeriodo() {
        return $this->inicioPeriodo;
    }

    function getFinPeriodo() {
        return $this->finPeriodo;
    }

    function setIdPeriodo($idPeriodo) {
        $this->idPeriodo = $idPeriodo;
    }

    function setDescripcionPeriodo($descripcionPeriodo) {
        $this->descripcionPeriodo = $descripcionPeriodo;
    }

    function setInicioPeriodo($inicioPeriodo) {
        $this->inicioPeriodo = $inicioPeriodo;
    }

    function setFinPeriodo($finPeriodo) {
        $this->finPeriodo = $finPeriodo;
    }

    function periodoVacacionalAlta() {
        try {
        $pdo = new Conexion();
        $query = $pdo->prepare("INSERT INTO periodo_vacacional (descripcionPeriodo,
        inicioPeriodo,
        finPeriodo) VALUES (
        '".$this->getDescripcionPeriodo()."',
        '".$this->getInicioPeriodo()."',
        '".$this->getFinPeriodo()."');");
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

    function consultaPeriodos() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT idPeriodo, descripcionPeriodo, inicioPeriodo, finPeriodo FROM periodo_vacacional;');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
          $conPeriod[$key] = array(
                $value['idPeriodo'],
                $value['descripcionPeriodo'],
                $value['inicioPeriodo'],
                $value['finPeriodo'],
                '<a href="periodoVacacionalModificar.php?id='.$value['idPeriodo'].'" class="btn btn-default">Modificar</a>'
            );
        }
        return $conPeriod;
    }

    function periodoSeleccionModificar() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT * FROM periodo_vacacional WHERE idPeriodo = '.$this ->getIdPeriodo().';');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $value) {
             $conPeriod = array(
                $value['descripcionPeriodo'],
                $value['inicioPeriodo'],
                $value['finPeriodo']
            );
        }
        return $conPeriod;
    }

    function periodoModificar() {
        $pdo = new Conexion();
        $query = $pdo->prepare("UPDATE periodo_vacacional"
                . " SET descripcionPeriodo = :descripcionPeriodo, inicioPeriodo = :inicioPeriodo,"
                . " finPeriodo = :finPeriodo WHERE idPeriodo = :idPeriodo;");
        $query->bindValue(':descripcionPeriodo', $this->getDescripcionPeriodo());
        $query->bindValue(':inicioPeriodo', $this->getInicioPeriodo());
        $query->bindValue(':finPeriodo', $this->getFinPeriodo());
        $query->bindValue(':idPeriodo', $this->getIdPeriodo());
        $query->execute();
        echo '<div class="container">'
        . '<br><br><center><img class="img-responsive" src="images/check.png" style="width:15%">'
                    . '<br><p class="text-success text-center text-uppercase">'
                    . 'La información se guardó correctamente</p></center>'
                    . '</div>';
    }
}
