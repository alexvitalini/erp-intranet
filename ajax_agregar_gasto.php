<?php require_once('inicio_php.php');?>
<?php 
$cNombre	= mysql_real_escape_string ( $_GET['nombre'] );
$cCalculo	= mysql_real_escape_string ( $_GET['calculo'] );
$cGrupo		= mysql_real_escape_string ( $_GET['grupo'] );

$cRespuesta="<resultado estado='error' mensaje='' id='0'/>";

$cSQL = "insert into erp_cat_gastos set nombre_gasto='$cNombre',calculo_gasto='$cCalculo',grupo_gasto='$cGrupo'";

$connect->sQuery( $cSQL );
if ( ( $nRegistros = $connect->affected_rows() ) > 0 ) {
	$nId = $connect->insert_id();
	$cRespuesta ="<resultado estado='OK' mensaje='' id='$nId' registros='$nRegistros'></resultado>";
} else
	$cRespuesta="<resultado estado='error' mensaje='No se pudo dar de alta' detalle='' id='0'/>";
header("Content-Type: text/xml charset=utf-8");
echo($cRespuesta);

?>