<?php
include 'conexion.php';

class proveedor{

    public function __construct() {
        $this->setTitulo1('ID');
        $this->setTitulo2('RFC');
        $this->setTitulo3('Razón Social');
        $this->setTitulo4('Nombre Comercial');
        $this->setTitulo5('Contacto');
        $this->setTitulo6('Teléfono');
        $this->setTitulo7('Email');
        $this->setTitulo8('Estatus');
    }

    private $idProveedor;
    private $RFC;
    private $razonSocial;
    private $nombreComercial;
    private $nombreContacto;
    private $telefono;
    private $email;
    private $estadoProveedor;

    private $titulo1;
    private $titulo2;
    private $titulo3;
    private $titulo4;
    private $titulo5;
    private $titulo6;
    private $titulo7;
    private $titulo8;

    function getIdProveedor() {
        return $this->idProveedor;
    }

    function getRFC() {
        return $this->RFC;
    }

    function getRazonSocial() {
        return $this->razonSocial;
    }

    function getNombreComercial() {
        return $this->nombreComercial;
    }

    function getNombreContacto() {
        return $this->nombreContacto;
    }

    function getTelefono() {
        return $this->telefono;
    }

    function getEmail() {
        return $this->email;
    }

    function getEstadoProveedor() {
        return $this->estadoProveedor;
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

    function setIdProveedor($idProveedor) {
        $this->idProveedor = $idProveedor;
    }

    function setRFC($RFC) {
        $this->RFC = $RFC;
    }

    function setRazonSocial($razonSocial) {
        $this->razonSocial = $razonSocial;
    }

    function setNombreComercial($nombreComercial) {
        $this->nombreComercial = $nombreComercial;
    }

    function setNombreContacto($nombreContacto) {
        $this->nombreContacto = $nombreContacto;
    }

    function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setEstadoProveedor($estadoProveedor) {
        $this->estadoProveedor = $estadoProveedor;
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


    function alta() {
        try {
        $pdo = new Conexion();
        $query = $pdo->prepare("INSERT INTO proveedor (RFC, razonSocial, nombreComercial, nombreContacto,
            telefono,
            email) VALUES (
        '".$this->getRFC()."',
        '".$this->getRazonSocial()."',
        '".$this->getNombreComercial()."',
        '".$this->getNombreContacto()."',
        '".$this->getTelefono()."',
        '".$this->getEmail()."');");
        $query->execute();
            echo '<div class="container">'
        . '<br><center><img class="img-responsive" src="images/images/check.png" style="width:15%">'
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

    function titulosProveedor(){

            echo '<tr>
                <th>'.$this ->getTitulo1().'</th>
                <th>'.$this ->getTitulo2().'</th>
                <th>'.$this ->getTitulo3().'</th>
                <th>'.$this ->getTitulo4().'</th>
                <th>'.$this ->getTitulo5().'</th>
                <th>'.$this ->getTitulo6().'</th>
                <th>'.$this ->getTitulo7().'</th>
                <th>'.$this ->getTitulo8().'</th>
                <th>Operación</th>
            </tr>';
    }

     function consultaProveedor() {

        $pdo = new Conexion();
        //Los select hay que modificar por los campos a usar
        $query = $pdo->prepare('SELECT
            *
            FROM proveedor WHERE RFC LIKE "%'.$this->getRFC().'%"'
                . 'AND razonSocial LIKE "%'.$this->getRazonSocial().'%"'
                . 'AND nombreComercial LIKE "%'.$this->getNombreComercial().'%"'
                . 'AND nombreContacto LIKE "%'.$this->getNombreContacto().'%"'
                . 'AND telefono LIKE "%'.$this->getTelefono().'%"'
                . 'AND email LIKE "%'.$this->getEmail().'%"'
                . ';');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            echo '
                <tr>
                    <td>'. $value['idProveedor'] .'</td>
                    <td>'. $value['RFC'] .'</td>
                    <td>'. $value['razonSocial'] .'</td>
                    <td>'. $value['nombreComercial'] .'</td>
                    <td>'. $value['nombreContacto'] .'</td>
                    <td>'. $value['telefono'] .'</td>
                    <td>'. $value['email'] .'</td>
                    <td>'. $value['estadoProveedor'] .'</td>
                    <td><a href="proveedorModificar.php?id='. $value['idProveedor'] .'"'
                        . ' class="btn btn-default" role="button">Modificar</a></td>
                </tr>
            ';
        }
     }
        function proveedorSeleccionModificar() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT * FROM proveedor WHERE idProveedor = '.$this ->getIdProveedor().';');
        $query->execute();
        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            $arregloProv = array(
                $value['idProveedor'],
                $value['RFC'],
                $value['razonSocial'],
                $value['nombreComercial'],
                $value['nombreContacto'],
                $value['telefono'],
                $value['email'],
                $value['estadoProveedor']
            );
        }
        return $arregloProv;
    }


   function proveedorModificar() {
        $pdo = new Conexion();
        $query = $pdo->prepare("UPDATE proveedor SET RFC = :RFC, razonSocial = :razonSocial, 
            nombreComercial = :nombreComercial, nombreContacto = :nombreContacto,
            telefono = :telefono, email = :email, estadoProveedor = :estadoProveedor
            WHERE idProveedor = :idProveedor;");
        $query->bindValue(':idProveedor', $this->getIdProveedor());
        $query->bindValue(':RFC', $this->getRFC());
        $query->bindValue(':razonSocial', $this->getRazonSocial());
        $query->bindValue(':nombreComercial', $this->getNombreComercial());
        $query->bindValue(':nombreContacto', $this->getNombreContacto());
        $query->bindValue(':telefono', $this->getTelefono());
        $query->bindValue(':email', $this->getEmail());
        $query->bindValue(':estadoProveedor', $this->getEstadoProveedor());
        $query->execute();
        echo '<div class="container">'
        . '<br><center><img class="img-responsive" src="images/check.png" style="width:15%">'
                    . '<center><br><p class="text-success text-center text-uppercase">'
                    . 'La información se guardó correctamente</p>'
                    . '</div>';
    }
}
