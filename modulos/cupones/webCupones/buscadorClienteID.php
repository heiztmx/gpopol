<?php 
include '../metCupones/metodosCupones.php';

$id =isset($_POST["id_cliente"]) ? $_POST["id_cliente"] : "";
$id=(int)$id;
 $objeto = new Cupones();
 $cliente = $objeto->NombreClientes($id);

 	if ($cliente == NULL) {
 		print_r("No existe cliente con ese ID  :(");
 	}else{
 		print_r($cliente);
 	}
 ?>