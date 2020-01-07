<?php 
session_start();
require_once('conexiones/conexion_duplex.php');
$connect = new connect;
$connect->connect_db( false );
//if ( isset( $_SESSION['correo'] ) && $_SESSION['correo']=="" )
	$varsesion = $_SESSION['correo'];

if( /*!isset( $varsesion ) ||*/  $varsesion == '' || $varsesion == null || !$connect->lConsultaUsuario( $varsesion ) ) { 

// si el usuario no está activo
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<script>
		location.href = "errorUsuario.html";
	</script>
</head>
</html>

<?php die(); }

	else { 
	$usuario = $connect->aDatosUsuario;
	}
	
?>