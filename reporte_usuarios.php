	<div class="container-fluid">
		<div class="row">
			<div class="col">
				<div class="card-deck mb-3">
					<div class="card">
						<div class="card-header">
							Título card
						</div>
						<div class="card-body">
							<h5 class="card-title">Título del cuerto en h5</h5>
							<p class="card-text">Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen.</p>
							<a href="#" class="btn btn-primary">Botón</a>
						</div>
						<div class="card-footer text-muted">
						No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos electrónicos
						</div>
					</div>
					<div class="card text-white bg-dark ">
						<div class="card-header">
							Datos
						</div>
						<div class="card-body ">
							<h5 class="card-title">Usuario</h5>
							<p class="card-text"><?php print_r( $usuario ); ?></p>
						</div>
						<div class="card-footer text-muted">
						SALIDA
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="card border-dorado m-2">
				<div class="card-header bg-dorado text-white">
					Card completo
				</div>
				<div class="card-body ">
					<h4 class="card-title">Permisos del usuario</h4>
					<h5 class="card-subtitle text-muted">Por departamento</h5>
					<p class="card-text"><?php print_r( $connect->aPermisos ); ?></p>
				</div>
				<div class="card-footer">
					<a href="#" class="card-link">Card link</a>
					<a href="#" class="card-link">Another link</a>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
			  <div class="card-header">Header</div>
			  <div class="card-body">
				<h5 class="card-title">Danger card title</h5>
				<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
			  </div>
			</div>
		</div>
	</div>