<?php
 include './loginSecurity.php';
 if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'Sistemas') {
    header('location: index.php');
}
?>
<!--este documento devuelve la respuesta de AJAX dentro del <div id="respuestaFiltro"> actualizando la tabla-->
<script>
//    Este script actualiza las propiedades del DataTable en cada cambio
    $(document).ready(function(){
//        Cambiar el titulo de la variable según el nombre del módulo o tabla
        var t = 'Listado de Áreas';
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
include 'area.php';
$obj = new area();
$obj ->setArea($_POST['filtro1']);
$obj ->setPiso($_POST['filtro2']);
$obj ->setEdificio($_POST['filtro3']);
$obj ->setTipo($_POST['filtro4']);
$obj ->setEstadoArea($_POST['filtro5']);
?>
    <table id="dtPlantilla" class="display" cellspacing="0" width="100%">
        <thead>
            <?php $obj ->titulosArea(); ?>
        </thead>
        <tfoot>
            <?php $obj ->titulosArea(); ?>
        </tfoot>
        <tbody>
            <?php $obj ->consultaArea() ?>
        </tbody>
    </table>