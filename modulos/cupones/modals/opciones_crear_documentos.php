<button type="button" class="btn btn-primary d-none" data-toggle="modal" id="btn_modal_crear_doc" data-target="#modal_opciones_crear_documentos">
	Launch demo modal
</button>



<div class="modal fade" id="modal_opciones_crear_documentos" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-md modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalCenterTitle">Captura de Folio Volumetrico</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="opciones_documentos">

			</div>
			<div class="modal-footer">
				<div id="error_opcion"></div>
				<style>button:hover{color:white !important;} button{color:rgba(255,255,255,.5) !important;} </style>
				<button type="button" class="btn btn-warning" data-dismiss="modal" >Cancelar</button>
				<button type="button" class="btn btn-warning" onclick="siguiente_crear_documento()" style="">Siguiente</button>
			</div>
		</div>
	</div>
</div>