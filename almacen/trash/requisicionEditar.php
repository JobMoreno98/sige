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
            });
        </script>
    </head>
    <body>
        <?php 
        include 'barraMenu.php';
        $menu = new menu();
        $menu ->barraMenu();
        date_default_timezone_set("America/Mexico_City");

        include 'requisicion.php';
        $obj = new requisicion();
        $obj->setIdRequisicion($_GET['id']);
        
        $datosRequisicion = $obj->consultaDatosRequisicion();
        $materialRequisicion = $obj->consultaMaterialRequisicion();
        
        ?>
        <div class="container">
            <div class="page-header">
                <h3 style="text-align: center">Autorizar Requisición</h3>
            </div>
            
           
                

                    <div class="input-group">

                        <span class="input-group-addon">IdWeb</span>
                        <input type="text" class="form-control" name="idRequisicion" value="<?php echo $obj->getIdRequisicion(); ?>" readonly>
                        
                        <span class="input-group-addon">Folio</span>
                        <input type="text" class="form-control" value="<?php print_r($datosRequisicion[0][0]); ?>" readonly>

                        <span class="input-group-addon">Fecha</span>
                        <input type="date" class="form-control" value="<?php print_r($datosRequisicion[0][3]); ?>" readonly>

                        <span class="input-group-addon">Tipo</span>
                        <input type="text" class="form-control" value="<?php print_r($datosRequisicion[0][4]); ?>" readonly>
                    </div>
                <br>
                    <div class="input-group">
                        <span class="input-group-addon">Solicitante</span>
                        <input type="text" class="form-control" value="<?php print_r($datosRequisicion[0][1]); ?>" readonly>
                        
                        <span class="input-group-addon">Área</span>
                        <input type="text" class="form-control" value="<?php print_r($datosRequisicion[0][2]); ?>" readonly>
                        
                        
                        <span class="input-group-addon">Responsable Almacén</span>
                        <select class="form-control" name="responsableAlmacen" required>
                            <?php $obj->consultaResponsableAlmacen() ?>
                        </select>
                    </div>
                <br>
                    
                    
                    <table class="table table-hover">
                        <thead>
                          <tr>
                            <th>Número</th>
                            <th>Artículo</th>
                            <th>Existencia</th>
                            <th>Cant. Solicitada</th>
                            <th>Estado</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php 
                            for ($i = 0; $i < count($materialRequisicion); $i++) 
                            {
                                $bandera = $i + 1;
                                echo '
                                <tr>
                                    <td><input class="form-control" type="number" name="num" value="'. $materialRequisicion[$i][0] .'" readonly></td>
                                    
                                    <td><select class="form-control" name="idMaterial'.$bandera.'" readonly>
                                    <option value="'. $materialRequisicion[$i][1] .'">'. $materialRequisicion[$i][1] .' - '. $materialRequisicion[$i][2] .'</option>
                                        </select></td>
                                    
                                    <td><input class="form-control" type="number" value="'. $materialRequisicion[$i][3] .'" readonly></td>';
                                    
                                
                                if ($materialRequisicion[$i][5] == 'Surtido') 
                                {
                                    echo '<td><input class="form-control" type="number" value="'. $materialRequisicion[$i][4] .'" readonly></td>
                                    <td><input class="form-control" type="text" value="'. $materialRequisicion[$i][5] .'" readonly></td>';
                                }
                                else 
                                {
                                    echo '<td><input class="form-control" type="number" name="cantidad'.$bandera.'" min="1" value="'. $materialRequisicion[$i][4] .'" required="number"></td>
                                    
                                    <td><select class="form-control" name="estado'.$bandera.'">
                                    <option>'. $materialRequisicion[$i][5] .'</option>
                                    <option>Autorizado</option>
                                    <option>No autorizado</option>
                                    <option>Pendiente</option>
                                        </select></td>';
                                }
                                echo '</tr>';
                            } 
                            ?>
                        </tbody>
                      </table>
                    
                 <form action="aplicarMovimiento.php" class="form-horizontal" method="post"
                  onsubmit="return confirm('¿Seguro que quieres guardar este formulario?');">
                    
                    <input type="hidden" name="tipo" value="<?php echo $obj ->getTipo(); ?>">

                    <br>



                    <div class="form-group">
            <?php 
                    for ($i = count($materialRequisicion); $i < 10; $i++) 
                    {
                        echo '
                        <div id="campo1" class="col-xs-12 col-sm-2 col-md-1">
                            <input class="form-control" id="num'.$i.'" type="number" name="num" value="'.$i.'" readonly>
                        </div>
                        <div id="campo2" class="col-xs-12 col-sm-8 col-md-9">
                            <select class="form-control" id="idMaterial'.$i.'" name="idMaterial'.$i.'" autofocus required>
                                <option value="" disabled selected>Artículo</option>'; 
                        $obj->consultaMaterialAlmacen();
                        echo '
                            </select>
                        </div>
                        <div id="campo3" class="col-xs-12 col-sm-2 col-md-2">
                            <input class="form-control" type="number" id="cantidad'.$i.'" name="cantidad'.$i.'"  min="1" max="1000" placeholder="Cantidad" required="number">
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
                            <button type="submit" class="btn btn-primary" name="requisicionAlta">Guardar</button>
                            <a href="index.php" class="btn btn-default">Cancelar</a>
                        </div>
                    </div>

                </form> 
    

                  

               
        </div>  
    </body>
</html>
