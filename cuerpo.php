<?php require_once('inicio_php.php'); ?>

<?php 
//sleep( 1 );
if ($usuario['usuario_pagina']) {
	include( $usuario['usuario_pagina'] );
} ?>

<?php
if ($usuario['departamento_pagina']) {
	include( $usuario['departamento_pagina'] );
}
?>
