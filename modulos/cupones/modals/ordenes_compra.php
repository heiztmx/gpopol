
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_detalladoOC" id="btn_detalladoOC" style="display: none;">Large modal</button>

<div class="modal fade"  id="modal_detalladoOC" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="z-index: 2001">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header margen_modal">
        <h5 class="modal-title" id="">Detallado Ordenes de compra</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form_detallado">
         <div class="col-lg-12 d-flex flex-wrap">
          <div class="col-lg-6 d-flex flex-wrap justify-content-between">
           <div class="form-group col-lg-6 d-flex flex-wrap">
            <label for="inputEmail4">Orden de compra</label>
            <input class="form-control col-lg-12 " type="text" id="requisicionco" disabled="">
          </div>

          <div class="form-group col-lg-6 d-flex flex-wrap">
            <label for="inputEmail4">Fecha</label>
            <input class="form-control " type="text"  id="fechaco" disabled="">
          </div>

        </div>

        <div class="col-lg-6 d-flex flex-wrap justify-content-between">

         <div class="form-group col-lg-6 d-flex flex-wrap">
          <label for="inputEmail4">Tipo Afectacion</label>
          <input class="form-control " type="text" id="tipo_afectaciónco" disabled="">

        </div>
        <br>
        <div class="form-group col-lg-6 d-flex flex-wrap">
          <label for="inputEmail4">Solicitante</label>
          <input class="form-control " type="text"  id="solicitanteco" disabled="">
        </div>

      </div>
    </div>
    <div  class="d-flex flex-wrap col-lg-12">
      <label for="inputEmail4" class="col-lg-2">Concepto</label>
      <input class="form-control col-lg-10" type="text"  id="conceptoco" disabled="">
    </div>
    <input type="text"  id="requifiltro" style="display: none;">


    <section >
      <!--for demo wrap-->

      <div style="margin-top: 4%" >
        <table id="tabla_descripcionOC" class="display" width="100%">
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
            <tr>
            <th class="">Descripcion</th>
            <th class="">Uni</th>
            <th class="">Cant. Sol</th>
            <th class="">Cant. Aut</th>
            <th class="" style="font-size: 12px !important">Precio</th>
            <th class="" style="font-size: 12px !important">Importe</th>

          </tr>
          </tfoot>
        </table>
      </div>


    </section>
  </form>
  <a href="#" onclick="importar_pdf('requisicionco','orden_compra')"> Vista previa</a>
  <a href="#" class="cont_archivo">||</a>
  <a class="cont_archivo" target="_blank">Archivo</a>
  <div id="descripcionesxproducto" >

  </div>
</div>
<div class="modal-footer flex-wrap">
  <div class=" d-flex flex-wrap separacion" style=" justify-content: center;align-items: center;"> 
  <label class="col-lg-4">Total: </label>
  <input id = 'idtotaloc' readonly='' style='border:0px; text-align: center;' class='form-control col-lg-8'  value='' >

</div>
<button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn_cancelar_oc">Cancelar</button>
<button type="button" class="btn btn-danger"  id="btn_rechazar_oc" onclick="aviso_rechazar_todo('ODC','btn_cancelar_oc')" >Rechazar OC</button>
<button type="button" class="btn btn-primary"   id="btn_pagar_oc" onclick="pagar_OC()">Pagar</button>
</div>
</div>
</div>
</div>
