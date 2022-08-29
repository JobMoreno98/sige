<!DOCTYPE html>
<?php
 include './loginSecurity.php';
    if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'RH-Almacen' and $_SESSION['privilegios'] != 'Recursos Humanos') {
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
        ?>
        <div class="container">
            <div class="page-header">
                <h3 style="text-align: center">Captura de Asistencias</h3>
            </div>
            <form action="asistenciaAltaConfirmar.php" method="post">
                <div class="form-group">
                  <label for="fechaInicio">Fecha Inicio:</label>
                  <input type="date" class="form-control" id="fechaInicio" name="fechaInicio" required="date">
                </div> 
                <div class="form-group">
                  <label for="fechaFin">Fecha Fin:</label>
                  <input type="date" class="form-control" id="fechaFin" name="fechaFin" required="date">
                </div> 
                <div class="form-group">
                  <label for="comment">Comment:</label>
                  <textarea class="form-control" rows="20" id="comment" name="datos" required></textarea>
                </div>
                <div class="form-group">        
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                    <a href="index.php" class="btn btn-default">Salir</a>
                </div>
            </form>
        </div>
        <br>
    </body>
</html>

