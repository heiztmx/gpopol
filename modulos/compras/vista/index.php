<?php

include "../../../conexion/sesion.php";


$ses = new sesion();
$permisos = $ses->validar_sesion();

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Compras</title>
  <meta name="viewport" content="initial-scale=1">
</head>
<body>
	<?php include '../../../menu/menu2.php';
    $permisorechazar =  $objeto->permisos_cancelar_requisiciones($_SESSION["id"]);
    $permiso_rechazar_req = $permisorechazar["reqrechazada"];
    $permiso_rechazar_orden = $permisorechazar["ordenrechazada"];
    echo $_SESSION["aut_compras"];
     ?>
  <link rel="stylesheet" href="../../../bootstrapcss/comprascss.css">

  <script src="../jsCompras/funCompras.js"></script>
  <script src="../../precios/js/cambioSubmenu.js"></script>
  <script type="text/javascript" src="../jsCompras/nueva_req.js"></script>
  <script type="text/javascript">
    var idusuario = "<?php echo $_SESSION["id"] ?>"
    var permiso_rechazar_req =  "<?php echo $permiso_rechazar_req ?>"
    var permiso_rechazar_orden =  "<?php echo $permiso_rechazar_orden ?>"
    var aut_compras = "<?php echo $_SESSION["aut_compras"] ?>";
  </script>


  <?php 


  include '../submenus/menucompras.php';
  ?>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>




<div id="contenedor_compras">
  <br>

<h4 style=" font-weight: bold; position: relative; top: -25px;" id="titulo_estado">Compras</h4>
<div class="col-lg-12 d-flex flex-wrap">
  <div class="col-lg-4 d-flex " id="contenedor_fecha">
    <label for="example-datetime-local-input" class="col-lg-4 col-form-label" id="label_fecha" style="text-align: center;">Fecha</label>
    <input class="form-control col-lg-8"   type="month"  id="fecha_buscar"  style="" >
  </div>
  <div class="col-lg-7"></div>
</div>
<br>


<br>

  <div id="calendario"></div>


    <table  id="tabla"  class="display cell-border compact hover table-striped table-bordered" style="width:100%; ">
      <thead>

        <tr>
         
          <th>Fecha</th>
  
          <th id="tipo_req_odc">---</th>
          <th>Elaboro</th>
          <th>Concepto</th>
          <th>Autorizo</th>
          <th>Importe</th>
          <th>Estado</th>

        </tr>
      </thead>
  
    <tfoot>
          <tr>
         
          <th>Fecha</th>
          <th>Requisicion</th>
          <th>Elaboro</th>
          <th id="concepto_ft">Concepto</th>
          <th>Autorizo</th>
          <th id="importe">Importe</th>
          <th >Estado</th>
        </tr>
    </tfoot>
    </table>

</div>





<?php
include  '../modals/requisiciones.php';
include  '../modals/ordenes_compra.php';
include  '../modals/buscador_productos.php';
include  '../modals/buscador_proveedores.php';
include '../modals/opciones_crear_documentos.php';
include '../modals/cotizador.php';
include '../modals/modal_decision_cot.php';
?>



</body>
</html>


