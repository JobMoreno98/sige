<?php
include 'conexion.php';

class material{

    public function __construct() {
        $this->setTitulo1('ID');
        $this->setTitulo2('Descripción');
        $this->setTitulo3('Tipo');
        $this->setTitulo4('Existencia');
        $this->setTitulo9('Salidas');
        $this->setTitulo5('Stock Mínimo');
        $this->setTitulo6('Años Cad.');
        $this->setTitulo7('Nivel de Existencia');
        $this->setTitulo8('Uso');
        $this->setTitulo10('Nivel de Proyección');
        $this->setTitulo11('Proyección');
    }

    private $idMaterial;
    private $descripcion;
    private $tipo;
    private $existencia;
    private $stock;
    private $caducidad;
    private $nivelExistencia;
    private $uso;
    private $nivelProyeccion;
    private $fechaCaducidad;


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

    function getNivelProyeccion() {
        return $this->nivelProyeccion;
    }

    function setNivelProyeccion($nivelProyeccion) {
        $this->nivelProyeccion = $nivelProyeccion;
    }
    function getFechaCaducidad() {
        return $this->fechaCaducidad;
    }

    function setFechaCaducidad($fechaCaducidad) {
        $this->fechaCaducidad = $fechaCaducidad;
    }


    function getIdMaterial() {
        return $this->idMaterial;
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
    function setIdMaterial($idMaterial) {
        $this->idMaterial = $idMaterial;
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
    function getDescripcion() {
        return $this->descripcion;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getExistencia() {
        return $this->existencia;
    }

    function getStock() {
        return $this->stock;
    }

    function getCaducidad() {
        return $this->caducidad;
    }

    function getNivelExistencia() {
        return $this->nivelExistencia;
    }

    function getUso() {
        return $this->uso;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setExistencia($existencia) {
        $this->existencia = $existencia;
    }

    function setStock($stock) {
        $this->stock = $stock;
    }

    function setCaducidad($caducidad) {
        $this->caducidad = $caducidad;
    }

    function setNivelExistencia($nivelExistencia) {
        $this->nivelExistencia = $nivelExistencia;
    }

    function setUso($uso) {
        $this->uso = $uso;
    }

    function alta() {
        try {
        $pdo = new Conexion();
        $query = $pdo->prepare("INSERT INTO material (descripcion, tipo, stockMinimo,
            tiempoCaducidad) VALUES (
        '".$this->getDescripcion()."',
        '".$this->getTipo()."',
        '".$this->getStock()."',
        '".$this->getCaducidad()."');");
        $query->execute();
            echo '<div class="container">'
        . '<br><center><img class="img-responsive" src="images/check.png" style="width:15%">'
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

    function titulosMaterial(){
            if($_SESSION['privilegios'] == 'Ayudante Almacén' || $_SESSION['privilegios'] == 'Dirección')
            {
                $fila='';
            }
            else if ($_SESSION['privilegios'] == 'Encargado Almacén' || $_SESSION['privilegios'] == 'Administrador' || $_SESSION['privilegios'] == 'RH-Almacen')
            {
                $fila='<th>Operación</th>';
            }
            echo '<tr>
                <th>'.$this ->getTitulo1().'</th>
                <th>'.$this ->getTitulo2().'</th>
                <th>'.$this ->getTitulo3().'</th>
                <th>'.$this ->getTitulo4().'</th>
                <th>'.$this ->getTitulo5().'</th>
                <th>'.$this ->getTitulo6().'</th>
                <th>'.$this ->getTitulo7().'</th>
                <th>'.$this ->getTitulo8().'</th>
                <th>Mostrar</th>
                '.$fila.'
            </tr>';
    }
        function titulosMaterialProyeccion(){
            if($_SESSION['privilegios'] == 'Ayudante Almacén' || $_SESSION['privilegios'] == 'Dirección')
            {
                $fila='';
            }
            else if ($_SESSION['privilegios'] == 'Encargado Almacén' || $_SESSION['privilegios'] == 'Administrador' || $_SESSION['privilegios'] == 'RH-Almacen')
            {
                $fila='<th>Operación</th>';
            }
            echo '<tr>
                <th>'.$this ->getTitulo1().'</th>
                <th>'.$this ->getTitulo2().'</th>
                <th>'.$this ->getTitulo3().'</th>
                <th>'.$this ->getTitulo4().'</th>
                <th>'.$this ->getTitulo9().'</th>
                <th>'.$this ->getTitulo5().'</th>
                <th>'.$this ->getTitulo10().'</th>
                <th>'.$this ->getTitulo11().'</th>
                <th>'.$this ->getTitulo7().'</th>
                <th>Mostrar</th>
                '.$fila.'
            </tr>';
    }
    function consultaMaterial() {

        $pdo = new Conexion();
        //Los select hay que modificar por los campos a usar
        $query = $pdo->prepare('SELECT
            idMaterial, descripcion, tipo, existencia, stockMinimo, tiempoCaducidad, nivelExistencia, enUso
            FROM material WHERE descripcion LIKE "%'.$this->getDescripcion().'%"'
                . 'AND tipo = "'.$this->getTipo().'"'
                . 'AND existencia LIKE "'.$this->getExistencia().'%"'
                . 'AND stockMinimo LIKE "'.$this->getStock().'%"'
                . 'AND tiempoCaducidad LIKE "'.$this->getCaducidad().'%"'
                . 'AND nivelExistencia LIKE "%'.$this->getNivelExistencia().'%"'
                . 'AND enUso LIKE "'.$this->getUso().'%"'
                . ';');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            if($_SESSION['privilegios'] == 'Ayudante Almacén' || $_SESSION['privilegios'] == 'Dirección')
            {
                $fila='';
            }
            else if ($_SESSION['privilegios'] == 'Encargado Almacén' || $_SESSION['privilegios'] == 'Administrador' || $_SESSION['privilegios'] == 'RH-Almacen')
            {
                $fila='<td><a href="materialModificar.php?id='. $value['idMaterial'] .'&t='. $value['tipo'] .'"'
                        . ' class="btn btn-default" role="button">Modificar</a></td>';
            }
            echo '
                <tr>
                    <td>'. $value['idMaterial'] .'</td>
                    <td>'. $value['descripcion'] .'</td>
                    <td>'. $value['tipo'] .'</td>
                    <td>'. $value['existencia'] .'</td>
                    <td>'. $value['stockMinimo'] .'</td>
                    <td>'. $value['tiempoCaducidad'] .'</td>
                    <td>'. $value['nivelExistencia'] .'</td>
                    <td>'. $value['enUso'] .'</td>
                    <td><a href="requisicionConsultaMaterial.php?id='. $value['idMaterial'] .'" class="btn btn-default" role="button">Salidas</a></td>
                    '.$fila.'
                </tr>
            ';
        }
    }
    function consultaMaterialProyecciones() {

        $pdo = new Conexion();
        //Los select hay que modificar por los campos a usar
        $query = $pdo->prepare('SELECT idMaterial as idMaterialMaterial, descripcion, tipo, existencia, nivelProyeccion, stockMinimo, tiempoCaducidad, nivelExistencia, enUso, (SELECT sum(`cantidad`) AS salidas FROM `salida_material` where `estado`="Surtido" AND idMaterial=idMaterialMaterial) AS salidas FROM material '
                . 'WHERE enUso="Activo" AND descripcion LIKE "%'.$this->getDescripcion().'%"'
                . 'AND tipo = "'.$this->getTipo().'"'
                . 'AND existencia LIKE "'.$this->getExistencia().'%"'
                . 'AND stockMinimo LIKE "'.$this->getStock().'%"'
                . 'AND tiempoCaducidad LIKE "'.$this->getCaducidad().'%"'
                . 'AND nivelExistencia LIKE "%'.$this->getNivelExistencia().'%"'
                . 'AND enUso LIKE "'.$this->getUso().'%"'
                . ';');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {
            if($_SESSION['privilegios'] == 'Ayudante Almacén' || $_SESSION['privilegios'] == 'Dirección')
            {
                $fila='';
            }
            else if ($_SESSION['privilegios'] == 'Encargado Almacén' || $_SESSION['privilegios'] == 'Administrador' || $_SESSION['privilegios'] == 'RH-Almacen')
            {
                $fila='<td><a href="materialModificar.php?id='. $value['idMaterialMaterial'] .'&t='. $value['tipo'] .'"'
                        . ' class="btn btn-default" role="button">Modificar</a></td>';
            }
            $limiteInventario=$value['salidas']+$value['stockMinimo'];

            $nivel=($value['nivelProyeccion']/100)+1;
            if($value['existencia']<=$limiteInventario){
                $proyeccion=$value['salidas']*$nivel;

                if($value['existencia']<$value['stockMinimo']){
                    $regularExistencia=$value['stockMinimo']-$value['existencia'];
                    $proyeccion+=$regularExistencia;
                }
                if($value['existencia']>$value['stockMinimo']){
                    $regularExistencia=$value['existencia']-$value['stockMinimo'];
                    $proyeccion-=$regularExistencia;
                }
                $numeroProyeccion=ceil($proyeccion);
            }else{
               $numeroProyeccion="-";
            }
            echo '
                <tr>
                    <td>'. $value['idMaterialMaterial'] .'</td>
                    <td>'. $value['descripcion'] .'</td>
                    <td>'. $value['tipo'] .'</td>
                    <td>'. $value['existencia'] .'</td>';

                if($value['salidas']!=0)
                    echo '<td>'. $value['salidas'] .'</td>';
                else
                    echo '<td>'. 0 .'</td>';
                    echo '<td>'. $value['stockMinimo'] .'</td>
                    <td>'. $value['nivelProyeccion'] .'%</td>
                    <td>'. $numeroProyeccion .'</td>

                    <td>'. $value['nivelExistencia'] .'</td>

                    <td><a href="requisicionConsultaMaterial.php?id='. $value['idMaterialMaterial'] .'" class="btn btn-default" role="button">Salidas</a></td>
                    '.$fila.'
                </tr>
            ';
        }
    }
    function materialSeleccionModificar() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT * FROM material WHERE idMaterial = '.$this ->getIdMaterial().';');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $value) {
             $arregloMatMod = array(
                $value['idMaterial'],
                $value['descripcion'],
                $value['tipo'],
                $value['stockMinimo'],
                $value['tiempoCaducidad'],
                $value['enUso'],
                $value['nivelProyeccion']
            );
        }
        return $arregloMatMod;
    }

    function materialModificar() {
        $pdo = new Conexion();
        $query = $pdo->prepare("UPDATE material SET descripcion = :descripcion, tipo = :tipo, stockMinimo = :stockMinimo,
        tiempoCaducidad = :tiempoCaducidad, enUso = :enUso, nivelProyeccion = :nivelProyeccion WHERE idMaterial = :idMaterial;");
        $query->bindValue(':idMaterial', $this->getIdMaterial());
        $query->bindValue(':descripcion', $this->getDescripcion());
        $query->bindValue(':tipo', $this->getTipo());
        $query->bindValue(':stockMinimo', $this->getStock());
        $query->bindValue(':tiempoCaducidad', $this->getCaducidad());
        $query->bindValue(':enUso', $this->getUso());
        $query->bindValue(':nivelProyeccion', $this->getNivelProyeccion());
        $query->execute();
        echo '<div class="container">'
        . '<br><center><img class="img-responsive" src="images/check.png" style="width:15%">'
                    . '<center><br><p class="text-success text-center text-uppercase">'
                    . 'La información se guardó correctamente</p>'
                    . '</div>';
    }

    function consultaEntradaMaterialPorCaducar(){
       $conn=new Conexion();
       $sql=$conn->prepare('SELECT em.idMaterial, m.descripcion, m.existencia, e.fechaEntrega, em.fechaCaducidad, em.cantidad, e.idCompra, em.idEntrega
FROM  entrada_material em
JOIN material m ON em.idMaterial = m.idMaterial
JOIN entrega e ON em.idEntrega = e.idEntrega
WHERE em.cantidad != 0 AND
em.idMaterial IN (SELECT idMaterial from material WHERE tipo = "'.$this->getTipo().'" AND existencia != 0 AND enUso = "Activo")
ORDER BY em.idMaterial, em.fechaCaducidad, em.idEntrega;');
       $sql->execute();
       $resultado=$sql->fetchAll();
       foreach ($resultado as $key => $value){
          $arregloCad[$key] = array(
                $value['idMaterial'],
                $value['descripcion'],
                $value['existencia'],
                $value['fechaEntrega'],
                $value['fechaCaducidad'],
                $value['cantidad'],
                $value['idCompra'],
                $value['idEntrega']
            );
        }
        return $arregloCad;
    }

    function consultaMaterialGeneral(){
       $conn=new Conexion();
       $sql=$conn->prepare('SELECT idMaterial, existencia FROM material '
               . 'WHERE tipo = "'.$this->getTipo().'" AND existencia != 0 AND enUso = "Activo" ORDER BY idMaterial;');
       $sql->execute();
       $resultado=$sql->fetchAll();
       foreach ($resultado as $key => $value){
          $arregloCad[$key] = array(
                $value['idMaterial'],
                $value['existencia']
            );
        }
        return $arregloCad;
    }

    function calculoMaterialPorCaducar() {
        $entrada = $this->consultaEntradaMaterialPorCaducar();
        $material = $this->consultaMaterialGeneral();


        $j = (count($entrada)-1);
        for ($i = (count($material)-1); $i >= 0; $i--) {

            $existenciaMaterial = $material[$i][1];

            while ($entrada[$j][0] == $material[$i][0] && $j > 0) {

                if ($entrada[$j][5] < $existenciaMaterial) {

                    $existenciaMaterial = $existenciaMaterial - $entrada[$j][5];
                }else {
                    $entrada[$j][5] = $existenciaMaterial;
                    $existenciaMaterial = 0;
                }
                $j--;
            }
            if ($j == 0 && $entrada[$j][5] > $material[$i][1]) {
                $entrada[$j][5] = $material[$j][1];
            }

        }

        $fechaCad = strtotime($this->getFechaCaducidad());
        for ($k = 0; $k < count($entrada); $k++) {

            $fechaEn = strtotime($entrada[$k][4]);

            if ($entrada[$k][5] > 0 && $fechaEn <= $fechaCad) {
                $arregloCad[] = $entrada[$k];
            }
        }

        return $arregloCad;
    }
}
