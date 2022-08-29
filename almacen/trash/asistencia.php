<?php
include 'conexion.php';
include 'conexion2.php';

class asistencia{
    
    private $codigo;
    private $semana;
    private $mes;
    private $fecha;
            
    function getCodigo() {
        return $this->codigo;
    }

    function getSemana() {
        return $this->semana;
    }

    function getMes() {
        return $this->mes;
    }

    function getFecha() {
        return $this->fecha;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setSemana($semana) {
        $this->semana = $semana;
    }

    function setMes($mes) {
        $this->mes = $mes;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

                    
    function consultaEmpleadoPorCodigo() {
        $pdo = new Conexion2();
        $query = $pdo->prepare('SELECT p.idPersona, p.codigo, p.nombre, p.idPrestacion, pr.prestacion, pr.institucion FROM persona p '
                . 'JOIN prestacion pr ON p.idPrestacion = pr.idPrestacion WHERE p.codigo = '. $this->getCodigo() .';');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $value) {
            $empl = array(
                $value['idPersona'],
                $value['codigo'],
                $value['nombre'],
                $value['idPrestacion'],
                $value['prestacion'],
                $value['institucion']
            );
        }
            return $empl;
    }
    
    function consultaEmpleados() {
        $pdo = new Conexion2();
        $query = $pdo->prepare('SELECT codigo, nombre FROM persona ORDER BY codigo ASC;');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $value) {
            echo '<option value="'. $value['codigo'] .'">'. $value['codigo'] .', '. $value['nombre'] .'</option>';
        }
    }

    function consultaMesEmpleado() {
        $pdo = new Conexion2();
        $query = $pdo->prepare('SELECT fecha, DATE_FORMAT(fecha, "%T") AS hora, DATE_FORMAT(fecha, "%a") AS nombreDia,
            DATE_FORMAT(fecha, "%Y-%m-%d") AS fechaC, DATE_FORMAT(fecha, "%m") AS mes, DATE_FORMAT(fecha, "%d") AS dia
            FROM asistencias 
WHERE DATE_FORMAT(fecha, "%x-%m") = "'. $this->getMes() .'" AND codigo = '. $this->getCodigo() .' ORDER BY fecha;');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            $mesEmp[$key] = array(
                $key+1,
                $value['fecha'],
                $value['hora'],
                $value['nombreDia'],
                $value['fechaC'],
                $value['mes'],
                $value['dia']
            );  
        }
        if (isset($mesEmp)) 
        {
            return $mesEmp;
        }
    }
    
    function consultaPeriodosVacacionales() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT inicioPeriodo, finPeriodo, descripcionPeriodo FROM PERIODO_VACACIONAL;');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            $periodoVac[$key] = array(
                $value['inicioPeriodo'],
                $value['finPeriodo'],
                $value['descripcionPeriodo']
            );
        }
            return $periodoVac;
    }
    
    function consultaHorariosPersona() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT entradaLunVie, entradaSabDom, entradaVacaciones, salidaLunVie, salidaSabDom, salidaVacaciones FROM horario WHERE codigo = '. $this->getCodigo() .';');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $value) {
            $horarioPer = array(
                $value['entradaLunVie'],
                $value['entradaSabDom'],
                $value['entradaVacaciones'],
                $value['salidaLunVie'],
                $value['salidaSabDom'],
                $value['salidaVacaciones']
            );
        }
        if (isset($horarioPer)) 
        {
            return $horarioPer;
        }
            
    }
    
    function consultaSemanaEmpleado() {
        $pdo = new Conexion2();
        $query = $pdo->prepare('select fecha, DATE_FORMAT(fecha, "%T") AS hora, DATE_FORMAT(fecha, "%j") AS dia,
            DATE_FORMAT(fecha, "%v") AS semana, DATE_FORMAT(fecha, "%x") AS año, DATE_FORMAT(fecha, "%a") AS nombreDia,
            DATE_FORMAT(fecha, "%d-%m-%Y") AS fechaC FROM asistencias
    WHERE DATE_FORMAT(fecha, "%x-W%v") = "'. $this->getSemana() .'" AND codigo = '. $this->getCodigo() .' ORDER BY fecha;');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            $semanaEmp[$key] = array(
                $key+1,
                $value['fecha'],
                $value['hora'],
                $value['dia'],
                $value['semana'],
                $value['año'],
                $value['nombreDia'],
                $value['fechaC']
            );
        }
        if (isset($semanaEmp)) 
        {
            return $semanaEmp;  
        }    
    }
    
    function consultaRegistrosDiario() {
        $pdo = new Conexion2();
        $query = $pdo->prepare('SELECT fecha, DATE_FORMAT(fecha, "%T") AS hora
FROM asistencias WHERE DATE_FORMAT(fecha, "%d-%m-%Y") = "'. $this->getFecha() .'" AND codigo = '. $this->getCodigo() .' ORDER BY fecha;');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            $regDia[$key] = array(
                $value['fecha'],
                $value['hora']
            );
        }
        if (isset($regDia)) 
        {
            return $regDia;  
        }    
    }
}

