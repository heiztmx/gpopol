<?php 

if(isset($_SESSION['user']) &&  $_SESSION['logeado']== true){
 ?>


 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
 <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
 <head>
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />

  <title>Agregar Precios</title>
  <script src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="../js/mobiscroll-1.5.1.js" type="text/javascript"></script>
  <script src="../js/manejoCheckbox.js"></script>
  <script src="../alertifyjs/alertify.js"></script>


  

  <link rel="stylesheet" href="../alertifyjs/css/alertify.css">
  <link rel="stylesheet" href="../alertifyjs/css/themes/default.css">
  <link href="../css/mobiscroll-1.5.css" rel="stylesheet" type="text/css" />
  <link href="https://fonts.googleapis.com/css?family=Gugi|Roboto+Condensed" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Patua+One|Teko" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Russo+One" rel="stylesheet">
  <link rel="stylesheet" href="../css/jquery.mobile-1.0b2.min.css" />
  <link rel="stylesheet" href="../css/styleModificarPrecios.css" />
  <link rel="stylesheet" href="../css/styleprecios.css" />
  <link rel="stylesheet" href="../css/stylemodalConfirmar.css" />

  <!-- links del movil -->
  <link rel="stylesheet" href="../cssmovil/movilAgregarprecio.css" />
  <link rel="stylesheet" href="../cssmovil/movilModalConfirmar.css" />

  <script type="text/javascript">
   
   
    $(document).ready(function () {
      $('#date1').scroller();
      $('#date2').scroller({ preset: 'time' });
      $('#date3').scroller({ preset: 'datetime' });
      $('#date4').scroller({ preset: 'datetime' });
      wheels = [];
      wheels[0] = { 'PESOS': {} };
      wheels[1] = { 'CENTAVOS': {} };
      for (var i = 0; i < 100; i++) {
        if (i < 100) wheels[0]['PESOS'][i] = (i < 10) ? ('0' + i) : i;
        wheels[1]['CENTAVOS'][i] = (i < 10) ? ('0' + i) : i;
      }
      $('#diesel').scroller({
        width: 90,
        wheels: wheels,
        showOnFocus: false,
        formatResult: function (d) {
          return ((d[0] - 0) + ((d[1] - 0) / 100)).toFixed(2);
        },
        parseValue: function (s) {
          var d = s.split('.');
          d[0] = d[0] - 0;
          d[1] = d[1] ? ((('0.' + d[1]) - 0) * 10) : 0;
          return d;
        }
      });
      $('#diesel').click(function() { $(this).scroller('show'); });

            // --------------------------------------

            $('#magna').scroller({
              width: 90,
              wheels: wheels,
              showOnFocus: false,
              formatResult: function (d) {
                return ((d[0] - 0) + ((d[1] - 0) / 100)).toFixed(2);
              },
              parseValue: function (s) {
                var d = s.split('.');
                d[0] = d[0] - 0;
                d[1] = d[1] ? ((('0.' + d[1]) - 0) * 10) : 0;
                return d;
              }
            });
            $('#magna').click(function() { $(this).scroller('show'); });
            // -------------------------------------------


            $('#premium').scroller({
              width: 90,
              wheels: wheels,
              showOnFocus: false,
              formatResult: function (d) {
                return ((d[0] - 0) + ((d[1] - 0) / 100)).toFixed(2);
              },
              parseValue: function (s) {
                var d = s.split('.');
                d[0] = d[0] - 0;
                d[1] = d[1] ? ((('0.' + d[1]) - 0) * 10) : 0;
                return d;
              }
            });
            $('#premium').click(function() { $(this).scroller('show'); });

                    // ------------------------------------
                    $('#disable').click(function() {
                      if ($('#date2').scroller('isDisabled')) {
                        $('#date2').scroller('enable');
                        $(this).text('Disable');
                      }
                      else {
                        $('#date2').scroller('disable');
                        $(this).text('Enable');
                      }
                      return false;
                    });

                    $('#get').click(function() {
                      alert($('#date2').scroller('getDate'));
                      return false;
                    });

                    $('#set').click(function() {
                      $('#date1').scroller('setDate', new Date(), true);
                      return false;
                    });

                    $('#theme, #mode').change(function() {
                      var t = $('#theme').val();
                      var m = $('#mode').val();
                      $('#date1').scroller('destroy').scroller({ theme: t, mode: m });
                      $('#date2').scroller('destroy').scroller({ preset: 'time', theme: t, mode: m });
                      $('#date3').scroller('destroy').scroller({ preset: 'datetime', theme: t, mode: m });
                      $('#date4').scroller('destroy').scroller({ preset: 'datetime', theme: t, mode: m });
                      $('#negro').scroller('option', { theme: t, mode: m });
                      $('#magna').scroller('option', { theme: t, mode: m });
                      $('#premium').scroller('option', { theme: t, mode: m });
                      

                    });
                  });

        /*$(function () {
        $('#numero').mobiscroll().number({theme: 'material', maxWidth:100});

      }  );*/
    </script>
    



    <!-- ----------------------------------------------------- -->



    <body>
     
     <?php 
     include 'metodosweb.php';
     include 'elegir-encabezado.php';
     $x = new  encabezados();
     $enca = $x->elegir_enca();

     ?>

     <h1 class="h1">Nuevos Precios</h1><!-- insertarprecioweb.php -->
     <form id="formulario" >

       <div id="folio">
        
        
        <!-- concatenar las estaciones para el boton todos-->
        <?php
        $metodos = new metodosweb();
        $bloqueador = $metodos->tablaEstaciones();
        $bloquear =array();
        while($est = ibase_fetch_assoc($bloqueador)){
          array_push($bloquear,$est['ESTACION']);
        }
        
        ?>
      </div>
      <script src="../js/ocultar.js"></script>
      <div id="selector">
        <label for="">Estacion</label>
        <label for="">Todos <input type="checkbox" name="todos" value="todos"  id="todos1" onclick="bloquearEstaciones('<?php   foreach($bloquear as $value) {
          echo $concatenado2=$value."||";
        } ?>')" class="estacionopc"></label>
        <i id="icono" class="fas fa-caret-down"></i>
      </div>
      <div id="check">   <!--principio del contenedor que oculta las estaciones-->
       <table  id="contendor_estaciones">
         <?php 
         
         $metodos2 = new metodosweb();
         $estaciones = $metodos2->tablaEstaciones();
         $arrayEst=array();
         while($variable = ibase_fetch_assoc($estaciones)){
          array_push($arrayEst,$variable['ESTACION']);
          ?>
          
          <tr border="1">
            <td>
              <label for=""><input type="checkbox" name="<?php echo $variable['ESTACION'] ?>" value="<?php echo $variable['ESTACION']; ?>"  id="<?php echo $variable['ESTACION'] ?>" onclick="bloquearTodo('<?php
                foreach($arrayEst as $value) {
                  echo $concatenado=$value."||";}
                  ?>')"  /> <?php echo $variable['ESTACION'] ?>  </label>
                </td>
                
              </tr>

              <?php   
            }
            ?>
          </table>
        </div> <!--fin del contenedor que oculta las estaciones-->

        <?php  
        $metodos = new metodosweb;
        $x = $metodos->UltimoPrecio();
        $rowpo = ibase_fetch_object($x);
        ?>
        <div id="folyDT">
          
          <label for="date3">Fecha</label>
          <input type="text" name="date3" id="date3" class="mobiscroll fechaide" />
        </div>

        <div id="combustibles">
          <div id="verde">
            
           <h2>PEMEX MAGNA</h2>
           
           <input type="text" name="magna" id="magna" class="mobiscroll vm" value="<?php print number_format($rowpo->MAGNA,2,'.',','); ?>"  />
         </div>

         <div id="rojo">
          <h2>PEMEX PREMIUM</h2>
          <input type="text" name="premium" id="premium" class="mobiscroll rp" value="<?php print number_format($rowpo->PREMIUM,2,'.',','); ?>" />
        </div>
        <div id="negro">
          <h2>PEMEX DIESEL</h2>
          <!-- <input type="text" name="date4" id="date4" class="mobiscroll "/> -->
          <input type="text" name="diesel" id="diesel" class="mobiscroll nd" value="<?php print number_format($rowpo->DIESEL,2,'.',','); ?>" />
        </div>

        
      </div>

      <div id="botones">
       <a onclick="mandarPrincipal()">Cancelar</a>
       <?php 
       $array2Est=array();
       $metodos3= new metodosweb();
       $estaciones3 = $metodos3->tablaEstaciones();
       $array2Est=array();
       while($variable = ibase_fetch_assoc($estaciones3)){
        array_push($array2Est,$variable['ESTACION']);}
        ?>
        <!--href="#popup"-->
        <a  id="mostrar-modal"  href="#popup" onclick="mostrarModalPC('<?php
          foreach($array2Est as $valor){
            echo $concatenado=$valor."||";
          }
          
          ?>')" >Aplicar</a>
        </div> 
      </form>


      <script src="../js/DatosModal.js"></script>
      <script src="../js/confirmacion.js"></script> 










      <!-------------------modal------------------------------ -->
      <div class="modal-wrapper" id="popup">
       <div class="popup-contenedor">
        <table id="tabla-modal"><!-- onsubmit="return mandarDatos();  -->
         <form method="POST" name="formulariomodal" id="formulariomodal" >
           <tr>
            <td colspan="4" > <h2 style="color: #008558; width:100%;">¿Seguro que desea programar estos precios?</h2></td>
          </tr>
          
          <tr class="linea">
           <td> 
            <div class="diseno">
              <p for="" class="box1">Fecha</p>
              <input type="text" value="" name="fecha" id="fechamodal" class="box" readonly="">
            </div>
          </td>
          <td>
            <div class="diseno">
              <p for="" class="box1">Magna</p>
              <input type="text" value=" " name="magna" id="magnamodal" class="box" readonly="">
            </div>  
            
          </td>
          <td> 
            <div class="diseno">
             <p for="" class="box1">Premium</p>
             <input type="text" value="" name="fecha" id="premiummodal" class="box" readonly="">
           </div>
         </td>
         <td>
          <div class="diseno">
            <p for="" class="box1">Diesel</p>
            <input type="text" value=" " name="magna" id="dieselmodal" class="box" readonly="">
          </div>  
          
        </td>
      </tr>
      <p id="facturacion" class="mensaje_fac"></p>
    </td>
    <tr class="linea">
      <td colspan="6" id="esta">
       <div class="estacionesmodal">
         <?php
         $objeto = new  metodosweb;
         $estaciones = $objeto->tablaEstaciones();
         while($row=ibase_fetch_assoc($estaciones))
         {
          ?>
               <!--<tr class="linea">
                <td colspan="6" id="esta">-->
                  

                  <div id="cadaestacion">
                    <input type="text"  name="<?php echo $row['ESTACION']; ?>" id="modal<?php echo $row['ESTACION']; ?>" class="boxes" readonly="" value="">
                    <div  id="loader<?php echo $row['ESTACION']; ?>" class="preloader"></div>
                    <img src="" id="imagen<?php echo $row['ESTACION'] ?>" alt="" class="imagenmodal" /> 
                    
                    
                  </div>
                  
<!--
                  nayelidzul@icloud.com.mx
                  Nayelidzul2018-->
              <!--</td>
              </tr>-->
            <?php }
            ?>
          </div>
        </td>
      </tr>
      <tr>
        <td colspan="4"><p style="color: red; width: 65%; margin: auto;" id="errorfatal"></p></td>
      </tr>
      <tr >
        <td colspan="4" id="contenedor-boton">
          <a  class="botonmodal"  id="botonfinal"   onclick="confirmarPC('<?php
            foreach($array2Est as $valor2){
              echo $concatenado2=$valor2."||";
            }
            
            ?>')">Si</a>
            <a href="#" class="botoncancelar" id="btncancelar" >NO</a>
            <a href="" class="botonOK" id="btnOK">OK</a>

            
          </td>


        </tr>
      </form>
    </table>




    <!------------------------------------------------------------------->
        <!-- modal para celular 
          cuadro 1 dond estan los precios-->
          <!--<script src="../js/envDatPostModal.js">  </script>-->
          <script src="../js/confirmacionModal.js">  </script>
          <div id="modalPrincipalM">
            <div id="modal-movil">
             <h2 class="h2">¿Seguro que desea programar estos precios?</h2>
             <div id="movil-precios1">

               <div class="diseno">
                <p for="" class="box1">Fecha</p>
                <input type="text" value="" name="fecha" id="fechamodal2" class="box2" readonly="">
              </div>
              
              
            </div>

            <div id="movil-precios2">
              <div class="diseno">
               <p for="" class="box1">Premium</p>
               <input type="text" value="" name="premium" id="premiummodal2" class="box" readonly="">
             </div>
             <div class="diseno">
              <p for="" class="box1">Magna</p>
              <input type="text" value=" " name="magna" id="magnamodal2" class="box" readonly="">
            </div>
            <div class="diseno">
              <p for="" class="box1">Diesel</p>
              <input type="text" value=" " name="diesel" id="dieselmodal2" class="box" readonly="">
            </div>
          </div>
        </div>
        <hr class="linea-modal" />
        <!--          cuadro 2 donde va el resto -->
        <div id="modal-movil2">
          <div class="estacionesmodal1">
            <?php
            $objetophone = new  metodosweb;
            $estacionesphone = $objetophone->tablaEstaciones();
            while($rowphone=ibase_fetch_assoc($estacionesphone))
            {
              ?>
              <div id="cadaestacion2">
               <input type="text" value="" name="modalphone<?php echo $rowphone['ESTACION']; ?>" id="modalphone<?php echo $rowphone['ESTACION']; ?>" class="boxes" readonly="" >
               <div id="loaderphone<?php echo $rowphone['ESTACION']; ?>" class="preloader"></div>
               <img src="" id="imagenphone<?php echo $rowphone['ESTACION']; ?>" alt=""  class="imagenmodal" />  
               
               
             </div>

             <?php 
           }
           ?>      

           
         </div>
         <p id="facturacion2" class="mensaje_fac2"></p>
         <p style="color: red; " id="errorfatal2"></p>
         
         <div id="botones-movil"> 
           <a  class="botoncancelar"  id="botonfinal2" value="SI" readonly="" onclick="confirmarModal('<?php
            foreach($array2Est as $valorphone){
              echo $concatenadophone=$valorphone."||";
            }
            
            ?>')"
            >SI</a>
            <a href="#" class="botoncancelar" id="btncancelar2" >NO</a>
            <a href="" class="botonOK" id="btnOK2">OK</a>
          </div>
        </div>
        <a class="popup-cerrar" href="frmPrecios.php">X</a>
      </div>
    </div>


  </body>
  </html>
