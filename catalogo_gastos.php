							<div class="modal-header bg-dorado">
								<h5 class="modal-title pl-3" id=""><i class="fa fa-credit-card"></i>Catálogo de gastos</h5>
								<button class="close btn-sm" data-dismiss="modal" aria-label="Cerrar">
									<i class="fa fa-close"></i>
								</button>
							</div>

							<div class="modal-body">
								<div class="container-fluid">
									<form id="form_agregar_gasto">
										<div class="form-row d-flex align-items-end">
											<div class="col">
												<div class="form-group">
													<label for="nombre">Nombre del gasto</label>
													<div class="input-group input-group-sm">
														<input type="text" class="form-control form-control-sm" id="nombre" name="nombre" >
													</div>
												</div>
											</div>
											<div class="col">
												<div class="form-group">
													<label for="calculo">Tipo de cálculo</label>
													<select class="form-control form-control-sm" name="calculo" id="calculo" >
														<option value="" selected>Seleccione...</option>
														<option value="manual">Manual</option>
														<option value="por_edecán">Por curso</option>
														<option value="por_curso">Por edecán</option>
														<option value="por_hora">Por horas curso</option>
														<option value="por_día">Por día</option>
														<option value="por_expositor">Por expositor</option>
													</select>
												</div>
											</div>
											<div class="col">
												<div class="form-group">
													<label for="grupo">Grupo de gastos</label>
													<select class="form-control form-control-sm" name="grupo" id="grupo" >
														<option value="" >Seleccione...</option>
														<option value="cefa">Cursos cefa</option>
														<option value="viaje">Viaje</option>
														<option value="salon">Salón rentado</option>
														<option value="representante">Representantes</option>
														<option value="honorarios">Honorarios</option>
														<option value="especial">Curso especial</option>
														<option value="conferencia">Conferencia</option>
														<option value="presupuestos">Presupuestos</option>
													</select>
												</div>
											</div>
											<div class="col ">
												<button id="btn_agregar_gasto" type="button" class="btn btn-success btn-sm mb-3"><i class="fa fa-plus-circle
"></i>Agregar</button>
											</div>
										</div>
									</form>
									<div class="table">
										<table class="table table-sm table-borderless">
											<thead>
												<tr>
													<th>
													Gasto
													</th>
													<th>
													Cálculo
													</th>
													<th>
													Grupo
													</th>
													<th>
													
													</th>
												</tr>
											</thead>
											<tbody id="destino_catalogo_gastos">
												<tr>
												</tr>
											</tbody>
										</table>
									</div> <!-- table-responsive -->
								</div>
							</div>

							<div class="modal-footer">
								<button class="btn btn-sm btn-primary" onClick="javascript:actualizaListadoGastos(0);" ><i class="fa fa-refresh"></i> Actualizar</button>
								<button id="cerrar_gastos" class="btn btn-sm btn-secondary" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
							</div>

<script>

var $nIdGastoEnCurso = 0;
var $cNombreReset = "";
var $cCalculoReset = "";
var $cGrupoReset = "";

function btn_body01_aceptar() {
	alert("pruebaDiálogo2 aceptar");
}

function lResultadoSatisfactorio( data ){
	var $xRespuesta = $( data ).find("resultado");
	var $cEstado;
	var $lRespuesta;
	
	$cEstado = $xRespuesta.attr('estado')
	if ( !($lRespuesta = ( $cEstado.toUpperCase()=="OK" ) ) ){
		$cRespuesta = "Algo salió mal: \n"+$xRespuesta.attr('mensaje');
		console.log( $cRespuesta+"\n"+$xRespuesta.attr('detalle') );
		alert($cRespuesta);
	}
	//console.log($xRespuesta.text() );
	return $lRespuesta;
}
	function actualizaListadoGastos($nId) {
		//console.log("actualizando con id:"+$nId);
		$("#destino_catalogo_gastos").load( "ajax_gasto_php.php",{tipo:'listado',id:$nId}, function(  data , $cEstatus ) {
			if ( $cEstatus=="success" )
				console.log("ajax_gasto_php.php->success");
		} );
	}

	function clickAgregarGasto() { 
		if ( $("#nombre").val() ==""  || $("#calculo").val()==""  || $("#grupo").val()=="" )
			alert("No puede estar vacío ninguno de los campos");
		else {// no está vacío ninguno de los campos
			$.get("ajax_gasto_agregar.php", $("#form_agregar_gasto").serialize(), function( data , $cEstatus ) {
					if ($cEstatus=="success" && lResultadoSatisfactorio( data ) ){
						var $xRespuesta = $( data ).find("resultado");
						var $nId = $xRespuesta.attr("id");
						actualizaListadoGastos($nId);
					}
				} );
		}
		
	}
	
	function ResetCampos( $nId , $lGuarda ){
		var $cElemento="#elemento_"+$nId;
		var $jElementos = $($cElemento);
		
		if ( $lGuarda ) {
			$cNombreReset  = $jElementos.find("input[name='nombre']").val();
			$cCalculoReset = $jElementos.find("select[name='calculo']").val();
			$cGrupoReset   = $jElementos.find("select[name='grupo']").val();
		} else {
			$jElementos.find("input[name='nombre']").val( $cNombreReset );
			$jElementos.find("select[name='calculo']").val( $cCalculoReset );
			$jElementos.find("select[name='grupo']").val( $cGrupoReset );
		}
	}
	
	function quitaDisabled( $nId , $jBtnEditar , $jDialogoActual ) {
		var $cElemento="#elemento_"+$nId;
		var $jElementos = $($cElemento).find("input,select");
		var $jRestoBotones,$jBotonHermano
		
		$jElementos.prop( "disabled" , false );
		
		ResetCampos( $nId, true );
		
		$jBtnEditar.find("i.fa").removeClass("fa-pencil");
		$jBtnEditar.find("i.fa").addClass("fa-save");
		$jBtnEditar.attr("title","Guardar modificaciones")
		
		$jBotonHermano = $jBtnEditar.next()
		$jBotonHermano.find("i.fa").removeClass("fa-close");
		$jBotonHermano.find("i.fa").addClass("fa-mail-reply");
		$jBotonHermano.attr("title","Cancelar edición");
		
		$jRestoBotones = $jDialogoActual.find("button i.fa-pencil,button i.fa-close");
		$jRestoBotones.parent().prop("disabled",true);
		
		$("#cerrar_gastos").prop("disabled",true);
		
		$nIdGastoEnCurso = $nId;
		$jElementos.get(0).focus();
	}
	
	function agregaDisabled( $nId , $jBtnEditar , $jDialogoActual , $lCancela ) {
		var $cElemento="#elemento_"+$nId;
		var $jElementos = $($cElemento).find("input,select");
		var $jRestoBotones

		if ( $lCancela ) 
			ResetCampos( $nId, false );
		
		$jElementos.prop( "disabled" , true );
		
		
		
		$jBtnEditar.find("i.fa").removeClass("fa-save");
		$jBtnEditar.find("i.fa").addClass("fa-pencil");
		$jBtnEditar.attr("title","Modificar elemento")
		
		$jBotonHermano = $jBtnEditar.next()
		$jBotonHermano.find("i.fa").removeClass("fa-mail-reply");
		$jBotonHermano.find("i.fa").addClass("fa-close");
		$jBotonHermano.attr("title","Borrar elemento");
		
		$jRestoBotones = $jDialogoActual.find("button i.fa-pencil,button i.fa-close");
		$jRestoBotones.parent().prop("disabled",false );
		
		$("#cerrar_gastos").prop("disabled",false);
		
		$nIdGastoEnCurso = 0;
	}
	
	function BorraGastoPorID( $nId ){
		var lResultado = false;
		
		$.post("ajax_gasto_php.php",{tipo:"borrar-gasto",id:$nId}, function( data ,$cStatus ){
			if  ( $cStatus=='success' && lResultadoSatisfactorio( data ) )
				actualizaListadoGastos( 0 );
		});
		return true;
	}
	
	function cancelaBorraGasto( $oEste, $nId ){
		var $jBtnCancelar = $( $oEste );
		var $jBotonHermano = $jBtnCancelar.prev();
		var $jDialogoActual = $jBtnCancelar.parents ("div.modal-content");

		if( $nIdGastoEnCurso==0 ) { // El botón es eliminar registro
			if ( confirm( "¿Desea borrar el gasto seleccionado?" ) )
				BorraGastoPorID( $nId );
		} else if ( $nIdGastoEnCurso == $nId ) { // El botón cancelar edición
			agregaDisabled( $nId , $jBotonHermano , $jDialogoActual , true );
		} // Ignora los demás
	}
	
	function ActualizaGastoPorID( $nId , $jBtnEditar , $jDialogoActual ) {
		var $cElemento="#elemento_"+$nId;
		var $jElemento = $($cElemento);
		var $cNombre = $jElemento.find("input[name='nombre']").val();
		var $cCalculo = $jElemento.find("select[name='calculo']").val();
		var $cGrupo = $jElemento.find("select[name='grupo']").val();
		
		$.post("ajax_gasto_php.php",{tipo:"actualiza-gasto",id:$nId,nombre:$cNombre,calculo:$cCalculo,grupo:$cGrupo}, function( data , $cStatus) {
			if  ( $cStatus == 'success' && lResultadoSatisfactorio( data ) ) 
				agregaDisabled( $nId , $jBtnEditar , $jDialogoActual , false );
		} );
		
		
	}
	
	function editaSalvaGasto( $oEste, $nId ){
		var $jBtnEditar = $( $oEste );
		var $jDialogoActual = $jBtnEditar.parents ("div.modal-content");
		
		if( $nIdGastoEnCurso==0 ) { // El botón es Editar
			console.log("Oprimió editar");
			quitaDisabled( $nId , $jBtnEditar , $jDialogoActual );
		} else if ( $nIdGastoEnCurso == $nId ) { // El botón es Guardar
			console.log("Oprimió guardar");
			ActualizaGastoPorID( $nId , $jBtnEditar , $jDialogoActual );
		} // Ignora los demás
		return false;
	}
	
	$(function(){
		$("#btn_agregar_gasto").click( clickAgregarGasto );
		actualizaListadoGastos(0);
	});

</script>