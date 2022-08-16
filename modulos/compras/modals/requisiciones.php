
<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg" id="btn_detallado" style="display: none;">Large modal</button>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="z-index: 2001">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header margen_modal">
        <h5 class="modal-title" id="">Detallado de Requisicion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form_detallado_req">
         <div class="col-lg-12 d-flex flex-wrap">
          <div class="col-lg-6 d-flex flex-wrap justify-content-between">
           <div class="form-group col-lg-6 d-flex flex-wrap">
            <label for="inputEmail4">Requisición</label>
            <input class="form-control col-lg-12 " type="text" id="requisicion" disabled="">
          </div>

          <div class="form-group col-lg-6 d-flex flex-wrap">
            <label for="inputEmail4">Fecha</label>
            <input class="form-control " type="text"  id="fecha" disabled="">
          </div>

        </div>

        <div class="col-lg-6 d-flex flex-wrap justify-content-between">

         <div class="form-group col-lg-6 d-flex flex-wrap">
          <label for="inputEmail4">Tipo Afectacion</label>
          <input class="form-control " type="text" id="tipo_afectación" disabled="">

        </div>
          <br>
        <div class="form-group col-lg-6 d-flex flex-wrap">
          <label for="inputEmail4">Solicitante</label>
          <input class="form-control " type="text"  id="solicitante" disabled="">
        </div>

      </div>
    </div>
    <div  class="d-flex flex-wrap col-lg-12">
      <label for="inputEmail4" class="col-lg-2">Concepto</label>
      <input class="form-control col-lg-10" type="text"  id="concepto" disabled="">
    </div>
    <input type="text"  id="requifiltro" style="display: none;">
    <br>


    <section >
      <!--for demo wrap-->

      <div >
        <table id="tabla_descripcion" class="display" width="100%">
          <thead>
            <tr>

              <th class="">Descripcion</th>
              <th class="">Uni</th>
              <th class="">Cant. Sol</th>
              <th class="">Cant. Aut</th>
              <th class="">Precio</th>
              <th class="">Importe</th>
              <th class="d-none">Codigo</th>
              <th class="d-none">indice producto</th>
            </tr>
          </thead>
          <tfoot>
              <th class="">Descripcion</th>
              <th class="">Uni</th>
              <th class="">Cant. Sol</th>
              <th class="">Cant. Aut</th>
              <th class="">Precio</th>
              <th class="">Importe</th>
              <th class="d-none">Codigo</th>
              <th class="d-none">indice producto</th>
          </tfoot>
        </table>
      </div>


    </section>
  </form>
  <a href="#" id="archivo_pdf" onclick="importar_pdf('requisicion','requisicion')"> Vista previa</a>
   <a href="#" class="cont_archivo">||</a>
  <a class="cont_archivo" target="_blank">Comprobante orden de pago</a>
  <div id="descripcionesxproducto" >

  </div>
</div>
<div class="modal-footer flex-wrap">
  <div class=" d-flex flex-wrap separacion" style=" justify-content: center;align-items: center;"> 
    <label class="col-lg-4">Total: </label>
    <input id = 'idtotal' readonly='' style='border:0px; text-align: center;' class='form-control col-lg-8'  value='' >

  </div>
  <button type="button" id="btn_cancelar_requ" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
  <button type="button" class="btn btn-danger"  id="btn_rechazar_req" onclick="aviso_rechazar_todo('requisicion','btn_cancelar_requ')" >Rechazar Req.</button>
  <button type="button" class="btn btn-primary" id="btn_autorizar" onclick="enviar_Autorizadas()">Autorizar</button>
</div>
</div>
</div>
</div>
