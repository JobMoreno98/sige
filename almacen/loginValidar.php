<?php
include 'conexion.php';
$pdo = new Conexion();
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
session_start();

//variables que pasamos del formulario de IndexLogin
$vPass='p';
$vUser='u';
$pass=$_POST['pwd'];
$user=$_POST['user'];

//Conexion a base de datos

if($user=='' || $pass==''){header('location: loginMenu.php');}
else {
    try{
        $query=$pdo->prepare("select u.*, a.tipo, a.area, e.privilegios AS privilegiosEmpleado"
                . " from usuario u JOIN empleado e ON u.idEmpleado = e.idEmpleado"
                . " JOIN area a ON e.idArea = a.idArea"
                . " WHERE u.usuario = :usuario and u.password = MD5(:password) and e.estado = :estado;");
        $query->bindValue(':usuario', $user);
        $query->bindValue(':password', $pass);
        $query->bindValue(':estado', 'Activo');
        $query->execute();
        $resultado=$query->fetchAll();

        //Validacion y comparacion del usuario y contraseña
        foreach($resultado as $value){
            $vPass='p'.$value['password'];
            $vUser='u'.$value['usuario'];
            $nombreUsuario=$value['nombreUsuario'];
            $privilegios=$value['privilegios'];
            $idEmpleado=$value['idEmpleado'];
            $tipo = $value['tipo'];
            $area = $value['area'];
            $privilegiosEmpleado = $value['privilegiosEmpleado'];
        }
        if($vUser=='u' && $vPass=='p'){
            echo '<script>alert("El usuario o contraseña son incorrectos. Intente de nuevo.")</script>';
            echo '<script>location.href="loginMenu.php"</script>';
        }else{
            $_SESSION['valido']=1;
            $_SESSION['nombreUsuario']=$nombreUsuario;
            $_SESSION['privilegios']=$privilegios;
            $_SESSION['idEmpleado']=$idEmpleado;
            $_SESSION['tipoArea']=$tipo;
            $_SESSION['area']=$area;
            $_SESSION['privilegiosEmpleado']=$privilegiosEmpleado;
            if (isset($_SESSION['direccionURL'])) {
                echo "<script>location.href='".$_SESSION['direccionURL']."'</script>";
            }else{
                header('location: index.php');
            }
        }

    }catch(PDOException $ex){
        echo 'Error: '.$ex->getMessage();
    }
    $pdo = null;

}
