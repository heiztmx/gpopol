
<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".modal_cotizador" id="btn_cotizador" style="display: none;">Large modal</button>

<div class="modal fade modal_cotizador" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="z-index: 2001">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header margen_modal">
        <h5 class="modal-title" id="">Detallado de Requisicion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form_detallado_cotizador">
         <div class="col-lg-12 d-flex flex-wrap">
          <div class="col-lg-6 d-flex flex-wrap justify-content-between">
           <div class="form-group col-lg-6 d-flex flex-wrap">
            <label for="inputEmail4">Requisición</label>
            <input class="form-control col-lg-12 " type="text" id="requisicion_cot" disabled="" style="text-align: center;">
          </div>

          <div class="form-group col-lg-6 d-flex flex-wrap">
            <label for="inputEmail4">Fecha</label>
            <input class="form-control " type="text"  id="fecha_cot" disabled="" style="font-size: 13px;text-align: center;">
          </div>

        </div>

        <div class="col-lg-6 d-flex flex-wrap justify-content-between">

         <div class="form-group col-lg-6 d-flex flex-wrap">
          <label for="inputEmail4">Tipo Afectacion</label>
          <input class="form-control " type="text" id="tipo_afectacion_cot" disabled="" style="font-size: 13px;text-align: center;">

        </div>
        <br>
        <div class="form-group col-lg-6 d-flex flex-wrap">
          <label for="inputEmail4">Solicitante</label>
          <input class="form-control " type="text"  id="solicitante_cot" disabled="" style="font-size: 14px;text-align: center;">
        </div>

      </div>
    </div>
    <div  class="d-flex flex-wrap col-lg-12">
      <label for="inputEmail4" class="col-lg-2">Concepto</label>
      <input class="form-control col-lg-10" type="text"  id="concepto_cot" disabled="">
    </div>
    <input type="text"  id="requifiltro_cot" style="display: none;">
    <br>


    <section >
      <!--for demo wrap-->

      <div >
        <table id="tabla_descripcion_cotizador" class="display" width="100%" >
          <thead>
            <tr>
            <th class="">ID</th>
              <th class="">Producto</th>
              <th class="" >Proveedor</th>
              <th class="">Cant</th>
              <th class="">Pre</th>
              <th class="">Total</th>
            </tr>
          </thead>
          <tfoot>
            <th class="">ID</th>
            <th class="">Producto</th>
            <th class="">Uni</th>
            <th class="">Cant</th>
            <th class="">Precio</th>
            <th class="">Proveedor</th>
          </tfoot>
        </table>
      </div>


    </section>
  </form>
  <a href="#" id="archivo_pdf_cot" onclick="importar_pdf('requisicion_cot','requisicion')"> Vista previa</a>
<!--   <a href="#" class="cont_archivo">||</a>
  <a class="cont_archivo" target="_blank">Comprobante orden de pago</a> -->
  <div id="descripcionesxproducto_cot" >

  </div>
</div>
<div class="modal-footer flex-wrap">
  <div class=" d-flex flex-wrap separacion" style=" justify-content: center;align-items: center;"> 
    <label class="col-lg-4">Total: </label>
    <input id = 'idtotal_req' readonly='' style='border:0px; text-align: center;' class='form-control col-lg-8'  value='' >

  </div>
  <button type="button" id="btn_cancelar_requ_cot" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
  <button type="button" class="btn btn-danger"  id="btn_rechazar_req_cot" onclick="aviso_rechazar_todo('requisicion','btn_cancelar_requ_cot')" >Rechazar Req.</button>
  <button type="button" class="btn btn-primary" id="btn_autorizar_cot" onclick="enviar_Autorizadas()">Autorizar</button>
  <button type="button" class="btn btn-success" onclick="show_modal_ending()" id="btn_autorizar_cot" >Cotizar</button>
</div>
</div>
</div>
</div>
