<?php

include "../../../conexion/sesion.php";


$ses = new sesion();
$permisos = $ses->validar_sesion();

?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Portada</title>
</head>

<body onload="verificarSiNo('')">	

	<script src="../../../javascript/jquery-3.3.1.min.js"></script>

	<script src="../js/cambioSubmenu.js"></script>
	<script src="../js/links.js"></script>
	<script src="../js/cerrarSesion.js"></script>
	<script src="../js/manejoCheckbox.js"></script>
	<script src="../js/DatosModal.js"></script>
	<script src="../js/confirmacion.js"></script>
	<script src="../js/irmodificar.js"></script>
	<script src="../js/llamarValidarSiNo.js"></script>
	<script src="../js/formatoNumeros.js"></script>
	<script src="../js/opcionRegistro2.js"></script>
	<script src="../js/facturacion.js"></script>
	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
	<script src="../js/cambioSubmenu.js" async="async"></script>
	<link rel="stylesheet" href="../../../bootstrapcss/Estiloportada.css">
	<script src="../js/opcionRegistro.js"></script>
	<script src="../js/clickModulo1.js"></script>
	<?php
	include '../../../menu/menu2.php';
	include '../submenus/menuprecios.php';
	?>

	<div class="m-5"></div>
	<div></div>
	<div id="cargador" class="container">
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
	<h1></h1>
	</div>


</body>

</html>


