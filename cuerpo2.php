<?php 
session_start();
require_once('conexiones/conexion_duplex.php');
$connect = new connect;
$connect->connect_db( false );
$varsesion = $_SESSION['correo'];
if($varsesion == '' || $varsesion == null || !$connect->lConsultaUsuario( $varsesion ) ) { ?>
     <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
     <script>

      window.addEventListener('load', alerta, false);
      function alerta() {
          swal("Necesita iniciar sesi\u00F3n", " ", "error")
              .then((value) => {
                  location.href = "login.php";
              });
         }

        </script>
<?php die(); }
	else { 
	$usuario = $connect->aDatosUsuario;
	}
?>
CUERPO 2
<?php
	print_r($usuario);
?>
	<script>
	$(function(){console.log("Autocargado")})
	</script>