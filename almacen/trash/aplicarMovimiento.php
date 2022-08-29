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
        <meta name="author" content="Valentín Camacho Veloz, Daniel Flores Rodriguez, Brian Valentín Franco, Nancy García Mesillas">
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


    //        agregar pdf 
            $obj->compraAlta();
            $obj->setIdCompra($obj->consultaIdCompra());

            
            $obj->primerEntregaAlta();
            $obj->setIdEntrega($obj->consultaIdEntrega());
            
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
        }
        elseif (isset($_POST['empleadoAlta']))//Valida si se envía el formulario
        {
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
            $empleados ->empleadoAlta();
        ?>
            <div class="container">
                <br>
                <center><a href="empleadoAlta.php" class="btn btn-default">Crear nuevo Registro</a>
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

            
            $obj->entregaAlta();
            $obj->setIdEntrega($obj->consultaIdEntrega());

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
                    <br><br><center><img class="img-responsive" src="img/check.png" style="width:15%">
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
            
             $cont= $_POST['num'];
            $obj->setTipo($_POST['tipo']);
            $obj->setFolio($obj->consultafolioRequisicion());
            $obj->setFechaRequisicion($_POST['fechaRequisicion']);
            $obj->setIdEmpleado($_POST['idEmpleado']);
            $obj->setResponsableAlmacen('Pendiente por asignar');
            $obj->setIdArea($_POST['idArea']);
            $obj->requisicionAlta();
            $obj->setIdRequisicion($obj->consultaIdRequisicion());
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
                    <a href="requisicionAlta.php?tipo=<?php echo $obj->getTipo(); ?>" class="btn btn-default">Nueva requisición</a>
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
            $obj->setFolio($obj->consultafolioRequisicion());
            $obj->setFechaRequisicion($_POST['fechaRequisicion']);
            $obj->setIdEmpleado($_POST['idEmpleado']);
            $obj->setResponsableAlmacen($_POST['responsableAlmacen']);
            $obj->setIdArea($_POST['idArea']);
            $obj->requisicionAlta();
            $obj->setIdRequisicion($obj->consultaIdRequisicion());
            $obj->setEstado('Autorizado');

            for ($i = 1; $i < $cont+1; $i++) {
                $obj->setIdMaterial($_POST['idMaterial'.$i]);
                $obj->setCantidad($_POST['cantidad'.$i]);
                $obj->requisicionMaterialAlta();
                
                $obj->salidaMaterialSurtirEntregado();
                
                $estad = $obj->consultaEstadoRequisicion();
                if ($estad == 'Surtido') 
                {
                    $obj->setEstado($estad);
                    $obj->salidaMaterialProcedure();
                }
            }
        ?>
            <div class="container">
                <br>
                <center>
                    <a href="requisicionPDF.php?id=<?php echo $obj->getIdRequisicion(); ?>" class="btn btn-success" target="_blank">Descargar PDF</a>
                    <a href="requisicionAltaEntregado.php?tipo=<?php echo $obj->getTipo(); ?>" class="btn btn-default">Nueva requisición</a>
                    <a href="index.php" class="btn btn-default">Salir</a></center>
            </div>
        <?php
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
                <br><br><center><img class="img-responsive" src="img/check.png" style="width:15%">
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
                . '<br><center><img class="img-responsive" src="img/check.png" style="width:15%">'
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
            include 'horario.php';
            $obj = new horario();
            $obj ->setEntradaLunVie($_POST['entradaLunVie']);
            $obj ->setSalidaLunVie($_POST['salidaLunVie']);
            $obj ->setEntradaSabDom($_POST['entradaSabDom']);
            $obj ->setSalidaSabDom($_POST['salidaSabDom']);
            $obj ->setEntradaVacaciones($_POST['entradaVacaciones']);
            $obj ->setSalidaVacaciones($_POST['salidaVacaciones']);
            $obj ->setComentarios($_POST['comentarios']);
            $obj ->setCodigo($_POST['codigo']);
            $numero = $obj ->consultaPersonalConHorario();
            if ($numero == 0) {
               $obj ->horarioAlta(); 
            }
             else 
            {
                 ?>
                <br>
                <br>
                <div class="container">
                    <p class="bg-danger">El personal ingresado ya tiene horario registrado, intente de nuevo.</p>
                </div>
                <?php
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
            include 'horario.php';
            $obj = new horario();
            $obj ->setEntradaLunVie($_POST['entradaLunVie']);
            $obj ->setSalidaLunVie($_POST['salidaLunVie']);
            $obj ->setEntradaSabDom($_POST['entradaSabDom']);
            $obj ->setSalidaSabDom($_POST['salidaSabDom']);
            $obj ->setEntradaVacaciones($_POST['entradaVacaciones']);
            $obj ->setSalidaVacaciones($_POST['salidaVacaciones']);
            $obj ->setComentarios($_POST['comentarios']);
            $obj ->setIdHorario($_POST['idHorario']);
            $obj ->horarioModificar();        
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
                <br><br><center><img class="img-responsive" src="img/check.png" style="width:15%">
                <br><p class="text-success text-center text-uppercase">La información se guardó correctamente</p></center>
            </div>
            <div class="container">
                <br>
                <center><a href="asistenciaAlta.php" class="btn btn-default">Capturar Nuevo</a>
                    <a href="index.php" class="btn btn-default">Salir</a></center>
            </div>   
            <?php
        }
        ?>
    </body>
</html>