<?php require_once('inicio_php.php');?>
<?php 
$cTipo	= mysql_real_escape_string( $_POST['tipo'] );
$nId	= (int) mysql_real_escape_string( $_POST['id'] );

/*
$cRespuesta="<resultado estado='error' mensaje='' id='0'/>";

$cSQL = "insert into erp_cat_gastos set nombre_gasto='$cNombre',calculo_gasto='$cCalculo',grupo_gasto='$cGrupo'";

$connect->sQuery( $cSQL );
if ( ( $nRegistros = $connect->affected_rows() ) > 0 ) {
	$nId = $connect->insert_id();
	$cRespuesta ="<resultado estado='OK' mensaje='' id='$nId' registros='$nRegistros'></resultado>";
} else

*/

function optionSelectSelected( $cValue , $cTexto , $cOpcion ) {
	if ( $cValue )
		$cSelect = ( $cValue == $cOpcion )? " selected ": "";
	else
		$cSelect = "";
	return "\t<option value='$cValue' $cSelect class=''>$cTexto</option>\n";
}

function selectTipoCalculoGasto( $cCalculo ) {
	$cRespuesta = "";

	$cRespuesta = "<select class='form-control form-control-sm' name='calculo' disabled>\n";
		$cRespuesta.= optionSelectSelected( "", "Seleccione...", "");
		$cRespuesta.= optionSelectSelected( "manual", "Manual", $cCalculo );
		$cRespuesta.= optionSelectSelected( "por_edecán", "Por curso", $cCalculo );
		$cRespuesta.= optionSelectSelected( "por_curso", "Por edecán", $cCalculo );
		$cRespuesta.= optionSelectSelected( "por_hora", "Por horas curso", $cCalculo );
		$cRespuesta.= optionSelectSelected( "por_día", "Por día", $cCalculo );
		$cRespuesta.= optionSelectSelected( "por_expositor", "Por expositor", $cCalculo ); 
	$cRespuesta .= "</select>";
return $cRespuesta;
}

function selectGrupoGasto( $cGasto ) {
	$cRespuesta = "";

	$cRespuesta = "<select class='form-control form-control-sm' name='grupo' disabled>\n";
		$cRespuesta.= optionSelectSelected( "", "Seleccione...", "");
		$cRespuesta.= optionSelectSelected( "cefa", "Cursos cefa", $cGasto );
		$cRespuesta.= optionSelectSelected( "viaje", "Viaje", $cGasto );
		$cRespuesta.= optionSelectSelected( "salon", "Salón rentado", $cGasto );
		$cRespuesta.= optionSelectSelected( "representante", "Representantes", $cGasto );
		$cRespuesta.= optionSelectSelected( "honorarios", "Honorarios", $cGasto );
		$cRespuesta.= optionSelectSelected( "especial", "Curso especial", $cGasto );
		$cRespuesta.= optionSelectSelected( "conferencia", "Conferencia", $cGasto );
		$cRespuesta.= optionSelectSelected( "presupuestos", "Presupuestos", $cGasto );
	$cRespuesta .= "</select>";
return $cRespuesta;
}

	$cRespuesta="NADA";

if ( $cTipo=="listado" ) {
	$cSQL="select * from erp_cat_gastos order by grupo_gasto,nombre_gasto";

	$sQuery = $connect->sQuery($cSQL);
	$cRespuesta="";
	if ( mysql_num_rows( $sQuery ) > 0 ){
		while ($oQuery = mysql_fetch_object( $sQuery ) ){
			$cTRClass = ( $oQuery->id_gasto == $nId )? " class='table-success'" : "";
			$cRespuesta.="<tr id='elemento_$oQuery->id_gasto' $cTRClass><td><input type='text' class='form-control form-control-sm' name='nombre' value='$oQuery->nombre_gasto' disabled></td><td>";
			
			$cRespuesta.= selectTipoCalculoGasto( $oQuery->calculo_gasto );
			
			$cRespuesta.="</td><td>\n";
			
			$cRespuesta.= selectGrupoGasto( $oQuery->grupo_gasto );

			$cRespuesta.= "</td><td><div class='btn-group btn-group-sm d-flex justify-content-center' role='group' >
				<button class='btn btn-sm btn-outline-primary' title='Modificar elemento' onClick='javascript:editaSalvaGasto( this , $oQuery->id_gasto);return false;' ><i class='fa fa-pencil'></i></button>
				<button class='btn btn-sm btn-outline-primary' title='Borrar elemento' onClick='javascript:cancelaBorraGasto( this , $oQuery->id_gasto);return false;'><i class='fa fa-close'></i></button></div></td></tr>\n";
		}
		header("Content-Type: text/html charset=utf-8");
		echo($cRespuesta);
	}
} else if ( $cTipo=='borrar-gasto') {
	$cRespuesta="<resultado estado='error' mensaje='no se pudo borrar el registro id: $nId' id='$nId' detalle='' />";
	if ( $nId ) {
		$cSQL = "DELETE FROM erp_cat_gastos WHERE id_gasto = '$nId'";
		$connect->sQuery( $cSQL );
		$nRegistros = mysql_affected_rows();
		$cRespuesta="<resultado estado='ok' mensaje='Registros borrados: $nRegistros' id='$nId' detalle='' />";
	}

	header("Content-Type: text/xml charset=utf-8");
	echo($cRespuesta);
} else if ( $cTipo=='actualiza-gasto') {
	if ( $nId ) {
		$cNombre 	= mysql_real_escape_string( $_POST['nombre'] );
		$cCalculo 	= mysql_real_escape_string( $_POST['calculo'] );
		$cGrupo		= mysql_real_escape_string( $_POST['grupo'] );
		$cSQL ="update erp_cat_gastos set  nombre_gasto='$cNombre', calculo_gasto='$cCalculo', grupo_gasto='$cGrupo' where id_gasto='$nId'";
		
		$connect->sQuery( $cSQL );
		$nRegistros = mysql_affected_rows();
		$cRespuesta="<resultado estado='ok' mensaje='Registros modificados: $nRegistros' id='$nId' detalle=''/>";
		
		//$cRespuesta="<resultado estado='error' mensaje='$cSQL' id='$nId' detalle='' />";
		header("Content-Type: text/xml charset=utf-8");
		echo($cRespuesta);
	}
}
?>