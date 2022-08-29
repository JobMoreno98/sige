<!DOCTYPE html>
<?php
include './loginSecurity.php';
if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'Encargado Almacén' and $_SESSION['privilegios'] != 'RH-Almacen') {
    header('location: index.php');       
}
include 'compra.php';
$obj = new compra();
$obj->setIdCompra($_GET['id']);

$datosCompra = $obj->consultaDetalleCompra();
$arregloConEntr = $obj->entregaConsulta();
$materialCompra = $obj->consultaCompraMaterial(); 
$obj->setTipoCompra($datosCompra[0][2]);
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
            
            hr {
                display: block;
                margin-top: 0.5em;
                margin-bottom: 0.5em;
                margin-left: auto;
                margin-right: auto;
                border: 0.5px solid #eee;
            }
        </style>
        <script>
            //Toma el número de artículos de la compra
            var cont = <?php if (is_array($materialCompra)) {
                                echo count($materialCompra);   
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
                
                //contAgregar va almacenando el número del último artículo para agregar a compra
                var contAgregar = cont + 1;
                
                //Desbloquea los campos para agregar nuevos artículos a la compra
                $('#agregarArticulos').change(function() {
                    var inicio = cont+1;
                    var fin = contAgregar+1;
                    if($(this).is(":checked")) {
                        for (var i = inicio; i < fin; i++) {
                         $('#num'+i).prop('disabled', false);
                         $('#num'+i).prop('readonly', true);
                         $('#idMaterial'+i).prop('disabled', false);
                         $('#cantidad'+i).prop('disabled', false);
                        }
                        $('#btnAdd').removeAttr("disabled");
                        if(fin >(inicio+1))  {
                            $('#btnDel').removeAttr("disabled");
                        }
                    } else {
                        for (var i = inicio; i < fin; i++) {
                         $('#num'+i).prop('disabled', true);
                         $('#idMaterial'+i).prop('disabled', true);
                         $('#cantidad'+i).prop('disabled', true);
                        }
                        $('#btnDel').attr('disabled','disabled');
                        $('#btnAdd').attr('disabled','disabled');
                    }
                });
                
                //Duplica los campos para agregar mas artículos
                $('#btnAdd').click(function() {
                    var newNum = new Number(contAgregar+1); // the numeric ID of the new input field being added
                    var newElem = $('#campo1').clone().attr('id', 'Add' + newNum);// create the new element via clone(), and manipulate it's ID using newNum value
                    newElem.children(':last').attr('id', 'num' + newNum).attr('name', 'numNuevo').val(newNum);// manipulate the name/id values of the input inside the new element
                    $('#copiaNueva').before(newElem); // insert the new element after the last "duplicatable" input field
                    $('#btnDel').attr('disabled',false);// enable the "remove" button
                    if (newNum == 100)//     business rule
                      $('#btnAdd').attr('disabled','disabled');
                });

                $('#btnAdd').click(function() {
                    var newNum = new Number(contAgregar+1);
                    var newElem = $('#campo2').clone().attr('id', 'Add' + newNum);
                    newElem.children(':last').attr('id', 'idMaterial' + newNum).attr('name', 'idMaterial' + newNum);
                    $('#copiaNueva').before(newElem);
                    $('#idMaterial'+newNum).focus();//enfoca el articulo al clonar
                });

                $('#btnAdd').click(function() {
                    var newNum = new Number(contAgregar+1);
                    var newElem = $('#campo3').clone().attr('id', 'Add' + newNum);
                    newElem.children(':last').attr('id', 'cantidad' + newNum).attr('name', 'cantidad' + newNum).val('');
                    $('#copiaNueva').before(newElem);
                    contAgregar=contAgregar+1;
                });
                
                //Elimina el último campo de los nuevos artículos a agregar
                $('#btnDel').click(function() {
                    var num = contAgregar; // how many "duplicatable" input fields we currently have
                    $('#num' + num).remove(); // remove the last element
                    $('#idMaterial' + num).remove(); // remove the last element
                    $('#cantidad' + num).remove(); // remove the last element
//                     enable the "add" button
                    $('#btnAdd').attr('disabled',false);
                    if (num == cont+2)
                      $('#btnDel').attr('disabled','disabled');
                    contAgregar=contAgregar-1;
                    $('#idMaterial'+contAgregar).focus();
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
            
        </script>    
    </head>
    <body>
        <?php 
        include 'barraMenu.php';
        $menu = new menu();
        $menu ->barraMenu();
        ?>
        <div class="container">
            <div class="page-header">
                <h3 style="text-align: center">Editar Compra<small> Factura</small></h3>
            </div>
            
            <form action="aplicarMovimiento.php" class="form-horizontal" method="post"
                  onsubmit="return confirm('¿Seguro que quieres guardar este formulario?');">
                
                <input type="hidden" name="idCompra" value="<?php echo $obj ->getIdCompra(); ?>">
                <input type="hidden" name="tipo" value="<?php echo $obj ->getTipoCompra(); ?>">
                
                
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                          <tr>
                            <th style="text-align: center">Folio Compra</th>
                            <th style="text-align: center">Fecha</th>
                            <th style="text-align: center">Tipo</th>
                            <th style="text-align: center">Recibió</th>
                            <th style="text-align: center">Proveedor</th>
                          </tr>
                        </thead>
                        <tbody align="center">
                          <tr>
                              <td><?php print_r($datosCompra[0][0]); ?></td>
                              <td><?php print_r($datosCompra[0][1]); ?></td>
                              <td><?php print_r($datosCompra[0][2]); ?></td>
                              <td><?php print_r($datosCompra[0][3]); ?></td>
                              <td><?php print_r($datosCompra[0][4]); ?></td>
                              <td>
                                <p class="text-danger">
                                    <label class="checkbox-inline" data-toggle="tooltip" title="También debes de eliminar todos los artículos y las entregas parciales">
                                        <input type="checkbox" name="eliminarCompra">Eliminar Compra
                                    </label>
                                </p>
                              </td>
                          </tr>
                        </tbody>
                    </table>
                </div>
                <hr>
                <br>
                <h4 style="text-align: center">Entregas Parciales</h4>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                          <tr>
                            <th style="text-align: center">Num.</th>
                            <th style="text-align: center">Folio Entrega</th>
                            <th style="text-align: center">Fecha</th>
                            <th style="text-align: center">Entregó del Proveedor</th>
                            <th style="text-align: center">Recibió</th>
                            <th style="text-align: center"></th>
                          </tr>
                        </thead>
                        <tbody align="center">
                          <?php 
                        if (is_array($arregloConEntr)) {
                            for ($i = 0; $i < count($arregloConEntr); $i++) {
                                ?>
                                <tr>
                                    <td><?php print_r($arregloConEntr[$i][0]); ?></td>
                                    <td><?php print_r($arregloConEntr[$i][1]); ?></td>
                                    <td><?php print_r($arregloConEntr[$i][2]); ?></td>
                                    <td><?php print_r($arregloConEntr[$i][3]); ?></td>
                                    <td><?php print_r($arregloConEntr[$i][4]); ?></td>
                                    <td><a href="entregaEditar.php?id=<?php print_r($arregloConEntr[$i][1]); ?>&idC=<?php print_r($obj->getIdCompra()); ?>&t=<?php print_r($obj->getTipoCompra()); ?>"
                                         class="btn btn-warning" role="button">Editar</a></td>
                                </tr>    
                                <?php
                            }
                        } 
                        ?>
                        </tbody>
                    </table>
                </div>
                <br>
                
               <?php
               if (is_array($materialCompra)) {
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
                        for ($i = 0; $i < count($materialCompra); $i++) {
                            $bandera = $i + 1;

                            echo '
                            <div class="col-xs-12 col-sm-1 col-md-1">
                                <input class="form-control" type="number" name="num" value="'.$bandera.'" readonly>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <select class="form-control" name="idMaterial'.$bandera.'" readonly>
                                    <option value="'. $materialCompra[$i][0] .'">'. $materialCompra[$i][1] .' \ Id: '. $materialCompra[$i][0] .' \ Estado: '. $materialCompra[$i][4] .' \ Catidad Recibida: '. $materialCompra[$i][3] .'</option>
                                </select>
                            </div>
                            <div class="col-xs-12 col-sm-1 col-md-1">
                                <p class="text-primary">
                                    <label class="radio-inline">
                                        <input type="radio" id="bloquear'.$bandera.'" name="radioEditar'.$bandera.'" value="bloquear" onclick="desactivarCaja(cantidad'.$bandera.', $(this));" checked>Bloquear
                                    </label>
                                </p>
                            </div>
                            <div class="col-xs-12 col-sm-1 col-md-1">
                                <p class="text-warning">
                                    <label class="radio-inline">
                                        <input type="radio" id="modificar'.$bandera.'" name="radioEditar'.$bandera.'"  value="modificar" onclick="activarCaja(cantidad'.$bandera.', $(this));">Modificar
                                    </label>
                                </p>    
                            </div>
                            <div class="col-xs-12 col-sm-2 col-md-2">
                                <input class="form-control" type="number" id="cantidad'.$bandera.'" name="cantidad'.$bandera.'" value="'. $materialCompra[$i][2] .'"  min="1" max="100000" placeholder="Cantidad en Factura" required="number" disabled>
                            </div>
                            <div class="col-xs-12 col-sm-1 col-md-1">
                                <p class="text-danger">
                                    <label class="radio-inline" data-toggle="tooltip" title="El artículo de de tener cero entregas recibidas para poder eliminar">
                                        <input type="radio" id="eliminar'.$bandera.'" name="radioEditar'.$bandera.'" value="eliminar" onclick="desactivarCaja(cantidad'.$bandera.', $(this));">Eliminar Artículo
                                    </label>
                                </p>
                            </div>
                            ';
                        }
                        ?>
                    </div>
                    <?php
                    $j = count($materialCompra)+1;
                    ?>
                    <hr>
                    <div class="form-group">
                        
                        <p class="text-success">
                            <label class="checkbox-inline" data-toggle="tooltip" title="Al ingresar los artículos deberas de editar la entrega parcial donde se recibieron">
                                <input type="checkbox" id="agregarArticulos" name="agregarArticulos">Agregar artículo(s) a compra
                            </label>
                        </p><br>    
                        <?php
                        echo '    
                        <div id="campo1" class="col-xs-12 col-sm-2 col-md-1">
                            <input class="form-control" id="num'.$j.'" type="number" name="numNuevo" value="'.$j.'" disabled>
                        </div>
                        <div id="campo2" class="col-xs-12 col-sm-8 col-md-8">
                            <select class="form-control" id="idMaterial'.$j.'" name="idMaterial'.$j.'" autofocus required disabled>
                                <option value="" disabled selected>Artículo</option>'; 
                        $obj->consultaMaterialAlmacen();
                        echo '
                            </select>
                        </div>
                        <div id="campo3" class="col-xs-12 col-sm-2 col-md-3">
                            <input class="form-control" type="number" id="cantidad'.$j.'" name="cantidad'.$j.'"  min="1" max="100000" placeholder="Cantidad en Factura" required="number" disabled>
                        </div>
                        ';
                        ?>
                        <div id="copiaNueva"></div>
                    </div>

                    <div class="form-group">
                        <div class="col-0 col-sm-10 col-md-10 col-lg-11"></div>
                        <div class="col-12 col-sm-2 col-md-2 col-lg-1">
                            <button type="button" class="btn btn-default pull-left" id="btnAdd" disabled>+</button>
                            <button type="button" class="btn btn-default pull-right" id="btnDel" disabled>-</button>
                        </div>
                    </div>
                <?php
               } else {
                   ?><div class="alert alert-info"><center>La compra no cuenta con artículos para mostrar</center></div><?php
               }
               ?>
               
                <div class="form-group">
                    <div class="col-xs-12 col-sm-8 col-md-9">
                        <button type="submit" class="btn btn-success" name="compraEditar">Guardar Cambios</button>
                        <a href="compraConsulta.php?tipo=<?php echo $obj->getTipoCompra(); ?>" class="btn btn-primary">Volver a Consulta</a>
                        <a href="index.php" class="btn btn-default">Salir</a> 
                    </div>
                </div>

            </form> 
        </div> 
        <br>
    </body>
</html>
