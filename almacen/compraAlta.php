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
        <style>
            .form-control {
                margin-bottom: 12px;
            }
        </style>
        <script>
            var cont= 15;
            $(document).ready(function() {
//                $('#btnDel').attr('disabled','disabled');
                $('#btnAdd').click(function() {
                    var newNum = new Number(cont+1); // the numeric ID of the new input field being added
                    var newElem = $('#campo1').clone().attr('id', 'Add' + newNum);// create the new element via clone(), and manipulate it's ID using newNum value
                    newElem.children(':last').attr('id', 'num' + newNum).attr('name', 'num').val(newNum);// manipulate the name/id values of the input inside the new element
                    $('#copiaNueva').before(newElem); // insert the new element after the last "duplicatable" input field
                    $('#btnDel').attr('disabled',false);// enable the "remove" button
                    if (newNum == 100)//     business rule: you can only add 10 names
                      $('#btnAdd').attr('disabled','disabled');
                });

                $('#btnAdd').click(function() {
                    var newNum = new Number(cont+1);
                    var newElem = $('#campo2').clone().attr('id', 'Add' + newNum);
                    newElem.children(':last').attr('id', 'idMaterial' + newNum).attr('name', 'idMaterial' + newNum);
                    $('#copiaNueva').before(newElem);
                    $('#idMaterial'+newNum).focus();//enfoca el articulo al clonar
                });

                $('#btnAdd').click(function() {
                    var newNum = new Number(cont+1);
                    var newElem = $('#campo3').clone().attr('id', 'Add' + newNum);
                    newElem.children(':last').attr('id', 'cantidad' + newNum).attr('name', 'cantidad' + newNum).val('');
                    $('#copiaNueva').before(newElem);
                });
                
                $('#btnAdd').click(function() {
                    var newNum = new Number(cont+1);
                    var newElem = $('#campo4').clone().attr('id', 'Add' + newNum);
                    newElem.children(':last').attr('id', 'chkboxFecha' + newNum);
                    newElem.find('input:last').attr('id', 'sinFecha' + newNum).attr('onclick', 'boxDisable(fechaCaducidad'+ newNum + ', $(this))').prop('checked', false);
                    $('#copiaNueva').before(newElem);
                });
                
                $('#btnAdd').click(function() {
                    var newNum = new Number(cont+1);
                    var newElem = $('#campo5').clone().attr('id', 'Add' + newNum);
                    newElem.children(':last').attr('id', 'fechaCaducidad' + newNum).attr('name', 'fechaCaducidad' + newNum).attr('disabled', true);
                    $('#copiaNueva').before(newElem);
                });
                
                $('#btnAdd').click(function() {
                    var newNum = new Number(cont+1);
                    var newElem = $('#campo6').clone().attr('id', 'Add' + newNum);
                    newElem.children(':last').attr('id', 'chkboxEstado' + newNum);
                    newElem.find('input:last').attr('id', 'estadoMaterial' + newNum).attr('name', 'estadoMaterial' + newNum).attr('onclick', 'boxDisable2(cantidadEntrega'+ newNum + ', $(this))').prop('checked', true);
                    $('#copiaNueva').before(newElem);
                });
                
                $('#btnAdd').click(function() {
                    var newNum = new Number(cont+1);
                    var newElem = $('#campo7').clone().attr('id', 'Add' + newNum);
                    newElem.children(':last').attr('id', 'cantidadEntrega' + newNum).attr('name', 'cantidadEntrega' + newNum).val('').attr('disabled', true);
                    $('#copiaNueva').before(newElem);
//                    cont = newNum;
                    cont=cont+1;
                });
                
                $('#btnDel').click(function() {
                    var num = cont; // how many "duplicatable" input fields we currently have
                    $('#num' + num).remove(); // remove the last element
                    $('#idMaterial' + num).remove(); // remove the last element
                    $('#cantidad' + num).remove(); // remove the last element
                    $('#chkboxFecha' + num).remove(); // remove the last element
                    $('#fechaCaducidad' + num).remove(); // remove the last element
                    $('#chkboxEstado' + num).remove(); // remove the last element
                    $('#cantidadEntrega' + num).remove(); // remove the last element
//                     enable the "add" button
                    $('#btnAdd').attr('disabled',false);
                    if (num == 2)//     business rule: you can only add 10 names
                      $('#btnDel').attr('disabled','disabled');
                    cont=cont-1;
                    $('#idMaterial'+cont).focus();
                });
//                
                $('[data-toggle="tooltip"]').tooltip();
            });
            
            function boxDisable(e, t) {
                if (t.is(':checked')) {
                  $(e).removeAttr('disabled');
                  
                } else {
                  $(e).attr('disabled', true);
                }
            }
            
            function boxDisable2(e, t) {
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
        date_default_timezone_set("America/Mexico_City");

        include 'compra.php';
        $obj = new compra();
        $obj->setTipoCompra($_GET['tipo']);
        ?>
        <div class="container">
            <div class="page-header">
                <h3 style="text-align: center">Captura de Compra <?php echo $obj->getTipoCompra(); ?><small> Factura y Primera Entrega</small></h3>
            </div>
            
            <form action="aplicarMovimiento.php" class="form-horizontal" method="post"
                  onsubmit="return confirm('¿Seguro que quieres guardar este formulario?');">
                
                    <input type="hidden" name="tipo" value="<?php echo $obj ->getTipoCompra(); ?>">
                    
                    <div class="input-group">
                        <span class="input-group-addon">Fecha</span>
                        <input id="fechaRequisicion" type="date" class="form-control" name="fechaCompra" value="<?php echo date("Y-m-d");?>">

<!--                        <span class="input-group-addon">Folio</span>
                        <input id="folio" type="number" class="form-control" value="<?php // echo $obj->consultaIdCompra(); ?>" readonly>-->

                        <span class="input-group-addon">Proveedor</span>
                        <select class="form-control" id="idProveedor" name="idProveedor" required>
                            <option value="" disabled selected>Sin seleccionar</option> 
                            <?php $obj->consultaNombreProveedor(); ?>
                        </select>
                    </div>
                    <br>


                    <div class="form-group">
                        <div class="col-xs-12 col-md-5">
                            <label for="idEmpleado">Recibió Material</label>
                        <!--<input class="form-control" id="idEmpleado" type="text" value="x" readonly>-->
                            <select class="form-control" id="idEmpleado" name="idEmpleado">
                                <?php $obj->consultanombreEmpleado(); ?>
                            </select>
                        </div>
                        <div class="col-xs-12 col-md-5">
                            <label for="personaEntrega">Entregó del Proveedor</label>
                            <input class="form-control" type="text" id="personaEntrega" name="personaEntrega" placeholder="Personal Proveedor" required>
                        </div>
                        <div class="checkbox col-xs-12 col-md-2">
                            <center><label data-toggle="tooltip" data-placement="right" title="Selecciona si la compra es un pedido especial">
                                <input type="checkbox" name="pedidoEspecial" value="1">Pedido especial
                                </label></center>
                        </div>
                    </div>

                    <div class="form-group">
            <?php 
                    for ($i = 1; $i < 16; $i++) 
                    {
                        echo '
                        <div id="campo1" class="col-xs-12 col-sm-3 col-md-1">
                            <input class="form-control" id="num'.$i.'" type="number" name="num" value="'.$i.'" readonly>
                        </div>
                        <div id="campo2" class="col-xs-12 col-sm-6 col-md-3">
                            <select class="form-control" id="idMaterial'.$i.'" name="idMaterial'.$i.'" autofocus required>
                                <option value="" disabled selected>Artículo</option>'; 
                        $obj->consultaMaterialAlmacen();
                        echo '
                           </select>
                        </div>
                        <div id="campo3" class="col-xs-12 col-sm-3 col-md-2">
                            <input class="form-control" type="number" id="cantidad'.$i.'" name="cantidad'.$i.'"  min="1" max="1000000" placeholder="Cantidad compra" required="number">
                        </div>
                        <div id="campo4" class="col-xs-12 col-sm-3 col-md-1">
                            <label class="checkbox-inline" id="chkboxFecha'.$i.'" data-toggle="tooltip" title="Seleccionar si el material tiene caducidad">
                            <input type="checkbox" id="sinFecha'.$i.'" onclick="boxDisable(fechaCaducidad'.$i.', $(this));">F.Cad.
                        </label>
                        </div>
                        <div id="campo5" class="col-xs-12 col-sm-3 col-md-2">
                            <input id="fechaCaducidad'.$i.'" type="date" class="form-control" name="fechaCaducidad'.$i.'" required disabled>
                        </div>
                        <div id="campo6" class="col-xs-12 col-sm-3 col-md-1">
                            <label class="checkbox-inline" id="chkboxEstado'.$i.'">
                              <input type="checkbox" id="estadoMaterial'.$i.'" name="estadoMaterial'.$i.'" onclick="boxDisable2(cantidadEntrega'.$i.', $(this));" checked>Completo
                            </label>
                        </div>
                        <div id="campo7" class="col-xs-12 col-sm-3 col-md-2">
                            <input class="form-control" type="number" id="cantidadEntrega'.$i.'" name="cantidadEntrega'.$i.'"  min="0"                               placeholder="Cantidad recibida" required="number" data-toggle="tooltip" data-placement="right" title="Ingresar 0 si no se recibe material" disabled>
                        </div>
                        ';
                    }
            ?>
                        
                        <div id="copiaNueva"></div>
                    </div>

                    <div class="form-group">
                        <div class="col-0 col-sm-10 col-md-10 col-lg-11"></div>
                        <div class="col-12 col-sm-2 col-md-2 col-lg-1">
                            <button type="button" class="btn btn-default pull-left" id="btnAdd">+</button>
                            <button type="button" class="btn btn-default pull-right" id="btnDel">-</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12 col-sm-8 col-md-9">
                            <button type="submit" class="btn btn-primary" name="compraAlta">Guardar</button>
                            <a href="index.php" class="btn btn-default">Cancelar</a>
                        </div>
                    </div>

                </form> 
        </div>  
    </body>
</html>
