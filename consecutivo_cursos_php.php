<?php require_once('inicio_php.php');?>
<?php

$cQueryInicial = <<<FIN
SELECT 
	agenda_general.id,
	fechas,
	GROUP_CONCAT(DISTINCT agenda_detalle.hora separator ',') as horas,
	primfecha,
	if(modulo.idmodulo>0,modulo.titulo,curso.titulo) as nombre_corto_curso,
	modulo.nombre_corto as ncorto,
	grupo,
	temas.nombre as area,
	GROUP_CONCAT(DISTINCT agenda_detalle.expositores separator '/') as expositores,
	sesiones,
	day( primfecha) as dia,
	status,
	month( primfecha ) as mes,
	asistencia AS tot_participantes,
	asist_becados,
	participantes ,
	agenda_general.curso,
	agenda_general.tipo,
	nombre_tipo_curso,
	agenda_general.nombre_corto as texto,
	modulo.idmodulo ,
	modulo,
	CONVERT(curso.titulo USING latin1) as titulo, 
	sede.nombre as sede_nombre, 
	sede.abreviacion,
	agenda_general.status as ssstatus, 
	agenda_detalle.id_sede
FROM 
	agenda_general 
		left join curso on agenda_general.curso = curso.idcurso 
		left join agenda_detalle on agenda_general.id=agenda_detalle.id_general 
		left join sede on agenda_detalle.id_sede =sede.idsede 
		left join modulo on agenda_general.curso = modulo.curso_idcurso && agenda_general.modulo = modulo.idmodulo 
		left join temas on temas.idtemas = curso.temas_idtemas
		left join agenda_tipo_curso on agenda_general.tipo = id_tipo
WHERE
	agenda_general.primfecha between '%1\$s' and '%2\$s' && 
	agenda_general.tipo>='50' 
group by 
	id 
order 
	by primfecha,hora,id
FIN;

function armaCuerpoTabla( $oQuery , $cVista ) {
	if ($oQuery->nombre_corto_curso)
		$cCeldaCurso = "<TD title='$oQuery->texto'>$oQuery->nombre_corto_curso</TD>";
	else
		$cCeldaCurso = "<TD><b>$oQuery->texto</b></TD>";
	
echo <<<FIN
	<TR>
				<TD title="$oQuery->sede_nombre">$oQuery->nombre_tipo_curso</TD>
				<TD>$oQuery->id</TD>
				<TD>$oQuery->primfecha</TD>
				<TD>$oQuery->fechas ($oQuery->horas)</TD>
				$cCeldaCurso
				<TD class="text-center">$oQuery->grupo</TD>
				<TD class="text-truncate" style="max-width: 100px;">$oQuery->area</TD>
				<TD>$oQuery->expositores</TD>
				<TD>$oQuery->sesiones</TD>
				<TD>$oQuery->status</TD>
				<TD>$oQuery->tot_participantes</TD>
				<TD>$oQuery->asist_becados</TD>
			</TR>
FIN;
}

	$cRespuesta = "NADA!";
	$connect->conectarLi();

if ( $_GET['tipo_consecutivo']=="D" ) { 
	$cQuery = sprintf( $cQueryInicial ,$_GET['fecha_desde'] , $_GET['fecha_hasta'] ) ;
	
	if ( $sQuery = $connect->QueryLi( $cQuery ) ) {
		// $cRespuesta = $sQuery->num_rows;
	// } else {
		// $cRespuesta = "Error";
		$nCursos = $sQuery->num_rows;
		while( $oQuery = $sQuery->fetch_object() ){
			armaCuerpoTabla( $oQuery , "");
		}
		$sQuery->close();
	}
}
?>
			
<script>
	$nCantidad="<?=$nCursos?>";
console.log("ESTE es el LOG:"+$nCantidad);
	$("#total_registros").html($nCantidad);
</script>