<!DOCTYPE html>
<?php

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
                    newElem.children(':last').attr('id', 'dia' + newNum).attr('name', 'dia' + newNum);// manipulate the name/id values of the input inside the new element
                    $('#copiaNueva').before(newElem); // insert the new element after the last "duplicatable" input field
                    $('#btnDel').attr('disabled',false);// enable the "remove" button
                    if (newNum == 50)//     business rule: you can only add 10 names
                      $('#btnAdd').attr('disabled','disabled');
                });

                $('#btnAdd').click(function() {
                    var newNum = new Number(cont+1);
                    var newElem = $('#campo2').clone().attr('id', 'Add' + newNum);
                    newElem.children(':last').attr('id', 'mes' + newNum).attr('name', 'mes' + newNum);
                    $('#copiaNueva').before(newElem);
                    $('#mes'+newNum).focus();//enfoca el articulo al clonar
                });

                $('#btnAdd').click(function() {
                    var newNum = new Number(cont+1);
                    var newElem = $('#campo3').clone().attr('id', 'Add' + newNum);
                    newElem.children(':last').attr('id', 'anio' + newNum).attr('name', 'anio' + newNum).val('');
                    $('#copiaNueva').before(newElem);
//                    cont = newNum;
                    
                });
                
                $('#btnAdd').click(function() {
                    var newNum = new Number(cont+1);
                    var newElem = $('#campo4').clone().attr('id', 'Add' + newNum);
                    newElem.children(':last').attr('id', 'numero' + newNum).attr('name', 'numero' + newNum).val('');
                    $('#copiaNueva').before(newElem);
//                    cont = newNum;
                    cont=cont+1;
                });
                
                $('#btnDel').click(function() {
                    var num = cont; // how many "duplicatable" input fields we currently have
                    $('#dia' + num).remove(); // remove the last element
                    $('#mes' + num).remove(); // remove the last element
                    $('#anio' + num).remove(); // remove the last element
                    $('#numero' + num).remove(); // remove the last element
//                     enable the "add" button
                    $('#btnAdd').attr('disabled',false);
                    if (num == 2)//     business rule: you can only add 10 names
                      $('#btnDel').attr('disabled','disabled');
                    cont=cont-1;
                    $('#dia'+cont).focus();
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

date_default_timezone_set("America/Mexico_City");     
        ?>
        <div class="container">
            <div class="page-header">
                <h3 style="text-align: center">Capturar Requisición Entregada <small> </small></h3>
            </div>
            
            <form action="aplicarMovimiento.php" class="form-horizontal" method="post"
                  onsubmit="return confirm('¿Seguro que quieres guardar este formulario?');">
                    
                   

                    <br>
                    
                    <div class="form-group">
                        <div class="col-xs-12 col-md-6">
                            <label for="idEmpleado">Solicitante</label>
                            <select class="form-control" id="idEmpleado" name="idEmpleado" required>
                                <option value="" disabled selected>Sin seleccionar</option>
                                
                            </select>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <label for="idArea">Área</label>
                            <select class="form-control" id="idArea" name="idArea" required>
                                <option value="" disabled selected>Sin seleccionar</option>
                                
                            </select>
                        </div>
                    </div>


                    <div class="form-group">
            <?php 
                    for ($i = 1; $i < 6; $i++) 
                    {
                        echo '
                        <div id="campo1" class="col-xs-12 col-sm-2 col-md-1">
                            <input class="form-control" id="dia'.$i.'" type="number" name="dia'.$i.'" >
                        </div>
                        <div id="campo2" class="col-xs-12 col-sm-8 col-md-7">
                            <input class="form-control" id="mes'.$i.'" type="text" name="mes'.$i.'" >
                        </div>
                        <div id="campo3" class="col-xs-12 col-sm-2 col-md-2">
                            <input class="form-control" type="number" id="anio'.$i.'" name="anio'.$i.'">
                        </div>
                        <div id="campo4" class="col-xs-12 col-sm-2 col-md-2">
                            <input class="form-control" type="number" id="numero'.$i.'" name="numero'.$i.'">
                        </div>
                        ';
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
                            <button type="submit" class="btn btn-primary" name="requisicionAltaEntregado">Guardar</button>
                            <a href="index.php" class="btn btn-default">Cancelar</a>
                        </div>
                    </div>

                </form> 
          

        </div>  
    </body>
</html>
