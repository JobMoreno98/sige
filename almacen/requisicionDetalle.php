<!DOCTYPE html>
<?php
 include './loginSecurity.php';
         if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'Ayudante Almacén' and $_SESSION['privilegios'] != 'Encargado Almacén' and $_SESSION['privilegios'] != 'Coordinador' and $_SESSION['privilegios'] != 'RH-Almacen' and $_SESSION['privilegios'] != 'Dirección') {
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

        include 'requisicion.php';
        $obj = new requisicion();
        $obj->setIdRequisicion($_GET['id']);
        
        $datosRequisicion = $obj->consultaDatosRequisicion();
        $materialRequisicion = $obj->consultaMaterialRequisicion();
        
        ?>
        <div class="container">
            <div class="page-header">
                <h3 style="text-align: center">Detalle Requisición</h3>
            </div>
            
            <div class="table-responsive">
                <table class="table">
                    <thead>
                      <tr>
                        <th style="text-align: center">IdWeb</th>
                        <th style="text-align: center">Folio</th>
                        <th style="text-align: center">Fecha</th>
                        <th style="text-align: center">Tipo</th>
                        <th style="text-align: center">Solicitante</th>
                        <th style="text-align: center">Área</th>
                        <th style="text-align: center">Responsable Almacén</th>
                        <th style="text-align: center">Documento</th>
                      </tr>
                    </thead>
                    <tbody align="center">
                      <tr>
                          <td><?php echo $obj->getIdRequisicion(); ?></td>
                          <td><?php print_r($datosRequisicion[0][0]); ?></td>
                          <td><?php print_r($datosRequisicion[0][3]); ?></td>
                          <td><?php print_r($datosRequisicion[0][4]); ?></td>
                          <td><?php print_r($datosRequisicion[0][1]); ?></td>
                          <td><?php print_r($datosRequisicion[0][2]); ?></td>
                          <td><?php print_r($datosRequisicion[0][5]); ?></td>
                          <td><a href="requisicionPDF.php?id=<?php echo $obj->getIdRequisicion(); ?>" class="btn btn-success" target="_blank">Descargar</a></td>
                      </tr>
                    </tbody>
                </table>
            </div>
                
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>Número</th>
                        <th>Artículo</th>
                        <th>Cant. Solicitada</th>
                        <th>Estado</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php 
                        for ($i = 0; $i < count($materialRequisicion); $i++) 
                        {
                            echo '
                            <tr>
                                <td>'. $materialRequisicion[$i][0] .'</td>
                                <td>'. $materialRequisicion[$i][1] .' - '. $materialRequisicion[$i][2] .'</td>
                                <td>'. $materialRequisicion[$i][4] .'</td>
                                <td>'. $materialRequisicion[$i][5] .'</td>'
                                    . '</tr>';
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
