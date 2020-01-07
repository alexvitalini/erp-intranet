<?php require_once('inicio_php.php');?>
<?php
$_POST['proceso'] = "inicial";
?>
							<div class="modal-header">
								<h5 class="modal-title" id="">Expositores</h5>
								<button class="close" data-dismiss="modal" aria-label="Cerrar">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<div class="container-fluid">
									<div class="row"> <!-- Selección de Expositor -->
										<div class="form-row d-flex align-items-end">
											<div class="col-12">
												<label for="ExpositorSelect">Seleccione el expositor</label>
												<div class="input-group">
												<select class="form-control form-control-sm custom-select" name="ExpositorSelect" id="ExpositorSelect" >
												<?php include("ajax_expositores.php"); ?>
												</select>
												  <div class="input-group-append">
													<button type="button" class="btn btn-sm btn-dorado con_tooltip" title="Revisar datos del expositor seleccionado" onClick="javascript:revisaExpositor();"><i class="fa fa-check-square"></i> Revisar</button>
													<button type="button" class="btn btn-sm btn-dorado active dropdown-toggle dropdown-toggle-split con_tooltip" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Aquí puede cambiar el orden" >
													  <i class="fa fa-sort-alpha-asc"></i>
													</button>
													<div class="dropdown-menu">
													  <a class="dropdown-item" href="#" id="#orden_iniciales" onClick="javascript:SetOrden('iniciales');">Iniciales</a>
													  <a class="dropdown-item" href="#" id="#orden_apellido"  onClick="javascript:SetOrden('apellido');">Apellido</a>
													</div>
												  </div>
												</div>
											</div>
										</div>
									</div>
									<div class="row mt-2"> <!-- Folder -->
										<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
											<li class="nav-item">
												<a class="nav-link active" id="pills-facturas-tab" data-toggle="pill" href="#pills-facturas" role="tab" aria-controls="pills-facturas" aria-selected="true">Facturas</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" id="pills-rfc-tab" data-toggle="pill" href="#pills-rfc" role="tab" aria-controls="pills-rfc" aria-selected="false"><i class="fa fa-link"></i>RFC Asociados</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" id="pills-datos-tab" data-toggle="pill" href="#pills-datos" role="tab" aria-controls="pills-datos" aria-selected="false">Datos</a>
											</li>
										</ul>
									</div>
									<!--<div class="row">
										<div class="col-12">-->
											<div class="tab-content" id="pills-tabContent">
												<div class="tab-pane fade show active" id="pills-facturas" role="tabpanel" aria-labelledby="pills-facturas-tab"><?php include "dlg_tab_facturas.php"; ?></div>
												<div class="tab-pane fade" id="pills-rfc" role="tabpanel" aria-labelledby="pills-rfc-tab"><?php include "dlg_tab_rfc.php"; ?></div>
												<div class="tab-pane fade" id="pills-datos" role="tabpanel" aria-labelledby="pills-datos-tab"></div>
											</div>
									<!--	</div>
									</div>-->
								</div>
							<div class="modal-footer p-1 mt-2">
								<button id="cerrar" class="btn btn-sm btn-secondary" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
							</div>

<script>
	var $nTab = 1; 
	var $cExpositor = "";
	var $lRecarga_pills_facturas = true;
	var $lRecarga_pills_rfc = true;
	var $lRecarga_pills_datos = true;

	function revisaExpositor() {
		if ( $cExpositor !=="" )
			limpiaDestinosExpositores();
		recargaTabExpositor();
	}

	function cargaExpositores() {
		$.post( "ajax_expositores.php", { proceso:"inicial" } , function( data ){
			$("#ExpositorSelect").html( data );
		} );
	}
	
	function SetOrden($cOrden){
		$.post( "ajax_expositores.php", { setOrden:$cOrden } , function( data ){
			if ( data ) 
				cargaExpositores();
		} );
	}

	function limpiaDestinosExpositores() {
		$("#tab-facturas-contenedor").empty();
		$("#pills-rfc-list").empty();
		$("#pills-datos").empty();
		$lRecarga_pills_facturas	= true;
		$lRecarga_pills_rfc 		= true;
		$lRecarga_pills_datos 		= true;
	}

	function limpiaDatosNuevoRFC( $lCampoBusquedaTambien = false ) {
		$("#btnAsociarRFC").prop( "disabled" , true );
		$("#rfcEncontrado").val( "" );
		$("#rfcTextoEncontrado").val( "" );
		if ( $lCampoBusquedaTambien )
			$("rfcPorBuscar").val( "" );
	}

	function asociaRFC() {
		var $cRFCxAgregar = $("#rfcEncontrado").val();
		
		if ( $cRFCxAgregar.length > 0  && $cExpositor.length > 0){
			$.post( "ajax_expositores.php", { asociar: $cRFCxAgregar , expositor: $cExpositor } , function( data ){
				if ( data=="OK" ){
					recargaTabExpositor();
					limpiaDatosNuevoRFC( true );
				}
			} );
		}
	}

	function desenlazaRFC( $nIdEnlace ){
		$nIdEnlace = parseInt( $nIdEnlace , 10 );
		
		if ( ($nIdEnlace > 0 )  && confirm("¿Realmente desea desenlazar este RFC al expositor?") )
			$.post( "ajax_expositores.php", { eliminarfc: $nIdEnlace }, function(data){
				if ( data=="OK" )
					recargaTabExpositor();
			} );
	}

	function recargaTabExpositor() {
		var $cId =""
		
		if ( $cExpositor=="" ){
			//alert("Seleccione un expositor");
			return;
		} 
		
		$cTemporalidad = $("input[name='tiempo_facturas_expositor']:checked").val();
		
		$.post( "ajax_expositores.php", { carga: $nTab , expositor: $cExpositor, temporalidad: $cTemporalidad } , function( data ) {
			if ( $nTab == 1) { // facturas
				$cId = "#tab-facturas-contenedor";
				$($cId).html( data );
				$lRecarga_pills_facturas	= false;
			} else if ( $nTab == 2 ) { // rfc
				$cId = "#pills-rfc-list";
				$($cId).html( data );
				$lRecarga_pills_rfc 		= false;
			} else if ( $nTab == 3 ) { // datos
				$cId = "#pills-datos";
				$($cId).html( data );
				$lRecarga_pills_datos 		= false;
			} 
		});
	}

	function inicioExpositores(){
		$(".con_tooltip").tooltip();
		
		$("#ExpositorSelect").change( function() {
			$cExpositor = $( this ).val();
			limpiaDestinosExpositores();
		});
		
		$("#rfcPorBuscar").keyup( function(){
			var $cTexto = $(this).val();
			
			if ( $cTexto.length > 2 ) {
				$.post( "ajax_expositores.php", { rfc: $cTexto , expositor: $cExpositor } , function( data ) {
					$xResultado = $(data).find("resultado");
					if ( $xResultado.attr("OK")=="OK" ) {
						$("#btnAsociarRFC").prop( "disabled" , ( $xResultado.attr("estado")=="NO" ) );
						$("#rfcEncontrado").val( $xResultado.attr("rfc") );
						$("#rfcTextoEncontrado").val( $xResultado.attr("descripcion") );
					}
				}, "xml");
			} else
				limpiaDatosNuevoRFC();
			
		});
		
		$('#pills-facturas-tab').on('shown.bs.tab', function ( e ) {
			$nTab = 1;
			if ( $lRecarga_pills_facturas ) {
				recargaTabExpositor();
			}
		});
		$('#pills-rfc-tab').on('shown.bs.tab', function ( e ) {
			$nTab = 2;
			if ( $lRecarga_pills_rfc ) {
				recargaTabExpositor();
			}
		});
		
		$('#pills-datos-tab').on('shown.bs.tab', function ( e ) {
			$nTab = 3;
			if ( $lRecarga_pills_datos ) {
				recargaTabExpositor();
			}
		});
		
	}

	$( inicioExpositores() );

</script>
<?php
/*
//$("#pills-datos-tab").tab("show")

		// $('/* #pills-tab li a').on('shown.bs.tab', function ( e ) {
			// console.log( e.target )
			// e.relatedTarget // previous active tab 
		// }); 

				SELECT * FROM validacfd.facturas WHERE fecha >= date_sub(curdate(), interval 12 month) && rfc in (SELECT rfc FROM test.erp_expositor_rfc_asociacion  WHERE idexpositor LIKE 'VHCP' ) ORDER BY fechavalidacion DESC
				
				
				1 SELECT GROUP_CONCAT( rfc ) FROM erp_expositor_rfc_asociacion  WHERE idexpositor LIKE 'VHCP' GROUP by idexpositor
				2 SELECT * FROM validacfd.facturas WHERE fecha >= date_sub(curdate(), interval 12 month) && rfc in ('CAPV711213BB1','NWM9709244W4') ORDER BY fechavalidacion DESC
				
				CAPV711213BB1,NWM9709244W4
				
				SELECT * FROM validacfd.facturas WHERE fecha >= date_sub(curdate(), interval 12 month) && rfc in (SELECT rfc FROM test.erp_expositor_rfc_asociacion  WHERE idexpositor LIKE 'VHCP' ) ORDER BY fechavalidacion DESC

SELECT * FROM validacfd.facturas WHERE fecha >= date_sub(curdate(), interval 12 month) && rfc in (

SELECT * FROM test.erp_expositor_rfc_asociacion join validacfd.facturas using (rfc) WHERE idexpositor LIKE 'VHCP' ORDER BY fechavalidacion DESC


SELECT * FROM `facturas` WHERE `rfc`='MACM5502093P5' && fecha >= date_sub(curdate(), interval 12 month)
ORDER BY `facturas`.`fechavalidacion`  DESC
SELECT * FROM `facturas` WHERE `rfc`='MACM5502093P5' && fecha >= date_sub(curdate(), interval 12 month) ORDER BY `facturas`.`fechavalidacion` DESC
										<nav>
											<div class="nav nav-tabs" id="nav-tab" role="tablist"> <!-- Folders -->
												<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Home</a>
												<a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Profile</a>
												<a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Contact</a>
											</div>
										</nav>
										<div class="tab-content" id="nav-tabContent"> <!-- Contenido de los folders -->
											<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
												<div class="container-fluid">
													<div class="col-12">
														<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
														tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
														quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
														consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
														cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
														proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
													</div>
													<div class="col-6">
														<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
														tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
														quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
														consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
														cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
														proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
													</div>
												</div>
											</div>
											<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
											</div>
											<div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
											</div>
										</div>


*/
?>
