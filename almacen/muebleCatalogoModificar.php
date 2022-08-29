<?php
session_start();
include 'loginSecurity.php';
if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'Sistemas' and $_SESSION['privilegios'] != 'EncargadoCatHist' and $_SESSION['privilegios'] != 'EncargadoCat2daG' and $_SESSION['privilegios'] != 'EncargadoCat3raG') {
    header('location: index.php');
}
include_once 'mueble.php';
$mueble = new mueble();
$mueble->setIdCatalogoM($_GET['id']);
$mueble->muebleCatalogoModificar();
$mueble->muebleListadoPorTipo($mueble->getIdCatalogoM());
?>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Modificar Catálogo Mueble. BPEJ. Sistema Integral de GestiÃ³n</title>
        <title>Catálogo Mobiliario. SIGE. BPEJ</title>
        <link rel="shortcut icon" href="favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Equipo Desarrollo BPEJ">
        <!--bootstrap-->
        <link rel="stylesheet" href="css/bootstrap.css"><!-- Editado para el menu -->
        <!--jquery-->
        <script src="js/jquery-3.2.1.min.js"></script>
        <!--bootstrap-js-->
        <script src="js/bootstrap.min.js"></script>
        <!--Datatables-->
        <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css"/><!-- Editado y menu -->
        <script type="text/javascript" src="js/jquery.dataTables.js"></script><!-- Editado -->
        <!--Datatables responsive-->
        <link rel="stylesheet" type="text/css" href="css/responsive.dataTables.min.css"/>
        <script type="text/javascript" src="js/dataTables.responsive.min.js"></script>
        <!--Datatables Buttons-->
        <link rel="stylesheet" type="text/css" href="css/buttons.dataTables.css"/><!-- Editado y menu -->
        <script type="text/javascript" src="js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" src="js/buttons.html5.min.js"></script>
        <script type="text/javascript" src="js/pdfmake.min.js"></script><!--Imprimir PDF-->
        <script type="text/javascript" src="js/vfs_fonts.js"></script><!-- Imprimir PDF-->
        <script type="text/javascript" src="js/jszip.min.js"></script><!--Imprimir Excel-->
        <script type="text/javascript" src="js/buttons.print.min.js"></script><!--Imprimir pantalla-->
        
        <script>
            var arregloDT = <?php echo json_encode($mueble->muebleListadoPorTipo($mueble->getIdCatalogoM())); ?>;
            $(document).ready(function(){
                 var t = 'Listado de Cuentas';
                $('#dtPlantilla').DataTable( {
                    "data": arregloDT,
                    "order": [[ 3, "asc" ]],
                    responsive: true,
                    dom: '<"col-sm-5"l><"col-sm-3"B><"col-sm-4"f>rtip',
            //                    dom: es el orden de las funciones de la tabla
            //                    l: es la lista de numero de registros que se muestran 
            //                    B: son los botones para imprimir
            //                    f: es el filtro de busqueda
            //                    rt: son los registros de la tabla
            //                    i: es la información de registros
            //                    p: es la barra de paginación
            //tipo='Contemporáneo 2da Generación'tipo='Contemporáneo Belenes'"
                    buttons: [
                        {
                            extend: 'print',
                            title: t
                        },
                        {
                            extend: 'pdf',
                            title: t
                        },

                        {
                            extend: 'excel',
                            title: t
                        }
                    ]
                });
            });
        </script>
    </head>
    <body>
        <?php 
        include 'barraMenu.php';
        $menu = new menu();
        $menu ->barraMenu();
        
        
        ?>
        <div class="container-fluid">
          <div class="page-header">
              <h3 style="text-align: center">Modificar Catálogo Mueble</h3>
          </div>
            <div class="row">
                <div class="col-sm-offset-2 col-sm-5">
                    <img src="imgMuebles/<?php echo $mueble->getImgFrente(); ?>" height="40%"> 
                </div>
                 <div class="col-sm-2">
                 
                </div>
                <div class="col-sm-5">
                    <?php if($mueble->getImgLateral()!='No Disponible')
                    echo '<img src="imgMuebles/'.$mueble->getImgLateral().' height="40%"> ';
                    ?>
                </div>
            </div>
            
            <form class="form-horizontal" action="aplicarMovimiento.php" method="post" onsubmit="return confirm('¿Seguro que quieres guardar este formulario?');">
            <div class="form-group">
              <label class="control-label col-sm-2" for="idCatalogoM">Id Catálogo Mueble:</label>
              <div class="col-sm-2">
                  <input type="text" class="form-control" id="idCatalogoM" name="idCatalogoM" value="<?php echo $mueble->getIdCatalogoM(); ?>" readonly>
              </div>
            </div>
            
            <div class="form-group">
              <label class="control-label col-sm-2" for="descripcion">Descripción:</label>
              <div class="col-sm-8">
                  <input type="text" class="form-control" id="descripcion" name="descripcion" value="<?php echo $mueble->getDescripcion(); ?>" required>
              </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="origenMueble">Origen del Mueble:</label>
                <div class="col-sm-8">          
                    <select class="form-control" id="origenMueble" name="origenMueble" value="<?php echo $mueble->getOrigenMueble(); ?>" required>
                    <option value="<?php echo $mueble->getOrigenMueble(); ?>"><?php echo $mueble->getOrigenMueble(); ?></option>
                    <option value="" disabled>Sin seleccionar</option>
                    <option value="Compra mediante CGADM">Compra mediante CGADM o CCU</option>
                    <option value="Compra con Factura">Compra con Factura</option>
                    <option value="Donación">Donación</option>
                    <option value="No definido">No definido</option>
                    <option value="No aplica para inventario real">No aplica para inventario real</option>
                </select>
              </div>
            </div>    
            <div class="form-group">
              <label class="control-label col-sm-2" for="marca">Marca:</label>
              <div class="col-sm-8">
                  <input type="text" class="form-control" id="marca" name="marca" value="<?php echo $mueble->getMarca(); ?>" required>
              </div>
            </div>
            
            <div class="form-group">
              <label class="control-label col-sm-2" for="modelo">Modelo:</label>
              <div class="col-sm-8">
                  <input type="text" class="form-control" id="modelo" name="modelo" value="<?php echo $mueble->getModelo(); ?>" required>
              </div>
            </div>
              
            <div class="form-group">
              <label class="control-label col-sm-2" for="medidas">Medidas:</label>
              <div class="col-sm-8">
                  <input type="text" class="form-control" id="medidas" name="medidas" value="<?php echo $mueble->getMedidas(); ?>" required>
              </div>
            </div>
            <?php  
            echo '<div class="form-group">';
            if($_SESSION['privilegios']=='Administardor' or $_SESSION['privilegios']=='Sistemas'){
                echo '<label class="control-label col-sm-2" for="imgFrente">Imagen de Frente:</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="imgFrente" name="imgFrente" value="'.$mueble->getImgFrente().'" required>
                    </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-2" for="imgLateral">Imagen Lateral:</label>
                  <div class="col-sm-8">
                      <input type="text" class="form-control" id="imgLateral" name="imgLateral" value="'.$mueble->getImgLateral().'" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="fichaTecnica">Ficha Técnica</label>
                  <div class="col-sm-8">
                      <input type="text" class="form-control" id="fichaTecnica" name="fichaTecnica" value="'.$mueble->getFichaTecnica().'" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="IdTipoSIIAU">Id de SIIAU</label>
                  <div class="col-sm-8">
                      <input type="text" class="form-control" id="IdTipoSIIAU" name="IdTipoSIIAU" value="'.$mueble->getIdTipoSIIAU().'" required>
                  </div>
                </div>';
            }else{
                echo '<input type="hidden" class="form-control" id="imgFrente" name="imgFrente" value="'.$mueble->getImgFrente().'" >
                <input type="hidden" class="form-control" id="imgLateral" name="imgLateral" value="'.$mueble->getImgLateral().'" >
                <input type="hidden" class="form-control" id="fichaTecnica" name="fichaTecnica" value="'.$mueble->getFichaTecnica().'" >
                <input type="hidden" class="form-control" id="IdTipoSIIAU" name="IdTipoSIIAU" value="'.$mueble->getIdTipoSIIAU().'" >';
            }
            
            ?>    
            <div class="form-group">
                <label class="control-label col-sm-2" for="tipo">Tipo:</label>
                <div class="col-sm-8">          
                <select class="form-control" id="tipo" name="tipo" required>
                    <option value="<?php echo $mueble->getTipo(); ?>"><?php echo $mueble->getTipo(); ?></option>
                    <option value="" disabled>Sin seleccionar</option>
                    <option value="Histórico">Histórico</option>
                    <option value="Contemporáneo 2da Generación">Contemporáneo 2da Generación</option>
                    <option value="Contemporáneo Belenes">Contemporáneo Belenes</option>
                </select>
              </div>
            </div>
           

                
            <div class="form-group">
                <label class="control-label col-sm-2" for="categoria">Categoría:</label>
                <div class="col-sm-8">          
                <select class="form-control" id="categoria" name="categoria" required>
                    <option value="<?php echo $mueble->getCategoria(); ?>"><?php echo $mueble->getCategoria(); ?></option>
                    <option value="" disabled>Sin seleccionar</option>
                    <option value="Obra de Arte">Obra de Arte</option>
                    <option value="Utilitario">Utilitario</option>
                    <option value="Decorativo">Decorativo</option>
                </select>
              </div>
            </div>
               
            <div class="form-group">
                <label class="control-label col-sm-2" for="estadoCatalogoMueble">Borrar:</label>
                <div class="col-sm-8">          
                <select class="form-control" id="estadoCatalogoMueble" name="estadoCatalogoMueble" required>
                    <option value="<?php echo $mueble->getEstadoCatalogoMueble(); ?>"><?php echo $mueble->getEstadoCatalogoMueble(); ?></option>
                    <option value="" disabled>Sin seleccionar</option>
                    <option value="Activo">Activo</option>
                    <option value="No Activo">No Activo - Eliminar</option>
                </select>
              </div>
            </div>  
              <div class="form-group">        
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary" name="muebleCatalogoModificar">Guardar</button>
                <a href="index.php" class="btn btn-default">Regresar</a>
              </div>
            </div>
          </form>
             <div class="container-fluid">
            <div class="page-header">
                <h3 style="text-align: center">Listado de Muebles de ese tipo en Catálogo <?php echo $mueble->getTipo(); 
                    echo "<br>";
                    
                       
                    ?>
                    
                </h3>
          </div>
             <!--tabla de consulta-->
            <div id="respuestaFiltro">
                <table id="dtPlantilla" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>IdMueble</th>        
                            <th>Id UDG</th> 
                            <th>Descripción</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Medidas</th>
                            <th>Área</th>
                            <th>Piso</th>
                            <th>Edificio</th>
                            <th>Código</th>
                            <th>Resguardante</th>
                           
                            
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
             <!--tabla de consulta-->
             <a href="index.php" class="btn btn-default">Salir</a>    
        </div>
        </div>  
    </body>
</html>

