<?php require_once('inicio_php.php');?>
<?php require_once('php_funciones.php');?>
<?php

$cFechaDesde = "";
$cFechaHasta = "";

$cGruposDelModulo = "Cursos,Representantes,Gastos,Honorarios";
/*SELECT * FROM `erp_grupos` WHERE `nombre_grupo` IN ('Cursos','Representantes','Gastos','Honorarios')
select * from erp_grupos_usuarios where id_usuario='1'
select * from erp_grupos where nombre_grupo in ('Cursos','Representantes','Gastos','Honorarios')

select id_grupo,nombre_grupo,descripcion_grupo from erp_grupos_usuarios left join erp_grupos using ( id_grupo ) where id_usuario='1' && nombre_grupo IN ('Cursos','Representantes','Gastos','Honorarios')
->vista_principal
*/

function CargaFechasDefault( &$cIni , &$cFin ) {
	global $connect;
	
	$cConfiguracion = $connect->cValorIni( "consecutivo_cursos_todos" , "tipoFechaInicial" , $cDefault = "Semanas2Lunes" );
	
	if ( $cConfiguracion == "Semanas2Lunes" ) { // Vicky
		$cIni = _cfecha( nLunes2Semanas() );
		$cFin = cHoy();
	}
}

CargaFechasDefault( $cFechaDesde , $cFechaHasta );

?>
<div class="container-fuid" style="background-color: #FFF;">
	<div class="row">
		<div class="col">
			<div class="card border-dorado" style="max-width: 600px">
				<div class="card-header bg-dorado text-white">
					Opciones consecutivo de cursos
				</div>
				<div class="card-body">
					<form id="form_opciones">
						<input type="hidden" name="tipo_consecutivo" id="tipo_consecutivo" value="C">
						<div class="form-row align-items-end">
							<div class="col-sm-5">
								<div class="form-group mb-0">
									<label for="fecha_desde" class="font-weight-bold">Seleccione las fechas</label>
									<div class="input-group input-group-sm">
										<div class="input-group-prepend">
											<label class="input-group-text" for="fecha_desde">Desde</label>
										</div>
										<input type="date" class="form-control " value="<?php echo($cFechaDesde);?>" id="fecha_desde" name="fecha_desde" title="Puede oprimir F4 para desplegar el calendario" data-toggle="tooltip">
									</div><!-- /.input-group -->
									
								</div><!-- /.form-group -->
							</div><!-- /.col -->
							<div class="col-sm-7">
								<div class="form-group mb-0">
									<div class="input-group input-group-sm">
										<div class="input-group-prepend">
											<label class="input-group-text" for="fecha_hasta">Hasta</label>
										</div>
										<input type="date" class="form-control " placeholder="Hasta" value="<?php echo($cFechaHasta);?>" id="fecha_hasta" name="fecha_hasta">
										<div class="input-group-append">
											<button type="button" class="btn btn-dorado" onClick="javascrip:CargaConsecutivo('D')" title="Oprima para actualizar a las fechas seleccionadas" data-toggle="tooltip" >Cursos</button>
											<button type="button" class="btn btn-dorado dropdown-toggle dropdown-toggle-split active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="o busque una opción predefinida en el submenú">
											</button>
											<div class="dropdown-menu">
												<a class="dropdown-item" href="#" onClick="javascrip:CargaConsecutivo('a2')">Desde hace un mes</a>
												<a class="dropdown-item" href="#" onClick="javascrip:CargaConsecutivo('a1')">Este mes</a>
												<a class="dropdown-item" href="#" onClick="javascrip:CargaConsecutivo('a3')">Este mes y el próximo</a>
												<div role="separator" class="dropdown-divider"></div>
												<a class="dropdown-item" href="#" onClick="javascrip:CargaConsecutivo('a4')">Próximos 3 meses</a>
											</div><!-- /.dropdown-menu -->
										</div><!-- /.input-group-append -->
									</div><!-- /.input-group -->
								</div><!-- /.form-group -->
							</div><!-- /.col -->
						</div> <!-- /.form-row fechas --> 
						<div class="form-row align-items-end mt-2">
							<div class="col-sm-3">

<div class="form-group">
	<label for="tipo_vista">Vista</label>
	<div class="input-group input-group-sm">
		<select class="form-control" id="tipo_vista" name="tipo_vista">
			<option value="inicial" >General</option>
			<option value="carga">Gastos</option>
			<option>Representantes</option>
			<option>Liquidaciones</option>
		</select>
	</div>
</div>

							</div> <!-- /.col -->
							<div class="col-sm-3">

<div class="form-group">
	<label for="tipo_vista">Filtro</label>
	<div class="input-group input-group-sm">
		<select class="form-control" id="filtro" name="filtro">
			<option value="inicial" >Todos</option>
			<option value="carga">Activos</option>
			<option>Locales</option>
			<option>Interior</option>
		</select>
	</div>
</div>


							</div> <!-- /.col -->
							<div class="col-sm-4">

<div class="form-group">
	<label for="tipo_vista">Diálogo captura</label>
	<div class="input-group input-group-sm">
		<select class="form-control" id="filtro" name="filtro">
			<option value="inicial" >Salones</option>
			<option value="carga">Gastos</option>
			<option>Hojas de liquidación</option>
			<option>Expositores</option>
		</select>
	</div>
</div>

							</div> <!-- /.col -->
						</div> <!-- /.row opciones -->
					</form>
				</div> <!-- /.card-body -->
				<div class="card-footer " id="footer-resultado" style="display:none">
					<?php /*$connect->vistasGrupos( "'Cursos','Representantes','Gastos','Honorarios'" )*/ ?>
				</div> <!-- /.card-footer -->
			</div><!-- /.card-->
		</div><!-- /.col-->
	</div><!-- /.row-->
	<div class="row mt-4">
		<div class="col">
			<div id="tabla-consecutivo">
				<h4>Cursos consecutivos <small class="text-muted" id="total_registros"></small></h4>
				<div class="table-responsive-xl" >
					<table id="tabla_principal" class="table table-sm table-bordered  table-bordered-dorado table-hover" >
						<thead>
							<TR>
								<TH style="width: 60px;">Tipo</TH>
								<TH style="width: 48px;">IDG</TH>
								<TH style="width: 80px;">Inicio</TH>
								<TH style="width: 140px;">Fechas</TH>
								<TH style="width: 320px;">Curso</TH>
								<TH style="width: 50px;">Gpo.</TH>
								<TH style="width: 100px;">Área</TH>
								<TH style="width: 90px;">Expositor</TH>
								<TH style="width: 50px;">Ses.</TH>
								<TH style="width: 48px;">Estado</TH>
								<TH style="width: 48px;">Pagados</TH>
								<TH style="width: 48px;">Becados</TH>
							</TR>
						</thead>
						<tfoot>
						</tfoot>
						<tbody id="cuerpo_tabla_destino">

						</tbody>
					</table>
				</div><!-- /.table-->
			</div> <!-- id="tabla-consecutivo" -- >
		</div><!-- .col -->
	</div><!-- /.row-->
</div>




<script>
	
	function CargaConsecutivo( $cTipo ) {
		
		$("#total_registros").empty()
		
		$("#tipo_consecutivo").val( $cTipo );
		
		$( "#footer-resultado" ).empty().hide();
		$("#tabla-consecutivo").hide();

		$cDesde = $("#fecha_desde").val();
		$cHasta = $("#fecha_hasta").val();
		console.log( cHoraCompleta()+"=>Consecutivo: "+$("#form_opciones").serialize() );
		if ( $cTipo != "" ){
			$("#cuerpo_tabla_destino").load( "consecutivo_cursos_php.php", $("#form_opciones").serialize(), function( data , $cStatus , $xhr ) {
				//console.log( cHoraCompleta()+"<=>" );
				if ( $cStatus == "success" )
					$("#tabla-consecutivo").show();
				return true;
			} );
		}
		return false;
	}

	function ConsecutivoDefault(){
		CargaConsecutivo( "D" );
	}

$( function() {
	$("#tabla_principal thead tr").clone().appendTo("#tabla_principal tfoot");
	ConsecutivoDefault();
	$('[data-toggle~="tooltip"]').tooltip();
} ); // function()

</script>
<?php
/*
Filtro de Cancelados (default)
I
CFDI solicitado


Sin CFDI x Expositor

Vistas
Solicitud de CFDI
Comprobante

Capturas

***Filtro
Vacias en Cantidad CFDi ordenadas por Expositor (marca de pedidas)
llenar Cantidad CFDI,fecha comprobante y fecha de pago y/o complemento, en espera de póliz y de ahí se recibe el pago se rectifica la fecha de pago y el número de póliza-> Araceli regresa con la hoja de presupuestos 


*/
?>


