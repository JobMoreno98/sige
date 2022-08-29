<?php
include './loginSecurity.php';
 if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'Recursos Humanos' and $_SESSION['privilegios'] != 'RH-Almacen') {
    header('location: index.php');
}
?>
<html>
    <head lang="es">
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
                $('[data-toggle="tooltip"]').tooltip();
            });
            </script>
    </head>
    <body>
        <?php 
        include 'barraMenu.php';
        $menu = new menu();
        $menu ->barraMenu();
        
        include 'empleado.php';
        $obj = new empleado();
        $obj->setIdEmpleado($_GET['id']);
        $arregloEmpl = $obj->empleadoDetalle();
        $arregloExp = $obj->expedienteDetalle();
        ?>
        
        <div class="container-fluid">
        <div class="page-header">
            <h3 style="text-align: center">Expedientes</h3>
        </div>
            
        <div class="table-responsive">
            <table class="table">
                <thead>
                  <tr>
                    <th style="text-align: center">ID</th>
                    <th style="text-align: center">Código UDG</th>
                    <th style="text-align: center">Nombre</th>
                    <th style="text-align: center">Área</th>
                    <th style="text-align: center">Puesto</th>
                    <th style="text-align: center">Definitividad</th>
                    <th style="text-align: center">Carga Horaria</th>
                    <th style="text-align: center">Escolaridad</th>
                    <th style="text-align: center">Observaciones</th>
                    <th style="text-align: center">Extensión</th>
                    <th style="text-align: center">Estado</th>
                    <th style="text-align: center">Privilegios</th>
                  </tr>
                </thead>
                <tbody align="center">
                  <tr>
                      <td><?php echo $obj->getIdEmpleado(); ?></td>
                      <td><?php print_r($arregloEmpl[0][0]) ?></td>
                      <td><?php print_r($arregloEmpl[0][1]) ?></td>
                      <td><?php print_r($arregloEmpl[0][2]) ?></td>
                      <td><?php print_r($arregloEmpl[0][3]) ?></td>
                      <td><?php print_r($arregloEmpl[0][4]) ?></td>
                      <td><?php print_r($arregloEmpl[0][5]) ?></td>
                      <td><?php print_r($arregloEmpl[0][6]) ?></td>
                      <td><?php print_r($arregloEmpl[0][7]) ?></td>
                      <td><?php print_r($arregloEmpl[0][8]) ?></td>
                      <td><?php print_r($arregloEmpl[0][9]) ?></td>
                      <td><?php print_r($arregloEmpl[0][10]) ?></td>
                  </tr>
                </tbody>
            </table>
        </div>
        <br>
        </div>
        <div class="container">    
            
            <form class="form-horizontal" action="aplicarMovimiento.php" enctype="multipart/form-data" method="post" onsubmit="return confirm('¿Seguro que quieres guardar la información?');">
            
                <input type="hidden" name="id" value="<?php echo $obj ->getIdEmpleado(); ?>">
                
                <table class="table table-hover">
                      <tr>
                        <th>Ficha UIP:</th>
                        <td align="center">
                        <?php
                            if ($arregloExp[0][0] != 'No especificado') {
                                echo '<a href="expedientes/'. $arregloExp[0][0] .'" class="btn btn-success" target="_blank">Mostrar Documento</a>';
                            }
                            else 
                            {
                                print_r($arregloExp[0][0]);
                            }
                         ?>
                        </td>
                        <td><input class="form-control" type="file" name="fichaUIP" data-toggle="tooltip" data-placement="right" title="Agregar o modificar documento en PDF"></td>
                      </tr>
                      <tr>
                        <th>Curriculum:</th>
                        <td align="center">
                        <?php
                            if ($arregloExp[0][1] != 'No especificado') {
                                echo '<a href="expedientes/'. $arregloExp[0][1] .'" class="btn btn-success" target="_blank">Mostrar Documento</a>';
                            }
                            else 
                            {
                                print_r($arregloExp[0][1]);
                            }
                         ?>
                        </td>
                        <td><input class="form-control" type="file" name="CV" data-toggle="tooltip" data-placement="right" title="Agregar o modificar documento en PDF"></td>
                      </tr>
                      <tr>
                        <th>INE:</th>
                        <td align="center">
                        <?php
                            if ($arregloExp[0][2] != 'No especificado') {
                                echo '<a href="expedientes/'. $arregloExp[0][2] .'" class="btn btn-success" target="_blank">Mostrar Documento</a>';
                            }
                            else 
                            {
                                print_r($arregloExp[0][2]);
                            }
                         ?>
                        </td>
                        <td><input type="file"  class="form-control" name="INE" data-toggle="tooltip" data-placement="right" title="Agregar o modificar documento en PDF"></td>
                      </tr>
                      <tr>
                        <th>RFC:</th>
                        <td align="center">
                        <?php
                            if ($arregloExp[0][3] != 'No especificado') {
                                echo '<a href="expedientes/'. $arregloExp[0][3] .'" class="btn btn-success" target="_blank">Mostrar Documento</a>';
                            }
                            else 
                            {
                                print_r($arregloExp[0][3]);
                            }
                         ?>
                        </td>
                        <td><input  class="form-control" type="file" name="RFC" data-toggle="tooltip" data-placement="right" title="Agregar o modificar documento en PDF"></td>
                      </tr>
                      <tr>
                        <th>Número de Seguro Social:</th>
                        <td align="center">
                        <?php
                            if ($arregloExp[0][4] != 'No especificado') {
                                echo '<a href="expedientes/'. $arregloExp[0][4] .'" class="btn btn-success" target="_blank">Mostrar Documento</a>';
                            }
                            else 
                            {
                                print_r($arregloExp[0][4]);
                            }
                         ?>
                        </td>
                        <td><input  class="form-control" type="file" name="IMSS" data-toggle="tooltip" data-placement="right" title="Agregar o modificar documento en PDF"></td>
                      </tr>
                      <tr>
                        <th>Acta Nacimiento:</th>
                        <td align="center">
                        <?php
                            if ($arregloExp[0][5] != 'No especificado') {
                                echo '<a href="expedientes/'. $arregloExp[0][5] .'" class="btn btn-success" target="_blank">Mostrar Documento</a>';
                            }
                            else 
                            {
                                print_r($arregloExp[0][5]);
                            }
                         ?>
                        </td>
                        <td><input class="form-control" type="file" name="actaNacimiento" data-toggle="tooltip" data-placement="right" title="Agregar o modificar documento en PDF"></td>
                      </tr>
                      <tr>
                        <th>CURP:</th>
                        <td align="center">
                        <?php
                            if ($arregloExp[0][6] != 'No especificado') {
                                echo '<a href="expedientes/'. $arregloExp[0][6] .'" class="btn btn-success" target="_blank">Mostrar Documento</a>';
                            }
                            else 
                            {
                                print_r($arregloExp[0][6]);
                            }
                         ?>
                        </td>
                        <td><input  class="form-control" type="file" name="CURP" data-toggle="tooltip" data-placement="right" title="Agregar o modificar documento en PDF"></td>
                      </tr>
                      <tr>
                        <th>Comprobante de Domicilio:</th>
                        <td align="center">
                        <?php
                            if ($arregloExp[0][7] != 'No especificado') {
                                echo '<a href="expedientes/'. $arregloExp[0][7] .'" class="btn btn-success" target="_blank">Mostrar Documento</a>';
                            }
                            else 
                            {
                                print_r($arregloExp[0][7]);
                            }
                         ?>
                        </td>
                        <td><input  class="form-control" type="file" name="comprobanteDom" data-toggle="tooltip" data-placement="right" title="Agregar o modificar documento en PDF"></td>
                      </tr>
                      <tr>
                        <th>Título:</th>
                        <td align="center">
                        <?php
                            if ($arregloExp[0][8] != 'No especificado') {
                                echo '<a href="expedientes/'. $arregloExp[0][8] .'" class="btn btn-success" target="_blank">Mostrar Documento</a>';
                            }
                            else 
                            {
                                print_r($arregloExp[0][8]);
                            }
                         ?>
                        </td>
                        <td><input  class="form-control" type="file" name="titulo" data-toggle="tooltip" data-placement="right" title="Agregar o modificar documento en PDF"></td>
                      </tr>
                </table>
                
                <button type="submit" class="btn btn-primary" name="expedienteModificar">Agregar</button>
                <a href="empleadoConsulta.php" class="btn btn-default">Regresar</a>
              
          </form>
        </div>
        <br>
    </body>
</html>
