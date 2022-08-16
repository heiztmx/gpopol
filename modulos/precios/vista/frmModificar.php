
<?php 
session_start();
if(isset($_SESSION['user']) &&  $_SESSION['logeado'] == true){


  
 ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>

<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.0/css/all.css" integrity="sha384-aOkxzJ5uQz7WBObEZcHvV5JvRW3TUc2rNPA7pe3AwnsUohiw1Vj2Rgx2KSOkF5+h" crossorigin="anonymous">
<link rel="stylesheet" href="../bootstrapcss/estiloInsertar.css">
<script src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>


<script src="../alertifyjs/alertify.js"></script>



<link rel="stylesheet" href="../alertifyjs/css/alertify.css">
<link rel="stylesheet" href="../alertifyjs/css/themes/default.css">
<link href="../css/mobiscroll-1.5.css" rel="stylesheet" type="text/css" />
<link href="https://fonts.googleapis.com/css?family=Gugi|Roboto+Condensed" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Patua+One|Teko" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Russo+One" rel="stylesheet">
<link rel="stylesheet" href="../css/jquery.mobile-1.0b2.min.css" />







 
</head>
<body >
  
      
  
  <?php
 
 include '../menu/menu2.php';

          $metodos = new metodosweb();
                    $bloqueador = $metodos->tablaEstaciones();
                    $bloquear =array();
                     while($est = ibase_fetch_assoc($bloqueador)){
                          array_push($bloquear,$est['ESTACION']);
                    }

$folio =$_POST["folio"];
// $fechaPost =$_POST["fecha"];
// $horaPost=$_POST["hora"];

$folio=(int)$folio;
$traer = $metodos->traerDatos($folio);

$row = ibase_fetch_object($traer);

$horabuena=date_create($row->HORA);
$hora =date_format($horabuena,'G:i');
$fechacompleta = $row->FECHA."T".$hora;
echo "<script type='text/javascript' >";
echo "alert('hola');";

echo "</script>";
  ?>


    

<div class="container">
  <br>
  <br>
  <br>
  <br>
  

   <h4 style="text-align: left; position: relative; top: -25px;">Modificacion de precios</h4>
<!-- <hr size="2"> -->
  <div class="container-fluid" >
<div class="  d-flex flex-column   " style="position: relative; top: -15px;">
<input type="text" id="usuario" value="<?php echo $_SESSION['user'];  ?>" style="display: none;" >
  <div class=" col-lg-4">
    <input  class="form-control" type="text" id="folio" disabled="" value="<?php echo $row->FOLIO; ?>">
  </div>
  <br>

<script>

 
function HoraModificar() {
  // body...
  var dateControl = document.querySelector('input[type="datetime-local"]');
dateControl.value = '<?php echo $fechacompleta ?>';
}


</script>

<div class="d-flex flex-nowrap col-lg-12" >
<div class="form-group row d-flex flex-nowrap ">
  <label for="example-datetime-local-input" class="col-1 col-form-label">Fecha</label>
  <div class="container d-flex flex-column">

     <input  class="form-control col-lg-10" type="datetime-local"  id="date3"
      style="margin-left: 15px;" > 

    
  </div>

  

</div>
</div>

<br>
<div class="d-flex flex-nowrap col-lg-12" >
<div class="form-group row d-flex flex-nowrap ">
  <label for="example-datetime-local-input" class="col-2 col-form-label">Estacion</label>
  <div class="container ">
     <input class="form-control" type="text"  id="estacion" disabled="" style="margin-left: 15px;" value="<?php echo $row->ESTACION;?>"> 

     <input class="form-control" type="text"  id="ipEstacion" disabled="" style="margin-left: 15px;display: none;" value="<?php echo $row->IP;?>" > 
  </div>

  

</div>
</div>


</div>
</div>




 <div class="row m-1"></div>


<div class="row "></div>
<div class="row " >
<div class="d-flex col-lg-4 col-md-12 col-sm-12  magna" style="position: relative; top: -15px;" >
<label class="col-lg-6 text-center">PEMEX MAGNA</label>
<input type="number" id="magna1" class="col-lg-7 magna" style="font-size: 30px; text-align: center;"value="<?php print number_format($row->MAGNA,2,'.',','); ?>">
</div>
</div>

<div class="row m-1"></div>

<div class="row" >
<div class="d-flex flex-row col-lg-4 premium" style="position: relative; top: -15px;" >
<label for="" class=" col-lg-6 text-center">PEMEX PREMIUM</label>
<input type="number" class="col-lg-7 premium" id="premium1" style="font-size: 30px; text-align: center;" value="<?php print number_format($row->PREMIUM,2,'.',','); ?>">
</div>
</div>

<div class="row m-1"></div>

<div class="row" >
<div class="d-flex flex-row col-lg-4  diesel" style="position: relative; top: -15px;">
<label for="" class=" col-lg-6 text-center " >PEMEX DIESEL</label>
<input type="number" id="diesel1" class=" col-lg-7  diesel " style="font-size: 30px; text-align: center;" value="<?php print number_format($row->DIESEL,2,'.',','); ?>">
</div>
</div>

<div class="row m-1"></div>

<div class="row" >
<div class="d-flex flex-row col-lg-4 justify-content-end" style="position: relative; top: -15px;left:17px;">
<div id="botones">
         <a href="portada.php">Cancelar</a>

                  
                         <!--href="#popup"-->
       <a  id="mostrar-modal"   href="#" onclick="VerificacionHora1()">Aplicar</a>
        </div>


</div>
</div>



</div>


<button style="display: none;" id="btn_modalM" type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Large modal</button>

<div style="z-index: 100000; " class="modal  fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static"   data-keyboard="false">
  <div class="modal-dialog modal-lg">
   
    <div class="modal-content">
           <div class="modal-header"><h4 style="text-align: center;">Confirmacion de modificacion de precios</h4> <button type="button" class="close" data-dismiss="modal"><span id="tachamod" aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></div>
            
            <p id="errorFatalM" class="mx-auto"></p>
          
              <div class="modal-body  col-lg-11 mx-auto" >
                  <div  class="d-flex flex-nowrap   container ">
                    <label class="col-form-label" for="">Folio :</label>
                    <input type="text" id="foliomodal" class="form-control-sm" readonly="" style="border: 0px solid; margin-top: 4px; ">

                  </div>
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
                <div  class="d-flex flex-nowrap   container mx-auto">
                    <label class="col-form-label" for="">Estacion :</label>
                    <input type="text" id="estacionmodal" class="form-control-sm col-lg-3" readonly="" style="border: 0px solid; margin-top: 4px; 
                     ">
                     <div style="display: none;"  id="loader" class="preloader"></div>
  
                    <img src="" style="display: none" id="imagen" alt="" class="imagenmodal" /> 
                  </div>
           <br>
        <div class="modal-footer">
         
          <button style="display: none;" type="button" class="btn btn-secondary" id="btnOK" data-dismiss="modal" onclick="clear_interface_update()">OK</button>
        <button type="button" class="btn btn-secondary" id="btnCancelarModalm" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btnEnviarModalm" onclick="Modificacion('<?php
                foreach($array2Est as $valor2){
                echo $concatenado2=$valor2."||";
                }
       
                ?>')">Enviar</button>


      </div>

      
    </div>
      </div>
</div>
 


</body>
</html>

<?php 
} else {
    header('location:../index.php');
}
?>