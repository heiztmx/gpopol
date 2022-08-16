<?php 

include 'metodosweb.php';
$fecha =isset($_POST["fecha"]) ? $_POST["fecha"] : "";
$estacion =isset($_POST["estacion"]) ? $_POST["estacion"] : "";

$objeto = new metodosweb();
$respuesta = $objeto->eliminarFactura($fecha,$estacion);
if ($respuesta == 3) {
	# code...
	print_r("Borrado");
}else{
	print_r($respuesta);
}




 ?>