




<button style="display: none;" type="button" class="btn btn-primary" id="modificar_productos"  data-toggle="modal" data-target=".bd-example-modal-lg">Large modal</button>

<div class=" centrar modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" >
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
     <div class="modal-header centar_header">
      <h5 class="modal-title" id="exampleModalLabel">Modificación de producto</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <form>
        <div class="contenedor_inputs">
          <div class="form-group inputs1">
            <label for="recipient-name" class="col-form-label">Clave:</label>
            <input type="text" class="form-control" id="clave" readonly="">
            <input type="hidden" id="id_producto">
          </div>
          <div class="form-group inputs1">
            <label for="recipient-name" class="col-form-label">Precio</label>
            <input type="text" class="form-control" id="precio" readonly="">
            <input type="hidden" id="">
          </div>
        </div>

        <div class="contenedor_inputs">
          <div class="form-group inputs1">
            <label for="message-text" class="col-form-label">Nombre</label>
            <input type="text" name="" class="form-control" id="nombre">
          </div>
          <div class="form-group inputs1">
            <label for="message-text" class="col-form-label">Codigo de barras:</label>
            <input type="text" name="" class="form-control" id="codigo">
            <input type="hidden" name="" class="form-control" id="id_estacion">


          </div>
        </div>

        <div class="contenedor_inputs">
          <div class="form-group inputs">
            <label for="recipient-name" class="col-form-label">Estado</label>
            <select class="form-control" id="estado">
              <option value="Si">Activo</option>
              <option value="No">Desactivo</option>
            </select>
          </div>
          <div class="form-group inputs">
            <label for="recipient-name" class="col-form-label">Linea:</label>
            <select class="form-control" id="linea">
              <option value="1">AKRON</option>
              <option value="2">MEXLUB</option>
              <option value="3">BARDHAL</option>
              <option value="4">OTROS</option>
            </select>
          </div>
          <div class="form-group inputs">
            <label for="recipient-name" class="col-form-label">Estacion</label>
            <select class="form-control" id="estacion">
              <?php 


              for ($i=0; $i <count($estaciones_check) ; $i++) { 
                $id_estacion = $ids_estaciones[$i];
                $name_estacion = $estaciones_check[$i];
                echo "<option value='".$id_estacion."'>".$name_estacion."</option>";
              }
              ?>
            </select>
          </div>
        </div>
      </form>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      <button type="button" class="btn btn-primary" onclick="modificar_productos()">Guardar</button>
    </div>
  </div>
</div>
</div>

<!-- <div class="centrar   modal fade " tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" ">

  </div>
</div> -->


<!-- <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

    </div>
  </div>
</div> -->