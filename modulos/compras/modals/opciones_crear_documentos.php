<button type="button" class="btn btn-primary d-none" data-toggle="modal" id="btn_modal_crear_doc" data-target="#modal_opciones_crear_documentos">
	Launch demo modal
</button>



<div class="modal fade" id="modal_opciones_crear_documentos" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalCenterTitle">¿Que tipo de solicitud deseas crear?</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="opciones_documentos">

			</div>
			<div class="modal-footer">
				<div id="error_opcion"></div>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-primary" onclick="siguiente_crear_documento()">Siguiente</button>
			</div>
		</div>
	</div>
</div>