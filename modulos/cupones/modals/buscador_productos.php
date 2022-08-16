<button type="button" class="btn btn-primary d-none" data-toggle="modal" data-target="#modal_buscador_producto" data-whatever="@mdo" id="btn_buscador_producto" >Open modal for @mdo</button>


<div class="modal fade" id="modal_buscador_producto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style=" margin-top: 15%;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Buscador de productos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Recipient:</label>
            <input type="text" class="form-control" id="texto_producto" autofocus="">
          </div>
<!--           <div class="form-group">
            <label for="message-text" class="col-form-label">Message:</label>
            <textarea class="form-control" id="message-text"></textarea>
          </div> -->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary">Seleccionar</button>
      </div>
    </div>
  </div>
</div>