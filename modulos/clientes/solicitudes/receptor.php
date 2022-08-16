<?php 
include '../metodos/metodos.php';


$obj = new metodosclientes();


$rfc = isset($_POST["rfc"]) ? $_POST["rfc"] : "IMS421231I45";
$opcion  = isset($_POST["opcion"]) ? $_POST["opcion"] : "buscar_rfc";
trim($rfc);
switch ($opcion) {
	case 'buscar_rfc':
		
		echo  $obj->buscador_clientes_rfc($rfc);
		break;
	
	default:
		# code...
		break;
}




 ?>