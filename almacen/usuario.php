<?php
include 'conexion.php';

class usuario {

    public function __construct() {
        $this->setTitulo1('ID');
        $this->setTitulo2('Nombre');
        $this->setTitulo3('Usuario');
        $this->setTitulo4('Privilegios');
        $this->setTitulo5('Empleado');
    }

    private $idUsuario;
    private $nombreUsuario;
    private $usuario;
    private $password;
    private $privilegios;
    private $idEmpleado;

    private $titulo1;
    private $titulo2;
    private $titulo3;
    private $titulo4;
    private $titulo5;

    function getIdUsuario() {
        return $this->idUsuario;
    }

    function getNombreUsuario() {
        return $this->nombreUsuario;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getPassword() {
        return $this->password;
    }

    function getPrivilegios() {
        return $this->privilegios;
    }

    function getIdEmpleado() {
        return $this->idEmpleado;
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

    function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    function setNombreUsuario($nombreUsuario) {
        $this->nombreUsuario = $nombreUsuario;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setPrivilegios($privilegios) {
        $this->privilegios = $privilegios;
    }

    function setIdEmpleado($idEmpleado) {
        $this->idEmpleado = $idEmpleado;
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


    function consultanombreEmpleado() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT idEmpleado, nombre FROM empleado WHERE '
                . 'idEmpleado NOT IN (SELECT idEmpleado FROM usuario) AND estado = "Activo" AND codigoUDG<>0 ORDER BY nombre ASC');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            echo '
                <option value="'. $value['idEmpleado'] .'">'.$value['nombre'] .'</option>';
        }
    }
    function consultaTodosEmpleado() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT idEmpleado, nombre FROM empleado WHERE '
                . 'idEmpleado NOT IN (SELECT idEmpleado FROM usuario) AND estado = "Activo" ORDER BY nombre ASC');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            echo '
                <option value="'. $value['idEmpleado'] .'">'.$value['nombre'] .'</option>';
        }
    }

    function usuarioAlta() {
        try {
        $pdo = new Conexion();
        $query = $pdo->prepare("INSERT INTO usuario (nombreUsuario, usuario,
        password,
        privilegios,
        idEmpleado) VALUES (
        '".$this->getNombreUsuario()."',
        '".$this->getUsuario()."',
        MD5('".$this->getPassword()."'),
        '".$this->getPrivilegios()."',
        ".$this->getIdEmpleado().");");
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

        function titulosUsuario()   {
            echo '<tr>
                <th>'.$this ->getTitulo1().'</th>
                <th>'.$this ->getTitulo2().'</th>
                <th>'.$this ->getTitulo3().'</th>
                <th>'.$this ->getTitulo4().'</th>
                <th>'.$this ->getTitulo5().'</th>
                <th>Operación</th>
            </tr>';

    }

    function consultaUsuario() {

        $pdo = new Conexion();
        //Los select hay que modificar por los campos a usar
        $query = $pdo->prepare('SELECT
                u.idUsuario, u.nombreUsuario, u.usuario, u.privilegios, u.idEmpleado,
                e.nombre
            FROM usuario u JOIN empleado e ON u.idEmpleado = e.idEmpleado
            WHERE u.nombreUsuario LIKE "%'.$this->getNombreUsuario().'%"'
                . 'AND u.usuario LIKE "%'.$this->getUsuario().'%"'
                . 'AND u.privilegios LIKE "%'.$this->getPrivilegios().'%"'
                . 'AND e.nombre LIKE "%'.$this->getIdEmpleado().'%"'
                . ';');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            echo '
                <tr>
                    <td>'. $value['idUsuario'] .'</td>
                    <td>'. $value['nombreUsuario'] .'</td>
                    <td>'. $value['usuario'] .'</td>
                    <td>'. $value['privilegios'] .'</td>
                    <td>'. $value['idEmpleado'] .' - '. $value['nombre'] .'</td>
                    <td><a href="usuarioModificar.php?id='. $value['idUsuario'] .'"'
                        . ' class="btn btn-default" role="button">Modificar</a></td>
                </tr>
            ';
        }

    }

    function usuarioSeleccionModificar() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT
                u.*,
                e.nombre
            FROM usuario u JOIN empleado e ON u.idEmpleado = e.idEmpleado
            WHERE
            u.idUsuario = '.$this ->getIdUsuario().';');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $value) {
             $arregloUsMod = array(
                $value['idUsuario'],
                $value['nombreUsuario'],
                $value['usuario'],
                $value['privilegios'],
                $value['idEmpleado'],
                $value['nombre']
            );
        }
        return $arregloUsMod;
    }

    function usuarioModificar() {
        $pdo = new Conexion();
        $query = $pdo->prepare("UPDATE usuario"
                . " SET nombreUsuario = :nombreUsuario, usuario = :usuario,"
                . "password = MD5(:password), privilegios = :privilegios,"
                . "idEmpleado = :idEmpleado WHERE idUsuario = :idUsuario;");
        $query->bindValue(':idUsuario', $this->getIdUsuario());
        $query->bindValue(':nombreUsuario', $this->getNombreUsuario());
        $query->bindValue(':usuario', $this->getUsuario());
        $query->bindValue(':password', $this->getPassword());
        $query->bindValue(':privilegios', $this->getPrivilegios());
        $query->bindValue(':idEmpleado', $this->getIdEmpleado());
        $query->execute();
        echo '<div class="container">'
        . '<br><br><center><img class="img-responsive" src="images/check.png" style="width:15%">'
                    . '<br><p class="text-success text-center text-uppercase">'
                    . 'La información se guardó correctamente</p></center>'
                    . '</div>';
    }
}
