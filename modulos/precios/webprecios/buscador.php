<!DOCTYPE html>
<html lang="en">
<head>

	<!-- Buenas librerias hasta ahora -------------- -->
<script src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="../js/mobiscroll-1.5.1.js" type="text/javascript"></script>
<!-- --------------------------------------------- -->
<script src="../javascript/jquery-3.3.1.min.js"></script>
<link href="../sweetalert-master/src/sweetalert.css" type="text/css">
<script src="../sweetalert-master/docs/assets/sweetalert/sweetalert.min.js"></script>
<link rel="stylesheet" href="../css/stylelistadoBuscar.css">
<link rel="stylesheet" href="../css/stylemodalBorrarprecios.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
<script src="../js/buscarRegistro.js"></script>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>

	<select name="opciones" id="opciones" onchange="elegirOpcion()">
		<option value=""></option>
		<option value="1" id="1" >FOLIO</option>
		<option value="2" id="2">ESTACION</option>
		<option value="3" id="3">FECHA</option>
		<option value="4" id="4">FECHA Y ESTACION</option>
		<option value="5" id="5">USUARIOS POR ESTACION</option>
		<option value="6" id="6">APLICADOS POR FECHA</option>
		<option value="7" id="7">APLICADOS POR ESTACION</option>
	</select>
	
 <div id="div1">
	<input type="date" id="caja-buscar">
	<input type="text" id="caja-estacion">
	<input type="text" id="caja-fecha">
	<input type="text" id="caja-folio">
	<input type="submit"  value="buscar" id="boton">
 </div>	

<div id="tabla-mostrar"></div>

		
</body>
</html>