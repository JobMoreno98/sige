<?php
class menu {
    function barraMenu() {
        ?>
            <nav class="navbar navbar-inverse">
              <div class="container-fluid">
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                    <a class="navbar-brand" href="index.php">SIGE BPEJ</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                  <ul class="nav navbar-nav">
                      <li><a href="index.php">Inicio</a></li>
                      <li><a href="muebleConsulta.php">Mobiliario</a></li>
                      <?php
                      if($_SESSION['privilegios']!='Director'){
                        echo '<li><a href="equipoConsulta.php">Equipos</a></li>';
                      }else{
                          echo '<li><a href="equipoInventariableConsulta.php">Equipos</a></li>';
                          echo '<li><a href="areaConsulta.php">Listado de Áreas</a></li>';
                      }
                      ?>
                      <li><a href="ticketsUsuario.php"> Consulta Ticket </a></li>
                      <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Catálogo Muebles <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="muebleCatalogoConsulta.php?tipo=Histórico">Mueble Histórico</a></li>
                                <li><a href="muebleCatalogoConsulta.php?tipo=Contemporáneo 2da Generación">Segunda Generación</a></li>
                                <li><a href="muebleCatalogoConsulta.php?tipo=Contemporáneo Belenes">Contemporáneo Belenes (3ra. Generación)</a></li>
                                <li><a href="muebleCatalogoConsulta.php">Catálogo Completo</a></li>
                               <?php
                                if($_SESSION['privilegios'] == 'EncargadoCatHist' || $_SESSION['privilegios'] == 'Administrador' || $_SESSION['privilegios'] == 'Sistemas'){
                                echo '<li><a href="arteConsulta.php">Catálogo de Pinturas, Objetos y Similares</a></li>';
                                }
                                ?>

                            </ul>
                      </li>


                    <?php
                    if ($_SESSION['privilegios'] == 'Administrador' || $_SESSION['privilegios'] == 'Encargado Almacén' || $_SESSION['privilegios'] == 'RH-Almacen' || $_SESSION['privilegios'] == 'Coordinador' || $_SESSION['privilegios'] == 'Ayudante Almacén' || $_SESSION['privilegios'] == 'Dirección')
                    {
                        ?>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Papelería <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                        <?php
                    }
                        if ($_SESSION['privilegios'] == 'Administrador' || $_SESSION['privilegios'] == 'Encargado Almacén' || $_SESSION['privilegios'] == 'RH-Almacen')
                        {
                            if ($_SESSION['tipoArea'] == 'Gestión' || $_SESSION['tipoArea'] == 'Administrativa')
                            {
                                if ($_SESSION['privilegiosEmpleado'] == 'Administrador' || $_SESSION['privilegiosEmpleado'] == 'Responsable')
                                {
                                    ?>
                                        <li><a href="../../sige/requisicionAltaEntregado.php?tipo=Papelería"><img src="images/papeleria.png"> Capturar Requisición Entregada</a></li>
                                        <li role="separator" class="divider"></li>
                                    <?php
                                }
                            }
                        }

                        if ($_SESSION['privilegios'] == 'Administrador' || $_SESSION['privilegios'] == 'Encargado Almacén' || $_SESSION['privilegios'] == 'RH-Almacen' || $_SESSION['privilegios'] == 'Coordinador')
                        {
                            if ($_SESSION['tipoArea'] == 'Gestión' || $_SESSION['tipoArea'] == 'Administrativa')
                            {
                                if ($_SESSION['privilegiosEmpleado'] == 'Administrador' || $_SESSION['privilegiosEmpleado'] == 'Responsable')
                                {
                                    ?>
                                        <li><a href="../../sige/requisicionAlta.php?tipo=Papelería"><img src="images/agregarpapeleria.png"> Alta Requisición Papelería</a></li>
                                        <li><a href="../../sige/requisicionConsultaArea.php?t=Papelería"><img src="images/volantes.png"> Requisiciones Solicitadas Papelería</a></li>
                                    <?php
                                }
                            }
                        }

                        if ($_SESSION['privilegios'] == 'Administrador' || $_SESSION['privilegios'] == 'Encargado Almacén' || $_SESSION['privilegios'] == 'RH-Almacen' || $_SESSION['privilegios'] == 'Ayudante Almacén')
                        {
                            ?>
                                <li><a href="../../sige/requisicionConsulta.php?t=Papelería"><img src="images/nota.png"> Listado de Requisiciones Papelería</a></li>
                            <?php
                        }

                        if ($_SESSION['privilegios'] == 'Administrador' || $_SESSION['privilegios'] == 'Encargado Almacén' || $_SESSION['privilegios'] == 'RH-Almacen')
                        {
                            ?>
                                <li role="separator" class="divider"></li>
                                <li><a href="../../sige/compraAlta.php?tipo=Papelería"><img src="images/compras.png"> Agregar Compra</a></li>
                                <li><a href="../../sige/compraConsulta.php?tipo=Papelería"><img src="images/listadecompras.png">Listado de Compras Papelería</a></li>
                            <?php
                        }

                        if ($_SESSION['privilegios'] == 'Administrador' || $_SESSION['privilegios'] == 'Encargado Almacén' || $_SESSION['privilegios'] == 'RH-Almacen' || $_SESSION['privilegios'] == 'Ayudante Almacén' || $_SESSION['privilegios'] == 'Dirección')
                        {
                            ?>
                                <li role="separator" class="divider"></li>
                                <li><a href="../../sige/materialConsulta.php?t=Papelería"><img src="images/almacen.png"> Inventario General de Papelería</a></li>
                                <li><a href="../../sige/materialProyeccion.php?t=Papelería"><img src="images/portapapeles.png"> Proyección Compra de Papelería 2018</a></li>
                                <li role="separator" class="divider"></li>
                            <?php
                        }

                        if ($_SESSION['privilegios'] == 'Administrador' || $_SESSION['privilegios'] == 'Encargado Almacén' || $_SESSION['privilegios'] == 'RH-Almacen' || $_SESSION['privilegios'] == 'Dirección')
                        {
                            ?>
                                <li><a href="../../sige/requisicionConsultaAreas.php?tipo=Papelería"><img src="images/listado.png"> Listado de Coordinaciones Papelería</a></li>
                                <li><a href="../../sige/materialPorCaducar.php?t=Papelería"><img src="images/fin.png"> Productos a Caducar</a></li>
                                 <li role="separator" class="divider"></li>
                                 <li><a href="equipoConsultaImpresoras.php"><img src="images/impresora2..png"> Impresoras</a></li>
                            <?php
                        }

                    if ($_SESSION['privilegios'] == 'Administrador' || $_SESSION['privilegios'] == 'Encargado Almacén' || $_SESSION['privilegios'] == 'RH-Almacen' || $_SESSION['privilegios'] == 'Coordinador' || $_SESSION['privilegios'] == 'Ayudante Almacén' || $_SESSION['privilegios'] == 'Dirección')
                    {
                        ?>
                            </ul>
                        </li>
                        <?php
                    }


                    if ($_SESSION['privilegios'] == 'Administrador' || $_SESSION['privilegios'] == 'Encargado Almacén' || $_SESSION['privilegios'] == 'RH-Almacen' || $_SESSION['privilegios'] == 'Coordinador' || $_SESSION['privilegios'] == 'Ayudante Almacén' || $_SESSION['privilegios'] == 'Dirección')
                    {
                        ?>
                         <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Limpieza <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                        <?php
                    }
                        if ($_SESSION['privilegios'] == 'Administrador' || $_SESSION['privilegios'] == 'Encargado Almacén' || $_SESSION['privilegios'] == 'RH-Almacen')
                        {
                            if ($_SESSION['tipoArea'] == 'Gestión')
                            {
                                if ($_SESSION['privilegiosEmpleado'] == 'Administrador')
                                {
                                   ?>
                                        <li><a href="../../sige/requisicionAltaEntregado.php?tipo=Limpieza">Capturar Requisición Entregada</a></li>
                                        <li role="separator" class="divider"></li>
                                    <?php
                                }

                            }
                        }

                        if ($_SESSION['privilegios'] == 'Administrador' || $_SESSION['privilegios'] == 'Encargado Almacén' || $_SESSION['privilegios'] == 'RH-Almacen' || $_SESSION['privilegios'] == 'Coordinador')
                        {
                            if ($_SESSION['tipoArea'] == 'Gestión')
                            {
                                if ($_SESSION['privilegiosEmpleado'] == 'Administrador')
                                {
                                   ?>
                                        <li><a href="../../sige/requisicionAlta.php?tipo=Limpieza">Alta Requisición Limpieza</a></li>
                                        <li><a href="../../sige/requisicionConsultaArea.php?t=Limpieza">Requisiciones Solicitadas Limpieza</a></li>
                                    <?php
                                }

                            }
                        }

                        if ($_SESSION['privilegios'] == 'Administrador' || $_SESSION['privilegios'] == 'Encargado Almacén' || $_SESSION['privilegios'] == 'RH-Almacen' || $_SESSION['privilegios'] == 'Ayudante Almacén')
                        {
                            ?>
                                <li><a href="../../sige/requisicionConsulta.php?t=Limpieza"><img src="images/listado.png"> Listado de Requisiciones Limpieza</a></li>
                            <?php
                        }

                        if ($_SESSION['privilegios'] == 'Administrador' || $_SESSION['privilegios'] == 'Encargado Almacén' || $_SESSION['privilegios'] == 'RH-Almacen')
                        {
                            ?>
                                <li role="separator" class="divider"></li>
                                <li><a href="../../sige/compraAlta.php?tipo=Limpieza"><img src="images/agregarcompra.png"> Agregar Compra</a></li>
                                <li><a href="../../sige/compraConsulta.php?tipo=Limpieza"><img src="images/listadelimpieza.png"> Listado de Compras Limpieza</a></li>
                            <?php
                        }

                        if ($_SESSION['privilegios'] == 'Administrador' || $_SESSION['privilegios'] == 'Encargado Almacén' || $_SESSION['privilegios'] == 'RH-Almacen' || $_SESSION['privilegios'] == 'Ayudante Almacén' || $_SESSION['privilegios'] == 'Dirección')
                        {
                            ?>
                                <li role="separator" class="divider"></li>
                                <li><a href="../../sige/materialConsulta.php?t=Limpieza"><img src="images/almacenamiento.png"> Inventario General de Limpieza</a></li>
                                <li><a href="../../sige/materialProyeccion.php?t=Limpieza">Proyección Compra de Limpieza 2018</a></li>
                                <li role="separator" class="divider"></li>
                            <?php
                        }

                        if ($_SESSION['privilegios'] == 'Administrador' || $_SESSION['privilegios'] == 'Encargado Almacén' || $_SESSION['privilegios'] == 'RH-Almacen' || $_SESSION['privilegios'] == 'Dirección')
                        {
                            ?>
                                <li><a href="../../sige/requisicionConsultaAreas.php?tipo=Limpieza">Listado de Coordinaciones Papelería</a></li>
                                <li><a href="../../sige/materialPorCaducar.php?t=Limpieza">Productos a Caducar</a></li>
                            <?php
                        }

                    if ($_SESSION['privilegios'] == 'Administrador' || $_SESSION['privilegios'] == 'Encargado Almacén' || $_SESSION['privilegios'] == 'RH-Almacen' || $_SESSION['privilegios'] == 'Coordinador' || $_SESSION['privilegios'] == 'Ayudante Almacén' || $_SESSION['privilegios'] == 'Dirección')
                    {
                        ?>
                            </ul>
                        </li>
                        <?php
                    }



                    //Menú para encargado de Inventario Histórico
                    if ($_SESSION['privilegios'] == 'Encargado AVS')
                        {
                            ?>
                            <li class="dropdown">
                              <a class="dropdown-toggle" data-toggle="dropdown" href="#">Listados de SIIAU <span class="caret"></span></a>
                              <ul class="dropdown-menu">
                                    <li><a href="equipoSIIAUConsulta.php">Equipo en SIIAU</a></li>
                                    <li role="separator" class="divider"></li>
                                  <li><a href="muebleSIIAUConsulta.php">Listado de Mobiliario en SIIAU</a></li>
                              </ul>
                            </li>

                            <?php
                        }
                    //Menú para Sistemas
                    if ($_SESSION['privilegios'] == 'Administrador' || $_SESSION['privilegios'] == 'Sistemas' )
                        {
                            ?>
                            <li class="dropdown">
                              <a class="dropdown-toggle" data-toggle="dropdown" href="#">Administrador <span class="caret"></span></a>
                              <ul class="dropdown-menu">
                                <li><a href="usuarioAlta.php">Capturar Nuevo Usuario</a></li>
                                <li><a href="usuarioConsulta.php">Listado de Usuarios</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="logConsulta.php">Ver Log</a></li>
                              </ul>
                            </li>

                            <?php
                        }
                        if ($_SESSION['privilegios'] == 'Administrador' || $_SESSION['privilegios'] == 'Sistemas' )
                        {
                            ?>
                            <li class="dropdown">
                              <a class="dropdown-toggle" data-toggle="dropdown" href="#">Mobiliario <span class="caret"></span></a>
                              <ul class="dropdown-menu">
                                <li><a href="catalogoMuebleAlta.php">Capturar Catálogo Muebles</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="muebleAlta.php">Capturar Nuevo Mobiliario</a></li>
                                <li><a href="muebleConsulta.php">Listado de Muebles</a></li>
                                <li role="separator" class="divider"></li>
                                 <li><a href="muebleListadoTotalesConsulta.php">Listado de Mobiliario Totales por Piso SIGE vs SIIAU</a></li>
                                 <li><a href="muebleListadoTotalesConsultaSIGE.php">Listado de Mobiliario Totales por Piso solo SIGE</a></li>
                                  <li role="separator" class="divider"></li>
                                  <li><a href="muebleSIIAUConsulta.php">Listado de Mobiliario en SIIAU</a></li>
                              </ul>
                            </li>
                            <li class="dropdown">
                              <a class="dropdown-toggle" data-toggle="dropdown" href="#">Tecnologías <span class="caret"></span></a>
                              <ul class="dropdown-menu">
                                <li><a href="ticketConsulta.php"><img src="../../sige/images/tickets.png"> Tickets</a></li>
                                <li><a href="ticketAlta.php"><img src="../../sige/images/agregar.png"> Nuevo Ticket</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="tecnicosConsulta.php"><img src="images/television.png"> Técnicos</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="areaAlta.php">Capturar Nueva Área</a></li>
                                <li><a href="areaConsulta.php">Listado de Áreas</a></li>
                              </ul>
                            </li>


                            <li class="dropdown">
                              <a class="dropdown-toggle" data-toggle="dropdown" href="#">Equipo <span class="caret"></span></a>
                              <ul class="dropdown-menu">
                                <li><a href="equipoConsulta.php">Consulta de Equipos</a></li>
                                <li><a href="equipoAlta.php">Alta de Equipo</a></li>
                                <li><a href="movimientoEquipoAlta.php">Capturar Movimiento de Equipo</a></li>
                                <li><a href="equipoConsultaMovimientos.php">Historial de Movimientos Equipos</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="equipoConsultaImpresoras.php">Impresoras</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="equipoInventariableConsulta.php">Equipo Inventariable</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="equipoListadoTotalesConsultaSIGE.php">Totales de Equipo solo SIGE</a></li>
                                <li><a href="equipoSIIAUConsulta.php">Equipo en SIIAU</a></li>

                              </ul>
                            </li>
                            <?php
                        }
         //Menú para Dirección
                            if ($_SESSION['privilegios'] == 'Administrador' || $_SESSION['privilegios'] == 'Dirección' || $_SESSION['privilegios'] == 'Finanzas')
                        {
                            ?>
                            <li class="dropdown">
                              <a class="dropdown-toggle" data-toggle="dropdown" href="#">Finanzas <span class="caret"></span></a>
                              <ul class="dropdown-menu">
                                <li><a href="../../sige/cuentaAlta.php">Capturar Cuenta</a></li>
                                <li><a href="../../sige/cuentaConsulta.php">Listado de Cuentas</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="../../sige/pagoAlta.php?anio=2018">Capturar Nuevo Pago</a></li>
                                <li><a href="../../sige/pagoConsulta.php?anio=2018">Listado de Pagos</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="../../sige/movimientoAlta.php">Capturar Cargo - Abono</a></li>
                                <li><a href="../../sige/movimientoConsulta.php">Listado de Movimientos</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="../../sige/facturaAlta.php?anio=2018">Capturar Nueva Factura</a></li>
                                <li><a href="../../sige/facturaConsulta.php">Listado de Facturas</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="../../sige/proveedorAlta.php">Capturar Nuevo Proveedor</a></li>
                                <li><a href="../../sige/proveedorConsulta.php">Listado de Proveedores</a></li>

                              </ul>
                            </li>
                            <li class="dropdown">
                              <a class="dropdown-toggle" data-toggle="dropdown" href="#">Finanzas 2017<span class="caret"></span></a>
                              <ul class="dropdown-menu">
                                <li><a href="../../sige/cuentaConsulta.php?anio=2017">Listado de Cuentas 2017</a></li>
                                <li role="separator" class="divider"></li>

                                <li><a href="../../sige/pagoConsulta.php?anio=2017">Listado de Pagos 2017</a></li>
                                <li role="separator" class="divider"></li>

                                <li><a href="../../sige/movimientoConsulta.php">Listado de Movimientos 2017</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="../../sige/facturaAlta.php?anio=2017">Capturar Nueva Factura 2017</a></li>
                                <li><a href="../../sige/facturaConsulta.php">Listado de Facturas 2017</a></li>
                                  </ul>
                            </li>
                            <?php
                        }
                if ($_SESSION['privilegios'] == 'Administrador' || $_SESSION['privilegios'] == 'Prestadores')
                        {
                            ?>
                            <li class="dropdown">
                              <a class="dropdown-toggle" data-toggle="dropdown" href="#">Prestadores <span class="caret"></span></a>
                              <ul class="dropdown-menu">
                                <li><a href="../../sige/altaPrestador.php">Capturar Nuevo Prestador</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="prestadoresConsulta.php">Consulta Prestadores Activos</a></li>
                                <li><a href="prestadoresConsultaTodos.php">Consulta Prestadores Todos</a></li>

                              </ul>
                            </li>
                            <?php
                        }

                        if ($_SESSION['privilegios'] == 'Administrador' || $_SESSION['privilegios'] == 'RH-Almacen' || $_SESSION['privilegios'] == 'Recursos Humanos')
                        {
                            ?>
                            <li class="dropdown">
                              <a class="dropdown-toggle" data-toggle="dropdown" href="#">Recursos Humanos <span class="caret"></span></a>
                              <ul class="dropdown-menu">
                                <li><a href="../../sige/empleadoAlta.php">Capturar Nuevo Personal</a></li>
                                <li><a href="../../sige/empleadoConsulta.php">Listado de Personal</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="../../sige/suplenciaAlta.php">Alta de Suplencias</a></li>
                                <li><a href="../../sige/suplenciaConsulta.php">Listado de Suplencias</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="../../sige/nombramientoAlta.php">Capturar Nuevo Nombramiento</a></li>
                                <li><a href="../../sige/nombramientoConsulta.php">Listado de Nombramientos</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="../../sige/permisoAlta.php"><img src='images/nuevo.png'> Capturar Nuevo Permiso</a></li>
                                <li><a href="../../sige/incapacidad.php"><img src='images/nuevo.png'> Capturar Incapacidad, Licencia o Comosión</a></li>
                                <li><a href="../../sige/permisoConsulta.php"><img src='images/nuevo.png'> Listado de Permisos</a></li>
                                <li><a href="../../sige/incapacidadConsulta.php"><img src='images/nuevo.png'> Listado de Permisos (Incapacidad, Licencia y Comisión)</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="../../sige/asistenciaSemana.php"><img src='images/nuevo.png'> Reporte Semanal por Personal</a></li>
                                <li><a href="../../sige/asistenciaMes.php"><img src='images/nuevo.png'> Reporte Mensual por Personal</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="../../sige/horarioAlta.php"><img src='images/nuevo.png'> Capturar Horario de Personal</a></li>
                                <li><a href="../../sige/horarioConsulta.php"><img src='images/nuevo.png'> Listado de Horarios</a></li>
                                  <li><a href="../../sige/CargarAsistencia.php"><img src='images/nuevo.png'> Cargar Asistencias</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="../../sige/periodoVacacionalAlta.php">Captura Periodo Vacacional</a></li>
                                <li><a href="../../sige/periodoVacacionalConsulta.php">Listado de Periodos Vacacionales</a></li>
                              </ul>
                            </li>
                            <?php
                        }

                        if ($_SESSION['privilegios'] == 'Administrador' || $_SESSION['privilegios'] == 'RH-Almacen' || $_SESSION['privilegios'] == 'Encargado Almacén')
                        {
                            ?>
                            <li class="dropdown">
                              <a class="dropdown-toggle" data-toggle="dropdown" href="#">Almacén <span class="caret"></span></a>
                              <ul class="dropdown-menu">
                                <li><a href="../../sige/materialAlta.php">Capturar Nuevo Material</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="../../sige/proveedorAlta.php">Capturar Nuevo Proveedor</a></li>
                                <li><a href="../../sige/proveedorConsulta.php">Listado de Proveedores</a></li>
                              </ul>
                            </li>
                            <?php
                        }
                    ?>
                    <!---
                    <li class="dropdown">
                      <a class="dropdown-toggle" data-toggle="dropdown" href="#">Permisos <span class="caret"></span></a>
                      <ul class="dropdown-menu">
                          <li><a href="../../sige/permisoAlta.php">Capturar Nuevo Permiso</a></li>
                          <li><a href="../../sige/permisoConsultaEmpl.php">Permisos Solicitados</a></li>
                      </ul>
                    </li>-->
                  </ul>
                  <ul class="nav navbar-nav navbar-right">

                    <li><a><?php echo $_SESSION['nombreUsuario']; ?></a></li>
                    <li><a href="../../sige/loginCerrar.php">Cerrar Sesión</a></li>
                    <li><a href="../sic/index.php">Ir a SIC</a></li>
                  </ul>
                </div>
              </div>
            </nav>
            <div class="container-fluid">
                <div class="col-sm-3"><center><img class="img-responsive" src="images/BIBLIOTECA_300.jpg" style="padding-top: 8%"></center></div>
                <div class="col-sm-6"></div>
                <div class="col-sm-3"><center><img class="img-responsive" src="images/ccdLogo.png" style="padding-top: 8%"></center></div>
            </div>
    <?php
    }



    function caducidadMes($mes){
        $f= date('Y-m-d');
        $fechaCad= strtotime($mes.' month',strtotime($f));
        $fechaCad= date('Y-m-d',$fechaCad);

        return $fechaCad;
    }
}
