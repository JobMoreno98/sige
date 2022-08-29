<!DOCTYPE html>
<?php
include './loginSecurity.php';
if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'Encargado Almacén' and $_SESSION['privilegios'] != 'RH-Almacen') {
    header('location: index.php');       
}
include 'compra.php';
$obj = new compra();
$obj->setIdEntrega($_GET['id']);
$obj->setIdCompra($_GET['idC']);
$obj->setTipoCompra($_GET['t']);

$datosEntrega = $obj->consultaDatosEntrega();
$materialEntrada = $obj->consultaEntradaMaterial(); 
$tablaMaterial = $obj->consultaCompraMaterialSinSurtir();
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
        <style>
            .form-control {
                margin-bottom: 12px;
            }
        </style>
        <script>
            //Toma el número de artículos de la compra
            var cont = <?php if (is_array($materialEntrada)) {
                                echo count($materialEntrada);   
                           } else {
                               echo 0;
                           }
                        ?>;
            
            $(document).ready(function() {
                //Activa el botón de Eliminar todos los artículos
                $('#seleccionarTodo').click(function() {
                    var num = cont+1;
                    for (var i = 1; i < num; i++) {
                        $('#eliminar' + i).prop("checked", true);
                        $('#cantidad' + i).prop("disabled", true);
                    }
                });
                
                //Activa el botón para bloquear todos los artículos y no se modifiquen
                $('#RestablecerTodo').click(function() {
                    var num = cont+1;
                    for (var i = 1; i < num; i++) {
                        $('#bloquear' + i).prop("checked", true);
                        $('#cantidad' + i).prop("disabled", true);
                    }
                });
                
                //contAgregar almacena el número artículos para agregar a entrega
                var contAgregar = cont + <?php if (is_array($tablaMaterial)) {
                                                    echo count($tablaMaterial);   
                                               } else {
                                                   echo 0;
                                               } 
                                          ?>;
                
                //Desbloquea los campos para agregar nuevos artículos a la compra
                $('#agregarArticulos').change(function() {
                    var inicio = cont+1;
                    var fin = contAgregar;
                    if($(this).is(":checked")) {
                        for (var i = inicio; i <= fin; i++) {
                         $('#num'+i).prop('disabled', false);
                         $('#num'+i).prop('readonly', true);
                         $('#idMaterial'+i).prop('disabled', false);
                         $('#idMaterial'+i).attr('readonly', true);
                         $('#cantidadCompra'+i).prop('disabled', false);
                         $('#cantidadCompra'+i).prop('readonly', true);
                         $('#cantidadRecibida'+i).prop('disabled', false);
                         $('#cantidadRecibida'+i).prop('readonly', true);
                         $('#cantidad'+i).prop('disabled', false);
                         $('#sinFecha'+i).prop('disabled', false);
                        }
                    } else {
                        for (var i = inicio; i <= fin; i++) {
                         $('#num'+i).prop('disabled', true);
                         $('#idMaterial'+i).prop('disabled', true);
                         $('#cantidadCompra'+i).prop('disabled', true);
                         $('#cantidadRecibida'+i).prop('disabled', true);
                         $('#cantidad'+i).prop('disabled', true);
                         $('#sinFecha'+i).prop('checked', false);
                         $('#sinFecha'+i).prop('disabled', true);
                         $('#fechaCaducidad'+i).prop('disabled', true);
                        }
                    }
                });
                
                //Activa los globos de ayuda
                $('[data-toggle="tooltip"]').tooltip();
            });
            
            //Activa la modificación del artículo seleccionado
            function activarCaja(e, t) {
                if (t.is(':checked')) {
                  $(e).removeAttr('disabled');
                  
                } else {
                  $(e).attr('disabled', true);
                }
            }
            
            //Bloquea la modificación del artículo seleccionado para no hacer cambios o eliminar el artículo
            function desactivarCaja(e, t) {
                if (t.is(':checked')) {
                  $(e).attr('disabled', true);
                } else {
                    $(e).removeAttr('disabled');
                }
            }
            
            //Activa el campo para ingresar la fecha de caducidad manualmente en un nuevo artículo
            function activarFechaCaducidad(e, t) {
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
        ?>
        <div class="container">
            <div class="page-header">
                <h3 style="text-align: center">Editar Entrega</h3>
            </div>
            
            <form action="aplicarMovimiento.php" class="form-horizontal" method="post"
                  onsubmit="return confirm('¿Seguro que quieres guardar este formulario?');">
                
                <input type="hidden" name="idCompra" value="<?php echo $obj ->getIdCompra(); ?>">
                <input type="hidden" name="idEntrega" value="<?php echo $obj ->getIdEntrega(); ?>">
                <input type="hidden" name="tipo" value="<?php echo $obj ->getTipoCompra(); ?>">
                
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                          <tr>
                            <th style="text-align: center">Folio Entrega</th>
                            <th style="text-align: center">Fecha</th>
                            <th style="text-align: center">Entregó del Proveedor</th>
                            <th style="text-align: center">Recibió</th>
                          </tr>
                        </thead>
                        <tbody align="center">
                          <tr>
                              <td><?php echo $obj->getIdEntrega(); ?></td>
                              <td><?php print_r($datosEntrega[0][0]); ?></td>
                              <td><?php print_r($datosEntrega[0][1]); ?></td>
                              <td><?php print_r($datosEntrega[0][2]); ?></td>
                              <td>
                                <p class="text-danger">
                                    <label class="checkbox-inline" data-toggle="tooltip" title="También debes de eliminar todos los artículos">
                                        <input type="checkbox" name="eliminarEntrega">Eliminar Entrega
                                    </label>
                                </p>
                              </td>
                          </tr>
                        </tbody>
                    </table>
                </div>
                <br>
                
               <?php
               if (is_array($materialEntrada)) {
                   ?>
                    <hr>
                    <div class="form-group">
                        <div class="col-0 col-sm-8 col-md-8 col-lg-9 pull-left"></div>
                        <div class="col-12 col-sm-4 col-md-4 col-lg-3 pull-right">
                            <button type="button" class="btn btn-default" id="RestablecerTodo">Restablecer</button>
                            <button type="button" class="btn btn-danger pull-right" id="seleccionarTodo">Eliminar todo</button>
                        </div>
                    </div>

                    <div class="form-group">    
                        <?php 
                        for ($i = 0; $i < count($materialEntrada); $i++) {
                            $bandera = $i + 1;
                            ?>
                            <div class="col-xs-12 col-sm-1 col-md-1">
                                <input class="form-control" type="number" name="num" value="<?php echo $bandera; ?>" readonly>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <select class="form-control" name="idMaterial<?php echo $bandera; ?>" readonly>
                                    <option value="<?php print_r($materialEntrada[$i][0]); ?>"><?php print_r($materialEntrada[$i][1]); ?> \ Id: <?php print_r($materialEntrada[$i][0]); ?>  \ Fecha Caducidad: <?php print_r($materialEntrada[$i][2]); ?></option>
                                </select>
                            </div>
                            <div class="col-xs-12 col-sm-1 col-md-1">
                                <p class="text-primary">
                                    <label class="radio-inline">
                                        <input type="radio" id="bloquear<?php echo $bandera; ?>" name="radioEditar<?php echo $bandera; ?>" value="bloquear" onclick="desactivarCaja(cantidad<?php echo $bandera; ?>, $(this));" checked>Bloquear
                                    </label>
                                </p>
                            </div>
                            <div class="col-xs-12 col-sm-1 col-md-1">
                                <p class="text-warning">
                                    <label class="radio-inline">
                                        <input type="radio" id="modificar<?php echo $bandera; ?>" name="radioEditar<?php echo $bandera; ?>"  value="modificar" onclick="activarCaja(cantidad<?php echo $bandera; ?>, $(this));">Modificar
                                    </label>
                                </p>    
                            </div>
                            <div class="col-xs-12 col-sm-2 col-md-2">
                                <input class="form-control" type="number" id="cantidad<?php echo $bandera; ?>" name="cantidad<?php echo $bandera; ?>" value="<?php print_r($materialEntrada[$i][3]); ?>"  min="1" max="100000" placeholder="Cantidad en Factura" required="number" disabled>
                            </div>
                            <div class="col-xs-12 col-sm-1 col-md-1">
                                <p class="text-danger">
                                    <label class="radio-inline" data-toggle="tooltip" title="El artículo de de tener cero entregas recibidas para poder eliminar">
                                        <input type="radio" id="eliminar<?php echo $bandera; ?>" name="radioEditar<?php echo $bandera; ?>" value="eliminar" onclick="desactivarCaja(cantidad<?php echo $bandera; ?>, $(this));">Eliminar Artículo
                                    </label>
                                </p>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <?php   
                    if (is_array($tablaMaterial)) {
                        ?>
                        <hr>    
                        <p class="text-success">
                            <label class="checkbox-inline" data-toggle="tooltip" title="Solo puedes agregar artículos de la compra que no estén recibidos por completo">
                                <input type="checkbox" id="agregarArticulos" name="agregarArticulos">Agregar artículo(s) a entrega
                            </label>
                        </p>  
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                  <tr>
                                    <th>Número</th>
                                    <th>Material</th>
                                    <th>Cant. en Factura</th>
                                    <th>Cant. Entregada</th>
                                    <th>Cant. Nueva</th>
                                    <th>Caducidad</th>
                                    <th></th>
                                  </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $cont = count($materialEntrada)+1;
                                    
                                    for ($i = 0; $i < count($tablaMaterial); $i++) {
                                        $restaMaterial = ($tablaMaterial[$i][2]) - ($tablaMaterial[$i][3]);
                                        ?>
                                        <tr>
                                            <td>
                                                <input type="number" class="form-control" name="numNuevo" id="num<?php echo $cont; ?>" value="<?php echo $cont; ?>" disabled>
                                            </td>
                                            <td>
                                                <select class="form-control" name="idMaterial<?php echo $cont; ?>" id="idMaterial<?php echo $cont; ?>" disabled>
                                                    <option value="<?php print_r($tablaMaterial[$i][0]); ?>"><?php print_r($tablaMaterial[$i][1]); ?> \ Id: <?php print_r($tablaMaterial[$i][0]); ?></option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" id="cantidadCompra<?php echo $cont; ?>" value="<?php print_r($tablaMaterial[$i][2]); ?>" disabled>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" id="cantidadRecibida<?php echo $cont; ?>" value="<?php print_r($tablaMaterial[$i][3]); ?>" disabled>
                                            </td>    
                                            <td>
                                                <input type="number" class="form-control" name="cantidad<?php echo $cont; ?>" id="cantidad<?php echo $cont; ?>" min="0" max="<?php echo $restaMaterial; ?>"
                                                       required="number" data-toggle="tooltip" title="Ingresar 0 si no se recibe el material" disabled>
                                            </td>
                                            <td>
                                                <label class="checkbox-inline" id="chkboxFecha" data-toggle="tooltip" title="Seleccionar si el material tiene fecha de caducidad">
                                                    <input type="checkbox" id="sinFecha<?php echo $cont; ?>" onclick="activarFechaCaducidad(fechaCaducidad<?php echo $cont; ?>, $(this));" disabled>F.Cad.
                                                </label>
                                            </td>
                                            <td>
                                                <input id="fechaCaducidad<?php echo $cont; ?>" type="date" class="form-control" name="fechaCaducidad<?php echo $cont; ?>" required disabled>
                                            </td>
                                        </tr>    
                                        <?php
                                        $cont++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <?php
                    }
               } else {
                   ?><div class="alert alert-info"><center>La entrega no cuenta con artículos para mostrar</center></div><?php
               }
               ?>
               
                <div class="form-group">
                    <div class="col-xs-12 col-sm-8 col-md-9">
                        <button type="submit" class="btn btn-success" name="entregaEditar">Guardar Cambios</button>
                        <a href="compraEditar.php?id=<?php echo $obj->getIdCompra(); ?>" class="btn btn-primary">Volver a Compra</a>
                        <a href="compraConsulta.php?tipo=<?php echo $obj->getTipoCompra(); ?>" class="btn btn-default">Volver a Consulta</a>
                        <a href="index.php" class="btn btn-default">Salir</a> 
                    </div>
                </div>

            </form> 
        </div>
        <br>
    </body>
</html>
