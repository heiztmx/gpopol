<?php

include "../../../conexion/sesion.php";


$ses = new sesion();

$permisos = $ses->validar_sesion();

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>

  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.0/css/all.css" integrity="sha384-aOkxzJ5uQz7WBObEZcHvV5JvRW3TUc2rNPA7pe3AwnsUohiw1Vj2Rgx2KSOkF5+h" crossorigin="anonymous">
  <link rel="stylesheet" href="../../../bootstrapcss/estiloInsertar.css">
  <script src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="../../js/mobiscroll-1.5.1.js" type="text/javascript"></script>

  <script src="../../../alertifyjs/alertify.js"></script>


  <link rel="stylesheet" href="../../../alertifyjs/css/alertify.css">
  <link rel="stylesheet" href="../../../alertifyjs/css/themes/default.css">
  <link href="../../../css/mobiscroll-1.5.css" rel="stylesheet" type="text/css" />
  <link href="https://fonts.googleapis.com/css?family=Gugi|Roboto+Condensed" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Patua+One|Teko" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Russo+One" rel="stylesheet">
  <link rel="stylesheet" href="../../../css/jquery.mobile-1.0b2.min.css" />
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
  <script src="../js/cambioSubmenu.js"  async="async"></script>
  <script src="../js/clickModulo1.js"></script>
  <link rel="stylesheet" href="../../../bootstrapcss/Estiloportada.css">
  <script src="../js/opcionRegistro.js"></script>
</head>
<body >



  <?php
  
  include '../../../menu/menu2.php';


  ?>
  


<!-- <div class="m-5"></div>
<div class="m-5"></div>
<div class="m-5"></div><div class="m-5"></div>
<div class="m-5"></div>
<div class="m-5"></div> -->


<div class="container-fluid">
  <br>
  <br>
  <br>
  <br>
  
  <?php 

  // $metodos = new metodosweb();
  // $bloqueador = $metodos->tablaEstaciones();
  // $estaciones_check =array();
  // $Estaciones ="";
  // while($est = ibase_fetch_assoc($bloqueador)){
  //   $Estaciones .= $est["ESTACION"];
  //   array_push($estaciones_check,$est['ESTACION']);
  // }

  $pre=$objeto->preciosPortada1("Uman");
  $precios=ibase_fetch_assoc($pre);
  ?>
  <h4 style="text-align: left; position: relative; top: -25px;">Agregar precios</h4>

  <div class="container-fluid" >
    <div class="  d-flex flex-column   " style="position: relative; top: -15px;">


      <div class="d-flex flex-nowrap col-lg-6" >
        <!--   -->
        <div class="form-group row d-flex flex-nowrap ">
          <label for="example-datetime-local-input" class="col-3 col-form-label">Fecha</label>
          <div class="container">
            <?php $fcha = date("Y-m-d");?>
           <input class="form-control" type="datetime-local" id="date3" value="<?php echo $fcha?>T00:00:01" style="" > 
            
         </div>

         


       </div>
       
     </div>


     <div class="row " >
      <div class="d-flex flex-row col-lg-5"  >


        <!-- <div class="container "> --> <!-- principio de estaciones -->

          <div class="d-flex justify-content-between col-sm-12 justify-content-center align-items-center">
            <table>
              <tr>
                <td> <label for="" class=" col-form-label ">Estaciones:&nbsp;&nbsp;&nbsp; </label></td>
                <td >  

                  <div class="form-check  ">
                    <script>
                     var Estaciones = "<?php echo $Estaciones ?>"

                   </script>
                   <input checked=""  type="checkbox" class="form-check-input bajar" id="todos1" onclick="bloquearEstaciones('<?php
                              foreach($estaciones_check as $valor2){
                                echo $concatenado2=$valor2."||";
                              }

                              ?>')">
                   <label class="col-form-label" for="todos1">Todos</label>
                 </div></td>
                 <td>
                  <a class="btn btn-light btn-sm" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                    <i id="icono" class="fas fa-caret-down col-lg-3" style="cursor: pointer;"></i></a>
                  </td>
                </tr>
                <tr>
                  <td colspan="3">
                    <!-- Estaciones ocultas -->
                    <div class="collapse " id="collapseExample">
                      <div id="check" class="row">
                        <div class="col-lg-5">
                         <?php 

                           // $metodos2 = new metodosweb();
                           // $estaciones = $metodos2->tablaEstaciones();

                         $arrayEst=array();
                         for($i = 0 ; $i<count($estaciones_check); $i++){
                            // array_push($arrayEst,$variable['ESTACION']);
                          ?>
                          <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="<?php echo $estaciones_check[$i] ?>" value="<?php echo  $estaciones_check[$i] ?>"  id="Estacion<?php echo  $estaciones_check[$i] ?>" onclick="bloquearTodo('<?php
                              foreach($estaciones_check as $valor2){
                                echo $concatenado2=$valor2."||";
                              }

                              ?>')" >
                              <label class="form-check-label" for="Estacion<?php  echo  $estaciones_check[$i] ?>"><?php echo  $estaciones_check[$i]  ?></label>
                            </div>


                            <?php   
                          }
                          ?>


                        </div>
                      </div>
                    </div>
                  </td>
                </tr>

              </table>

            </div>


            <!-- </div> -->
            <!-- </div> -->
          </div>
        </div>


      </div>
    </div>




    <div class="row m-1"></div>


    <div class="row "></div>
    <div class="row " >
      <div class="d-flex col-lg-4 col-md-12 col-sm-12  magna" style="position: relative; top: -15px;" >
        <label class="col-lg-6 text-center">PEMEX MAGNA</label>
        <input type="number" id="magna1" class="col-lg-7 magna " style="font-size: 30px; text-align: center;"  value="<?php print number_format($precios['MAGNA'],2,'.',','); ?>">
      </div>
    </div>

    <div class="row m-1"></div>

    <div class="row" >
      <div class="d-flex flex-row col-lg-4 premium" style="position: relative; top: -15px;" >
        <label for="" class="col-lg-6 text-center">PEMEX PREMIUM</label>
        <input type="number" class="col-lg-7 premium " id="premium1" style="font-size: 30px; text-align: center;"  value="<?php print number_format($precios['PREMIUM'],2,'.',','); ?>">
      </div>
    </div>

    <div class="row m-1"></div>

    <div class="row" >
      <div class="d-flex flex-row col-lg-4  diesel" style="position: relative; top: -15px;">
        <label for="" class="col-lg-6 text-center " >PEMEX DIESEL</label>
        <input type="number" id="diesel1" class=" col-lg-7  diesel " style="font-size: 30px; text-align: center;" value="<?php print number_format($precios["DIESEL"],2,'.',','); ?>">

      </div>
    </div>

    <div class="row m-1"></div>

    <div class="row" >
      <div class="d-flex flex-row col-lg-4 justify-content-end" style="position: relative; top: -15px;left:17px;">
        <div id="botones">
         <a href="portada.php">Cancelar</a>

         <?php 
         // $array2Est=array();
         // $metodos3= new metodosweb();
         // $estaciones3 = $metodos3->tablaEstaciones();
         // $array2Est=array();

         // while($variable = ibase_fetch_assoc($estaciones3)){
         //  array_push($array2Est,$variable['ESTACION']);}
          ?>
          <!--href="#popup"-->
          <a  id="mostrar-modal"   href="#" onclick="VerificacionHora('<?php
            foreach($estaciones_check as $valor){
              echo $concatenado=$valor."||";
            }

            ?>')" >Aplicar</a>
          </div>


        </div>
      </div>



    </div>


    <button style="display: none;" id="btn_modal" type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Large modal</button>

    <div style="z-index: 100000; " class="modal  fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modalConfirmacion" data-backdrop="static"   data-keyboard="false">
      <div class="modal-dialog modal-lg" >

        <div class="modal-content" >
         <div class="modal-header"><h4 style="text-align: center;">Confirmacion de precios</h4> <button type="button" class="close" data-dismiss="modal"><span type="reset" id="tacha" aria-hidden="true">&times;</span><span type="reset" class="sr-only">Close</span></button></div>
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
          <div class="d-flex flex-wrap  container justify-content-between justify-content-start" id="contenedor_estaciones" >
           <?php
           // $objeto = new  metodosweb;
           // $estaciones = $objeto->tablaEstaciones();
           // $array2Est = array();
           for($i=0; $i<count($estaciones_check); $i++)
           {
            // array_push($array2Est, $row["ESTACION"]);
            ?>



            <div id="cadaestacion" class="d-flex flex-nowrap " style="margin-top: 8px;">
              <input type="text"  name="<?php echo $estaciones_check[$i] ?>" id="modal<?php echo $estaciones_check[$i] ?>" class="form-control form-control-sm col-lg-9" readonly="" value="">

              <div  id="loader<?php echo $estaciones_check[$i] ?>" class="preloaderModal"></div>

              <img src="" id="imagen<?php echo $estaciones_check[$i] ?>" alt="" class="imagenmodal" /> 


            </div>
          <?php } ?>
        </div>
        <br>
        <div class="modal-footer">

          <button style="display: none" type="button" class="btn btn-secondary" id="btnOK" data-dismiss="modal" type="reset" onclick="clear_grafico('<?php
            foreach($estaciones_check as $valor2){
              echo $concatenado2=$valor2."||";
            }

            ?>')">OK</button>
            <button type="button" class="btn btn-secondary" id="btnCancelarModal" data-dismiss="modal"  >Cancelar</button>
            <button type="button" class="btn btn-primary" id="btnEnviarModal" onclick="confirmarPC('<?php
              foreach($estaciones_check as $valor2){
                echo $concatenado2=$valor2."||";
              }

              ?>')">Enviar</button>


            </div>


          </div>
        </div>
      </div>
    </div>

  </body>
  </html>

