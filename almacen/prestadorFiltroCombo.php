<!--este documento devuelve la respuesta de AJAX dentro del <div id="respuestaComboFiltro"> actualizando los ComboBox-->
<script>
//    Este script mantiene seleccionada la opción elegida de los ComboBox en cada cambio
    var f1 = "<?php echo $filtro1 = $_POST["filtro1"]; ?>";
    var f2 = "<?php echo $filtro2 = $_POST["filtro2"]; ?>";
    var f3 = "<?php echo $filtro3 = $_POST["filtro3"]; ?>";
    var f4 = "<?php echo $filtro4 = $_POST["filtro4"]; ?>";

  if(f1 !== "%")
  {
      $("select#lista1").prop('selectedIndex', 1);
  }
  if(f2 !== "%")
  {
       $("select#lista2").prop('selectedIndex', 1);
  }
  if(f3 !== "%")
  {
      $("select#lista3").prop('selectedIndex', 1);
  }
  if(f4 !== "%")
  {
      $("select#lista4").prop('selectedIndex', 1);
  }
</script>

<?php
include 'prestadores.php';
$con = new prestadores();

$con ->setFiltro1($filtro1);
$con ->setFiltro2($filtro2);
$con ->setFiltro3($filtro3);
$con ->setFiltro4($filtro4);
$con ->comboBoxFiltro();

//Desarrollado por: Carlos Valentín Camacho Veloz



        


