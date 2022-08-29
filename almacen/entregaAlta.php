<!DOCTYPE html>
<?php
 include './loginSecurity.php';
     if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'Encargado Almacén' and $_SESSION['privilegios'] != 'RH-Almacen') {
    header('location: index.php');
}
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
        <script>
            $(document).ready(function() {
                $('[data-toggle="tooltip"]').tooltip();
            });
            
            function boxDisable(e, t) {
                if (t.is(':checked')) {
                  $(e).removeAttr('disabled');
                  
                } else {
                  $(e).attr('disabled', true);
                }
            }
        </script>
    </head>
    <body>
        <?php 
        include 'barraMenu.php';
        $menu = new menu();
        $menu ->barraMenu();
        date_default_timezone_set("America/Mexico_City");

        include 'compra.php';
        $obj = new compra();
        $obj->setIdCompra($_GET['id']);
        $obj->setTipoCompra($_GET['t']);
        $tablaMaterial = $obj->tablaEntradaMaterial();
        ?>
        <div class="container">
            <div class="page-header">
                <h3 style="text-align: center">Entrega Parcial de Compra</h3>
            </div>
            
            <form action="aplicarMovimiento.php" class="form-horizontal" method="post"
                  onsubmit="return confirm('¿Seguro que quieres guardar este formulario?');">
                

                    <div class="input-group">
                        <span class="input-group-addon">Fecha</span>
                        <input type="date" class="form-control" name="fechaEntrega" value="<?php echo date("Y-m-d");?>" readonly>

                        <span class="input-group-addon">Núm. Folio Compra</span>
                        <input type="number" class="form-control" name="idCompra" value="<?php echo $obj->getIdCompra(); ?>" readonly>

                        <span class="input-group-addon">Proveedor</span>
                        <input type="text" class="form-control" value="<?php echo $obj->consultaProveedorCompra(); ?>" readonly>
                    </div>
                    <br>


                    <div class="form-group">
                        <div class="col-xs-12 col-md-6">
                            <label for="idEmpleado">Recibió Material</label>
                        <!--<input class="form-control" id="idEmpleado" type="text" value="x" readonly>-->
                            <select class="form-control" id="idEmpleado" name="idEmpleado">
                                <?php $obj->consultanombreEmpleado(); ?>
                            </select>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <label for="personaEntrega">Entregó del Proveedor</label>
                            <input class="form-control" type="text" id="personaEntrega" name="personaEntrega" placeholder="Personal Proveedor" required>
                        </div>
                    </div>
                    
                    
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                              <tr>
                                <th>Número</th>
                                <th>Material</th>
                                <th>Cant. en Factura</th>
                                <th>Cant. Entregada</th>
                                <th>Nueva Entrega</th>
                                <th>Caducidad</th>
                                <th></th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php 
                                for ($i = 0; $i < count($tablaMaterial); $i++) {
                                    $cont = $i + 1;
                                    $restaMaterial = ($tablaMaterial[$i][2]) - ($tablaMaterial[$i][3]);
                                    ?>
                                    <tr>
                                        <td><input type="number" class="form-control" name="num" value="<?php echo $cont; ?>" readonly></td>
                                        <td><select class="form-control" name="idMaterial<?php echo $cont; ?>" readonly><option value="<?php print_r($tablaMaterial[$i][0]); ?>"><?php print_r($tablaMaterial[$i][1]); ?> \ Id: <?php print_r($tablaMaterial[$i][0]); ?></option></select></td>
                                        <td><input type="number" class="form-control" value="<?php print_r($tablaMaterial[$i][2]); ?>" readonly></td>
                                        <td><input type="number" class="form-control" value="<?php print_r($tablaMaterial[$i][3]); ?>" readonly></td>    
                                    <?php
                                    if($restaMaterial == 0) {
                                        ?>
                                        <td><input type="number" class="form-control" placeholder="-" readonly></td><td></td><td></td>
                                        </tr>
                                        <?php
                                    } else {
                                        ?>
                                        <td><input type="number" name="cantidad<?php echo $cont; ?>" class="form-control" min="0" max="<?php echo $restaMaterial; ?>" required="number"
                                            data-toggle="tooltip" title="Ingresar 0 si no se recibe el material"></td>
                                        <td><label class="checkbox-inline" id="chkboxFecha" data-toggle="tooltip" title="Seleccionar si el material tiene fecha de caducidad">
                                                <input type="checkbox" id="sinFecha" onclick="boxDisable(fechaCaducidad<?php echo $cont; ?>, $(this));">F.Cad.
                                            </label></td>
                                        <td><input id="fechaCaducidad<?php echo $cont; ?>" type="date" class="form-control" name="fechaCaducidad<?php echo $cont; ?>" required disabled></td>
                                        </tr>    
                                        <?php
                                    }
                                }
                              ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12 col-sm-8 col-md-9">
                            <button type="submit" class="btn btn-primary" name="entregaAlta">Guardar</button>
                            <a href="compraConsulta.php?tipo=<?php echo $obj->getTipoCompra(); ?>" class="btn btn-default">Volver a Consulta</a>
                            <a href="index.php" class="btn btn-default">Salir</a> 
                        </div>
                    </div>

                </form> 
        </div>  
    </body>
</html>
