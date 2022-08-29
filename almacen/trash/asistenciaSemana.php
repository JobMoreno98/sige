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
    $(document).ready(function(){
        $("#buscarSemana").click(function()
        {
            var x = $("#busqueda").serialize();
            $.ajax(
                    {
                    url: 'asistenciaSemanaBusqueda.php',
                    type: 'POST',
                    data: x,
                    beforeSend:function() {
                        $("#respuestaBusqueda").html('<div class="container"><h4>Cargando..</h4></div>');
                    },
                    success: function(data) {
                        $("#respuestaBusqueda").html(data);
                    }
                    });
        } 
        );
    });
    </script>
</head>
<body>
    <?php
    include 'barraMenu.php';
    $menu = new menu();
    $menu ->barraMenu();
    
    include 'asistencia.php';
    $obj = new asistencia();
    date_default_timezone_set("America/Mexico_City");
    ?>
    <div class="container">
        <div class="page-header">
                <h3 style="text-align: center">Reporte Semanal por Personal</h3>
        </div>
        
        <form class="form-horizontal" id="busqueda"  method="post">
            <div class="form-group">
              <label class="control-label col-sm-2" for="semana">Semana:</label>
              <div class="col-sm-10">
                  <input type="week" class="form-control" id="semana" name="semana" value="<?php echo date("Y").'-W'. date("W");?>" required="week">
                  
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="codigo">Personal:</label>
              <div class="col-sm-10">          
                  <select class="form-control" id="codigo" name="codigo" required>
                    <!--<option value="" disabled selected>Sin seleccionar</option>-->
                    <?php $obj->consultaEmpleados(); ?>
                  </select>
              </div>
            </div>
        </form>
        <div class="form-group">        
          <div class="col-sm-offset-2 col-sm-10">
            <input type="button" class="btn btn-primary" id="buscarSemana" value="Buscar">
            <a href="index.php" class="btn btn-default">Salir</a>
          </div>
        </div>
    </div>
    <br>
    <div id="respuestaBusqueda"></div>
    <br>
</body>
</html>