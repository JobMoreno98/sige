<!DOCTYPE html>
 <?php
 include './loginSecurity.php';
    if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'RH-Almacen' and $_SESSION['privilegios'] != 'Recursos Humanos') {
    header('location: index.php');
} 
include 'asistencia.php';
$obj = new asistencia();

date_default_timezone_set("America/Mexico_City");

$obj->setCodigo($_POST['codigo']);
$obj->setSemana($_POST['semana']);

$empl = $obj->consultaEmpleadoPorCodigo();
$semanaEmp = $obj->consultaSemanaEmpleado();
$ultimoRegistro = count($semanaEmp) - 1;
$totalSeg = 0;

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

if ($semanaEmp != null) 
{
?>
    <div class="container">
        <div class="page-header">
                <h3 style="text-align: center">Reporte Semanal por Personal</h3>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                  <tr>
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
                        <th style="text-align: center">Fecha</th>
                        <th style="text-align: center">Hora Entrada</th>
                        <th style="text-align: center">Hora Salida</th>
                        <th style="text-align: center">Horas por Día</th>
                        <th style="text-align: center">Registros</th>   
                    </tr>
                </thead>

                <tbody align="center">
                <?php
                for ($i = $semanaEmp[0][3]; $i <= $semanaEmp[$ultimoRegistro][3]; $i++) // cicla los dias de la semana
                {
                    $entrada = null;
                    $salida = null;
                    for ($j = 0; $j < count($semanaEmp); $j++) //cicla todos los registros
                    {
                        if ($i == $semanaEmp[$j][3])//toma cada dia de la semana 
                        {
                            if ($entrada == null)//toma el primero registro del dia 
                            {
                                $entrada = new DateTime($semanaEmp[$j][1]);
                                $entradaf = $semanaEmp[$j][2];//asigna la hora de entrada registrada

                                $nombreDia = '';
                                switch ($semanaEmp[$j][6])//Cambia el día a español 
                                {
                                    case 'Mon':
                                        $nombreDia = 'Lunes ';
                                        break;
                                    case 'Tue':
                                        $nombreDia = 'Martes ';
                                        break;
                                    case 'Wed':
                                        $nombreDia = 'Miercoles ';
                                        break;
                                    case 'Thu':
                                        $nombreDia = 'Jueves ';
                                        break;
                                    case 'Fri':
                                        $nombreDia = 'Viernes ';
                                        break;
                                    case 'Sat':
                                        $nombreDia = 'Sabado ';
                                        break;
                                    case 'Sun':
                                        $nombreDia = 'Domingo ';
                                        break;
                                    default:
                                        break;
                                }
                                $fechaConDia = $nombreDia.$semanaEmp[$j][7];//asigna la fecha del registro
                                $fecha = $semanaEmp[$j][7];

                            }
                            else 
                            {
                                $salida = new DateTime($semanaEmp[$j][1]);
                                $salidaF = $semanaEmp[$j][2];
                            }
                        }
                    }

                    if ($salida == null) //verificar cuando solo hay un registro en un dia
                    {
                        $salida = $entrada;
                        $salidaF = $entradaf;
                    }
                    if ($entrada != null)//elimina los días que no asiste el personal 
                    {
                        $p =  $entrada->diff($salida);
                        ?>
                        <tr>
                            <td><?php echo $fechaConDia; ?></td>
                            <td><?php echo $entradaf; ?></td>
                            <td><?php echo $salidaF; ?></td>
                            <td><?php print_r($p->format('%H:%I:%S')); ?></td>
                            <td><a href="asistenciaRegistro.php?c=<?php print_r($empl[1]); ?>&f=<?php echo $fecha; ?>" class="btn btn-default" target="_blank">Mostrar</a></td>
                        </tr>    
                        <?php
                        $tiempoSum = $p->format('%H:%I:%S');
                        $dt = new DateTime("1970-01-01 $tiempoSum", new DateTimeZone('UTC'));
                        $seconds2 = (int)$dt->getTimestamp();
                        $totalSeg = $totalSeg + $seconds2;
                    }
                }

                $hours = floor($totalSeg / 3600);
                $mins = floor($totalSeg / 60 % 60);
                $secs = floor($totalSeg % 60);

                $totalSuma = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
                ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" style="text-align:right">Total Horas por Semana:</th>
                        <th style="text-align: center"><?php echo $totalSuma; ?></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
<?php
}
else 
{
    ?>
    <div class="container">
        <p class="bg-danger">No se encontraron registros con los datos ingresados, intente de nuevo.</p>
    </div>
    <?php
}
?>
<br>
</body>
</html>
        