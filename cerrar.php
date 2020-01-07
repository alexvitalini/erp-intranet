<?php 
	session_start();
	$_SESSION['correo'] = "";
	unset( $_SESSION['correo'] );
	session_destroy();
	header("location: login.php");
?>