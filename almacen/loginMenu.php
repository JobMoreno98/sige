<html lang="es">
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
        <!-- Login -->
        <link rel="stylesheet" href="css/login.css"/>
    </head>
    <body >
    <div class="container-fluid">
        <div class="col-sm-3"><center><img class="img-responsive" src="images/BIBLIOTECA_300.jpg" style="padding-top: 8%"></center></div>
        <div class="col-sm-6"></div>
        <div class="col-sm-3"><center><img class="img-responsive" src="images/logoccd.jpg" style="padding-top: 8%"></center></div>
        <div class="col-sm-12"><center><h3>Sistema Integral de Gestión <br><br><small>Biblioteca Pública del Estado de Jalisco</small></h3></center></div>
    </div>
    <div class="container-fluid">
        <div class="menuLogin">
             <div class="row">
                 <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <form name="form" role="form" method="post" action="loginValidar.php">
                            <div class="form-group">
                                <label  id="inicioSesion" for="usrname" class="h4" ><span class="glyphicon glyphicon-user" id="inicioSesion"></span> Usuario</label>
                                <input type="text" class="form-control" id="usrname" name="user" placeholder="Ingresa usuario" required pattern="[A-Za-z].+" title="Caracteres inválidos" autofocus required>
                            </div>
                            <div class="form-group">
                                <label id="inicioSesion" for="psw" class="h4"><span class="glyphicon glyphicon-lock" id="inicioSesion"></span> Contraseña</label>
                                <input type="password" class="form-control" id="psw" name="pwd" placeholder="Ingresa contraseña" required="password">
                            </div>
                                <button type="submit" class="btn btn-default btn-sm"> <span class="glyphicon glyphicon-home"></span>  ENTRAR</button>
                        </form>
                </div>
                <div class="col-sm-3"></div>
              </div>
         </div>
    </div>
</body>
</html>
