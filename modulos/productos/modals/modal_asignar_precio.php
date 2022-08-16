<!-- Modal -->
<div class="modal fade" id="modal_asignar_precio" tabindex="-1" role="dialog" aria-labelledby="modal_asignar_precioTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header" >
        <h5 class="modal-title" id="modal_asignar_precioTitle">Asignacion de precio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="exampleInputEmail1">Descripcion de producto</label>
          <input type="text" class="form-control text-center" id="descripcion_asignar_precio" disabled="" >   
        </div>
        <div class="d-flex col-lg-12">
          <div class="form-group col-lg-6">
            <label for="estacion_asignar_precio">Estacion</label>
            <input type="email" class="form-control text-center" id="estacion_asignar_precio" disabled="">
          </div>
          <div class="form-group col-lg-6">
            <label for="codigo_barras_asignar_precio">Codigo de barras</label>
            <input  type="text" class="form-control text-center" id="codigo_barras_asignar_precio" disabled="">
          </div>
        </div>
        <div class="col-lg-12" style="display: flex;justify-content: center;align-items: center;">
          <div class="form-group col-lg-6">
            <label for="precio_asignado">Precio</label>
            <input type="text" class="form-control" id="precio_asignado">
            <input type="text" class="d-none" id="id_producto_asignar">
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary">Guardar precio</button>
      </div>
    </div>
  </div>
</div>