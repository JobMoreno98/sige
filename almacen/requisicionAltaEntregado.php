<!DOCTYPE html>
<?php
 include './loginSecurity.php';
 if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'Encargado Almacén' and $_SESSION['privilegios'] != 'RH-Almacen') {
    header('location: index.php');
}
if ($_SESSION['tipoArea'] == 'Operaciones' || $_SESSION['privilegiosEmpleado'] == 'Colaborador') {
    header('location: index.php');
}

include 'requisicion.php';
$obj = new requisicion();
$obj->setTipo($_GET['tipo']);

if ($obj->getTipo() == "Limpieza" and $_SESSION['tipoArea'] == 'Administrativa') {
    header('location: index.php');
}
if ($obj->getTipo() == "Limpieza" and $_SESSION['privilegiosEmpleado'] == 'Responsable') {
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
            var cont= 5;
            $(document).ready(function() {
//                $('#btnDel').attr('disabled','disabled');
                $('#btnAdd').click(function() {
                    var newNum = new Number(cont+1); // the numeric ID of the new input field being added
                    var newElem = $('#campo1').clone().attr('id', 'Add' + newNum);// create the new element via clone(), and manipulate it's ID using newNum value
                    newElem.children(':last').attr('id', 'num' + newNum).attr('name', 'num').val(newNum);// manipulate the name/id values of the input inside the new element
                    $('#copiaNueva').before(newElem); // insert the new element after the last "duplicatable" input field
                    $('#btnDel').attr('disabled',false);// enable the "remove" button
                    if (newNum == 50)//     business rule: you can only add 10 names
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
//                    cont = newNum;
                    cont=cont+1;
                });
                
                $('#btnDel').click(function() {
                    var num = cont; // how many "duplicatable" input fields we currently have
                    $('#num' + num).remove(); // remove the last element
                    $('#idMaterial' + num).remove(); // remove the last element
                    $('#cantidad' + num).remove(); // remove the last element
//                     enable the "add" button
                    $('#btnAdd').attr('disabled',false);
                    if (num == 2)//     business rule: you can only add 10 names
                      $('#btnDel').attr('disabled','disabled');
                    cont=cont-1;
                    $('#idMaterial'+cont).focus();
                });
                
                // Esta sección limita la cantidad de productos con las existencias
                // de lo que se selecciona
                $('#idMaterial1').on('change',function(){
                        var limite1 = $('select#idMaterial1 option:selected').attr("id");
                        $('#cantidad1').attr('max', limite1);
                });
                $('#idMaterial2').on('change',function(){
                        var limite2 = $('select#idMaterial2 option:selected').attr("id");
                        $('#cantidad2').attr('max', limite2);
                });
                $('#idMaterial3').on('change',function(){
                        var limite3 = $('select#idMaterial3 option:selected').attr("id");
                        $('#cantidad3').attr('max', limite3);
                });
                $('#idMaterial4').on('change',function(){
                        var limite4 = $('select#idMaterial4 option:selected').attr("id");
                        $('#cantidad4').attr('max', limite4);
                });
                $('#idMaterial5').on('change',function(){
                        var limite5 = $('select#idMaterial5 option:selected').attr("id");
                        $('#cantidad5').attr('max', limite5);
                });
                
                $('#btnAdd').click(function() {
                    var num = cont;
                    for (var i = 0, limit = num; i < limit; i++) {
                        $('#idMaterial' + num).on('change',function(){
                                var limites = $('select#idMaterial'+ num +' option:selected').attr("id");
                                $('#cantidad' + num).attr('max', limites);
                        });
                    }
                });
                
            });
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
                <h3 style="text-align: center">Capturar Requisición Entregada <small> <?php echo $obj->getTipo(); ?></small></h3>
            </div>
            
            <form action="aplicarMovimiento.php" class="form-horizontal" method="post"
                  onsubmit="return confirm('¿Seguro que quieres guardar este formulario?');">
                    
                    <input type="hidden" name="tipo" value="<?php echo $obj ->getTipo(); ?>">

                    <div class="input-group">
                        <span class="input-group-addon">Fecha</span>
                        <input id="fechaRequisicion" type="date" class="form-control" name="fechaRequisicion" value="<?php echo date("Y-m-d");?>" autofocus required="date">

                        <span class="input-group-addon">Responsable Almacén</span>
                        <select class="form-control" name="responsableAlmacen" required>
                            <?php $obj->consultaResponsableAlmacen() ?>
                        </select>
                    </div>
                    <br>
                    
                    <div class="form-group">
                        <div class="col-xs-12 col-md-6">
                            <label for="idEmpleado">Solicitante</label>
                            <select class="form-control" id="idEmpleado" name="idEmpleado" required>
                                <option value="" disabled selected>Sin seleccionar</option>
                                <?php
                                if ($obj ->getTipo() == 'Papelería') 
                                {
                                    $obj->consultaEmpleadosPapeleria();
                                }
                                elseif ($obj ->getTipo() == 'Limpieza') 
                                {
                                    $obj->consultaEmpleadosLimpieza();
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <label for="idArea">Área</label>
                            <select class="form-control" id="idArea" name="idArea" required>
                                <option value="" disabled selected>Sin seleccionar</option>
                                <?php
                                if ($obj ->getTipo() == 'Papelería') 
                                {
                                    $obj->consultaAreasPapeleria();
                                }
                                elseif ($obj ->getTipo() == 'Limpieza') 
                                {
                                    $obj->consultaAreasLimpieza();
                                }
                                ?>
                            </select>
                        </div>
                    </div>


                    <div class="form-group">
            <?php 
                    for ($i = 1; $i < 6; $i++) 
                    {
                        echo '
                        <div id="campo1" class="col-xs-12 col-sm-2 col-md-1">
                            <input class="form-control" id="num'.$i.'" type="number" name="num" value="'.$i.'" readonly>
                        </div>
                        <div id="campo2" class="col-xs-12 col-sm-8 col-md-9">
                            <select class="form-control" id="idMaterial'.$i.'" name="idMaterial'.$i.'" autofocus required>
                                <option value="" disabled selected>Artículo</option>'; 
                        $obj->consultaMaterialConExistencia();
                        echo '
                            </select>
                        </div>
                        <div id="campo3" class="col-xs-12 col-sm-2 col-md-2">
                            <input class="form-control" type="number" id="cantidad'.$i.'" name="cantidad'.$i.'"  min="1" max="100000" placeholder="Cantidad" required="number">
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
                            <button type="submit" class="btn btn-primary" name="requisicionAltaEntregado">Guardar</button>
                            <a href="index.php" class="btn btn-default">Cancelar</a>
                        </div>
                    </div>

                </form> 
          

        </div>  
    </body>
</html>
