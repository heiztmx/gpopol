<div style="z-index: 100000; " class="modal  fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" >
   
    <div class="modal-content" >
           <div class="modal-header"><h4 style="text-align: center;">Confirmacion de precios</h4> <button type="button" class="close" data-dismiss="modal"><span type="reset" onclick="resetear()" aria-hidden="true">&times;</span><span type="reset" onclick="resetear()"  class="sr-only">Close</span></button></div>
            <p id="facturacion"></p>
            <p class="mx-auto" id="errorFatal" style="margin-bottom: -20px"></p>
          
              <div class="modal-body  col-lg-11 mx-auto" >
                 <div  class="d-flex flex-nowrap   container ">
                    <label class="col-form-label" for="">Fecha :</label>
                    <input type="text" id="fechamodal" class="form-control-sm" readonly="" style="border: 0px solid; margin-top: 4px; ">

                  </div>
                <div class="container mx-auto d-flex flex-wrap justify-content-between" >
                 
                    

                  <div class="d-flex flex-nowrap  align-items-center justify-content-center">
                    <label class="col-form-label" for="">Magna :</label>
                    <input type="text" id="magnamodal" class="form-control-sm " readonly="" style="border: 0px solid; margin-top: 1px; ">
                  </div>
                  <div class="d-flex flex-nowrap align-items-center justify-content-center " >
                    <label class="col-form-label" for="">Premium :</label>
                    <input type="text" id="premiummodal" class="form-control-sm" readonly="" style="border: 0px solid; margin-top: 1px; ">

                  </div>
                     <div class="d-flex flex-nowrap align-items-center justify-content-center ">
                      <label class="col-form-label" for="">Diesel :</label>
                        <input type="text" id="dieselmodal" class="form-control-sm" readonly="" style="border: 0px solid; margin-top: 1px; ">
                     </div> 
                </div>
                 <div class="d-flex flex-wrap  container justify-content-between justify-content-start"  >
             <?php
             $objeto = new  metodosweb;
        $estaciones = $objeto->tablaEstaciones();
        $array2Est = array();
        while($row=ibase_fetch_assoc($estaciones))
            {
                array_push($array2Est, $row["ESTACION"]);
              ?>
              
                  

                    <div id="cadaestacion" class="d-flex flex-nowrap " style="margin-top: 8px;">
                    <input type="text"  name="<?php echo $row['ESTACION']; ?>" id="modal<?php echo $row['ESTACION']; ?>" class="form-control form-control-sm col-lg-9" readonly="" value="">

                    <div  id="loader<?php echo $row['ESTACION']; ?>" class="preloader"></div>

                    <img src="" id="imagen<?php echo $row['ESTACION'] ?>" alt="" class="imagenmodal" /> 
                    
                    
                     </div>
                      <?php } ?>
              </div>
           <br>
        <div class="modal-footer">
         
          <button style="display: none;" type="button" class="btn btn-secondary" id=" btnOK" data-dismiss="modal" type="reset" onclick="resetear()" >OK</button>
        <button type="button" class="btn btn-secondary" id="btnCancelarModal" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btnEnviarModal" onclick="confirmarPC('<?php
                foreach($array2Est as $valor2){
                echo $concatenado2=$valor2."||";
                }
       
                ?>')">Enviar</button>


      </div>

      
    </div>
      </div>
</div>
 </div>