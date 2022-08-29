<!DOCTYPE html>
<?php
 include './loginSecurity.php';
     if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'Recursos Humanos' and $_SESSION['privilegios'] != 'RH-Almacen') {
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
            var cont = 4;
            $(document).ready(function() {
                $('#btnAdd').click(function() {
                    var newNum = new Number(cont+1); // the numeric ID of the new input field being added
                    var newElem = $('#campo0').clone().attr('id', 'Add' + newNum);// create the new element via clone(), and manipulate it's ID using newNum value
                    newElem.children(':last').attr('id', 'num' + newNum).attr('name', 'num').val(newNum);// manipulate the name/id values of the input inside the new element
                    $('#copiaNueva').before(newElem); // insert the new element after the last "duplicatable" input field
                    $('#btnDel').attr('disabled',false);// enable the "remove" button
                    if (newNum > 19)//     business rule: you can only add 10 names
                      $('#btnAdd').attr('disabled','disabled');
                });
                
                $('#btnAdd').click(function() {
                    var newNum = new Number(cont+1); // the numeric ID of the new input field being added
                    var bandera = newNum % 2;
                    if (bandera < 1) {
                        var newElem = $('#campo3').clone().attr('id', 'Add' + newNum);
                        newElem.children(':last').attr('id', 'idEmpleado' + newNum).attr('name', 'idEmpleado' + newNum);
                        $('#copiaNueva').before(newElem);
                        $('#idEmpleado'+newNum).focus();//enfoca el articulo al clonar
                    } else {
                        var newElem = $('#campo1').clone().attr('id', 'Add' + newNum);// create the new element via clone(), and manipulate it's ID using newNum value
                        newElem.children(':last').attr('id', 'idNombramiento' + newNum).attr('name', 'idNombramiento');// manipulate the name/id values of the input inside the new element
                        $('#copiaNueva').before(newElem); // insert the new element after the last "duplicatable" input field
                        $('#idNombramiento'+newNum).focus();//enfoca el articulo al clonar
                    }
                });

                $('#btnAdd').click(function() {
                    var newNum = new Number(cont+1);
                    var newElem = $('#campo2').clone().attr('id', 'Add' + newNum);
                    newElem.children(':last').attr('id', 'cargaHoraria' + newNum).attr('name', 'cargaHoraria' + newNum).val('');
                    $('#copiaNueva').before(newElem);
                });

                $('#btnAdd').click(function() {
                    var newNum = new Number(cont+1);
                    var bandera = newNum % 2;
                    if (bandera < 1) {
                        var newElem = $('#campo1').clone().attr('id', 'Add' + newNum);// create the new element via clone(), and manipulate it's ID using newNum value
                        newElem.children(':last').attr('id', 'idNombramiento' + newNum).attr('name', 'idNombramiento');// manipulate the name/id values of the input inside the new element
                        $('#copiaNueva').before(newElem); // insert the new element after the last "duplicatable" input field
                        cont=cont+1;
                    } else {
                        var newElem = $('#campo3').clone().attr('id', 'Add' + newNum);
                        newElem.children(':last').attr('id', 'idEmpleado' + newNum).attr('name', 'idEmpleado' + newNum);
                        $('#copiaNueva').before(newElem);
                        cont=cont+1;
                    }
                });    
                
                $('#btnDel').click(function() {
                    var num = cont; // how many "duplicatable" input fields we currently have
                    $('#num' + num).remove(); // remove the last element
                    $('#idNombramiento' + num).remove(); // remove the last element
                    $('#cargaHoraria' + num).remove(); // remove the last element
                    $('#idEmpleado' + num).remove(); // remove the last element
                    
                    $('#btnAdd').attr('disabled',false);
                    if (num == 2)//     business rule: you can only add 10 names
                      $('#btnDel').attr('disabled','disabled');
                    cont=cont-1;
                    
                    var bandera = num % 2;
                    if (bandera < 1) {
                        $('#idNombramiento'+cont).focus();
                    } else {
                        $('#idEmpleado'+cont).focus();
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

        include 'suplencia.php';
        $obj = new suplencia();
        ?>
        <div class="container">
            <div class="page-header">
                <h3 style="text-align: center">Registro de Suplencias</h3>
            </div>
            
            <form action="aplicarMovimiento.php" class="form-horizontal" method="post"
                  onsubmit="return confirm('¿Seguro que quieres guardar este formulario?');">
                

                    <div class="input-group">
                        <span class="input-group-addon">Fecha Inicio</span>
                        <input type="date" class="form-control" name="fechaInicio" required="date">

                        <span class="input-group-addon">Fecha Fin</span>
                        <input type="date" class="form-control" name="fechaFin" required="date">
                    </div>
                    <br>
                    <br>


                    <div class="form-group">
            <?php 
                    for ($i = 1; $i < 5; $i++) 
                    {
                        $bandera = $i % 2;
                        echo '
                        <div id="campo0" class="col-xs-12 col-sm-1 col-md-1">
                            <input class="form-control" id="num'.$i.'" type="number" name="num" value="'.$i.'" readonly>
                        </div>';
                        if ($bandera > 0) 
                        {
                            echo '<div id="campo1" class="col-xs-12 col-sm-4 col-md-4">
                          <select id="idNombramiento'. $i .'" name="idNombramiento'. $i .'" class="form-control" autofocus required>
                                <option value="" disabled selected>Nombramiento</option>';
                                $obj->consultaNombramiento();  
                            echo '</select>
                        </div>';
                        }
                        else 
                        {
                            echo '<div id="campo3" class="col-xs-12 col-sm-4 col-md-4">
                             <select id="idEmpleado'. $i .'" name="idEmpleado'. $i .'" class="form-control" required>
                                <option value="" disabled selected>Empleado</option>';
                                $obj->consultaNombreEmpleado();  
                            echo '</select>
                        </div>';
                        }
                        echo '
                         <div id="campo2" class="col-xs-12 col-sm-3 col-md-3">
                             <input type="number" class="form-control" id="cargaHoraria'. $i .'" name="cargaHoraria'. $i .'" min="1" max="100" placeholder="Carga H./Horas" required="number">
                          </div>
                        ';
                        if ($bandera > 0) 
                        {
                            echo '<div id="campo3" class="col-xs-12 col-sm-4 col-md-4">
                             <select id="idEmpleado'. $i .'" name="idEmpleado'. $i .'" class="form-control" required>
                                <option value="" disabled selected>Empleado</option>';
                                $obj->consultaNombreEmpleado();  
                            echo '</select>
                        </div>';
                        }
                        else 
                        {
                            echo '<div id="campo1" class="col-xs-12 col-sm-4 col-md-4">
                          <select id="idNombramiento'. $i .'" name="idNombramiento'. $i .'" class="form-control" autofocus required>
                                <option value="" disabled selected>Nombramiento</option>';
                                $obj->consultaNombramiento();  
                            echo '</select>
                        </div>';
                        }
                    }
            ?>
                        <div id="copiaNueva"></div>
                    </div>
                    

                    <div class="form-group">
                        <div class="col-sm-11"></div>
                        <div class="col-sm-1">
                            <button type="button" class="btn btn-default pull-left" id="btnAdd">+</button>
                            <button type="button" class="btn btn-default pull-right" id="btnDel">-</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12 col-sm-8 col-md-9">
                            <button type="submit" class="btn btn-primary" name="suplenciaAlta">Guardar</button>
                            <a href="index.php" class="btn btn-default">Cancelar</a>
                        </div>
                    </div>

                </form> 
        </div>
        <br>
    </body>
</html>