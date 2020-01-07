<div class="container-fluid">
	<div class="row"> <!-- Selección de meses a revisar  -->
		<div class="col-12 p-0">
			<label class="form-check-label">Temporalidad </label>
			<div class="custom-control custom-radio">
				<div class="form-check form-check-inline mx-3">
					<input type="radio" id="tFacturas3" name="tiempo_facturas_expositor" class="custom-control-input" value="3" checked>
					<label class="custom-control-label" for="tFacturas3">3 meses</label>
				</div>
				<div class="form-check form-check-inline mx-3">
					<input type="radio" id="tFacturas12" name="tiempo_facturas_expositor" class="custom-control-input" value="12">
					<label class="custom-control-label" for="tFacturas12">1 año</label>
				</div>
				<div class="form-check form-check-inline mx-3">
					<input type="radio" id="tFacturas0" name="tiempo_facturas_expositor" class="custom-control-input" value="0">
					<label class="custom-control-label" for="tFacturas0">Todas</label>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12" id='tab-facturas-contenedor'>
		</div>
	</div>
</div>