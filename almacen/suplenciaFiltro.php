<?php
include './loginSecurity.php';
     if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'Recursos Humanos' and $_SESSION['privilegios'] != 'RH-Almacen') {
    header('location: index.php');
}
include 'suplencia.php';
$obj = new suplencia();
$obj ->setIdCadena($_POST['filtro1']);
$obj ->setIdEmpleado($_POST['filtro2']);
$obj ->setIdNombramiento($_POST['filtro3']);
$obj ->setCargaHoraria($_POST['filtro4']);
$obj ->setAnioRegistro($_POST['filtro5']);
?>
<!--este documento devuelve la respuesta de AJAX dentro del <div id="respuestaFiltro"> actualizando la tabla-->
<script>
    var arregloDT = <?php echo json_encode($obj->consultaSuplencia()); ?>
//    Este script actualiza las propiedades del DataTable en cada cambio
    $(document).ready(function(){
//        Cambiar el titulo de la variable según el nombre del módulo o tabla
        var t = 'Listado de Suplencias';
        $('#dtPlantilla').DataTable( {
//          destroy: Es para borrar la tabla principal y  no interfiera con la nueva
            destroy: true,
            "data": arregloDT,
            "order": [[ 0, "desc" ]],
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
    <table id="dtPlantilla" class="display" cellspacing="0" width="100%">
        <thead>
            <?php $obj ->titulosSuplencia(); ?>
        </thead>
        <tfoot>
            <?php $obj ->titulosSuplencia(); ?>
        </tfoot>
        <tbody>
        </tbody>
    </table>