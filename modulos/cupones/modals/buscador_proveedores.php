<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg" id="btn_modal_proveedores">Large modal</button> -->

<div class="modal fade bd-example-modal-lg mt-5" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"  id="modal-proveedores">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="row"></div>
			<div class="row"></div>
			<h3 class=" text-center mt-3">Buscador de proveedores</h3>
			<div class="col-lg-9 d  mx-auto" >
				<!-- <label for="formGroupExampleInput">Nombre</label> -->
				<input type="text" class="form-control col-lg-10 mx-auto "  id="proveedores" tabindex="1" onkeyup="buscar_proveedor('tabla_nueva_ordenes_compra')" placeholder="Nombre">
			</div>
			<br><br>
			<div class="container"  id="contenedor_generel_proveedores" style="display: none;">

				<div class="d-flex justify-content-center align-items-center col-lg-12">
					<div class=" col-lg-2  d-flex">
						
						<label for="id" class="label_proveedores" >ID</label>
						<div>
							<input type="text" class="form-control" id="id" placeholder="" disabled="">
						</div>
						
					</div>
					<div class="col-lg-6 d-flex ">
						<label for="rfc"  class="label_proveedores">RFC</label>
						<input type="text" class="form-control" id="rfc" placeholder="" disabled="">
					</div>
					<div class=" col-lg-4 d-flex ">
						<label for="tipo_persona" class="col-lg-6 ">Tipo de persona</label>
						<input type="text" class="form-control col-lg-6" id="tipo_persona" placeholder="" disabled="">
					</div>

					
				</div>
				<div class="d-flex justify-content-center align-items-center col-lg-12">

					<div class="form-group col-lg-6 d-flex">
						<label for="formGroupExampleInput" class="label_proveedores">Dirección</label>
						<input type="text" class="form-control" id="direccion" placeholder="" disabled="">
					</div>
					<div class="form-group col-lg-6 d-flex">
						<label for="formGroupExampleInput" class="label_proveedores">Poblacion</label>
						<input type="text" class="form-control" id="poblacion" placeholder="" disabled="">
					</div>
				</div>
				<div class="d-flex justify-content-center align-items-center col-lg-12">
					<div class="form-group col-lg-6 d-flex">
						<label for="formGroupExampleInput" class="label_proveedores">País</label>
						<input type="text" class="form-control" id="pais" placeholder="" disabled="">
					</div>
					<div class="form-group col-lg-6 d-flex">
						<label for="formGroupExampleInput">Codigo postal</label>
						<input type="text" class="form-control" id="cp" placeholder="" disabled="">
					</div>
				</div>
				<div class="d-flex justify-content-center align-items-center col-lg-12">
					<div class="form-group col-lg-6 d-flex">
						<label for="formGroupExampleInput" class="label_proveedores">Telefono</label>
						<input type="text" class="form-control" id="telefono" placeholder="" disabled="">
					</div>
					<div class="form-group col-lg-6 d-flex">
						<label for="formGroupExampleInput" class="label_proveedores">Email</label>
						<input type="text" class="form-control" id="email" placeholder="" disabled="">
					</div>
				</div>
				<div class="d-flex justify-content-center align-items-center col-lg-12">
					<div class="form-group col-lg-6 d-flex">
						<label for="formGroupExampleInput" class="label_proveedores">Contacto</label>
						<input type="text" class="form-control" id="contacto" placeholder="" disabled="">
					</div>
					<div class="form-group col-lg-6 d-flex">
						<label for="formGroupExampleInput" class="label_proveedores">Moneda</label>
						<input type="text" class="form-control" id="moneda_pro" placeholder="" disabled="">
					</div>

				</div>
				<div class="d-flex justify-content-center align-items-center col-lg-12">


					<div style="padding: 10px;" class="col-lg-12 d-flex justify-content-end align-items-end">
						<button type="button" class="btn btn-primary" onclick="elegir_proveedor()" data-dismiss="modal">Aceptar</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>