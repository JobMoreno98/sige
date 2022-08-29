<!DOCTYPE html>
<?php
 include './loginSecurity.php';
         if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'Ayudante Almacén' and $_SESSION['privilegios'] != 'RH-Almacen') {
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
                <h3 style="text-align: center">Surtir Requisición</h3>
            </div>
            
            <form action="aplicarMovimiento.php" class="form-horizontal" method="post"
                  onsubmit="return confirm('¿Seguro que quieres guardar este formulario?');">
                

                    <div class="input-group">

                        <span class="input-group-addon">IdWeb</span>
                        <input type="text" class="form-control" name="idRequisicion" value="<?php echo $obj->getIdRequisicion(); ?>" readonly>
                        
                        <span class="input-group-addon">Folio</span>
                        <input type="text" class="form-control" value="<?php print_r($datosRequisicion[0][0]); ?>" readonly>

                        <span class="input-group-addon">Fecha</span>
                        <input type="date" class="form-control" value="<?php print_r($datosRequisicion[0][3]); ?>" readonly>

                        <span class="input-group-addon">Tipo</span>
                        <input type="text" class="form-control" name="tipo" value="<?php print_r($datosRequisicion[0][4]); ?>" readonly>
                    </div>
                <br>
                    <div class="input-group">
                        <span class="input-group-addon">Solicitante</span>
                        <input type="text" class="form-control" value="<?php print_r($datosRequisicion[0][1]); ?>" readonly>
                        
                        <span class="input-group-addon">Área</span>
                        <input type="text" class="form-control" value="<?php print_r($datosRequisicion[0][2]); ?>" readonly>
                        
                        
                        <span class="input-group-addon">Responsable Almacén</span>
                        <input type="text" class="form-control" value="<?php print_r($datosRequisicion[0][5]); ?>" readonly>
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
                                    <td><input class="form-control" type="number" value="'. $materialRequisicion[$i][3] .'" readonly></td>'
                                . '<td><input class="form-control" type="number" name="cantidad'.$bandera.'" value="'. $materialRequisicion[$i][4] .'" readonly></td>';
                                    
                                
                                if ($materialRequisicion[$i][5] == 'Autorizado') {
                                    
                                    echo '
                                    <td><select class="form-control" name="estado'.$bandera.'">
                                    <option>'. $materialRequisicion[$i][5] .'</option>';
                                    
                                    if ($materialRequisicion[$i][3] >= $materialRequisicion[$i][4]) {
                                        echo '<option>Surtido</option>';
                                    }
                                    
                                    echo '</select></td>';
                                }
                                else 
                                {
                                    echo '
                                    <td><input class="form-control" type="text" value="'. $materialRequisicion[$i][5] .'" readonly></td>';
                                }
                                echo '</tr>';
                            } 
                            ?>
                        </tbody>
                      </table>
                    
                    

                    <div class="form-group">
                        <div class="col-xs-12 col-sm-8 col-md-9">
                            <button type="submit" class="btn btn-primary" name="requisicionSurtir">Guardar</button>
                            <a href="requisicionConsulta.php?t=<?php print_r($datosRequisicion[0][4]); ?>" class="btn btn-default">Volver a Consulta</a>
                            <a href="index.php" class="btn btn-default">Salir</a> 
                        </div>
                    </div>

                </form> 
        </div>  
    </body>
</html>
