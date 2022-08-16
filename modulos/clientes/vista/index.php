
<?php

include "../../../conexion/sesion.php";


$ses = new sesion();
$permisos = $ses->validar_sesion();

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Solicitud de clientes</title>
	<script src="../../../javascript/jquery-3.3.1.min.js"></script>

	<script src="../../precios/js/cambioSubmenu.js"></script>
	<script src="../js/funciones.js"></script>
</head>
<body>
	
  <?php include '../../../menu/menu2.php';
  include '../submenus/menuclientes.php' ?>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>

	<div id="contenedor_seccion">
		

	</div>
</body>
</html>