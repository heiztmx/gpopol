
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
 <div id="contenedor_cupones">

  <div class="d-flex flex-wrap w-100 font-weight-light">

   <div class="order-1 w-100 p-2 d-flex flex-wrap" >
       <div class="w-50 p-1">
       <label for="Fechai" class="">Fecha de</label>
       <div class="form-group ">
         <input class="form-control" type="date" id="fecha_recuperacion" value="<?php 
         date_default_timezone_set('America/Mexico_City'); 
         echo date("Y-m-d");?>">
       </div>
      </div>
      <div class="w-50 p-1">
      <label for="Fechaf"  class="">Hasta</label>
       <div class="form-group ">
         <input class="form-control" type="date" id="fecha_recuperacion2" value="<?php 
         date_default_timezone_set('America/Mexico_City'); 
         echo date("Y-m-d");?>">
       </div>
      </div>
    </div>
  
    <div class="order-2 w-100 p-2 d-flex flex-wrap">
      <div class="w-50 p-1">
       <label for="estaciones"  class="">Estacion</label>
        <div class="form-group ">
         <select class="form-control" id="estaciones" name="estaciones" onchange="empresa1()">
          
          <?php 
          $list_est =$obj->REC_ESTACIONES($_SESSION["id"],"REPCUPONFIL");
          for ($i=0; $i < count($list_est); $i++) { 
            $idsuc = $list_est[$i]["PERMISO_ESPECIAL"];
            $sucursal = $list_est[$i]["ESTACION"];
            
            echo "<option  value='".$idsuc."'>".$sucursal."</option>";  

          }
           
         ?></select>
       </div>
      </div>       
      <div class="w-50 p-1">
       <label for=""  class="">Clientes</label>
       <div class="form-group " >
         <select class="form-control" onchange="busquedaCliente()" name="opcionCliente" id="opcionCliente">
          <option selected="" value="tc">Todos</option>
          <option value="pc">Por cliente</option>
         </select>
       </div>
      </div>
    </div>
   </div>


  <div class="col-lg-12 d-flex flex-wrap" style="visibility:hidden;">
    <div class="col-lg-10 d-flex flex-wrap justify-content-between" style="visibility:hidden;">
      <div class="d-flex flex-nowrap col-lg-5 justify-content-between" style="visibility:hidden;">
        <label for=""  class="col-lg-3 ">Terminal</label>
        <div class="form-group col-lg-10" >
          <select class="form-control"  name="opcionCliente1" id="opcionCliente1" >
            <option value="todosUsuarios" selected="">Todos</option>
            <?php 
            $objetoCup = new Cupones();
            $usuarios =$objetoCup->usuariosCupones();
            while($r =ibase_fetch_assoc($usuarios))
            {
              echo "<option  value='".$r["IP"]."'>".$r["IP"]."</option>";
            }
            ?>
          </select>

        </div>
      </div>
    </div>
  </div>

  <div style="display: none" id="formu_cliente" >
    <div class="d-flex flex-wrap col-lg-12 justify-content-between" >
      <div class="col-lg-3">
        <div class="d-flex justify-content-between col-lg-6 align-items-center" >
          <div class="input-group-text">Clave</div>
          <input class="col-lg-12 form-control" type="numeric" id="id_cliente">
          <button onclick="buscadorID()" class="form-control" style="cursor: pointer;background-color: #fbbb1d !important;"><i class="fas fa-search"></i></button>
        </div>
      </div>
      <div class="col-lg-9">
        <div class="d-flex col-lg-9" >
          <input readonly="" class="col-lg-12 form-control" type="text" id="nombre_cliente">
        </div>
      </div>
    </div>
  </div>

  <hr>
  <div class="d-flex  justify-content-center mx-auto font-weight-light" style="margin-top: -15px;">  <button style="text-align: center;background-color: #fbbb1d !important;border-style: inherit;"  type="submit" class="btn btn-primary my-1" onclick="GenerarReporteCupones()">Generar</button></div>

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

