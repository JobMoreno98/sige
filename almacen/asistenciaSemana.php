<!DOCTYPE html>
<?php
    include './loginSecurity.php';
    if ($_SESSION['privilegios'] != 'Administrador'
    and $_SESSION['privilegios'] != 'RH-Almacen'
    and $_SESSION['privilegios'] != 'Recursos Humanos') {
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

 </head>
 <body>
     <?php
         include 'barraMenu.php';
         $menu = new menu();
         $menu ->barraMenu();
         include 'horarioCumplido.php';
         $obj = new horarioCumplido();
         date_default_timezone_set("America/Mexico_City");
     ?>
     <div class="container">
         <div class="page-header">
             <h3 style="text-align: center">Reporte Semanal de Personal</h3>
         </div>
         <form class="form-horizontal" action="asistenciaSemanaBusqueda.php" method="POST">
             <div class="form-group">
               <label class="control-label col-sm-2" for="semana">Semana:</label>
               <div class="col-sm-10">
                   <input id="semana" type="date" class="form-control" name="semana" required>
               </div>
             </div>
             <div class="form-group">
               <label class="control-label col-sm-2" for="tipoReporte">Área Reporte:</label>
               <div class="col-sm-10">
                   <select class="form-control" id="tipoReporte" name="tipoReporte" required>
                     <option value="Contemporaneo">Contemporáneo</option>
                     <option value="Historico">Histórico</option>
                     <option value="Servicios generales">Servicios generales</option>
                     <option value="Mixto">Mixto</option>
                     <option value="Agua Azul">Agua Azul</option>
                     <option Otro>Otro</option>
                   </select>
               </div>
             </div>
         <div class="form-group">
           <div class="col-sm-offset-2 col-sm-10">
             <button type="submit" class="btn btn-primary">Consultar</button>
             <a href="index.php" class="btn btn-default">Salir</a>
           </div>
         </div>
         </form>
     </div>
 </body>
 </html>
