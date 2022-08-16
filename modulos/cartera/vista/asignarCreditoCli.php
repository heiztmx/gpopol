
<?php

include "../../../conexion/sesion.php";

$ses = new sesion();

$permisos = $ses->validar_sesion();

  ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Asignar Credito </title>
</head>
    <link rel="stylesheet" href="../../../bootstrapcss/limclientes.css">


<body>
 <h4 style="text-align: left; position: relative; top: -25px;">Asignacion de cliente a cartera</h4>
<div class="m-1">
<!--   <div class="form-group col-lg-4">
    <label for="exampleFormControlSelect1">Cliente:</label>
    <select class="form-control" name="opciones" id="opciones" onchange="elegirOpcion()">
      <option value="">Elegir tipo</option>
      <option value="PP">Prepago</option>
      <option value="CR">Credito</option>
      <option value="CO">Contado</option>   
    </select>
  </div> -->
<small id="emailHelp" class="form-text text-muted">Escribe el nombre del cliente que desea buscar</small>
</div>
<div class=" d-flex flex-wrap">

<!-- <input  class="form-control  col-lg-12" type="text" id="bPP" name="Buscar nombre" placeholder="Buscar clientes prepago" style=" display: none; border:1px red solid" onclick="buscadorClientesprepago()">	 -->
<input  class="form-control  col-lg-10" type="text" id="bCR" name="Buscar nombre" placeholder="Buscar clientes credito"  onclick="buscadorClientescredito()">  
<!-- <input  class="form-control  col-lg-12" type="text" id="bCO" name="Buscar nombre" placeholder="Buscar clientes contado" style=" display: none;" onclick="buscadorClientescontado()">  --> 
<div class="col-lg-2">
  <button type="button" class="btn btn-primary " onclick="buscadorClientescredito()">Buscar</button>

</div>
</div>
<div id="tablaBusqueda">
	
</div>

</body>
</html>