<!DOCTYPE html>
<!DOCTYPE html>
<?php
 include './loginSecurity.php';
?>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>BPEJ. Sistema Integral de Gestión</title>
        <link rel="shortcut icon" href="favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Equipo de desarrollo BPEJ">
        <!--bootstrap-->
        <link rel="stylesheet" href="css/bootstrap.css"><!-- Editado para el menu -->
        <!--jquery-->
        <script src="js/jquery-3.2.1.min.js"></script>
        <!--bootstrap-js-->
        <script src="js/bootstrap.min.js"></script>
<!--        PDF Make
        <script src='js/pdfmake.min.js'></script>
        <script src='js/vfs_fonts.js'></script>-->
    </head>
    <body>
        <?php
        include 'barraMenu.php';
        $menu = new menu();
        $menu ->barraMenu();
        date_default_timezone_set("America/Mexico_City");

        if(isset($_POST['areaAlta']))//Valida si se envía el formulario
        {
            include 'area.php';
            $area = new area();
            $area ->setArea($_POST['area']);
            $area ->setPiso($_POST['piso']);
            $area ->setEdificio($_POST['edificio']);
            $area ->setTipo($_POST['tipo']);
            $area ->areaAlta();
        ?>
            <div class="container">
                <br>
                <center><a href="areaAlta.php" class="btn btn-default">Crear nuevo Registro</a>
                    <a href="index.php" class="btn btn-default">Salir</a></center>
            </div>
        <?php
        }
        elseif (isset($_POST['areaModificar']))//Valida si se envía el formulario
        {
            include 'area.php';
            $obj = new area();
            $obj ->setIdArea($_POST['idArea']);
            $obj ->setArea($_POST['area']);
            $obj ->setPiso($_POST['piso']);
            $obj ->setEdificio($_POST['edificio']);
            $obj ->setTipo($_POST['tipo']);
            $obj ->setEstadoArea($_POST['estadoArea']);
            $obj ->areaModificar();

        ?>
            <div class="container">
                <br>
                <center><a href="areaConsulta.php?m=M" class="btn btn-default">Regresar</a>
                <a href="index.php" class="btn btn-default">Salir</a></center>
            </div>

         <?php
        }
        elseif (isset($_POST['catalogoMuebleAlta']))//Valida si se envÃ­a el formulario
        {
            include 'mueble.php';
            $mueble = new mueble();
           // $obj ->setIdCatalogoMueble($_POST['idCatalogoM']);
            $mueble ->setDescripcion($_POST['descripcion']);
            $mueble ->setMarca($_POST['marca']);
            $mueble ->setModelo($_POST['modelo']);
            $mueble ->setMedidas($_POST['medidas']);
            $mueble ->setImgFrente($_POST['imgFrente']);
            $mueble ->setImgLateral($_POST['imgLateral']);
            $mueble ->setEstadoCatalogoMueble($_POST['estadoCatalogoMueble']);
            $mueble ->setTipo($_POST['tipo']);
            $mueble ->setFichaTecnica($_POST['fichaTecnica']);
            $mueble ->setCategoria($_POST['categoria']);
            $mueble ->setIdTipoSIIAU($_POST['IdTipoSIIAU']);
            $mueble ->catalogoMuebleAlta();

        ?>
            <div class="container">
                <br>
                <br><br><center><img class="img-responsive" src="images/check.png" style="width:15%">
                <br><p class="text-success text-center text-uppercase">La información se guardó correctamente</p></center>
                <center><a href="muebleCatalogoConsulta.php" class="btn btn-default">Regresar</a>
                <a href="index.php" class="btn btn-default">Salir</a></center>
            </div>


        <?php
        }

        elseif (isset($_POST['compraAlta']))//Valida si se envía el formulario
        {
            include 'compra.php';
            $obj = new compra();

            $obj->setTipoCompra($_POST['tipo']);
            $obj->setFechaCompra($_POST['fechaCompra']);
            $obj->setIdProveedor($_POST['idProveedor']);
            $obj->setIdEmpleado($_POST['idEmpleado']);
            $obj->setPersonaEntrega($_POST['personaEntrega']);

            if(isset($_POST['pedidoEspecial']))
            {
                $obj->setPedidoEspecial($_POST['pedidoEspecial']);
            }
             else
            {
                $obj->setPedidoEspecial(0);
            }

            $obj->setIdCompra($obj->consultaIdCompra()+1);
    //        agregar pdf
            $obj->compraAlta();

            $obj->setIdEntrega($obj->consultaIdEntrega()+1);
            $obj->primerEntregaAlta();


            $cont= $_POST['num'];
            for ($i = 1; $i < $cont+1; $i++) {
                $obj->setIdMaterial($_POST['idMaterial'.$i]);
                $obj->setCantidad($_POST['cantidad'.$i]);

                $obj->compraMaterialAlta();

                if(isset($_POST['fechaCaducidad'.$i]))
                {
                    $obj->setFechaCaducidad($_POST['fechaCaducidad'.$i]);
                }
                else
                {
                    $obj->setFechaCaducidad($obj->caducidadAnio(+1)) ;
                }

                if(isset($_POST['estadoMaterial'.$i]))
                {
                    $obj->entradaMaterialAlta();
                }
                else
                {
                    $obj->setCantidad($_POST['cantidadEntrega'.$i]);

                    if ($obj->getCantidad() > 0) {
                        $obj->entradaMaterialAlta();
                    }
                }
            }
        ?>
            <div class="container">
                <br>
                <center><a href="compraAlta.php?tipo=<?php echo $obj->getTipoCompra(); ?>" class="btn btn-default">Nueva compra</a>
                    <a href="index.php" class="btn btn-default">Salir</a></center>
            </div>
        <?php
        } elseif (isset($_POST['compraEditar'])) {

            ?>
            <br>
            <div class="container">
            <?php
            include 'compra.php';
            $obj = new compra();

            $obj->setIdCompra($_POST['idCompra']);
            $obj->setTipoCompra($_POST['tipo']);
            $bandera = true;

            if (isset($_POST['num'])) {

                $cont= $_POST['num'];

                for ($i = 1; $i <= $cont; $i++) {

                    $radioEditar = $_POST['radioEditar'.$i];
                    if($radioEditar == 'modificar') {

                        $obj->setIdMaterial($_POST['idMaterial'.$i]);
                        $obj->setCantidad($_POST['cantidad'.$i]);
                        echo $obj->modificarCompraMaterial();
                        $bandera = false;

                    } elseif ($radioEditar == 'eliminar') {

                        $obj->setIdMaterial($_POST['idMaterial'.$i]);
                        echo $obj->eliminarCompraMaterial();
                        $bandera = false;
                    }
                }

                if(isset($_POST['agregarArticulos'])) {
                    $contNuevo= $_POST['numNuevo'];

                    for ($j = $cont+1; $j <= $contNuevo; $j++) {
                        $obj->setIdMaterial($_POST['idMaterial'.$j]);
                        $obj->setCantidad($_POST['cantidad'.$j]);
                        echo $obj->insertarCompraMaterial();;
                        $bandera = false;
                    }
                }
            }

            if (isset($_POST['eliminarCompra'])) {
                echo $obj->eliminarCompra();
                $bandera = false;
            }

            if ($bandera == true) {
                ?>
                <div class="alert alert-info">No se registró ningún cambio en la requisición.</div>
                <?php
            }?>
                <br>
                <center>
                    <?php
                    if (!(isset($_POST['eliminarCompra']))) {
                        ?>
                        <a href="compraEditar.php?id=<?php echo $obj->getIdCompra(); ?>" class="btn btn-primary">Volver a Editar Compra</a>
                        <?php
                    }
                    ?>
                    <a href="compraConsulta.php?tipo=<?php echo $obj->getTipoCompra(); ?>" class="btn btn-default">Volver a Consulta</a>
                    <a href="index.php" class="btn btn-default">Salir</a>
                </center>
            </div>
        <?php

        }  elseif (isset($_POST['entregaEditar'])) {

            ?>
            <br>
            <div class="container">
            <?php
            include 'compra.php';
            $obj = new compra();

            $obj->setIdCompra($_POST['idCompra']);
            $obj->setIdEntrega($_POST['idEntrega']);
            $obj->setTipoCompra($_POST['tipo']);
            $bandera = true;

            if (isset($_POST['num'])) {

                $cont= $_POST['num'];

                for ($i = 1; $i <= $cont; $i++) {

                    $radioEditar = $_POST['radioEditar'.$i];
                    if($radioEditar == 'modificar') {

                        $obj->setIdMaterial($_POST['idMaterial'.$i]);
                        $obj->setCantidad($_POST['cantidad'.$i]);
                        echo $obj->modificarEntradaMaterial();
                        $bandera = false;

                    } elseif ($radioEditar == 'eliminar') {

                        $obj->setIdMaterial($_POST['idMaterial'.$i]);
                        echo $obj->eliminarEntradaMaterial();
                        $bandera = false;
                    }
                }

                if(isset($_POST['agregarArticulos'])) {
                    $contNuevo= $_POST['numNuevo'];

                    for ($j = $cont+1; $j <= $contNuevo; $j++) {

                        if(isset($_POST['cantidad'.$j]) && $_POST['cantidad'.$j] > 0) {

                            $obj->setIdMaterial($_POST['idMaterial'.$j]);
                            $obj->setCantidad($_POST['cantidad'.$j]);

                            if(isset($_POST['fechaCaducidad'.$j])) {
                                $obj->setFechaCaducidad($_POST['fechaCaducidad'.$j]);
                            } else {
                                $obj->setFechaCaducidad($obj->caducidadAnio(+1));
                            }
                            echo $obj->insertarEntradaMaterial();
                        }
                    }
                    $bandera = false;
                }
            }

            if (isset($_POST['eliminarEntrega'])) {
                echo $obj->eliminarEntrega();
                $bandera = false;
            }

            if ($bandera == true) {
                ?>
                <div class="alert alert-info">No se registró ningún cambio en la requisición.</div>
                <?php
            }?>
                <br>
                <center>
                    <?php
                    if (!(isset($_POST['eliminarEntrega']))) {
                        ?>
                        <a href="entregaEditar.php?id=<?php echo $obj->getIdEntrega(); ?>&idC=<?php echo $obj->getIdCompra(); ?>&t=<?php echo $obj->getTipoCompra(); ?>"
                       class="btn btn-primary">Volver a Editar Entrega</a>
                        <?php
                    }
                    ?>
                    <a href="compraEditar.php?id=<?php echo $obj->getIdCompra(); ?>" class="btn btn-default">Volver a Editar Compra</a>
                    <a href="compraConsulta.php?tipo=<?php echo $obj->getTipoCompra(); ?>" class="btn btn-default">Volver a Consulta</a>
                    <a href="index.php" class="btn btn-default">Salir</a>
                </center>
            </div>
            <br>
        <?php

        } elseif (isset($_POST['empleadoAlta'])) {

            include 'empleado.php';
            $empleados = new empleado();

            $empleados ->setCodigoUDG($_POST['codigoUDG']);
            $empleados ->setNombre($_POST['nombre']);
            $empleados ->setPuesto($_POST['puesto']);
            $empleados ->setIdNombramiento($_POST['idNombramiento']);
            $empleados ->setCargaHoraria($_POST['cargaHoraria']);
            $empleados ->setGradoEstudios($_POST['gradoEstudios']);
            $empleados ->setObservaciones($_POST['observaciones']);
            $empleados ->setExtension($_POST['extension']);
            $empleados ->setIdArea($_POST['idArea']);
            $empleados ->setPrivilegios($_POST['privilegios']);
            $empleados ->setTipoReporte($_POST['tipoReporte']);
            $empleados ->setGenerarReporte($_POST['generarReporte']);
            $empleados ->empleadoAlta();
        ?>
            <div class="container">
                <br>
                <center><a href="empleadoAlta.php" class="btn btn-default">Crear nuevo Registro</a>
                    <a href="index.php" class="btn btn-default">Salir</a></center>
            </div>



        <?php
        }
        elseif (isset($_POST['arteAlta']))//Valida si se envía el formulario
        {
            include 'arte.php';
            $arte = new arte();

            $arte ->setDescripcion($_POST['descripcion']);
            $arte ->setOrigenMueble($_POST['origenMueble']);
            $arte ->setMedidas($_POST['medidas']);
            $arte ->setImgFrente($_POST['imgFrente']);
            $arte ->setImgLateral($_POST['imgLateral']);
            $arte ->setEstadoCatalogoMueble($_POST['estadoCatalogoMueble']);
            $arte ->setTipo($_POST['tipo']);
            $arte ->setCategoria($_POST['categoria']);
            $arte ->setInformacion($_POST['informacion']);
            $arte ->arteAlta();
        ?>
            <div class="container">
                <br>
                <center><a href="arteAlta.php" class="btn btn-default">Crear nuevo Registro</a>
                    <a href="index.php" class="btn btn-default">Salir</a></center>
            </div>



        <?php
        }
        elseif (isset($_POST['empleadoModificar']))//Valida si se envía el formulario
        {
            include 'empleado.php';
            $obj = new empleado();

            $obj ->setIdEmpleado($_POST['idEmpleado']);
            $obj ->setCodigoUDG($_POST['codigoUDG']);
            $obj ->setNombre($_POST['nombre']);
            $obj ->setPuesto($_POST['puesto']);
            $obj ->setCargaHoraria($_POST['cargaHoraria']);
            $obj ->setGradoEstudios($_POST['gradoEstudios']);
            $obj ->setObservaciones($_POST['observaciones']);
            $obj ->setExtension($_POST['extension']);
            $obj ->setPrivilegios($_POST['privilegios']);
            $obj ->setEstado($_POST['estado']);
            $obj ->setIdNombramiento($_POST['idNombramiento']);
            $obj ->setIdArea($_POST['idArea']);
            $obj ->setTipoReporte($_POST['tipoReporte']);
            $obj ->setGenerarReporte($_POST['generarReporte']);
            $obj ->empleadoModificar();
        ?>
            <div class="container">
                <br>
                <center><a href="empleadoConsulta.php" class="btn btn-default">Regresar</a>
                <a href="index.php" class="btn btn-default">Salir</a></center>
            </div>
        <?php
        }
        elseif (isset($_POST['entregaAlta']))//Valida si se envía el formulario
        {
            include 'compra.php';
            $obj = new compra();

            $obj->setFechaCompra($_POST['fechaEntrega']);
            $obj->setIdCompra($_POST['idCompra']);
            $obj->setIdEmpleado($_POST['idEmpleado']);
            $obj->setPersonaEntrega($_POST['personaEntrega']);

            $obj->setIdEntrega($obj->consultaIdEntrega()+1);
            $obj->entregaAlta();


            $cont= $_POST['num'];
            for ($i = 1; $i < $cont+1; $i++) {

                $obj->setIdMaterial($_POST['idMaterial'.$i]);

                if(isset($_POST['cantidad'.$i]) && $_POST['cantidad'.$i] > 0)
                {
                    $obj->setCantidad($_POST['cantidad'.$i]);

                    if(isset($_POST['fechaCaducidad'.$i]))
                    {
                        $obj->setFechaCaducidad($_POST['fechaCaducidad'.$i]);
                    }
                    else
                    {
                        $obj->setFechaCaducidad($obj->caducidadAnio(+1));
                    }

                    $obj->entradaMaterialAlta();
                }
            }
        ?>
            <div class="container">
                <br>
                <!--<center><a href=".php?id=<?php // echo $obj->getIdCompra(); ?>" class="btn btn-default">Detalle de Compra</a>-->
                    <a href="index.php" class="btn btn-default">Salir</a></center>
            </div>
        <?php
        }
        elseif (isset($_POST['expedienteModificar']))//Valida si se envía el formulario
        {
            include 'empleado.php';
            $obj = new empleado();

            $obj ->setIdEmpleado($_POST['id']);

            if ($_FILES['fichaUIP']['name'] != "")
            {
                if ($_FILES['fichaUIP']['type'] == 'application/pdf')//Aqui valida si el archivo es PDF
                {
                    $ruta1=$_FILES['fichaUIP']['tmp_name'];//Aquí toma la ruta de donde toma el archivo
                    $destino1="expedientes/". $obj->getIdEmpleado() ."fichaUIP.pdf";//aqui puedes cambiar el nombre del archivo

                    if(copy($ruta1, $destino1))//Aqui agrega el archivo al proyecto
                    {
                        $obj->expedienteModificar("fichaUIP", $obj->getIdEmpleado() ."fichaUIP.pdf");
                    }
                    else
                    {
                        echo '<script>alert("El documento de Ficha UIP no se pudo almacenar correctamente, verifique el archivo e intente nuevamente");'
                        . 'window.location.replace("expedienteModificar.php?id='. $obj->getIdEmpleado() .'")</script>';
                    }
                }
                else
                {
                    echo '<script>alert("El documento de ficha UIP debe de estar en formato PDF, intentalo nuevamente");'
                    . 'window.location.replace("expedienteModificar.php?id='. $obj->getIdEmpleado() .'")</script>';
                }
            }


            if ($_FILES['CV']['name'] != "")
            {
                if ($_FILES['CV']['type'] == 'application/pdf')//Aqui valida si el archivo es PDF
                {
                    $ruta2=$_FILES['CV']['tmp_name'];//Aquí toma la ruta de donde toma el archivo
                    $destino2="expedientes/". $obj->getIdEmpleado() ."CV.pdf";//aqui puedes cambiar el nombre del archivo

                    if(copy($ruta2, $destino2))//Aqui agrega el archivo al proyecto
                    {
                        $obj->expedienteModificar("CV", $obj->getIdEmpleado() ."CV.pdf");
                    }
                    else
                    {
                        echo '<script>alert("El documento de CV no se pudo almacenar correctamente, verifique el archivo e intente nuevamente");'
                        . 'window.location.replace("expedienteModificar.php?id='. $obj->getIdEmpleado() .'")</script>';
                    }
                }
                else
                {
                    echo '<script>alert("El documento de CV debe de estar en formato PDF, intentalo nuevamente");'
                    . 'window.location.replace("expedienteModificar.php?id='. $obj->getIdEmpleado() .'")</script>';
                }
            }


            if ($_FILES['INE']['name'] != "")
            {
                if ($_FILES['INE']['type'] == 'application/pdf')//Aqui valida si el archivo es PDF
                {
                    $ruta3=$_FILES['INE']['tmp_name'];//Aquí toma la ruta de donde toma el archivo
                    $destino3="expedientes/". $obj->getIdEmpleado() ."INE.pdf";//aqui puedes cambiar el nombre del archivo

                    if(copy($ruta3, $destino3))//Aqui agrega el archivo al proyecto
                    {
                        $obj->expedienteModificar("INE", $obj->getIdEmpleado() ."INE.pdf");
                    }
                    else
                    {
                        echo '<script>alert("El documento de INE no se pudo almacenar correctamente, verifique el archivo e intente nuevamente");'
                        . 'window.location.replace("expedienteModificar.php?id='. $obj->getIdEmpleado() .'")</script>';
                    }
                }
                else
                {
                    echo '<script>alert("El documento de INE debe de estar en formato PDF, intentalo nuevamente");'
                    . 'window.location.replace("expedienteModificar.php?id='. $obj->getIdEmpleado() .'")</script>';
                }
            }


            if ($_FILES['RFC']['name'] != "")
            {
                if ($_FILES['RFC']['type'] == 'application/pdf')//Aqui valida si el archivo es PDF
                {
                    $ruta4=$_FILES['RFC']['tmp_name'];//Aquí toma la ruta de donde toma el archivo
                    $destino4="expedientes/". $obj->getIdEmpleado() ."RFC.pdf";//aqui puedes cambiar el nombre del archivo

                    if(copy($ruta4, $destino4))//Aqui agrega el archivo al proyecto
                    {
                        $obj->expedienteModificar("RFC", $obj->getIdEmpleado() ."RFC.pdf");
                    }
                    else
                    {
                        echo '<script>alert("El documento de RFC no se pudo almacenar correctamente, verifique el archivo e intente nuevamente");'
                        . 'window.location.replace("expedienteModificar.php?id='. $obj->getIdEmpleado() .'")</script>';
                    }
                }
                else
                {
                    echo '<script>alert("El documento de RFC debe de estar en formato PDF, intentalo nuevamente");'
                    . 'window.location.replace("expedienteModificar.php?id='. $obj->getIdEmpleado() .'")</script>';
                }
            }


            if ($_FILES['IMSS']['name'] != "")
            {
                if ($_FILES['IMSS']['type'] == 'application/pdf')//Aqui valida si el archivo es PDF
                {
                    $ruta5=$_FILES['IMSS']['tmp_name'];//Aquí toma la ruta de donde toma el archivo
                    $destino5="expedientes/". $obj->getIdEmpleado() ."IMSS.pdf";//aqui puedes cambiar el nombre del archivo

                    if(copy($ruta5, $destino5))//Aqui agrega el archivo al proyecto
                    {
                        $obj->expedienteModificar("IMSS", $obj->getIdEmpleado() ."IMSS.pdf");
                    }
                    else
                    {
                        echo '<script>alert("El documento de IMSS no se pudo almacenar correctamente, verifique el archivo e intente nuevamente");'
                        . 'window.location.replace("expedienteModificar.php?id='. $obj->getIdEmpleado() .'")</script>';
                    }
                }
                else
                {
                    echo '<script>alert("El documento de IMSS debe de estar en formato PDF, intentalo nuevamente");'
                    . 'window.location.replace("expedienteModificar.php?id='. $obj->getIdEmpleado() .'")</script>';
                }
            }


            if ($_FILES['actaNacimiento']['name'] != "")
            {
                if ($_FILES['actaNacimiento']['type'] == 'application/pdf')//Aqui valida si el archivo es PDF
                {
                    $ruta6=$_FILES['actaNacimiento']['tmp_name'];//Aquí toma la ruta de donde toma el archivo
                    $destino6="expedientes/". $obj->getIdEmpleado() ."actaNacimiento.pdf";//aqui puedes cambiar el nombre del archivo

                    if(copy($ruta6, $destino6))//Aqui agrega el archivo al proyecto
                    {
                        $obj->expedienteModificar("actaNacimiento", $obj->getIdEmpleado() ."actaNacimiento.pdf");
                    }
                    else
                    {
                        echo '<script>alert("El documento de Acta de Nacimiento no se pudo almacenar correctamente, verifique el archivo e intente nuevamente");'
                        . 'window.location.replace("expedienteModificar.php?id='. $obj->getIdEmpleado() .'")</script>';
                    }
                }
                else
                {
                    echo '<script>alert("El documento de Acta de Nacimiento debe de estar en formato PDF, intentalo nuevamente");'
                    . 'window.location.replace("expedienteModificar.php?id='. $obj->getIdEmpleado() .'")</script>';
                }
            }


            if ($_FILES['CURP']['name'] != "")
            {
                if ($_FILES['CURP']['type'] == 'application/pdf')//Aqui valida si el archivo es PDF
                {
                    $ruta7=$_FILES['CURP']['tmp_name'];//Aquí toma la ruta de donde toma el archivo
                    $destino7="expedientes/". $obj->getIdEmpleado() ."CURP.pdf";//aqui puedes cambiar el nombre del archivo

                    if(copy($ruta7, $destino7))//Aqui agrega el archivo al proyecto
                    {
                        $obj->expedienteModificar("CURP", $obj->getIdEmpleado() ."CURP.pdf");
                    }
                    else
                    {
                        echo '<script>alert("El documento de CURP no se pudo almacenar correctamente, verifique el archivo e intente nuevamente");'
                        . 'window.location.replace("expedienteModificar.php?id='. $obj->getIdEmpleado() .'")</script>';
                    }
                }
                else
                {
                    echo '<script>alert("El documento de CURP debe de estar en formato PDF, intentalo nuevamente");'
                    . 'window.location.replace("expedienteModificar.php?id='. $obj->getIdEmpleado() .'")</script>';
                }
            }


            if ($_FILES['comprobanteDom']['name'] != "")
            {
                if ($_FILES['comprobanteDom']['type'] == 'application/pdf')//Aqui valida si el archivo es PDF
                {
                    $ruta8=$_FILES['comprobanteDom']['tmp_name'];//Aquí toma la ruta de donde toma el archivo
                    $destino8="expedientes/". $obj->getIdEmpleado() ."comprobanteDom.pdf";//aqui puedes cambiar el nombre del archivo

                    if(copy($ruta8, $destino8))//Aqui agrega el archivo al proyecto
                    {
                        $obj->expedienteModificar("comprobanteDom", $obj->getIdEmpleado() ."comprobanteDom.pdf");
                    }
                    else
                    {
                        echo '<script>alert("El documento de Comprobante de Domicilio no se pudo almacenar correctamente, verifique el archivo e intente nuevamente");'
                        . 'window.location.replace("expedienteModificar.php?id='. $obj->getIdEmpleado() .'")</script>';
                    }
                }
                else
                {
                    echo '<script>alert("El documento de Comprobante de Domicilio debe de estar en formato PDF, intentalo nuevamente");'
                    . 'window.location.replace("expedienteModificar.php?id='. $obj->getIdEmpleado() .'")</script>';
                }
            }


            if ($_FILES['titulo']['name'] != "")
            {
                if ($_FILES['titulo']['type'] == 'application/pdf')//Aqui valida si el archivo es PDF
                {
                    $ruta9=$_FILES['titulo']['tmp_name'];//Aquí toma la ruta de donde toma el archivo
                    $destino9="expedientes/". $obj->getIdEmpleado() ."titulo.pdf";//aqui puedes cambiar el nombre del archivo

                    if(copy($ruta9, $destino9))//Aqui agrega el archivo al proyecto
                    {
                        $obj->expedienteModificar("titulo", $obj->getIdEmpleado() ."titulo.pdf");
                    }
                    else
                    {
                        echo '<script>alert("El documento de Título no se pudo almacenar correctamente, verifique el archivo e intente nuevamente");'
                        . 'window.location.replace("expedienteModificar.php?id='. $obj->getIdEmpleado() .'")</script>';
                    }
                }
                else
                {
                    echo '<script>alert("El documento de Título debe de estar en formato PDF, intentalo nuevamente");'
                    . 'window.location.replace("expedienteModificar?id='. $obj->getIdEmpleado() .'.php")</script>';
                }
            }
        ?>
                <div class="container">
                    <br><br><center><img class="img-responsive" src="images/check.png" style="width:15%">
                    <br><p class="text-success text-center text-uppercase">La información se guardó correctamente</p></center>
                </div>
                <div class="container">
                    <br>
                    <center><a href="expedienteModificar.php?id=<?php echo $obj->getIdEmpleado(); ?>" class="btn btn-default">Regresar</a>
                        <a href="index.php" class="btn btn-default">Salir</a></center>
                </div>
        <?php
        }
        elseif (isset($_POST['materialAlta']))//Valida si se envía el formulario
        {
            include 'material.php';
            $material = new material();
            $material ->setDescripcion($_POST['descripcion']);
            $material ->setTipo($_POST['tipo']);
            $material ->setStock($_POST['stock']);
            $material ->setCaducidad($_POST['caducidad']);
            $material ->alta();
         ?>
             <div class="container">
                <br>
                <center><a href="materialAlta.php" class="btn btn-default">Crear nuevo Registro</a>
                <a href="index.php" class="btn btn-default">Salir</a></center>
            </div>
        <?php
        }
        elseif (isset($_POST['materialModificar']))//Valida si se envía el formulario
        {
            include 'material.php';
            $obj = new material();

            $obj ->setIdMaterial($_POST['idMaterial']);
            $obj ->setDescripcion($_POST['descripcion']);
            $obj ->setTipo($_POST['tipo']);
            $obj ->setStock($_POST['stock']);
            $obj ->setCaducidad($_POST['caducidad']);
            $obj ->setUso($_POST['uso']);
            $obj ->setNivelProyeccion($_POST['nivelProyeccion']);
            $obj ->materialModificar();
        ?>
            <div class="container">
                <br>
                <center><a href="materialConsulta.php?t=<?php echo $obj->getTipo(); ?>" class="btn btn-default">Regresar</a>
                <a href="index.php" class="btn btn-default">Salir</a></center>
            </div>
        <?php
        }
        elseif (isset($_POST['nombramientoAlta']))//Valida si se envía el formulario
        {
            include 'suplencia.php';
            $obj = new suplencia();
            $obj ->setNombramiento($_POST['nombramiento']);
            $obj ->nombramientoAlta();

        ?>
        <div class="container">
            <br>
            <center><a href="nombramientoAlta.php" class="btn btn-default">Registrar nuevo</a>
            <a href="index.php" class="btn btn-default">Salir</a></center>
        </div>
        <?php
        }
        elseif (isset($_POST['nombramientoModificar']))//Valida si se envía el formulario
        {
            include 'suplencia.php';
            $obj = new suplencia();
            $obj ->setIdNombramiento($_POST['idNombramiento']);
            $obj ->setNombramiento($_POST['nombramiento']);
            $obj ->setEstadoNombramiento($_POST['estadoNombramiento']);
            $obj ->nombramientoModificar();
        ?>
        <div class="container">
            <br>
            <center><a href="nombramientoConsulta.php" class="btn btn-default">Volver a Consulta</a>
                <a href="index.php" class="btn btn-default">Salir</a></center>
        </div>
        <?php
        }
        elseif (isset($_POST['proveedorAlta']))//Valida si se envía el formulario
        {
            include 'proveedor.php';
            $proveedor = new proveedor();

            $proveedor ->setRFC($_POST['RFC']);
            $proveedor ->setRazonSocial($_POST['razon']);
            $proveedor ->setNombreComercial($_POST['nombre']);
            $proveedor ->setNombreContacto($_POST['contacto']);
            $proveedor ->setTelefono($_POST['telefono']);
            $proveedor ->setEmail($_POST['email']);
            $proveedor ->alta();
         ?>
        <div class="container">
            <br>
            <center><a href="proveedorAlta.php" class="btn btn-default">Crear nuevo Registro</a>
            <a href="index.php" class="btn btn-default">Salir</a></center>
        </div>
        <?php
        }
        elseif (isset($_POST['proveedorModificar']))//Valida si se envía el formulario
        {
            include 'proveedor.php';
            $obj = new proveedor();

            $obj ->setIdProveedor($_POST['idProveedor']);
            $obj ->setRFC($_POST['RFC']);
            $obj ->setRazonSocial($_POST['razon']);
            $obj ->setNombreComercial($_POST['nombre']);
            $obj ->setNombreContacto($_POST['contacto']);
            $obj ->setTelefono($_POST['telefono']);
            $obj ->setEmail($_POST['email']);
            $obj ->setEstadoProveedor($_POST['estadoProveedor']);
            $obj ->proveedorModificar();
        ?>
        <div class="container">
            <br>
            <center><a href="proveedorConsulta.php" class="btn btn-default">Regresar</a>
            <a href="index.php" class="btn btn-default">Salir</a></center>
        </div>
        <?php
        }
        elseif (isset($_POST['requisicionAlta']))//Valida si se envía el formulario
        {
            include 'requisicion.php';
            $obj = new requisicion();
            //Falta quitar id autoincrementable, verificar alta, de ser posible agregar a procedures
             $cont= $_POST['num'];
            $obj->setTipo($_POST['tipo']);
            $obj->setFolio($obj->consultafolioRequisicion());
            $obj->setFechaRequisicion($_POST['fechaRequisicion']);
            $obj->setIdEmpleado($_POST['idEmpleado']);
            $obj->setResponsableAlmacen('Pendiente por asignar');
            $obj->setIdArea($_POST['idArea']);
            $obj->setIdRequisicion($obj->consultaIdRequisicion()+1);
            $obj->requisicionAlta();
            $obj->setEstado('Pendiente');

            for ($i = 1; $i < $cont+1; $i++) {
                $obj->setIdMaterial($_POST['idMaterial'.$i]);
                $obj->setCantidad($_POST['cantidad'.$i]);
                $obj->requisicionMaterialAlta();
            }
        ?>
            <div class="container">
                <br>
                <center>
                    <a href="requisicionPDF.php?id=<?php echo $obj->getIdRequisicion(); ?>" class="btn btn-success" target="_blank">Descargar PDF</a>
                    <a href="requisicionAlta.php?tipo=<?php echo $obj->getTipo(); ?>" class="btn btn-primary">Nueva requisición</a>
                    <a href="index.php" class="btn btn-default">Salir</a></center>
            </div>
        <?php
        }
        elseif (isset($_POST['requisicionAltaEntregado']))//Valida si se envía el formulario
        {
            include 'requisicion.php';
            $obj = new requisicion();

            $cont= $_POST['num'];
            $obj->setTipo($_POST['tipo']);
            $obj->setEstado('Surtido');//asignar estado como Surtido de todos los materiales

            //1. Validar que todos los materiales tengan existencias actuales en inventario, en caso contrario cancelar todo
            // Esta validación permite trabajar con múltiplles usuarios
            $bandera = 'TRUE';
            $j = 1;
            while ($bandera == 'TRUE' AND $j < $cont+1) {

                $obj->setIdMaterial($_POST['idMaterial'.$j]);
                $obj->setCantidad($_POST['cantidad'.$j]);
                $bandera = $obj->validacionInicialExistencia();
                $j++;
            }

            if ($bandera == 'TRUE') {
                //2. Tomar los datos de requisición
                $obj->setIdRequisicion($obj->consultaIdRequisicion()+1);//Buscar el último id de requisición y asignar el siguiente número
                $obj->setFolio($obj->consultafolioRequisicion());
                $obj->setFechaRequisicion($_POST['fechaRequisicion']);
                $obj->setIdEmpleado($_POST['idEmpleado']);
                $obj->setResponsableAlmacen($_POST['responsableAlmacen']);
                $obj->setIdArea($_POST['idArea']);

                //3. Dar de alta la requisición nueva
                $obj->requisicionAlta();

                for ($i = 1; $i < $cont+1; $i++) {

                    //4. Tomar cada material
                    $obj->setIdMaterial($_POST['idMaterial'.$i]);
                    $obj->setCantidad($_POST['cantidad'.$i]);

                    //5. Dar de alta cada material en requisición
                    $obj->requisicionMaterialAlta();

                    //6. Surtir el material de inventario con todas sus validaciones en procedure
                    $obj->surtirSalidaMaterial();
                }
                ?>
                <div class="container">
                    <br>
                    <center>
                        <a href="requisicionPDF.php?id=<?php echo $obj->getIdRequisicion(); ?>" class="btn btn-success" target="_blank">Descargar PDF</a>
                        <a href="requisicionAltaEntregado.php?tipo=<?php echo $obj->getTipo(); ?>" class="btn btn-primary">Nueva requisición</a>
                        <a href="index.php" class="btn btn-default">Salir</a></center>
                </div><br><br>
                <?php
            //Si no se validaron existencias se cancela todo el pedido
            } else {
//                ?>
                <div class="container">
                    <br><br><center><p class="text-danger text-center text-uppercase">
                            No es posible surtir el material debido a que se actualizaron las existencias en inventario,
                            <br> vuelva a realizar la captura</p></center>
                </div>
                <div class="container">
                    <br>
                    <center>
                        <a href="requisicionAltaEntregado.php?tipo=//<?php echo $obj->getTipo(); ?>" class="btn btn-primary">Nueva requisición</a>
                        <a href="index.php" class="btn btn-default">Salir</a></center>
                </div><br><br>
                <?php
            }
        }
        elseif (isset($_POST['requisicionModificar']))//Valida si se envía el formulario
        {
            include 'requisicion.php';
            $obj = new requisicion();

            $obj->setIdRequisicion($_POST['idRequisicion']);
            $obj->setResponsableAlmacen($_POST['responsableAlmacen']);
            $obj->requisicionModificar();

            $cont= $_POST['num'];

            for ($i = 1; $i <= $cont; $i++) {
                if(isset($_POST['estado'.$i]))
                {
                    $obj->setIdMaterial($_POST['idMaterial'.$i]);
                    $obj->setCantidad($_POST['cantidad'.$i]);
                    $obj->setEstado($_POST['estado'.$i]);
                    $obj->salidaMaterialModificar();
                }
            }
        ?>
            <div class="container">
                <br><center>
                    <a href="requisicionPDF.php?id=<?php echo $obj->getIdRequisicion(); ?>" class="btn btn-success" target="_blank">Descargar PDF</a>
                    <a href="index.php" class="btn btn-default">Salir</a></center>
            </div>
        <?php
        }
        elseif (isset($_POST['requisicionSurtir']))//Valida si se envía el formulario
        {
            include 'requisicion.php';
            $obj = new requisicion();
            //cargar procedure para surtir y procedure para validar existencias como en requisicionAltaEntregado
            $obj->setIdRequisicion($_POST['idRequisicion']);
            $obj->setTipo($_POST['tipo']);
            $cont= $_POST['num'];

            for ($i = 1; $i <= $cont; $i++) {
                if(isset($_POST['estado'.$i]))
                {
                    $obj->setCantidad($_POST['cantidad'.$i]);
                    $obj->setIdMaterial($_POST['idMaterial'.$i]);
                    $obj->setEstado($_POST['estado'.$i]);
                    $obj->salidaMaterialSurtir();

                    $estad = $obj->consultaEstadoRequisicion();
                    if ($estad == 'Surtido')
                    {
                        $obj->setEstado($estad);
                        $obj->salidaMaterialProcedure();
                    }
                }
            }
        ?>
            <div class="container">'
                <br><br><center><img class="img-responsive" src="images/check.png" style="width:15%">
                <br><p class="text-success text-center text-uppercase">La información se guardó correctamente</p></center>
            </div>
            <div class="container">
                <br>
                <center>
                    <a href="requisicionPDF.php?id=<?php echo $obj->getIdRequisicion(); ?>" class="btn btn-success" target="_blank">Descargar PDF</a>
                    <a href="index.php" class="btn btn-default">Salir</a></center>
            </div>
        <?php
        }
        elseif (isset($_POST['requisicionEditar']))//Valida si se envía el formulario
        {
            ?>
            <br>
            <div class="container">
            <?php
            include 'requisicion.php';
            $obj = new requisicion();

            $obj->setIdRequisicion($_POST['idRequisicion']);
            $obj->setTipo($_POST['tipo']);
            $bandera = true;

            if (isset($_POST['num'])) {

                $cont= $_POST['num'];

                for ($i = 1; $i <= $cont; $i++) {

                    $radioEditar = $_POST['radioEditar'.$i];
                    if($radioEditar == 'modificar') {

                        $obj->setIdMaterial($_POST['idMaterial'.$i]);
                        $obj->setCantidad($_POST['cantidad'.$i]);
                        echo $obj->modificarSalidaMaterial();
                        $bandera = false;

                    } elseif ($radioEditar == 'eliminar') {

                        $obj->setIdMaterial($_POST['idMaterial'.$i]);
                        echo $obj->eliminarSalidaMaterial();
                        $bandera = false;
                    }
                }

                if(isset($_POST['agregarArticulos'])) {
                    $contNuevo= $_POST['numNuevo'];

                    for ($j = $cont+1; $j <= $contNuevo; $j++) {
                        $obj->setIdMaterial($_POST['idMaterial'.$j]);
                        $obj->setCantidad($_POST['cantidad'.$j]);
                        echo $obj->insertarSalidaMaterialEntregado();;
                        $bandera = false;
                    }
                }
            }

            if (isset($_POST['eliminarRequisicion'])) {
                echo $obj->eliminarRequisicion();
                $bandera = false;
            }

            if ($bandera == true) {
                ?>
                <div class="alert alert-info">No se registró ningún cambio en la requisición.</div>
                <?php
            }

        ?>

                <br><center>
                    <a href="requisicionPDF.php?id=<?php echo $obj->getIdRequisicion(); ?>" class="btn btn-success" target="_blank">Descargar PDF</a>
                    <?php
                    if (!(isset($_POST['eliminarRequisicion']))) {
                        ?>
                        <a href="requisicionEditar.php?id=<?php echo $obj->getIdRequisicion(); ?>" class="btn btn-primary">Volver a Editar Requisición</a>
                        <?php
                    }
                    ?>
                    <a href="requisicionConsulta.php?t=<?php echo $obj->getTipo(); ?>" class="btn btn-default">Volver a Consulta</a>
                    <a href="index.php" class="btn btn-default">Salir</a></center>
            </div>
        <?php
        }
        elseif (isset($_POST['suplenciaAlta']))//Valida si se envía el formulario
        {
            include 'suplencia.php';
            $obj = new suplencia();

            $obj->setAnioRegistro(date("Y"));
            for ($i = 2017; $i <= date("Y"); $i++) {
                    $banderaRegistro = $obj->consultaReinicioCadena($i);
                    if ($banderaRegistro == 0) {
                        $obj->setIdCadena(1);
                    }
                    else {
                        $obj->setIdCadena($obj->consultaIdCadena());
                    }
                }
            $obj->setFechaInicio($_POST['fechaInicio']);
            $obj->setFechaFin($_POST['fechaFin']);

            $cont= $_POST['num'];
            for ($i = 1; $i < $cont+1; $i++) {
                $obj->setIdNombramiento($_POST['idNombramiento'.$i]);
                $obj->setCargaHoraria($_POST['cargaHoraria'.$i]);
                $obj->setIdEmpleado($_POST['idEmpleado'.$i]);

                $obj->suplenciaAlta();
            }

            echo '<div class="container">'
                . '<br><center><img class="img-responsive" src="images/check.png" style="width:15%">'
                            . '<center><br><p class="text-success text-center text-uppercase">'
                            . 'La información se guardó correctamente</p>'
                    . '<h3><small>ID Cadena:</small> '.$obj->getIdCadena().'<h3></center>'
                            . '</div>';

        ?>
            <div class="container">
                <br>
                <center><a href="suplenciaAlta.php" class="btn btn-default">Registrar nuevo</a>
                <a href="index.php" class="btn btn-default">Salir</a></center>
            </div>
        <?php
        }
        elseif (isset($_POST['usuarioAlta']))//Valida si se envía el formulario
        {
            include 'usuario.php';
            $obj = new usuario();

            $obj ->setNombreUsuario($_POST['nombreUsuario']);
            $obj ->setUsuario($_POST['usuario']);
            $obj ->setPassword($_POST['password']);
            $obj ->setPrivilegios($_POST['privilegios']);
            $obj ->setIdEmpleado($_POST['idEmpleado']);
            $obj ->usuarioAlta();
        ?>
            <div class="container">
                <br>
                <center><a href="usuarioAlta.php" class="btn btn-default">Crear nuevo</a>
                <a href="index.php" class="btn btn-default">Salir</a></center>
            </div>
        <?php
        }
        elseif (isset($_POST['usuarioModificar']))//Valida si se envía el formulario
        {
            include 'usuario.php';
            $obj = new usuario();

            $obj ->setIdUsuario($_POST['idUsuario']);
            $obj ->setNombreUsuario($_POST['nombreUsuario']);
            $obj ->setUsuario($_POST['usuario']);
            $obj ->setPassword($_POST['password']);
            $obj ->setPrivilegios($_POST['privilegios']);
            $obj ->setIdEmpleado($_POST['idEmpleado']);
            $obj ->usuarioModificar();
        ?>
            <div class="container">
                <br>
                <center><a href="usuarioConsulta.php" class="btn btn-default">Regresar</a>
                <a href="index.php" class="btn btn-default">Salir</a></center>
            </div>
        <?php
        }
        elseif (isset($_POST['periodoVacacionalAlta']))//Valida si se envía el formulario
        {
            include 'periodoVacacional.php';
            $obj = new periodoVacacional();
            $obj ->setDescripcionPeriodo($_POST['descripcionPeriodo']);
            $obj ->setInicioPeriodo($_POST['inicioPeriodo']);
            $obj ->setFinPeriodo($_POST['finPeriodo']);
            $obj ->periodoVacacionalAlta();
        ?>
            <div class="container">
                <br>
                <center><a href="periodoVacacionalAlta.php" class="btn btn-default">Crear nuevo Registro</a>
                    <a href="index.php" class="btn btn-default">Salir</a></center>
            </div>
        <?php
        }
        elseif (isset($_POST['horarioAlta']))//Valida si se envía el formulario
        {
            include 'horarioCumplir.php';
            $obj = new horarioCumplir();
            $obj ->setIdEmpleado($_POST['IdEmpleado']);
            $obj ->setComentarios($_POST['comentarios']);
            $dias = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo", "Vacacional");
            for ($i = 0; $i < 8; $i++) {
                $obj->setDia($dias[$i]);
                $obj->setHoraEntrada($_POST['entrada'.$i]);
                $obj->setHoraSalida($_POST['salida'.$i]);
                $obj ->horarioAlta();
            }
        ?>
            <div class="container">
                <br>
                <center><a href="horarioAlta.php" class="btn btn-default">Crear nuevo Registro</a>
                    <a href="index.php" class="btn btn-default">Salir</a></center>
            </div>
        <?php
        }
        elseif (isset($_POST['periodoVacacionalModificar']))//Valida si se envía el formulario
        {
            include 'periodoVacacional.php';
            $obj = new periodoVacacional();
            $obj ->setIdPeriodo($_POST['idPeriodo']);
            $obj ->setDescripcionPeriodo($_POST['descripcionPeriodo']);
            $obj ->setInicioPeriodo($_POST['inicioPeriodo']);
            $obj ->setFinPeriodo($_POST['finPeriodo']);
            $obj ->periodoModificar();
        ?>
            <div class="container">
                <br>
                <center><a href="periodoVacacionalConsulta.php" class="btn btn-default">Regresar a Consulta</a>
                    <a href="index.php" class="btn btn-default">Salir</a></center>
            </div>
        <?php
        }
        elseif (isset($_POST['horarioModificar']))//Valida si se envía el formulario
        {
          include 'horarioCumplir.php';
          $obj = new horarioCumplir();
          $obj ->setIdEmpleado($_POST['IdEmpleado']);
          $obj ->setComentarios($_POST['comentarios']);
          $dias = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo", "Vacacional");
          for ($i = 0; $i < 8; $i++) {
              $obj->setDia($dias[$i]);
              $obj->setHoraEntrada($_POST['entrada'.$i]);
              $obj->setHoraSalida($_POST['salida'.$i]);
              $obj ->horarioModificar();
          }
      ?>
          <div class="container">
              <br>
              <center><a href="horarioAlta.php" class="btn btn-default">Crear nuevo Registro</a>
                  <a href="index.php" class="btn btn-default">Salir</a></center>
          </div>
      <?php
        ?>
            <div class="container">
                <br>
                <center><a href="horarioConsulta.php" class="btn btn-default">Regresar a Consulta</a>
                    <a href="index.php" class="btn btn-default">Salir</a></center>
            </div>
        <?php
        }
        elseif (isset($_POST['horarioModificarGuardar']))//Valida si se envía el formulario
        {
          include 'horarioCumplir.php';
          $obj = new horarioCumplir();
          $obj ->setIdEmpleado($_POST['IdEmpleado']);
          $obj ->setComentarios($_POST['comentarios']);
          $dias = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo", "Vacacional");
          for ($i = 0; $i < 8; $i++) {
              $obj->setDia($dias[$i]);
              $obj->setHoraEntrada($_POST['entrada'.$i]);
              $obj->setHoraSalida($_POST['salida'.$i]);
              $obj ->horarioModificarGuardar();
          }
      ?>
          <div class="container">
              <br>
              <center><a href="horarioAlta.php" class="btn btn-default">Crear nuevo Registro</a>
                  <a href="index.php" class="btn btn-default">Salir</a></center>
          </div>
      <?php
        ?>
            <div class="container">
                <br>
                <center><a href="horarioConsulta.php" class="btn btn-default">Regresar a Consulta</a>
                    <a href="index.php" class="btn btn-default">Salir</a></center>
            </div>
        <?php
        }
        elseif (isset($_POST['asistenciaAltaConfirmar']))//Valida si se envía el formulario
        {
            include 'asistencia.php';
            $obj = new asistencia();

            $cantidad = $_POST['cantidad'];
            for ($i = 1; $i <= $cantidad; $i++)
            {
                $obj->setCodigo($_POST['codigo'.$i]);
                $obj->setFecha($_POST['fecha'.$i]);
                $obj->setTipo($_POST['tipo'.$i]);
                $obj->asistenciaAlta();
            }
            ?>
            <div class="container">
                <br><br><center><img class="img-responsive" src="images/check.png" style="width:15%">
                <br><p class="text-success text-center text-uppercase">La información se guardó correctamente</p></center>
            </div>
            <div class="container">
                <br>
                <center><a href="asistenciaAlta.php" class="btn btn-default">Capturar Nuevo</a>
                    <a href="index.php" class="btn btn-default">Salir</a></center>
            </div>
            <?php
        }
         elseif (isset($_POST['cuentaAlta']))//Valida si se envía el formulario
        {
            include_once 'cuenta.php';
            include_once 'movimiento.php';
            $obj = new cuenta();
            $movimiento = new movimiento();

                $obj->setCOG($_POST['COG']);
                $obj->setAnio($_POST['anio']);
                $obj->setDescripcion($_POST['descripcion']);
                $obj->setTipo($_POST['tipo']);
                $cuentaLastId=$obj->cuentaAlta();
                //echo $cuentaLastId;
                $movimiento->setIdCuenta($cuentaLastId);
                $movimiento->setMontoMovimiento($_POST['montoApertura']);
                $movimiento->setTipoMovimiento('Apertura');
                $movimiento->setObservaciones($_POST['observaciones']);
                $movimiento->movimientoAlta();

            ?>
            <div class="container">
                <br><br><center><img class="img-responsive" src="images/check.png" style="width:15%">
                <br><p class="text-success text-center text-uppercase">La información se guardó correctamente</p></center>
            </div>
            <div class="container">
                <br>
                <center><a href="cuentaAlta.php" class="btn btn-default">Capturar Nueva Cuenta</a>
                    <a href="index.php" class="btn btn-default">Salir</a></center>
            </div>
            <?php
        }
        elseif (isset($_POST['cuentaModificar']))//Valida si se envía el formulario
        {
            include 'cuenta.php';
            $obj = new cuenta();
                $obj->setIdCuenta($_POST['IdCuenta']);
                $obj->setCOG($_POST['COG']);
                $obj->setAnio($_POST['anio']);
                $obj->setDescripcion($_POST['descripcion']);
                $obj->setTipo($_POST['tipo']);
                $obj->cuentaModificar();

            ?>
            <div class="container">
                <br><br><center><img class="img-responsive" src="images/check.png" style="width:15%">
                <br><p class="text-success text-center text-uppercase">La información se guardó correctamente</p></center>
            </div>
            <div class="container">
                <br>
                <center>
                    <a href="index.php" class="btn btn-default">Salir</a></center>
            </div>
            <?php
        }
        elseif (isset($_POST['cuentaModificarGuardar']))//Valida si se envía el formulario
        {
            include 'cuenta.php';
            $obj = new cuenta();
                $obj->setIdCuenta($_POST['IdCuenta']);
                $obj->setCOG($_POST['COG']);
                $obj->setAnio($_POST['anio']);
                $obj->setDescripcion($_POST['descripcion']);
                $obj->setTipo($_POST['tipo']);
                $obj->cuentaModificarGuardar();

            ?>
            <div class="container">
                <br><br><center><img class="img-responsive" src="images/check.png" style="width:15%">
                <br><p class="text-success text-center text-uppercase">La información se guardó correctamente</p></center>
            </div>
            <div class="container">
                <br>
                <center>
                    <a href="index.php" class="btn btn-default">Salir</a></center>
            </div>
            <?php
        }
        elseif (isset($_POST['pagoAlta']))//Valida si se envía el formulario
        {
            include 'pago.php';
            $pago = new pago();
            $cont= $_POST['num'];

                $pago->setNumDoctoAfin($_POST['numDoctoAfin']);
                $pago->setTipoTramite($_POST['tipoTramite']);
                $pago->setBeneficiario($_POST['beneficiario']);
                $pago->setConcepto($_POST['concepto']);
                $pago->setNoCheque($_POST['noCheque']);
                $pago->setEstatus($_POST['estatus']);
                $pago->setObservaciones($_POST['observaciones']);
                $pago->setIdPago($pago->pagoAlta());

                for ($i = 1; $i < $cont+1; $i++) {
                    $pago->getIdPago();
                    $pago->setIdCuenta($_POST['IdCuenta'.$i]);
                    $pago->setMonto($_POST['cantidad'.$i]);
                    $pago->cargoPorPagoAlta();
                }



            ?>
            <div class="container">
                <br><br><center><img class="img-responsive" src="images/check.png" style="width:15%">
                <br><p class="text-success text-center text-uppercase">La información se guardó correctamente</p></center>
            </div>
            <div class="container">
                <br>
                <center>
                    <a href="index.php" class="btn btn-default">Salir</a></center>
            </div>
            <?php
        }
        elseif (isset($_POST['pagoModificarGuardar']))//Valida si se envía el formulario
        {
            include 'pago.php';
            $obj = new pago();
                $obj->setIdPago($_POST['IdPago']);
                $obj->setNumDoctoAfin($_POST['numDoctoAfin']);
                $obj->setTipoTramite($_POST['tipoTramite']);
                $obj->setBeneficiario($_POST['beneficiario']);
                $obj->setConcepto($_POST['concepto']);
                $obj->setNoCheque($_POST['noCheque']);
                $obj->setEstatus($_POST['estatus']);
                $obj->setObservaciones($_POST['observaciones']);

                $obj->pagoModificarGuardar();

            ?>
            <div class="container">
                <br><br><center><img class="img-responsive" src="images/check.png" style="width:15%">
                <br><p class="text-success text-center text-uppercase">La información se guardó correctamente</p></center>
            </div>
            <div class="container">
                <br>
                <center>
                    <a href="index.php" class="btn btn-default">Salir</a></center>
            </div>
            <?php
        }
        elseif (isset($_POST['facturaAlta']))//Valida si se envía el formulario
        {
            //print_r($_POST);
            include 'factura.php';
            $obj = new factura();
                $obj->setFolioFactura($_POST['folioFactura']);
                $obj->setIdProveedor($_POST['IdProveedor']);
                $obj->setFechaFactura($_POST['fechaFactura']);
                $obj->setMontoFactura($_POST['montoFactura']);
                $obj->setIdPago($_POST['IdPago']);
                $obj->setPdfFactura($_FILES['pdfFactura']['name']);
                if ($_FILES['pdfFactura']["error"] > 0){
                  echo "Error: " . $_FILES['archivo']['error'] . "<br>";

	  }

	else

	  {
	  /*ahora co la funcion move_uploaded_file lo guardaremos en el destino que queramos*/
	  move_uploaded_file($_FILES['pdfFactura']['tmp_name'], "facturas/" . $_FILES['pdfFactura']['name']);




                $obj->facturaAlta();
            //print_r($_POST);

            $cadena="INSERT INTO factura(folioFactura, IdProveedor, fechaFactura, montoFactura, IdPago, pdfFactura) VALUES (".$obj->getFolioFactura().",
        ".$obj->getIdProveedor().",
        '".$obj->getFechaFactura()."',
        ".$obj->getMontoFactura().",
        ".$obj->getIdPago().",
        '".$obj->getPdfFactura()."');";
                //echo $cadena;

                }
            ?>
            <div class="container">
                <br><br><center><img class="img-responsive" src="images/check.png" style="width:15%">
                <br><p class="text-success text-center text-uppercase">La información se guardó correctamente</p></center>
            </div>
            <div class="container">
                <br>
                <center>
                    <a href="index.php" class="btn btn-default">Salir</a></center>
            </div>
            <?php
        }
        elseif (isset($_POST['facturaModificarGuardar']))//Valida si se envía el formulario
        {
            include 'factura.php';
            $obj = new factura();
                $obj->setFolioFactura($_POST['folioFactura']);
                $obj->setIdProveedor($_POST['IdProveedor']);
                $obj->setFechaFactura($_POST['fechaFactura']);
                $obj->setMontoFactura($_POST['montoFactura']);
                $obj->setIdPago($_POST['IdPago']);
                $obj->setPdfFactura($_POST['pdfFactura']);
                $obj->setIdFactura($_POST['IdFactura']);
                $obj->facturaModificarGuardar();
            ?>
            <div class="container">
                <br><br><center><img class="img-responsive" src="images/check.png" style="width:15%">
                <br><p class="text-success text-center text-uppercase">La información se guardó correctamente</p></center>
            </div>
            <div class="container">
                <br>
                <center>
                    <a href="index.php" class="btn btn-default">Salir</a></center>
            </div>
            <?php
        }
        elseif (isset($_POST['movimientoAlta']))//Valida si se envía el formulario
        {
            include_once 'movimiento.php';
            $movimiento = new movimiento();
            $movimiento->setIdCuenta($_POST['IdCuentaOrigen']);
            $movimiento->setMontoMovimiento($_POST['monto']);
            $movimiento->setTipoMovimiento('Cargo');
            $movimiento->setObservaciones($_POST['observaciones']);
            $movimiento->movimientoAlta();

            $movimiento->setIdCuenta($_POST['IdCuentaDestino']);
            $movimiento->setTipoMovimiento('Abono');
            $movimiento->movimientoAlta();

            ?>
            <div class="container">
                <br><br><center><img class="img-responsive" src="images/check.png" style="width:15%">
                <br><p class="text-success text-center text-uppercase">La información se guardó correctamente</p></center>
            </div>
            <div class="container">
                <br>
                <center><a href="cuentaAlta.php" class="btn btn-default">Capturar Nueva Cuenta</a>
                    <a href="index.php" class="btn btn-default">Salir</a></center>
            </div>
            <?php
        }
        elseif (isset($_POST['movimientoModificacionGuardar']))//Valida si se envía el formulario
        {
            include_once 'movimiento.php';
            $movimiento = new movimiento();
            $movimiento->setIdMovimiento($_POST['IdMovimiento']);
            $movimiento->setIdCuenta($_POST['IdCuenta']);
            $movimiento->setTipoMovimiento($_POST['tipoMovimiento']);
            $movimiento->setMontoMovimiento($_POST['monto']);
            $movimiento->setObservaciones($_POST['observaciones']);
            $movimiento->movimientoModificarGuardar();


            ?>
            <div class="container">
                <br><br><center><img class="img-responsive" src="images/check.png" style="width:15%">
                <br><p class="text-success text-center text-uppercase">La información se guardó correctamente</p></center>
            </div>
            <div class="container">
                <br>
                <center><a href="movimientoConsulta.php" class="btn btn-default">Listado de Movimientos</a>
                    <a href="index.php" class="btn btn-default">Salir</a></center>
            </div>
            <?php
        }
        if(isset($_POST['movimientoEquipoAlta']))//Valida si se envía el formulario
        {
            include 'equipo.php';
            $equipo = new equipo();
            $equipo ->setFecha($_POST['fecha']);
            $equipo ->setSolicitante($_POST['solicitante']);
            $equipo ->setIdEquipo($_POST['equipo']);
            $equipo ->setIdArea($_POST['area']);
            $equipo ->setIdResguardante($_POST['resguardante']);
            $equipo ->setIdUsuario($_POST['usuario']);
            $equipo ->setComentarios($_POST['comentarios']);

            $equipo ->movimientoEquipoAlta();
        ?>
            <div class="container">
                <br>
                <center><a href="areaAlta.php" class="btn btn-default">Crear nuevo Registro</a>
                    <a href="index.php" class="btn btn-default">Salir</a></center>
            </div>
        <?php
        }
        elseif (isset($_POST['equipoAlta']))//Valida si se envía el formulario
        {
            include 'equipo.php';
            $equipo = new equipo();
            $equipo ->setDescripcion($_POST['descripcion']);
            $equipo ->setMarca($_POST['marca']);
            $equipo ->setModelo($_POST['modelo']);
            $equipo ->setNumSerie($_POST['numSerie']);
            $equipo ->setIdUdg($_POST['idUdg']);
            $equipo ->setMac($_POST['mac']);
            $equipo ->setIP($_POST['IP']);
            $equipo ->setTipoConexion($_POST['tipoConexion']);
            $equipo ->setDetalles($_POST['detalles']);
            $equipo ->setImgFrente($_POST['imgFrente']);
            $equipo ->setImgSerie($_POST['imgSerie']);
            $equipo ->setPdfFactura($_POST['pdfFactura']);
            $equipo ->setEstadoEquipo($_POST['estadoEquipo']);
            $equipo ->setIdArea($_POST['IdArea']);
            $equipo ->setIdResguardante($_POST['IdResguardante']);
            $equipo ->setIdUsuario($_POST['IdUsuario']);
            $equipo ->setFecha($_POST['fecha']);
            $equipo ->equipoAlta();

        ?>
            <div class="container">
                <br>
                <center><a href="equipoConsulta.php?m=M" class="btn btn-default">Regresar</a>
                <a href="index.php" class="btn btn-default">Salir</a></center>
            </div>
        <?php
        }
        elseif (isset($_POST['equipoModificar']))//Valida si se envía el formulario
        {
            include 'equipo.php';
            $equipo = new equipo();
            $equipo ->setIdEquipo($_POST['IdEquipo']);
            $equipo ->setDescripcion($_POST['descripcion']);
            $equipo ->setMarca($_POST['marca']);
            $equipo ->setModelo($_POST['modelo']);
            $equipo ->setNumSerie($_POST['numSerie']);
            $equipo ->setIdUdg($_POST['idUdg']);
            $equipo ->setMac($_POST['mac']);
            $equipo ->setIP($_POST['IP']);
            $equipo ->setTipoConexion($_POST['tipoConexion']);
            $equipo ->setDetalles($_POST['detalles']);
            $equipo ->setVerificado($_POST['verificado']);
            $equipo ->setImgFrente($_POST['imgFrente']);
            $equipo ->setImgSerie($_POST['imgSerie']);
            $equipo ->setPdfFactura($_POST['pdfFactura']);
            $equipo ->setEstadoEquipo($_POST['estadoEquipo']);
            $equipo ->equipoModificarGuardar();

        ?>
            <div class="container">
                <br>
                <br><br><center><img class="img-responsive" src="images/check.png" style="width:15%">
                <br><p class="text-success text-center text-uppercase">La información se guardó correctamente</p></center>
                <center><a href="equipoConsulta.php?m=M" class="btn btn-default">Regresar</a>
                <a href="index.php" class="btn btn-default">Salir</a></center>
            </div>
        <?php
        }
        elseif (isset($_POST['ticketAlta']))//Valida si se envía el formulario
        {
            //print_r($_POST);
            include 'ticket.php';
            $ticket = new ticket();
            $ticket ->setIdEquipo($_POST['IdEquipo']);
            $ticket ->setPrioridad($_POST['prioridad']);
            $ticket ->setIdArea($_POST['IdArea']);
            $ticket ->setIdSolicitante($_POST['IdSolicitante']);
            $ticket ->setIdTecnico($_POST['IdTecnico']);
            $ticket ->setStatus($_POST['estatus']);
            $ticket ->setDatosDelReporte ($_POST['descripcion']);
            $ticket ->setFechaReporte($_POST['fechaReporte']);
            $ticket ->setTomoSolicitud($_POST['tomoSolicitud']);
            $ticket ->ticketAlta();

        ?>
                    <div class="container">
                <br><br><center><img class="img-responsive" src="images/check.png" style="width:15%">
                <br><p class="text-success text-center text-uppercase">La información se guardó correctamente</p></center>
            </div>
            <div class="container">
                <br>
                <center><a href="ticketConsulta.php" class="btn btn-default">Regresar</a>
                <a href="index.php" class="btn btn-default">Salir</a></center>
            </div>
        <?php
        }
        elseif (isset($_POST['ticketModificacion']))//Valida si se envía el formulario
        {
            //print_r($_POST);
            include 'ticket.php';
            $ticket = new ticket();
            $ticket ->setIdTicket($_POST['IdTicket']);
            $ticket ->setIdEquipo($_POST['IdEquipo']);
            $ticket ->setPrioridad($_POST['prioridad']);
            $ticket ->setIdArea($_POST['IdArea']);
            $ticket ->setIdSolicitante($_POST['IdSolicitante']);
            $ticket ->setIdTecnico($_POST['IdTecnico']);
            $ticket ->setStatus($_POST['estatus']);
            $ticket ->setDatosDelReporte($_POST['descripcion']);
            $ticket ->setFechaReporte($_POST['fechaReporte']);
            $ticket ->setFechaInicio($_POST['fechaInicio']);
            $ticket ->setFechaTermino($_POST['fechaTermino']);
            $ticket ->setTomoSolicitud($_POST['tomoSolicitud']);
            $ticket ->setSolucion($_POST['solucion']);
            $ticket ->setStatusAnterior($_POST['statusAnterior']);
            $ticket ->setFechaActualizacion($_POST['fechaActualizacion']);
            $ticket ->ticketModificarGuardar();

        ?>
            <div class="container">
                <br>
                <br><br><center><img class="img-responsive" src="images/check.png" style="width:15%">
                <br><p class="text-success text-center text-uppercase">La información se guardó correctamente</p></center>
                <center><a href="ticketConsulta.php" class="btn btn-default">Regresar</a>
                <a href="index.php" class="btn btn-default">Salir</a></center>
            </div>
        <?php
        }
        elseif (isset($_POST['muebleAlta']))//Valida si se envía el formulario
        {
            //print_r($_POST);
            include 'mueble.php';
            $mueble = new mueble();
            $mueble ->setIdUdG($_POST['IdUdG']);
            $mueble->setIdEmpleado($_POST['IdEmpleado']);
            $mueble->setIdArea($_POST['IdArea']);
            $mueble->setIdCatalogoM($_POST['IdCatalogoM']);
            $mueble->setDetalles($_POST['detalles']);
            $mueble->muebleAlta();

        ?>
        <div class="container">
                <br><br><center><img class="img-responsive" src="images/check.png" style="width:15%">
                <br><p class="text-success text-center text-uppercase">La información se guardó correctamente</p></center>
            </div>
        <div class="container">
                <br>
                <center><a href="muebleConsulta.php" class="btn btn-default">Regresar</a>
                <a href="index.php" class="btn btn-default">Salir</a></center>
            </div>
        <?php
        }
        elseif (isset($_POST['muebleModificarGuardar']))//Valida si se envía el formulario
        {
            //print_r($_POST);
            include 'mueble.php';
            $mueble = new mueble();
            $mueble->setIdMobiliario($_POST['IdMobiliario']);
            $mueble->setIdUdG($_POST['IdUdG']);
            $mueble->setDetalles($_POST['detalles']);
            $mueble->setVerificado($_POST['verificado']);
            $mueble->setIdEmpleado($_POST['IdEmpleado']);
            $mueble->setIdArea($_POST['IdArea']);
            $mueble->setIdCatalogoM($_POST['IdCatalogoM']);
            $mueble->setEstatus($_POST['estatus']);
            $mueble->muebleModificarGuardar();

        ?>
        <div class="container">
                <br><br><center><img class="img-responsive" src="images/check.png" style="width:15%">
                <br><p class="text-success text-center text-uppercase">La información se guardó correctamente</p></center>
            </div>
        <div class="container">
                <br>
                <center><a href="muebleConsulta.php" class="btn btn-default">Regresar</a>
                <a href="index.php" class="btn btn-default">Salir</a></center>
            </div>
        <?php
        }
        elseif (isset($_POST['cargoPorPagoModificarGuardar']))//Valida si se envía el formulario
        {
            //print_r($_POST);
            include_once 'pago.php';
            $pago = new pago();
            $pago ->setIdRelPagoCuenta($_POST['IdRelPagoCuenta']);
            $pago ->setIdPago($_POST['IdPago']);
            $pago ->setIdCuenta($_POST['IdCuenta']);
            $pago ->setMonto($_POST['monto']);
            $pago ->setEstatusDetalle($_POST['estatusDetalle']);
            $pago ->detalleCargoPorPagoModificarGuardar();

        ?>
            <div class="container">
                <br><br><center><img class="img-responsive" src="images/check.png" style="width:15%">
                <br><p class="text-success text-center text-uppercase">La información se guardó correctamente</p></center>
            </div>
            <div class="container">
                <br>
                <center><a href="pagoConsulta.php" class="btn btn-default">Regresar</a>
                <a href="index.php" class="btn btn-default">Salir</a></center>
            </div>
        <?php
        }
        elseif (isset($_POST['muebleCatalogoModificar']))//Valida si se envía el formulario
        {
            //print_r($_POST);
            include_once 'mueble.php';
            $mueble = new mueble();
            $mueble ->setIdCatalogoM($_POST['idCatalogoM']);
            $mueble ->setDescripcion($_POST['descripcion']);
            $mueble ->setOrigenMueble($_POST['origenMueble']);
            $mueble ->setMarca($_POST['marca']);
            $mueble ->setModelo($_POST['modelo']);
            $mueble ->setMedidas($_POST['medidas']);
            $mueble ->setImgFrente($_POST['imgFrente']);
            $mueble ->setImgLateral($_POST['imgLateral']);
            $mueble ->setTipo($_POST['tipo']);
            $mueble ->setFichaTecnica($_POST['fichaTecnica']);
            $mueble ->setCategoria($_POST['categoria']);
            $mueble ->setIdTipoSIIAU($_POST['IdTipoSIIAU']);
            $mueble ->setEstadoCatalogoMueble($_POST['estadoCatalogoMueble']);
            $mueble ->muebleCatalogoModificarGuardar();

        ?>
            <div class="container">
                <br><br><center><img class="img-responsive" src="images/check.png" style="width:15%">
                <br><p class="text-success text-center text-uppercase">La información se guardó correctamente</p></center>
            </div>
            <div class="container">
                <br>
                <center><a href="muebleCatalogoConsulta.php?tipo=<?php echo $mueble->getTipo(); ?>" class="btn btn-default">Regresar</a>
                <a href="index.php" class="btn btn-default">Salir</a></center>
            </div>
    <?php
        }
        elseif (isset($_POST['arteModificar']))//Valida si se envía el formulario
        {
            //print_r($_POST);
            include_once 'mueble.php';
            $mueble = new mueble();
            $mueble ->setIdCatalogoM($_POST['idCatalogoM']);
            $mueble ->setDescripcion($_POST['descripcion']);
            $mueble ->setOrigenMueble($_POST['origenMueble']);
            $mueble ->setMedidas($_POST['medidas']);
            $mueble ->setImgFrente($_POST['imgFrente']);
            $mueble ->setImgLateral($_POST['imgLateral']);
            $mueble ->setCategoria($_POST['categoria']);
            $mueble ->arteModificarGuardar();

        ?>
            <div class="container">
                <br><br><center><img class="img-responsive" src="images/check.png" style="width:15%">
                <br><p class="text-success text-center text-uppercase">La información se guardó correctamente</p></center>
            </div>
            <div class="container">
                <br>
                <center><a href="muebleCatalogoConsulta.php?tipo=<?php echo $mueble->getTipo(); ?>" class="btn btn-default">Regresar</a>
                <a href="index.php" class="btn btn-default">Salir</a></center>
            </div>
        <?php
        }
        elseif (isset($_POST['guardarIncapacidad']))
        {
            include 'permiso.php';
            $obj = new permiso();
            $fechaRegistro = date('Y-m-d');

            $obj->setIdEmpleado($_POST['empleado']);
            $obj->setIdJefeInmediato($_POST['jefe']);
            $obj->setFechaSolicitud($fechaRegistro);
            $obj->setMotivo($_POST['motivo']);
            $obj->setObservaciones($_POST['observaciones']);
            $obj->setEstatus('Aprobado');
            $obj->setPeriodoLargo('si');
            $obj->permisoAlta();

            $obj->setFechaPermiso($_POST['rangoInicio']);
            $obj->setIdPermiso($obj->idUltimoPermiso());
            $obj->fechaPermisoAlta();

            $obj->setFechaPermiso($_POST['rangoFin']);
            $obj->setIdPermiso($obj->idUltimoPermiso());
            $obj->fechaPermisoAlta();

            ?>
            <div class="container">
                <br>
                <center>

                    <a href="incapacidad.php" class="btn btn-default">Crear nuevo Registro</a>
                    <a href="index.php" class="btn btn-default">Salir</a>
                </center>
            </div>
            <?php


        }
        elseif (isset($_POST['permisoAlta']))//Valida si se envía el formulario
        {
            include 'permiso.php';
            $obj = new permiso();

            $cont= $_POST['numP'];
            $cont2= $_POST['numR'];
            $obj->setIdEmpleado($_POST['IdEmpleado']);
            $obj->setIdJefeInmediato($_POST['IdJefeInmediato']);
            $obj->setFechaSolicitud($_POST['fechaSolicitud']);
            $obj->setMotivo($_POST['motivo']);
            $obj->setMotivoDiferente($_POST['motivoDiferente']);
            $obj->setObservaciones($_POST['observaciones']);
            $obj->setEstatus('Aprobado');
            $obj->setPeriodoLargo('no');
            $obj->permisoAlta();

            for ($i = 1; $i <$cont+1; $i++) {
                $obj->setFechaPermiso($_POST['fechaPermiso'.$i]);
                $obj->setIdPermiso($obj->idUltimoPermiso());
                $obj->fechaPermisoAlta();
            }

            if(!$_POST['fechaReposicion1'] == ''){
                for ($i = 1; $i < $cont2+1; $i++){
                    $obj->setFechaReposicion($_POST['fechaReposicion'.$i]);
                    $obj->setIdPermiso($obj->idUltimoPermiso());
                    $obj->fechaReposicionAlta();
                }
            }

            $obj->setIdFalta($obj->idUltimoPermiso());

            ?>
            <div class="container">
                <br>
                <center>
                    <a href="permisoPDF.php?id=<?php echo $obj->getIdFalta(); ?>" class="btn btn-success" target="_blank">Descargar PDF</a>
                    <a href="permisoAlta.php" class="btn btn-default">Crear nuevo Registro</a>
                    <a href="index.php" class="btn btn-default">Salir</a>
                </center>
            </div>
            <?php
        }
        elseif (isset($_POST['permisoModificar']))//Valida si se envía el formulario
        {
            include 'permiso.php';
            $falta = new permiso();

            $cont= $_POST['numP'];
            $cont2= $_POST['numR'];
            $falta ->setIdFalta($_POST['IdFalta']);
            $falta ->setIdEmpleado($_POST['IdEmpleado']);
            $falta ->setIdJefeInmediato($_POST['IdJefeInmediato']);
            $falta ->setFechaSolicitud($_POST['fechaSolicitud']);
            $falta ->setMotivo($_POST['motivo']);
            $falta ->setMotivoDiferente($_POST['motivoDiferente']);
            $falta ->setObservaciones($_POST['observaciones']);
            $falta ->setEstatus($_POST['estatus']);
            $falta ->permisoModificarGuardar();

            for ($i = 1; $i <$cont+1; $i++) {
                $falta->setFechaPermiso($_POST['fechaPermiso'.$i]);
                $falta->setIdPermiso($_POST['IdFalta']);
                $falta->fechaPermisoGuardar();
            }

            for ($i = 1; $i <$cont2+1; $i++) {
                $falta->setFechaReposicion($_POST['fechaReposicion'.$i]);
                $falta->setIdPermiso($_POST['IdFalta']);
                $falta->fechaReposicionGuardar();
            }

            $contN= $_POST['numPN'];
            $cont2N= $_POST['numRN'];

            if(!$_POST['fechaPermisoN1'] == ''){
                for ($i = 1; $i < $contN+1; $i++) {
                    $falta->setFechaPermisoN($_POST['fechaPermisoN'.$i]);
                    $falta->setIdPermiso($_POST['IdFalta']);
                    $falta->fechaPermisoNueva();
                }
            }

            if(!$_POST['fechaReposicionN1'] == ''){
                for ($i = 1; $i < $cont2N+1; $i++){
                    $falta->setFechaReposicionN($_POST['fechaReposicionN'.$i]);
                    $falta->setIdPermiso($_POST['IdFalta']);
                    $falta->fechaReposicionNueva();
                }
            }
        ?>
            <div class="container">
                <br><br><center><img class="img-responsive" src="images/check.png" style="width:15%">
                <br><p class="text-success text-center text-uppercase">La información se guardó correctamente</p></center>
            </div>
            <div class="container">
                <br>
                <center><a href="permisoConsulta.php" class="btn btn-default">Regresar</a>
                <a href="index.php" class="btn btn-default">Salir</a></center>
            </div>
        <?php
        }
        ?>
    </body>
</html>
