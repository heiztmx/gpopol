
<?php

include "../../../conexion/sesion.php";

$ses = new sesion();
$permisos = $ses->validar_sesion(); 


?>


<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Consulta de Cupones Recuperados</title>

  
  <link rel="stylesheet" href="../../../bootstrapcss/estiloListado.css">
  <link rel="stylesheet" href="../../../bootstrapcss/limclientes.css">
  <!--   <link rel="stylesheet" href="../../../bootstrapcss/estiloCupones.css"> -->
  <!--   <script src="../../js/clickModulo4.js"></script> -->

  

</head>
<br>
<br>
<br>
<br>
<body>

	<?php include '../../../menu/menu2.php';
  include '../metCupones/metodosCupones.php';



 
  $obj= new Cupones();
  if ($_SESSION["idgas"] == Null || $_SESSION["idgas"] == "") {
    echo "<div class = 'div_contenedor'>
    <h4  >Usuario web, sin usuario igas en la tabla usuarios</h4></div>";
    exit();
  }
 
  $permisos =$obj->permisos_igas($_SESSION["idgas"]);
  $gen = $permisos["general"];// $gen = new generales();


    $permisorechazar =  $objeto->permisos_cancelar_requisiciones($_SESSION["id"]);
    $permiso_rechazar_req = $permisorechazar["reqrechazada"];
    $permiso_rechazar_orden = $permisorechazar["ordenrechazada"];
    //echo $_SESSION["aut_compras"];
  

  ?>
  <link rel="stylesheet" href="../../../bootstrapcss/comprascss.css">

  <script src="../jsCupones/funCompras.js"></script>
  <script src="../jsCupones/busquedaCupones.js"></script>
  <script src="../../precios/js/cambioSubmenu.js"></script>
  <script type="text/javascript" src="../jsCupones/nueva_req.js"></script>

  
  <script type="text/javascript">
    var idusuario = "<?php echo $_SESSION["id"] ?>"
    var permiso_rechazar_req =  "<?php echo $permiso_rechazar_req ?>"
    var permiso_rechazar_orden =  "<?php echo $permiso_rechazar_orden ?>"
    var aut_compras = "<?php echo $_SESSION["aut_compras"] ?>";

    
  </script>


  <?php include '../submenus/menucompras.php'; ?>
 
<div id="contenedor_compras">
  
  <div class="w-100 p-3 align-middle">
   <span class="font-weight-normal">Consulta de Cupones Recuperados</span>
  </div>
 <div id="contenedor_cupones" class="container " style="width: 100%;">

   
    <div class="form-row">

      <div class="input-group col-md" style="margin-bottom: 10px;">
        <div class="input-group-prepend">
         <label for="Fechai" class="input-group-text">Fecha de</label>
        </div>
         <input class="form-control" type="date" id="fecha_recuperacion" value="<?php 
         date_default_timezone_set('America/Mexico_City'); 
         echo date("Y-m-d");?>">
          <div class="input-group-append">
          </div>
      </div>

      <div class="input-group col-md" style="margin-bottom: 10px;">
        <div class="input-group-prepend">
         <label for="Fechaf"  class="input-group-text">Hasta</label>
        </div>
         <input class="form-control" type="date" id="fecha_recuperacion2" value="<?php 
         date_default_timezone_set('America/Mexico_City'); 
         echo date("Y-m-d");?>">
          <div class="input-group-append">
          </div>
      </div>
       
    </div>
    
  
    <div class="form-row">

      <div class="input-group col-md" style="margin-bottom: 10px;">
        <div class="input-group-prepend">      
         <label for="estaciones"  class="input-group-text">Estacion</label>
        </div>
             <select class="form-control" id="estaciones" name="estaciones" onchange="empresa1()">
              
              <?php 
              $list_est =$obj->REC_ESTACIONES($_SESSION["id"],"REPCUPONFIL");
              for ($i=0; $i < count($list_est); $i++) { 
                $idsuc = $list_est[$i]["PERMISO_ESPECIAL"];
                $sucursal = $list_est[$i]["ESTACION"];
                
                echo "<option  value='".$idsuc."'>".$sucursal."</option>";  

              }
               
             ?></select>
          <div class="input-group-append">
          </div>
      </div>         
       
      <div class="input-group col-md" style="margin-bottom: 10px;">
        <div class="input-group-prepend">                    
         <label for=""  class="input-group-text">Clientes</label>
        </div>
           <select class="form-control" onchange="busquedaCliente()" name="opcionCliente" id="opcionCliente">
            <option selected="" value="tc">Todos</option>
            <option value="pc">Por cliente</option>
           </select>
          <div class="input-group-append">
          </div>
      </div>             
       
    </div>   


     
    

  <div id="formu_cliente"  style="display: none;" >
   <div class="form-row">
    <div class="input-group col-md" style="margin-bottom: 10px;">
        
        <input readonly="" class="form-control" type="text" id="nombre_cliente">

    </div>  

    <div class="input-group col-md btn-group me-2" style="margin-bottom: 10px;">
      
            <div class="input-group-prepend" aria-label="First group">
            <span class="input-group-text">Clave</span>
            </div>
            <input class="form-control" type="numeric" id="id_cliente">
            <button type="button" onclick="buscadorID()" class="btn btn-outline-secondary" ><i class="fas fa-search"></i></button>
            <div class="input-group-append">
            </div>

    </div>
  </div>


  </div>

  <hr>
  <div class="d-flex  justify-content-center mx-auto font-weight-light" style="margin-top: -15px;">  <button   type="submit" class="btn btn-dark my-1" onclick="GenerarReporteCupones()">Generar</button>
  </div>

  <div id="tablas_cupones">
  </div>
</div>





<!--?php
include  '../modals/requisiciones.php';
include  '../modals/ordenes_compra.php';
include  '../modals/buscador_productos.php';
include  '../modals/buscador_proveedores.php';
include '../modals/opciones_crear_documentos.php';
include '../modals/cotizador.php';
include '../modals/modal_decision_cot.php';
?-->


</body>
</html>

