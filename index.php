<?php require_once('inicio_php.php'); ?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<!-- Meta, title, CSS, favicons, etc. -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">


		<title>Cefa </title>

		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/navbar_dd.css" rel="stylesheet">
		<link href="css/jquery-ui.min.css" rel="stylesheet">

		<!-- Font Awesome -->
		<link href="plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		
		<!--Estilos personalizados  -->
		<link href="css/estilos.css" rel="stylesheet">

		<!-- JQuery -->
		<script src="js/jquery-3.4.1.min.js"></script>
		<script src="js/jquery-ui.min.js"></script>
		<!--<script src="js/datepicker-es.js"></script>-->
		<script src="js/funciones_js.js"></script>

		<!-- Bootstrap -->
		<script src="js/bootstrap.bundle.min.js"></script>

</head>

<body style="background: url(imagenes/SysCefaNLClaro.png) no-repeat center center fixed; ">
	<header><!-- /barra de navegación-->
	<?php include('include/barra_menu.php');?>
	</header>

	<div class="container-fluid" id="cuerpo_principal">
		<!-- Contenido de la página  -->
<?php include('cuerpo.php');?>
		<!-- /Contenido de la página  -->

	</div>
	<footer>
		<div class="fixed-bottom" style="height:20px">
			<p class="float-right">Cefa 2019 | <?php echo($usuario['usuario']); ?></p>
		</div>
		<div class="clearfix"></div>
	</footer>
	
	<div id="cargando_imagen">
		<img src="imagenes/ajax-loader_roller.gif" alt="Cargando...">
	</div>

		<!-- Carga de diálogos  -->
<?php include('include/dialogos_modales.php');?>
		<!-- Carga de diálogos  -->
	<script>
		$(function(){
			$( document ).ajaxStart( function() { // Cuando está trabajando AJAX 
					$("#cargando_imagen").show();
				}).ajaxStop( function() { // oculta la imagen de carga...
					$("#cargando_imagen").hide();
				}).ajaxError( function( event, jqxhr, settings, thrownError ) {
					console.log("Error Ajax al llamar: " + settings.url + " ("+thrownError +")");
					alert("Error en Ajax\nAvisa a sistemas")
				} );
		});
	</script>
</body>
</html>
<?php 
/*
'manual','por_sesión','por_edecán','por_curso','por_hora','por_día','por_expositor'


id
nombre
calculo (set)
area "libre" departamentos


id(hide),nombre,select,area texto (tooltip distintos)
*/
?>