<?php
 include './loginSecurity.php';
    if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'RH-Almacen' and $_SESSION['privilegios'] != 'Recursos Humanos') {
    header('location: index.php');
}
include 'asistencia.php';
$obj = new asistencia();

date_default_timezone_set("America/Mexico_City");

$obj->setCodigo($_POST['codigo']);
$obj->setMes($_POST['mes']);

$empl = $obj->consultaEmpleadoPorCodigo();
$mesEmp = $obj->consultaMesEmpleado();
$periodoVac = $obj->consultaPeriodosVacacionales();
$horarioPer = $obj->consultaHorariosPersona();
$ultimoRegistro = count($mesEmp) - 1;
 ?>
<script>
$(document).ready(function(){
    $("td:contains(Retardo)").css("color", "red");
});
</script>
<div class="container">
    <?php
    if ($mesEmp != null && $horarioPer != null) 
    {
    ?>     
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
                    <th style="text-align: center">Periodo</th>
                    <th style="text-align: center">Registro de Entrada</th>
                    <th style="text-align: center">Hora de Entrada</th>
                    <th style="text-align: center">Registro de Salida</th>
                    <th style="text-align: center">Hora de Salida</th>
                    <th style="text-align: center">Puntualidad</th>
                    <th style="text-align: center">Registros</th> 
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th style="text-align: center">Fecha</th>
                    <th style="text-align: center">Periodo</th>
                    <th style="text-align: center">Registro de Entrada</th>
                    <th style="text-align: center">Hora de Entrada</th>
                    <th style="text-align: center">Registro de Salida</th>
                    <th style="text-align: center">Hora de Salida</th>
                    <th style="text-align: center">Puntualidad</th>
                    <th style="text-align: center">Registros</th> 
                </tr>
            </tfoot>
            <tbody align="center">
            <?php
            for ($i = $mesEmp[0][6]; $i <= $mesEmp[$ultimoRegistro][6]; $i++)//cicla los registros por día del mes 
            {

                $fechaChecada = null;
                $salidaChecada = null;
                for ($j = 0; $j < count($mesEmp); $j++)//cicla todos los registros 
                {

                    if ($i == $mesEmp[$j][6])//toma cada día del mes 
                    {
//                            
                        if ($fechaChecada == null)//toma el primer registro de cada día 
                        {
                            $nombreDia = '';
                            switch ($mesEmp[$j][3]) //Cambia el día a español
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
                            $fecha = new DateTime($mesEmp[$j][4]);//Convierte la fecha consultada a formato date de php

                            $periodo = 0;
                            for ($k = 0; $k < count($periodoVac); $k++)//Cicla todos los registros del periodo vacacional 
                            {
                                if ($mesEmp[$j][4] >= $periodoVac[$k][0] && $mesEmp[$j][4] <= $periodoVac[$k][1])//Comprueba que la fecha este dentro de cada registro de periodo
                                {
                                    $periodo = 'Vacacional';
                                    $detallePeriodo = ', '.$periodoVac[$k][2];//Nombre del periodo vacacional
                                    $horaEstablecida = $horarioPer[2];//entradaVacaciones
                                    $salidaEstablecida = $horarioPer[5];//salidaVacaciones
                                }
                            }

                            if ($periodo === 0)//comprueba que no exista algun periodo vacacional dentro de la fecha 
                            {
                                $detallePeriodo = '';
                                $periodo = 'Normal';
                                if ($mesEmp[$j][3] == 'Sat' || $mesEmp[$j][3] == 'Sun')//Comprueba si la fecha cae en fin de semana 
                                {
                                    $horaEstablecida = $horarioPer[1];//entradaSabDom
                                    $salidaEstablecida = $horarioPer[4];//salidaSabDom
                                }
                                else//comprueba si la fecha cae entre semana
                                {
                                    $horaEstablecida = $horarioPer[0];//entradaLunVie
                                    $salidaEstablecida = $horarioPer[3];//salidaLunVie
                                }
                            }

                            $fechaChecada = new DateTime($mesEmp[$j][1]);//convierte la fecha con hora a date de php

                            $horaChecada = $fechaChecada->format('H:i:s');//divide el registro en horario
                            $horaChecadaSegungos = new DateTime("1970-01-01 $horaChecada", new DateTimeZone('UTC'));//envia el registro con fecha null
                            $segundosChecados = (int)$horaChecadaSegungos->getTimestamp();//Convierte el registro a segundos

                            $horaEstablecidaSegundos = new DateTime("1970-01-01 $horaEstablecida", new DateTimeZone('UTC'));//envia el registro con fecha null
                            $segundosEstablecidos = (int)$horaEstablecidaSegundos->getTimestamp();//Convierte el registro a segundos

                            if ($segundosChecados>$segundosEstablecidos + 900)//comprueba en segundos si el registro es retardo, 900 segundos equivalen a 15 minutos 
                            {
                                $puntualidad = 'Retardo';
                            }
                            else 
                            {
                                $puntualidad = 'Normal';
                            }
                        }
                        else//toma los ultimos registros de salida de cada día 
                        {
                            $salidaChecada = $mesEmp[$j][2];
                        }

                        if ($salidaChecada == null) //verificar cuando solo hay un registro en un dia
                        {
                            $salidaChecada = $horaChecada;
                        }
                    }
                }
                if ($salidaChecada != null)//elimina los días que no asiste el personal 
                {
                    ?>
                    <tr>
                        <td><?php echo $nombreDia.$fecha->format('d-m-Y'); ?></td>
                        <td><?php echo $periodo.$detallePeriodo; ?></td>
                        <td><?php echo $horaChecada; ?></td>
                        <td><?php echo $horaEstablecida; ?></td>
                        <td><?php echo $salidaChecada; ?></td>
                        <td><?php echo $salidaEstablecida; ?></td>
                        <td id="puntualidad"><?php echo $puntualidad; ?></td>
                        <td><a href="asistenciaRegistro.php?c=<?php print_r($empl[1]); ?>&f=<?php echo $fecha->format('d-m-Y'); ?>" class="btn btn-default" target="_blank">Mostrar</a></td>
                    </tr>    
                    <?php
                }
            }
            ?>
            </tbody>
        </table>
    </div>
    <?php
    }
    else 
    {
        ?>
        <div class="container">
            <p class="bg-danger">No se encontraron registros con los datos ingresados, revise que el personal tenga horario asignado e intente de nuevo.</p>
        </div>
        <?php
    }
    ?>
</div>

