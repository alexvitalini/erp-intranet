<?php 
session_start();
require_once('conexiones/conexion_duplex.php');
$connect = new connect;
$connect->connect_db();?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Cefa</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <!--Estilos personalizados  -->
    <link href="css/estilos.css" rel="stylesheet">
</head>

<body class="login">
    <div>

        <div class="contenedor_login">
            <div class="animate form formulario_login">
                <section class="contenido_login">
                   <img src="imagenes/cefa.jpg" >
                    <form action="validar.php" method="post">
                        <h1>Inicia sesión</h1>
                        <div>
                            <input type="text" class="form-control" placeholder="Usuario" name="usuario" required="" />
                        </div>
                        <div>
                            <input type="password" class="form-control" placeholder="Contraseña" name="clave" required="" />
                        </div>
                        <div>
                            <input class="btn boton_est boton_grande submit" type="submit" value="Ingresar">
                        </div>

                        <div class="clearfix"></div>

                        <div class="separador">

                        </div>
                    </form>
                </section>
            </div>

        </div>
    </div>
</body>
</html>
