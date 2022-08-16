




<button style="display: none;" type="button" class="btn btn-primary d-none" id="agregar_productos"  data-toggle="modal" data-target="#modal_agregar_producto">Large modal</button>

<div class=" centrar modal fade bd-example-modal-lg" id="modal_agregar_producto" tabindex="-1" role="dialog" aria-labelledby="modal_agregar_producto" aria-hidden="true" style="z-index: 2002 ">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
     <div class="modal-header centar_header">
      <h5 class="modal-title" id="exampleModalLabel">Agregar de producto</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body" id="ocultar_div">
      <div class="container" >
        <div class="stepwizard">
          <div class="stepwizard-row setup-panel">
            <div class="stepwizard-step col-xs-3"> 
              <a href="#step-1" type="button" class="btn btn-success btn-circle "  disabled="disabled" >1</a>
              <p class="d-none"><small>Shipper</small></p>
            </div>
            <div class="stepwizard-step col-xs-3"> 
              <a href="#step-2" type="button" class="btn btn-default btn-circle " disabled="disabled" >2</a>
              <p class="d-none"><small>Destination</small></p>
            </div>
            <div class="stepwizard-step col-xs-3"> 
              <a href="#step-3" type="button" class="btn btn-default btn-circle " disabled="disabled" >3</a>
              <p class="d-none"><small>Schedule</small></p>
            </div>
<!--             <div class="stepwizard-step col-xs-3"> 
              <a href="#step-4" type="button" class="btn btn-default btn-circle d-none" disabled="disabled">4</a>
              <p class="d-none"><small>Cargo</small></p>
            </div> -->
          </div>
        </div>

        <form role="form" id="formulario_productos">
          <div class="panel panel-primary setup-content" id="step-1">
            <div class="panel-heading">
              <br>
              <h3 class="panel-title">Datos generales</h3>
            </div>
            <div class="panel-body">
              <div class="d-flex cuadros">
                <div class="form-group sub_cuadros">
                  <label class="control-label" id="codigobarras_producto_label">Codigo de barras</label>
                  <input maxlength="15" type="text" name="codigobarras_producto" id="codigobarras_producto" required="required" class="form-control" placeholder="Codigo de barras" />
                </div>
                <div class="form-group sub_cuadros">
                  <label for="estaciones" id="estaciones_label">Estacion</label>
                  <select id="estaciones" class="form-control" name="estaciones">
                    <?php 
                    for ($i=0; $i < count($estaciones_check); $i++) { 
                     echo "<option value='".$ids_estaciones[$i]."'>".$estaciones_check[$i]."</option>";
                   }
                   ?>

                 </select>
               </div>
             </div>


             <div class="d-flex cuadros">


              <div class="form-check sub_cuadros" style=" margin-top: 20px;margin-left: 20px;margin-bottom: 20px;">
                <input class="form-check-input" type="checkbox" id="chkactivo" name="chkactivo" checked="" disabled="">
                <label class="form-check-label" for="chkactivo" id="chkactivo_label" >
                  Activo
                </label>
              </div>
              <br>
            </div>


            <button class="btn btn-primary nextBtn pull-right" type="button">Siguiente</button>
          </div>
        </div>

        <div class="panel panel-primary setup-content" id="step-2">
          <div class="panel-heading">
            <br>
            <h3 class="panel-title">Destination</h3>
          </div>
          <div class="panel-body">
            <div class="form-group">
              <label class="control-label" id="nombre_pro_label">Descripcion</label>
              <input maxlength="100" name="nombre_pro" type="text" required="required" class="form-control" placeholder="Descripcion" id="nombre_pro" />
            </div>

            <div class="cuadros ">
             <div class="form-group sub_cuadros">
              <label class="control-label" id="linea_producto_label">Linea</label>
              <input maxlength="200" type="text" name="linea_producto" required="required" class="form-control" oninput="buscador_lineas_sublineas('linea_producto','DINVLINE')" placeholder="Linea"  id="linea_producto" name="linea_producto" />
            </div> 
            <div class="form-group sub_cuadros">
              <!-- <label class="control-label">Sub linea</label> -->
              <label for="exampleFormControlSelect1" id="sublinea_producto_label">Sublinea</label>
              <select class="form-control"  id="sublinea_producto" name="sublinea_producto" disabled=""></select>
              <!-- <input maxlength="200" type="text"  required="required" class="form-control" placeholder="Enter Company Address" disabled="" /> -->
            </div>
          </div>
          <div class="cuadros">

            <div class=" form-group sub_cuadros">
              <label for="ivas" id="unidad_producto_label">unidad</label>
              <input maxlength="100" type="text" id="unidad_producto" name="unidad_producto" required="required" class="form-control" placeholder="Unidad" />
            </div>
          </div>
          <button class="btn btn-primary nextBtn pull-right" type="button">Siguiente</button>
        </div>
      </div>

      <div class="panel panel-primary setup-content" id="step-3">
        <div class="panel-heading">
          <br>
          <h3 class="panel-title">Schedule</h3>
        </div>
        <div class="panel-body">
          <div class="cuadros">
           <div class="form-group sub_cuadros">
            <label class="control-label" id="CVEPRODSAT_label">CVEPRODSAT</label>
            <input maxlength="200" type="text" value="15121500" required="required"  id="CVEPRODSAT" class="form-control" placeholder="CVEPRODSAT" oninput="buscador_autocomplete('CVEPRODSAT','DGENPRODSERVSAT')" name="CVEPRODSAT" />
          </div> 
          <div class="form-group sub_cuadros">
            <label class="control-label" for="CVEUISAT" id="CVEUISAT_label">CVEUISAT</label>
            <input maxlength="200" type="text" value="H87" required="required" id="CVEUISAT" class="form-control" placeholder="CVEPRODSAT" oninput="buscador_autocomplete('CVEUISAT','DGENUNISAT')"  name="CVEUISAT" />
          </div>
        </div>
        <div class="cuadros">
          <div class="sub_cuadros" >
            <div class=" form-group">
              <label for="marca_producto" id="marca_producto_label">Marca</label>
              <select id="marca_producto" class="form-control" name="marca_producto">

              </select>
            </div> 
          </div>
          <div class="sub_cuadros" >
            <div class=" form-group">
              <label for="iva_producto" id="iva_producto_label">IVA</label>
              <select id="iva_producto" class="form-control" name="iva_producto">

              </select>
            </div> 
          </div>
        </div>

        <button class="btn btn-success pull-right" id="guardar_producto" type="button" >Guardar</button>
      </div>
    </div>


</form>

</div>

           

</div> 
      <div class="contenedor_icono" id='icono_prod_res'  >
            
      </div>
      <p id='texto_res' class='text-center texto_response'></p> 
</div>
</div>
</div>


<style type="text/css">
  /* Latest compiled and minified CSS included as External Resource*/

  /* Optional theme */

  /*@import url('//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-theme.min.css');*/

</style>



<script type="text/javascript">

  $(document).ready(function () {

    $(".btnArriba").prop('disabled', true);
    var navListItems = $('div.setup-panel div a'),
    allWells = $('.setup-content'),
    allNextBtn = $('.nextBtn');


    allWells.show();


    navListItems.click(function (e) {
      e.preventDefault();
      var $target = $($(this).attr('href')),
      $item = $(this);
      // console.log($target)
      if (!$item.hasClass('disabled')) {
        navListItems.removeClass('btn-success').addClass('btn-default');
        $item.addClass('btn-success');




        allWells.hide();
        $target.show();
        $target.find('input:eq(0)').focus();
      }
    });



    // navListItems.unbind(); 
    allNextBtn.click(function () {
      todoscampos =  $("#formulario_productos").find("input[type='text'],input[type='url'],select")
      var curStep = $(this).closest(".setup-content"),
      curStepBtn = curStep.attr("id"),
      nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
      curInputs = curStep.find("input[type='text'],input[type='url'],select"),
      isValid = true;
      arreglo = [];
      for (var i = 0; i < curInputs.length; i++) {
        idinput  = curInputs[i].id
        $("#"+idinput).removeClass("error")
        arreglo.push(idinput)

      }
      for (var i = 0; i < curInputs.length; i++) {
        valor  = curInputs[i].value


        if (valor == "") {
          isValid = false;
          idinput  = curInputs[i].id
          $("#"+idinput).addClass("error")
        }

      }
      // console.log(arreglo)
      if( arreglo.includes("codigobarras_producto")){
       codigo_barras = $("#codigobarras_producto").val()
       estacion =$("#estaciones option:selected").val()
       nombre_estacion =$("#estaciones option:selected").text()
       if (codigo_barras != "") {
        validar_codigo_barras(codigo_barras,estacion,nextStepWizard,isValid,todoscampos,nombre_estacion)
      }
    }else{

      if (isValid) nextStepWizard.removeAttr('disabled').trigger('click');
    }
    limpiar_errores(curInputs)

  });

    $('div.setup-panel div a.btn-success').trigger('click');




  });



</script>