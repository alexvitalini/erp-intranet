<div class="container-fluid">
	<div class="row"> <!-- Selección de Expositor  -->
		<div class="col-12 p-0">
			<form class="form-inline">
				<input id="asociar" type="hidden" value='NO'>
				<input id="mensaje" type="hidden" value=''>
				<div class="input-group input-group-sm mb-2 mr-sm-2">
					<div class="input-group-prepend">
					  <div class="input-group-text">RFC</div>
					</div>
					<input type="text" class="form-control" id="rfcPorBuscar" placeholder="Escriba el RFC">
				</div>
				<div class="input-group input-group-sm mb-2 mr-sm-2">
					<div class="input-group-prepend">
					  <div class="input-group-text"><i class="fa fa-database"></i></div>
					</div>
					<input type="text" class="form-control" id="rfcEncontrado" placeholder="RFC..." readonly>
					<input type="text" class="form-control" id="rfcTextoEncontrado" placeholder="Descripción..." readonly>
				</div>
				<button onclick="javascript:asociaRFC()" id='btnAsociarRFC' class="btn btn-sm btn-success mb-2" disabled ><i class="fa fa-link"></i>Asociar</button>
			</form>
		</div>
	</div>
	<div class="row">
		<div class="col-4">
			<label class="font-weight-bold" for="ExpositorSelect">RFC Asociados y sus facturas</label>
			<ul class="list-group my-1" id="pills-rfc-list">
			</ul>
		</div>
	</div>
</div>