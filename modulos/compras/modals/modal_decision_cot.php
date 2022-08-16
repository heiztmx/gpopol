  

<!-- Modal -->
<div class="modal fade modal_peq" id="decision_cotizador" tabindex="-1" role="dialog" aria-labelledby="decision_cotizadorLabel" aria-hidden="true" style="z-index: 2003;background-color:black; ">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
 
      Usuario: <span style='font-weight:bold'> <?php echo $_SESSION["user"]?> </span> elige una de las siguientes
       opciones para cambiar el estado de la requisicion
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="close_modal_ending()" >Cancelar</button>
        <button type="button" class="btn btn-primary">Guardar</button>
        <button type="button" id="#val_dec_cot" class="btn btn-success" onclick="tomardatos_tabla('tabla_descripcion_cotizador')">Validar</button>
      </div>
    </div>
  </div>
</div>