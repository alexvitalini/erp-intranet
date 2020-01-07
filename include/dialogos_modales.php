
		<div class="modal" tabindex="-1" id="dialogo_modal_chico" role="dialog" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog modal-sm" modal-sm role="document" >
			<!-- Modal content-->
			<div class="modal-content">
			</div>
		</div>
	</div>

	<div class="modal" tabindex="-1" id="dialogo_modal_mediano" role="dialog" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog" role="document" >
			<!-- Modal content-->
			<div class="modal-content">
			</div>
		</div>
	</div>
	
	<div class="modal" tabindex="-1" id="dialogo_modal_grande" role="dialog" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog modal-lg"  role="document" >
			<!-- Modal content-->
			<div class="modal-content">
			</div>
		</div>
	</div>
	
	<div class="modal" tabindex="-1" id="dialogo_modal_extra_grande" role="dialog" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog modal-xl"  role="document">
			<!-- Modal content-->
			<div class="modal-content">
			</div>
		</div>
	</div>
	
	<div class="modal" tabindex="-1" id="dialogo_ini" role="dialog">
		<div class="modal-dialog modal-sm"  role="document">
			<!-- Modal content-->
			<div class="modal-content">

							<div class="modal-header">
								<h5 class="modal-title" id="">Ini</h5>
								<button class="close" data-dismiss="modal" aria-label="Cerrar">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>

							<div class="modal-body">
				<pre>
<?php print_r( $connect->aIni ); ?>
				</pre>
							</div>
			</div>
		</div>
	</div>
	
	<div class="modal" tabindex="-1" id="dialogo_permisos" role="dialog">
		<div class="modal-dialog modal-sm"  role="document">
			<!-- Modal content-->
			<div class="modal-content">

							<div class="modal-header">
								<h5 class="modal-title" id="">Permisos</h5>
								<button class="close" data-dismiss="modal" aria-label="Cerrar">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>

							<div class="modal-body">
				<pre>
<?php 
	print_r( $connect->aPermisos );
	echo("<p>Diseño: ".  $connect->nPermiso( "Diseño" )."<br>");
	echo("Dirección: ".  $connect->nPermiso( "Dirección" )."<br>");
	echo("Cursos: ".  $connect->nPermiso( "Cursos" ) );
?>
				</pre>
				<hr>
				<pre>
<?php print_r( $connect->aDatosUsuario ) ?>
				</pre>
							</div>
			</div>
		</div>
	</div>
	