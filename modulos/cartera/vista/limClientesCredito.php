
<!DOCTYPE html>
<html >
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Listado General</title>
	
	
	<link rel="stylesheet" href="../../../bootstrapcss/estiloListado.css">
	<link rel="stylesheet" href="../../../bootstrapcss/limclientes.css">

	
	
</head>
<body>
	<?php 


 		// include '../../../menu/menu2.php';
 	// 	include '../metGASOLINERA/metodosGASOLINERA.php';
 	
 	// 	$metodo = new metodosweb();

 	// 	$metodoGAS = new GASOLINERA();
	 // $priv = $objeto->ElegirPrivilegios($_SESSION['user']);
	 //  $digito = substr($privilegio["MODULO1"], -1,1);
	 ?>
	     <link rel="stylesheet" href="../../../bootstrapcss/limclientes.css">

<script src="../../precios/js/clickModulo2.js"></script>
<script src="../jsClientes/limCreditos.js"></script>

	 <!-- <div class=" row m-5"></div> -->
	
		
		
	
	 <h5 style="text-align: left; font-weight: bold; position: relative; top: 0px;">Modificacion clientes de Credito</h5>
     

<br>


<div class="" >
<small id="emailHelp" class="form-text text-muted">Escribe el nombre o el folio del cliente  que desee buscar</small>
</div>
<div class=" d-flex flex-wrap justify-content-center col-lg-12">
<!-- <input class="form-control col-lg-3 " type="text" id="bFolio" name="Buscar" placeholder="Buscar numero"> -->	
<input  class="form-control  col-lg-9" type="text" id="bNombre" name="Buscar nombre" placeholder="Buscar nombre">	
<div class="col-lg-3 d-flex justify-content-center">
	<button type="button" class="btn btn-primary " id="btnBuscarCliModi" onclick="buscador_clientes_modi()">Buscar</button>
</div>
</div>





<br>
	<div id="tablaBusqueda">
		
	</div>

</body>
</html>



