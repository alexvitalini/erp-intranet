<?php require_once('inicio_php.php');?>
<?php

$cEncabezadoRFC = <<<FIN
FIN;

?>
<?php

	$cListado1 = "<li class='list-group-item d-flex justify-content-between align-items-center p-1'>";
	$cListado2 = "<a href='#'  class='badge badge-primary badge-success p-1' title='cantidad de CFDIs ingresados'>";
	$cListado3 = "</a><button class='btn btn-sm btn-danger p-1' onclick='javascrip:desenlazaRFC(";
	$cListado4 = ")' title='Desasociar este RFC del expositor'><i class='fa fa-unlink p-1'></i></button></li>\r\n";

function listadoRFC_Asociados( $cExpositor ) {
	global $connect,$cListado1,$cListado2,$cListado3,$cListado4;
	
	
	$cSQL= "SELECT id_rfc,rfc, ( select count(*) from validacfd.facturas where rfc=test.erp_expositor_rfc_asociacion.rfc ) as cantidad FROM test.erp_expositor_rfc_asociacion  WHERE idexpositor LIKE '$cExpositor' ORDER by rfc";
	$cCadena="";
	if ( $sSQL = $connect->sQuery( $cSQL ) )
		while ( $oSQL = mysql_fetch_object( $sSQL ) )
			$cCadena .= $cListado1.$oSQL->rfc.$cListado2.$oSQL->cantidad.$cListado3.$oSQL->id_rfc.$cListado4;
	
	return $cCadena;
}

function tablaFacturasAsociadas( $sSQL ) {
	$cRespuesta = "";
	
	
	
	// while ($oSQL = mysql_fetch_object( $sSQL ) ){
		
	// }
	
}


function rfcAsociados( $cExpositor ){
	global $connect;
	$cRespuesta = "";
	
	$cSQL = "SELECT GROUP_CONCAT( DISTINCT rfc separator '\',\' ' ) asociados FROM erp_expositor_rfc_asociacion  WHERE idexpositor LIKE '$cExpositor' GROUP by idexpositor";
	if ( ( $sSQL = $connect->sQuery( $cSQL ) ) && mysql_num_rows( $sSQL ) > 0) 
		$cRespuesta = mysql_fetch_object( $sSQL )->asociados;
	return $cRespuesta;
}
function facturasAsociadas( $cExpositor , $cTemporalidad ){
	global $connect;
	$cRespuesta = "El expositor no tiene RFC asociado";
	
	if ( $cAsociados = rfcAsociados( $cExpositor ) ) {
		$cRespuesta = "No tiene facturas en el tiempo solicitado $cTemporalidad";
		if ( $cTemporalidad !=="0" )
			$cFiltro = "fecha >= date_sub(curdate(), interval $cTemporalidad month) && ";
		else
			$cFiltro="";
			
		$cSQL = "SELECT * FROM validacfd.facturas WHERE $cFiltro rfc in ('$cAsociados') ORDER BY fechavalidacion DESC";
		if (  ( $sSQL = $connect->sQuery( $cSQL ) ) && ( mysql_num_rows( $sSQL ) > 0) ) 
			$cRespuesta = tablaFacturasAsociadas(  $sSQL );
			//$cRespuesta = "Registros: ".mysql_num_rows( $sSQL );
	}
	return $cRespuesta . " " . $cSQL;
}

function procesoInicial() {
	global $connect;
	
	$cOrden = ( $connect->cValorIni("Expositores","Orden","iniciales") == "iniciales" ) ? "idexpositor" : "ElApellido";
	$cQuery = "SELECT idexpositor,ElNombre,ElApellido FROM expositor order by $cOrden";

	$connect->conectarLi();

	if ( $sQuery = $connect->QueryLi( $cQuery ) ) {
		$nCursos = $sQuery->num_rows;
		$cOptions ="<option value='' disabled selected>Seleccione...</option>\n";
		while( $oQuery = $sQuery->fetch_object() )
			if ( $oQuery->idexpositor<>"XCONF" )
				$cOptions .= ArmaExpositoresPrincipal( $oQuery , $cOrden );
		$sQuery->close();
	}
	return $cOptions;
}

function cargaTabExpositor( $cTipo , $cExpositor , $cTemporalidad ) {
	global $cEncabezadoRFC;
	$cRespuesta = "";
	switch( $cTipo ){
		case "1":
			$cRespuesta = facturasAsociadas( $cExpositor , $cTemporalidad );
			break;
		case "2":
			$cRespuesta = listadoRFC_Asociados( $cExpositor );
			break;
		case "3":
			$cRespuesta = "CASO3 $cExpositor";
			break;
		default:
			$cRespuesta = "Default($cTipo)";
	}
	return $cRespuesta;
}

function ArmaExpositoresPrincipal( $oQuery  , $cOrden ) {
	global $connect; 
	$cValue = $oQuery->idexpositor;
	
	if ( $cOrden == "idexpositor" )
		$cTexto = "$oQuery->idexpositor - $oQuery->ElNombre $oQuery->ElApellido";
	else
		$cTexto = "$oQuery->ElApellido, $oQuery->ElNombre ($oQuery->idexpositor)";

	return "<option value='$cValue'>$cTexto</option>\n" ; 
}

function buscaRFCxAsociar( $cRFC ) {
	global $connect;
	$cCadena = "";
	$cSQL = "SELECT rfc,idexpositor  FROM erp_expositor_rfc_asociacion WHERE rfc LIKE '".$cRFC."%' limit 1";
	if ( ( $sSQL = $connect->sQuery( $cSQL ) ) && mysql_num_rows( $sSQL ) > 0) {
		$oSQL = mysql_fetch_object( $sSQL );
		$cCadena="<resultado id='1' OK='OK' otro='$cRFC' estado='NO' mensaje='RFC previamente asociado' rfc='$oSQL->rfc' descripcion='Asociado a: $oSQL->idexpositor'>$cSQL</resultado>";
	} else {
		$cSQL = "SELECT rfc,nombre  FROM validacfd.facturas WHERE rfc LIKE '".$cRFC."%' limit 1";
		if ( ( $sSQL = $connect->sQuery( $cSQL ) ) && mysql_num_rows( $sSQL ) > 0 ) {
			$oSQL = mysql_fetch_object( $sSQL );
			$cCadena="<resultado id='2' OK='OK' otro='$cRFC' estado='SI' mensaje='' rfc='$oSQL->rfc' descripcion='$oSQL->nombre'>$cSQL</resultado>";
		} else
			$cCadena="<resultado id='3' OK='OK' otro='$cRFC' estado='NO' mensaje='No se encontró ningún CFDI' rfc='' descripcion=''>$cSQL</resultado>";
	}
	return $cCadena;
}

function asociaRFC_expositor( $cRFC , $cExpositor ){
	global $connect;
	$cRespuesta = "NO";
	if ( $cRFC && $cExpositor ) {
		$cSQL = "INSERT INTO erp_expositor_rfc_asociacion ( idexpositor, rfc ) VALUES ( '$cExpositor' , '$cRFC' )";
		$cRespuesta =  ( $connect->sQuery( $cSQL ) && $connect->affected_rows() )? "OK" : "NO" ;
	} 
	return $cRespuesta;
}

function eliminaRFC( $nId ){
	global $connect;
	$nId = (int ) $nId;
	$cRespuesta = "NO";
	if (  $nId > 0 ) {
		$cSQL = "DELETE FROM erp_expositor_rfc_asociacion WHERE id_rfc = '$nId'";
		$cRespuesta =  ( $connect->sQuery( $cSQL ) && $connect->affected_rows() )? "OK" : "NO" ;
	}
	return $cRespuesta;
}

if( isset( $_POST['proceso'] ) ) {						// regresa todos los options de un select de Expositores

	$cOptions = procesoInicial();
	echo( $cOptions ); 

} else if( isset( $_POST['setOrden'] ) ) { 				// Establecer el orden de los select de expositores
	
	$cValor = $_POST['setOrden'];
	$connect->SetIni( null , "Expositores" ,"Orden" , $cValor , true , true );
	echo $cValor; 

} else if( isset( $_POST['carga'] ) ) {					// Carga el listado de RFCs asociados a un expositor
	
	$cCarga = $_POST['carga'];
	$cExpositor = $_POST['expositor'];
	$cTemporalidad = $_POST['temporalidad'];
	echo( cargaTabExpositor( $cCarga , $cExpositor , $cTemporalidad ) );

} else if( isset( $_POST['rfc'] ) ) { 					// Regresa un XML con la búsqueda de RFC en las bases de RFC asociados y de facturas de ValidaCFD

	header("Content-Type: text/xml charset=utf-8");
	echo buscaRFCxAsociar( $_POST['rfc'] );

} else if( isset( $_POST['asociar'] ) ) { 				// Asocia un RFC con un expositor

	echo asociaRFC_expositor( $_POST['asociar'] , $_POST['expositor'] );
	
} else if( isset( $_POST['eliminarfc'] ) ) {			// Desasocia un RFC con un expositor
	
	echo eliminaRFC( $_POST['eliminarfc'] );
}
?>