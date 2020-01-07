<?php
   session_start();
   require_once('conexiones/conexion_duplex.php');
   $connect = new connect;
   $connect->connect_db( false );
   $lUsuarioValido = $connect->validaUsuario( $_POST['usuario'] , $_POST['clave'] );
   $cResultadoPrueba = "validado" ;
   ?>
   <script>
   var $resultado = <?php echo("\"$cResultadoPrueba\";\r\n\tconsole.log(\$resultado);"); ?>
   </script>
   
   <?php
   if( $lUsuarioValido ){ 
	$_SESSION['correo'] = $connect->cCorreoValidado;
   $cNombre = utf8_decode ("\"".$connect->cNombreValidado."\"");
	?>
	<script>

		window.addEventListener('load', alerta, false);

		function alerta() {
			swal(<?php echo($cNombre); ?>, "Bienvenido", "success")
				.then((value) => {
					location.href = "index.php";
				});
		}
	</script>
    <?php }
   else { ?>
        <script>
            window.addEventListener('load', alerta, false);

            function alerta() {
                swal(" usuario o contrase\u00f1a incorrectos ", " ", "error")
                    .then((value) => {
                        location.href = "login.php";
                    });
          }

        </script>
        <?php }?>
            <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>