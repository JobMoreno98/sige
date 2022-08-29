<!DOCTYPE html>
<?php
 include './loginSecurity.php';
    if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'RH-Almacen' and $_SESSION['privilegios'] != 'Recursos Humanos') {
    header('location: index.php');
}
?>
<html lang='es'>
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
            function cerrar() {
            var ventana = window.self;
            ventana.opener = window.self;
            ventana.close();
            }
        </script>
</head>
<body>
    <?php
    include 'barraMenu.php';
    $menu = new menu();
    $menu ->barraMenu();
        
    include 'asistencia.php';
    $obj = new asistencia();
    $obj->setCodigo($_GET['c']);
    $obj->setFecha($_GET['f']);
    $empl = $obj->consultaEmpleadoPorCodigo();
    $regDia = $obj->consultaRegistrosDiario();
    ?>
    <div class="container">
        <div class="page-header">
                <h3 style="text-align: center">Registros por Día</h3>
        </div>
        
        <div class="table-responsive">
            <table class="table">
                <thead>
                  <tr>
                    <th style="text-align: center">Fecha</th>
                    <th style="text-align: center">ID</th>
                    <th style="text-align: center">Código</th>
                    <th style="text-align: center">Nombre</th>
                    <th style="text-align: center">ID Prestación</th>
                    <th style="text-align: center">Prestación</th>
                    <th style="text-align: center">Institución</th>
                  </tr>
                </thead>
                <tbody align="center">
                  <tr>
                      <td><?php echo $obj->getFecha(); ?></td>
                      <td><?php print_r($empl[0]) ?></td>
                      <td><?php print_r($empl[1]) ?></td>
                      <td><?php print_r($empl[2]) ?></td>
                      <td><?php print_r($empl[3]) ?></td>
                      <td><?php print_r($empl[4]) ?></td>
                      <td><?php print_r($empl[5]) ?></td>
                  </tr>
                </tbody>
            </table>
        </div>
        <br>
        
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="text-align: center">Horas Registradas</th>  
                    </tr>
                </thead>

                <tbody align="center">
                    <?php
                        for ($i = 0; $i < count($regDia); $i++) {
                            ?>
                            <tr>
                                <td><?php print_r($regDia[$i][1]) ?></td>
                            </tr> 
                            <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>  
        
        <div class="form-group">
            <div class="col-xs-12 col-sm-8 col-md-9">
                <a href="#" onClick="cerrar()" class="btn btn-default">Cerrar Ventana</a> 
            </div>
        </div>
    </div>
    <br>
</body>
</html>