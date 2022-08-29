<?php
 include './loginSecurity.php';
   if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'Encargado Almacén' and $_SESSION['privilegios'] != 'RH-Almacen' and $_SESSION['privilegios'] != 'Finanzas') {
    header('location: index.php');
}
?>
<!--este documento devuelve la respuesta de AJAX dentro del <div id="respuestaFiltro"> actualizando la tabla-->
<script>
//    Este script actualiza las propiedades del DataTable en cada cambio
    $(document).ready(function(){
//        Cambiar el titulo de la variable según el nombre del módulo o tabla
        var t = 'Listado de Proveedores';
        $('#dtPlantilla').DataTable( {
//          destroy: Es para borrar la tabla principal y  no interfiera con la nueva
            destroy: true,
            responsive: true,
            dom: '<"col-sm-5"l><"col-sm-3"B><"col-sm-4"f>rtip',
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
        } );
    } );
</script>
<?php
include 'proveedor.php';
$obj = new proveedor();
$obj ->setRFC($_POST['filtro1']);
$obj ->setRazonSocial($_POST['filtro2']);
$obj ->setNombreComercial($_POST['filtro3']);
$obj ->setNombreContacto($_POST['filtro4']);
$obj ->setTelefono($_POST['filtro5']);
$obj ->setEmail($_POST['filtro6']);
?>
    <table id="dtPlantilla" class="display" cellspacing="0" width="100%">
        <thead>
            <?php $obj ->titulosProveedor(); ?>
        </thead>
        <tfoot>
            <?php $obj ->titulosProveedor(); ?>
        </tfoot>
        <tbody>
            <?php $obj ->consultaProveedor(); ?>
        </tbody>
    </table>